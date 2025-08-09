<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class Scripts
{
    private static Filesystem $filesystem;

    private static function fs(): Filesystem
    {
        if (!isset(self::$filesystem)) {
            self::$filesystem = new Filesystem();
        }
        return self::$filesystem;
    }

    /**
     * @return string[]|false
     */
    private static function scandir(string $filePath): mixed
    {
        $files = scandir($filePath);
        if ($files) {
            return array_diff($files, ['.', '..']);
        }
        return $files;
    }

    public static function installGAEFiles(Event $event): void
    {
        $projectPath = getcwd();
        $templatePath = Path::join(__DIR__, '/../template');
        $io = $event->getIO();
        $io->write('Checking Google App Engine configuration...');
        foreach (self::scandir($templatePath) as $fileName) {
            $src = Path::join($templatePath, $fileName);
            $dest = Path::join($projectPath, $fileName);
            if (!self::fileDataEqual($src, $dest)) {
                if (self::fs()->exists($dest)) {
                    $backup = self::backupFile($dest);
                    $io->write("Backed up $dest to $backup");
                }
                if (is_dir($src)) {
                    self::fs()->mirror($src, $dest);
                } else {
                    self::fs()->copy($src, $dest);
                }
                $io->write("Installed $dest");
            }
        }
        $io->write("Google App Engine configuration matches groton-school/slim-gae-shim.");
    }

    /**
     * @see https://stackoverflow.com/a/3060247
     */
    private static function fileDataEqual(string $a, string $b): bool
    {
        if (is_dir($a)) {
            if (is_dir($b)) {
                $afiles = self::scandir($a);
                $bfiles = self::scandir($b);
                $result = true;
                foreach ($afiles as $afile) {
                    $i = array_search($afile, $bfiles);
                    if ($i !== false) {
                        $bfile = $bfiles[$i];
                        $bfiles = array_splice($bfiles, $i, 1);
                        if (!self::fileDataEqual(Path::join($a, $afile), Path::join($b, $bfile))) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
                if (count($bfiles) > 0) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } elseif (is_dir($b)) {
            return false;
        } elseif (file_exists($a) && file_exists($b)) {
            // Check if filesize is different
            if (filesize($a) !== filesize($b)) {
                return false;
            }

            // Check if content is different
            $ah = fopen($a, 'rb');
            $bh = fopen($b, 'rb');

            $result = true;
            while (!feof($ah)) {
                if (fread($ah, 8192) != fread($bh, 8192)) {
                    $result = false;
                    break;
                }
            }

            fclose($ah);
            fclose($bh);

            return $result;
        }
        return false;
    }


    private static function backupFile(string $filePath): string
    {
        $backupPath = "$filePath.bak";
        if (self::fs()->exists($backupPath)) {
            $n = 1;
            do {
                $backupPath = "$filePath.$n.bak";
                $n++;
            } while (self::fs()->exists($backupPath));
        }
        self::fs()->rename($filePath, $backupPath);
        return $backupPath;
    }
}
