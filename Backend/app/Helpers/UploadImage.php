<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class UploadImage
{
    public static function uploadImage($image, $directory = 'uploads', $oldImagePath = null)
    {
        // If an old image exists, delete it
        if ($oldImagePath && Storage::exists($oldImagePath)) {
            Storage::delete($oldImagePath);
        }

        // Generate a new image filename and store it
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs($directory, $imageName, 'public');

        return $imagePath;
    }
}
