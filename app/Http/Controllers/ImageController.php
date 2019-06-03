<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public static function getImage($id)
    {
        $files = Storage::files('public/images/profiles/');
        $matchingFiles = preg_grep('/^' . $id . '\./', $files);
        if (count($matchingFiles) > 0) {
            return 'images/profiles/' . $matchingFiles[0];
        } else return 'images/profiles/default.png';
    }
}
