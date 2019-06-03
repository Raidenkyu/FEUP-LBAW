<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public static function getImage($id)
    {
        $matchingFiles = glob('images/profiles/' . $id . '.*');

        if (count($matchingFiles) > 0) {
            return $matchingFiles[0];
        } else return 'images/profiles/default.png';
    }

    public static function resizeImage($file, $extension)
    {
        $path = 'images/profiles/' . $file;
        $w = 400;
        $h = 400;
        list($width, $height) = getimagesize($path);
        $r = $width / $height;

        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;

        switch ($extension) {
            case 'jpeg':
                $src = imagecreatefromjpeg($path);
                break;
            case 'jpg':
                $src = imagecreatefromjpeg($path);
                break;
            case 'png':
                $src = imagecreatefrompng($path);
                break;
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        switch ($extension) {
            case 'jpeg':
                $src = imagejpeg($dst, $path);
                break;
            case 'jpg':
                $src = imagejpeg($dst, $path);
                break;
            case 'png':
                $src = imagepng($dst, $path);
                break;
        }
    }
}
