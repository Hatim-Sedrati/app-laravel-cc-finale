<?php
// app/Http/Controllers/ViewHelperController.php
// This ensures directories are created automatically

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class ViewHelperController extends Controller
{
    public static function ensureDirectories()
    {
        $directories = [
            'resources/views/layouts',
            'resources/views/appointments',
            'resources/lang/fr',
            'resources/lang/en',
        ];

        foreach ($directories as $dir) {
            $path = base_path($dir);
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }
    }
}
