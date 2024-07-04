<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

const ADMIN_ROLE = 'admin-role';
const PATIENT_ROLE = 'patient-role';

const STATUS_ACTIVE = 'PUBLISHED';
const STATUS_INACTIVE = 'DRAFT';
const STATUS_FINISH = 'FINISHED';

const STATUS_UPCOMING = 'UPCOMING';


const REMOVE_MESSAGE = 'All relevant items will be removed permanently and You will not be able to recover this imaginary file!';

// ================ Image Upload =========================== //
function ImageUpload($new_file, $path, $old_image = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }
    $file_name = Str::slug($new_file->getClientOriginalName()) . '_' . rand(111111, 999999) . '.' . $new_file->getClientOriginalExtension();
    $destinationPath = public_path($path);

    if ($old_image != null) {
        if (File::exists(public_path($old_image))) {
            unlink(public_path($old_image));
        }
    }

    $new_file->move($destinationPath, $file_name);

    return $path . $file_name;
};

function ResizeImageUpload($new_file, $path, $old_image, $w, $h)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }

    $destinationPath = public_path($path);
    $file_name = Str::slug($new_file->getClientOriginalName()) . '_' . rand(111111, 999999) . '.' . $new_file->getClientOriginalExtension();

    if ($old_image != null) {
        if (File::exists(public_path($old_image))) {
            unlink(public_path($old_image));
        }
    }

    // create image manager with desired driver
    $manager = new ImageManager(new Driver());

    $image = $manager->read($new_file);
    $image->cover($w, $h);
    $image->save($destinationPath . $file_name);

    return $path . $file_name;
};

function removeImage($file)
{
    if ($file != null) {
        if (File::exists(public_path($file))) {
            unlink(public_path($file));
        }
    }
}

function generateRandomString($length = 4)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString . '-';
}



function custom_path($name) {
    $url = $name;
    $baseUrl = url('/') . '/';
    $path = str_replace($baseUrl, '', $url);
    return $path;
}