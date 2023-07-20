<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function UploadImage($file)
    {
        // generate new image name
        $name_gen = hexdec(uniqid());
        $file_ext = strtolower($file->extension());
        $file_name = $name_gen . '.' . $file_ext;

        // check path to keep files like "images/2022/01/"
        $upload_folder = "images/" . date('Y') . "/" . date('m') . '/';

        // check folder if not exist we will create folder
        if (!File::exists(public_path($upload_folder))) {
            File::makeDirectory(public_path($upload_folder), 0777, true, true);
        }

        // move file
        $file->move(public_path($upload_folder), $file_name);

        return $upload_folder . $file_name;
    }
}
