<?php

function admin_vw()
{
    return 'admin';
}
function user_vw()
{
    return 'user';
}

function admin_lookup_vw()
{
    return 'admin.lookup';
}

function attendance_vw()
{
    return 'attendance';
}

function setting_vw()
{
    return 'setting';
}
function report_vw()
{
    return 'report';
}
function guardian_vw()
{
    return 'guardian';
}
function role_vw()
{
    return 'role';
}
function storeImage($image, $pathImg, $api = true)
{

    $ext = $image->getClientOriginalExtension();
    $imgContent = File::get($image);


    $file_name = str_random(40) . time() . "." . $ext;
    $fullPath = public_path() . "/storage" . $pathImg . $file_name;

    $path = $file_name;
    File::put($fullPath, $imgContent);
    return $path;
}

