<?php
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

/**
 * Funzione che stampa il contenuto di un overlay di immagini presenti nella cartella
 * @param   folder_path  ->  percorso assoluto della cartella (AJAX)
 */
function webkolm_ajax_populateOverlay(){

        $folder = $_POST[ 'folder_path' ];

        $files = get_files($folder);

        //print_r($files);

    $output = "";

    foreach ($files as $file) {
        $file_size = FileSizeConvert(filesize( $folder . '/' . $file ));
        $img_file_uri = get_img_uri($folder, $file);
        $img_uri = get_thumb_uri($folder, $file);

        $output .= '
            <li class="image-item">
                <div class="image-container">
                    <img src="'. $img_uri .'" alt="">
                    <div class="image-download">
                        <a href="' . $img_file_uri . '" download="">
                            <svg viewBox="29 29 142 141"><polygon points="146.7 113.3 146.7 140 53.3 140 53.3 113.3 33.3 113.3 33.3 140 33.3 166.7 53.3 166.7 146.7 166.7 166.7 166.7 166.7 140 166.7 113.3"></polygon><polygon points="120 86 120 33.3 80 33.3 80 86 58.7 86 100 127.3 141.3 86"></polygon></svg>
                            <span class="image-weight">' . $file_size . '</span>
                        </a>
                    </div>
                </div>
                <h5 class="image-title">'. $file .'</h5>
            </li>';
    }

    echo $output;

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

webkolm_ajax_populateOverlay();
?>
