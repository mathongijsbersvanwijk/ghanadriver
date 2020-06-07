<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function save($photo) {
        $img = Image::make($photo)->resize(384, 256)->save();
        Storage::disk('public')->put('img/'.$photo->getClientOriginalname(), $img);
        
        return $img;
    }

    public function delete() {
        return null;
    }
}