<?php

namespace App\Utils;

class Filesystem
{
  public static function getFilesList(string $dir, bool $withDotDirs = false): array
  {
    $files = scandir($dir);

    return $withDotDirs ? $files : array_slice($files, 2);
  }

  public static function getClassNames(string $dir): array
  {
    $files = self::getFilesList($dir);

    return array_map(fn ($filename) => pathinfo($filename, PATHINFO_FILENAME), $files);
  }
}
