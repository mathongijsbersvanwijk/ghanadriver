<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    // NOT USED
    public function get($photoFileName) {
        $path = 'storage/img/'.$photoFileName;
        $img = Image::make($path);
        $file = array('name' => $photoFileName, 'size' => $img->filesize(), 'path' => "/".$path);

        return json_encode($file);
    }

    public function save($photo, $queId) {
        $img = Image::make($photo)->save();
        Storage::disk('public')->put('img/'.$queId."_".$photo->getClientOriginalname(), $img);
        $imgThumb = $img->fit(100)->save();
        Storage::disk('public')->put('thumb/'.$queId."_".$photo->getClientOriginalname(), $imgThumb);
        
        return $img;
    }
    
    public function delete() {
        return null;
    }
}