<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function get($photoFileName) {
        $path = 'storage/img/'.$photoFileName;
        $img = Image::make($path);
        $file = array('name' => $photoFileName, 'size' => $img->filesize(), 'path' => "/".$path);

        return json_encode($file);
    }

    public function save($photo) {
        $img = Image::make($photo)->save();
        Storage::disk('public')->put('img/'.$photo->getClientOriginalname(), $img);
        
        return $img;
    }
    
    public function delete() {
        return null;
    }
}