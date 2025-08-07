<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class Scripts
{
    private static Filesystem $filesystem;

    private static function fs()
    {
        if (!isset(self::$filesystem)) {
            self::$filesystem = new Filesystem();
        }
        return self::$filesystem;
    }

    public static function installGAEFiles(Event $event)
    {
        $projectPath = getcwd();
        $templatePath = Path::join(__DIR__, '/../template');
        foreach (scandir($templatePath) as $fileName) {
            switch ($fileName) {
                case '.':
                case '..':
                    break;
                default:
                    $src = Path::join($templatePath, $fileName);
                    $dest = Path::join($projectPath, $fileName);
                    if (self::fs()->exists($dest)) {
                        self::numberedBackup($dest);
                    }
                    if (is_dir($src)) {
                        self::fs()->mirror($src, $dest);
                    } else {
                        self::fs()->copy($src, $dest);
                    }
            }
        }
    }

    private static function numberedBackup(string $filePath)
    {
        if (self::fs()->exists("$filePath.bak")) {
            $n = 1;
            for ($n = 1; self::fs()->exists("$filePath.$n.bak"); $n++) {
            }
            self::fs()->rename($filePath, "$filePath.$n.bak");
        } else {
            self::fs()->rename($filePath, "$filePath.bak");
        }
    }
}
