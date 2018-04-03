<?php


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




/**
 * Funzioneche restituisce tutti i files contenuti in una cartella
 * @param   $folder   ->   percorso asoluto della cartella
 */
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



function crop_img($imgSrc,$thumbdest){
    //getting the image dimensions
    list($width, $height) = getimagesize($imgSrc);

    //echo 'Limit: ' . ini_get('memory_limit') . "\n";
    //echo 'Usage before: ' . memory_get_usage()."\n";

    ini_set('memory_limit',((integer) memory_get_usage()/1000) . 'M');
        
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
    $thumbSize = 150;
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

    imagejpeg($thumb,$thumbdest);
    @imagedestroy($myImage);
    @imagedestroy($thumb);

}


/** 
 * recursively create a long directory path
 */
function createPath($path) {
    if (is_dir($path)) return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}


function generate_thumb($path){
    if(@getimagesize($path)){
        $array_path = explode("/", $path);
        $array_path[0] = "thumbs";
        $dest = implode("/", $array_path);
        array_pop($array_path);
        $folders_path = implode("/", $array_path);

        if(createPath( $folders_path)){
            crop_img($path, $dest);
        }
        
    }

}

function get_img_uri($path, $file){
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; 
    $path_array = explode("/", $path);
    return $actual_link . "/images/" . $path_array[sizeof($path_array) - 2] . "/" . $path_array[sizeof($path_array) - 1] . "/" . $file;
}

function get_thumb_uri($path, $file){

    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; 
    $path_array = explode("/", $path);
    $relative_path = "thumbs/" . $path_array[sizeof($path_array) - 2] . "/" . $path_array[sizeof($path_array) - 1] . "/" . $file;
    $uri = $actual_link . "/" . $relative_path;

    $thumb_path = "thumbs/" . $path_array[sizeof($path_array) - 2] . "/" . $path_array[sizeof($path_array) - 1] . "/" . $file;

    if(!file_exists( $thumb_path)){
        generate_thumb("images/" . $path_array[sizeof($path_array) - 2] . "/" . $path_array[sizeof($path_array) - 1] . "/" . $file);
    }

    return $uri;
}



/**
 * Funzione per la conversione delle dimensioni dei files
 * @param   $bytes  ->  chiaramente in bytes
 */
function FileSizeConvert($bytes){
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem){
        if($bytes >= $arItem["VALUE"]){
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}


function print_noimages_folders($folder){ 
    
    
    ?>
    <div class="root-folder-container <?php echo $folder; ?>">

        <div class="root-folder-title">
            <h2><?php echo $folder; ?></h2>
        </div>
    
        <?php 
        $files = get_files($folder); 
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; 
        ?>

        <?php
        if(sizeof($files)){
            // SUB-FOLDERS LOOP...
            // Print all subfolders with title and cover ?>
            <ul class="files-list">
                <?php
                foreach ($files as $file) { 
                    
                    $current_dir_path = $folder ."/". $file;
                    $file_link = $actual_link . "/" . $current_dir_path;
                    ?>
                    <li class="file-item ">
                        <a class="folder-title ajax-link" href="<?php echo $file_link; ?>" download="">
                            <h5><?php echo $file; ?></h5>
                        </a>
                    </li>
                <?php } // END FOR FOLDERS ?>
            </ul>
        <?php } // END IF ?>
    </div>


<?php
}




?>