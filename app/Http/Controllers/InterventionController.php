<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class InterventionController extends Controller
{
    public function __invoke(
        string $dir,
        string $method,
        string $size,
        string $file
    ) {
        abort_if(
            !in_array($size, config('thumbnail.allowed_sizes', [])),
            403,
            'Image size not allowed'
        );

        $storage = Storage::disk('image');

        $realPath = "$dir/$file";
        $newDir = "$dir/$method/$size";
        $newFile = "$newDir/$file";

        if ($storage->exists($newFile)) {
            return;
        }

        if (!$storage->exists($newDir)) {
            $storage->makeDirectory($newDir);
        }


        $image = Image::make($storage->path($realPath));

        [$w, $h] = explode('x', $size);

        $image->{$method}($w, $h);

        $image->save($storage->path($newFile));

        return response()->file($storage->path($newFile));
    }
}
