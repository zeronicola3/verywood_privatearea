<?php

function crop_img($imgSrc,$thumbdest){
    //getting the image dimensions
    list($width, $height) = getimagesize($imgSrc);


    //saving the image into memory (for manipulation with GD Library)
    $myImage = imagecreatefromjpeg($imgSrc);


    // calculating the part of the image to use for thumbnail
    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    }

    // copying the part into thumbnail
    $thumbSize = 100;
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

    imagejpeg($thumb,$thumbdest);
    @imagedestroy($myImage);
    @imagedestroy($thumb);

}
/*
function update_thumbs($dir){

    $files1 = scandir($dir);

    $thumbs_dir = '/srv/users/serverpilot/apps/privarearea/public';

    print_r($files1);

    foreach ($files1 as $file) {

        if ( ($file != "..") && ($file != ".") ) {
            $filepath = $thumbs_dir . $file;
            // CERCO SE CE GIA L'IMMAGINE
            $filename = $dir . $file;
            if (file_exists($filename)){
                echo $filename;
            }
            else{
                //crop_img($filepath,$filename);
            }
            $size = ((filesize($filepath)/1000));
            $size = number_format($size, 2);
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
            $withoutExt=str_replace('_', ' ', $withoutExt);
        }
    }
    
}
*/

//update_thumbs();

function get_folders($folder){

    $folder_items = scandir($folder);
    $result_array = [];

    foreach ($folder_items as $item) {
        if ( ($item != "..") && ($item != ".") ) {
            if(is_dir($folder . "/" . $item)){
                array_push($result_array, $item);
            }
        }
    }
    return $result_array;
}


function get_files($folder){

    $folder_items = scandir($folder);
    $result_array = [];

    foreach ($folder_items as $item) {
        if ( ($item != "..") && ($item != ".") ) {
            if(is_file($folder . "/" . $item)){
                array_push($result_array, $item);
            }
        }
    }
    return $result_array;
}

?>