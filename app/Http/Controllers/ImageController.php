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

    public static function getImageJSON($id)
    {
        $matchingFiles = glob('images/profiles/' . $id . '.*');

        if (count($matchingFiles) > 0) {
            return response()->file($matchingFiles[0]);
        } else return response()->file('images/profiles/default.png');
    }

    public static function resizeImage($file, $extension)
    {
        $file = 'images/profiles/' . $file;
        $quality = 80;
        $max_width = 400;
        $max_height = 400;

        $imgsize = getimagesize($file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $file, $quality);

        if ($dst_img) imagedestroy($dst_img);
        if ($src_img) imagedestroy($src_img);
    }

    public static function getBanImage($isBanned)
    {
        if ($isBanned) {
            return '/icons/done.svg';
        } else return '/icons/ban.svg';
    }
}
