<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    


    public function upload_image_book(Request $request)
    {
        //upload image
        if (!File::exists(storage_path('app/public/media/books'))) {
            File::makeDirectory(storage_path('app/public/media/books'));
        }

        $file = $request->image;
        $name = $file->hashName();
        $filename = time() . '.' . $name;
        $file->storeAs('public/media/books', $filename);

        return $filename;
    }
}
