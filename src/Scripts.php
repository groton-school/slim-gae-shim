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

    public static function installGAEFiles(Event $event): void
    {
        $projectPath = getcwd();
        $templatePath = Path::join(__DIR__, '/../template');
        $io = $event->getIO();
        $io->write('Checking Google App Engine configuration...');
        foreach (scandir($templatePath) as $fileName) {
            switch ($fileName) {
                case '.':
                case '..':
                    break;
                default:
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
        }
        $io->write("Google App Engine configuration matches groton-school/slim-gae-shim.");
    }

    /**
     * @see https://stackoverflow.com/a/3060247
     */
    private static function fileDataEqual($a, $b): bool
    {
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
