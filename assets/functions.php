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



function webkolm_ajax_populateOverlay(){

    $folder = $_POST[ 'folder_path' ];

    return "prova";

    //echo $folder;

    //$files = get_files($folder);

   // print_r($files);
/*
    $output = "";

    foreach ($files as $file) {
        $output .= '
            <li class="image-item">
                <div class="image-container">
                    <img src="' . $folder . '/' . $file . '" alt="photo_high_res/Carmen/VeryWood55532">
                    <div class="image-download">
                        <a href="' . $folder . '/' . $file . '" download="">
                            <svg viewBox="29 29 142 141"><polygon points="146.7 113.3 146.7 140 53.3 140 53.3 113.3 33.3 113.3 33.3 140 33.3 166.7 53.3 166.7 146.7 166.7 166.7 166.7 166.7 140 166.7 113.3"></polygon><polygon points="120 86 120 33.3 80 33.3 80 86 58.7 86 100 127.3 141.3 86"></polygon></svg>
                            <span class="image-weight">652 KB</span>
                        </a>
                    </div>
                </div>
                <h5 class="image-title">'. $file .'</h5>
            </li>';
    }

    return $output;
*/
}

?>