<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class WindowsSafeFilesystem extends Filesystem
{
    /**
     * Determine if a file or directory exists safely on Windows IIS / open_basedir hosts.
     *
     * @param  string  $path
     * @return bool
     */
    public function exists($path)
    {
        if (str_contains($path, '<') || str_contains($path, '>') || str_contains($path, "\0")) {
            return false;
        }

        try {
            return @file_exists($path);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
