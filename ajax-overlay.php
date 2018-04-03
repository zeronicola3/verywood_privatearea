<?php
require __DIR__.'/assets/functions.php';
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

webkolm_ajax_populateOverlay();
?>
