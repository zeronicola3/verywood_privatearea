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
        $output .= '
            <li class="image-item">
                <div class="image-container">
                    <img src="' . $folder . '/' . $file . '" alt="photo_high_res/Carmen/VeryWood55532">
                    <div class="image-download">
                        <a href="' . $folder . '/' . $file . '" download="">
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
