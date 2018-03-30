<?php 


//require __DIR__.'/assets/Settings.php';
require __DIR__.'/assets/functions.php';

//update_thumbs(__DIR__);

global $current_dir;

function print_single_directory() {

}

?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes ">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>

        body {
            width: 90%;
            margin: 0 auto;
            position: relative;
            font-family: sans-serif;
        }
        
        .wk-ap {
            margin-top: 50px;
        }

        .wk-ap .root-folder-title {
            background: #f1f1f1;
            padding: 10px 15px;
            text-align: left;
        }

        .wk-ap .root-folder-title h2 {
            margin: 5px 0;
        }

        #wk-overlay {
            position: fixed; 
            width:100%;
            height:100%;
            left: 0;
            top: 0;
            background-color: white;
            text-align:center;
            z-index:999;
            display:none;
            overflow: auto;
        }

        #wk-overlay .close-overlay {
            position: absolute;
            top: 10px;
            right: 15px;
        }

        #wk-overlay .close-overlay svg {
            width: 14px;
            fill: black;
        }
        
        #wk-overlay .image-folder-title {
            background: #f1f1f1;
            padding: 10px 15px;
            margin: 0;
            text-align: left;
            font-size: 14px;
        }


        ul.folder-list, ul.image-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;   
            flex-wrap: wrap; 
            align-content: flex-start;
        }

        ul.image-list {
            width: 90%;
            margin: 20px auto;
        }

        li.folder-item {
            width: calc(50% - 30px);
            max-width: 150px;
            padding-left: 15px;
            padding-right: 15px;
            cursor: pointer;
        }

        .folder-item a img {
            width: 100%;
        }

        .folder-item a h5 {
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 400;
        }

        li.image-item {
            width: calc(50% - 30px);
            max-width: 150px;
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
        }

        li.image-item .image-container {
            width: 100%;
            background-color: #f1f1f1;
            height: 0;
            position: relative;
            padding-top: 100%; /* 1:1 Aspect Ratio */
        }

        li.image-item .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .image-download {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            background-color: transparent;
            transition: background-color 0.5s ease;
        }

         .image-download a {
            opacity: 0;
            width: 80px;
            height: 80px;
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            transition: opacity 0.5s ease;
        }

        li.image-item:hover  .image-download {
            background-color: rgba(0,0,0,.6);
            transition: background-color 0.5s ease;
        }  

        li.image-item:hover  .image-download a {
            opacity: 1;
            transition: opacity 0.5s ease;
        }  
        
        .image-download a svg {
                width: 30px;
                margin-top: 15px;
                fill: white;
        }

        .image-download a span {
            position: relative;
            width: 100%;
            left: 0;
            top: 10px;
            text-decoration: none;
            color: white;
            text-align: center;
            display: inline-block;
        }
        

        .image-item a h5 {
            max-width: 100%;
        }

        @media screen and (min-width: 768px) {
            #wk-overlay {
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
            }

            #wk-overlay .close-overlay {
                position: fixed;
                top: 20px;
                right: 20px;
            }
            
            #wk-overlay .close-overlay svg {
                width: 20px;
                fill: white;
            }   

            #wk-overlay .image-folder-title {
                width: 70%;
                margin: 50px auto;
                background: #f1f1f1;
                padding: 10px 15px;
                text-align: left;
                margin: 100px auto 0;
                font-size: 24px;
            }

            ul.image-list {
                width: 70%;
                margin: 0px auto;
                padding: 50px 15px;
                background-color: white;
                /* display: inline-block; */
            }
        }

        @media screen and (min-width: 1000px) {

        }
        
        
    </style>
    </head>
    <body>
        <div id="wk-overlay">
            <a class="close-overlay">
                <svg x="0px" y="0px" viewBox="35 16 130 129" enable-background="new 35 16 130 129" xml:space="preserve">
                    <g>
                        <polygon points="153.1,20 99.5,73.8 45.8,20 39,26.9 92.6,80.5 39,134.2 45.8,141 99.5,87.4 153.1,141 160,134.2 106.2,80.5 
                            160,26.9 	"/>
                    </g>
                </svg>
            </a>
            <h2 class="image-folder-title"></h2>
            <ul class="image-list"></ul>
        </div>
        <div class="wk-ap">
            <?php
            
            // Codice inline da spezzettare in più funzioni

            // Get json array

            $thumb_src = "http://res.cloudinary.com/verywood/image/upload/c_fill,h_150,w_150/v1/photo_high_res/Blanc/Blanc_01";

            $images_dir = __DIR__ . '/images';

            $root_folders = get_folders($images_dir);

            // MAIN LOOP ...
            foreach ($root_folders as $root_folder) { ?>
                <div class="root-folder-container <?php echo $root_folder; ?>">

                    <div class="root-folder-title">
                        <h2><?php echo $root_folder; ?></h2>
                    </div>
                
                    <?php 
                    $folders = get_folders($images_dir . "/" . $root_folder); ?>

                    <?php
                    if(sizeof($folders)){
                        // SUB-FOLDERS LOOP...
                        // Print all subfolders with title and cover ?>
                        <ul class="folder-list">
                            <?php
                            foreach ($folders as $folder) { ?>
                                <li class="folder-item <?php echo $folder; ?>">
                                    <img src="<?php echo $thumb_src; ?>" alt="<?php echo $folder; ?>" />
                                    <a class="folder-title ajax-link" href="#!<?php echo $folder; ?>" data-parent="<?php echo $root_folder; ?>" data-folder="<?php echo $folder; ?>" >
                                        <h3><?php echo $folder; ?></h3>
                                    </a>
                                </li>
                            <?php } // END FOR FOLDERS ?>
                        </ul>
                    <?php } // END IF ?>
                </div>
            <?php } ?>
        </div>
        


        <script>
            /** 
             *  Insert content in overlay element and fadein it when images are loaded
             *  @param  folder (object)
             */
            function populateOverlay(folder, name){

                // Empty ul element
                $('#wk-overlay .image-list').empty();
                var html_content = '';
                var array_path;
                var image_file_name;
                var file_weight;
                $('#wk-overlay .image-folder-title').html(folder);

                images = get_files(folder);
                // For each image in that folder creates html content
                for(var images in image) {

                    array_path = folder.images[image].public_id.split("/");
                    image_file_name = (array_path[2] + "." + folder.images[image].format)
                    if(image_file_name.length > 20){
                        image_file_name = image_file_name.substring(0, 16) + " ...";
                    }
                    
                    file_weight = niceBytes(folder.images[image].bytes);
                    

                    html_content += 
                        '<li class="image-item">' +
                            '<div class="image-container"><img src="' + folder.images[image].cover + '" alt="' + folder.images[image].public_id + '" />' +
                                '<div class="image-download">' +
                                    '<a href="' + folder.images[image].url + '" download>' +
                                    '<svg viewBox="29 29 142 141"><polygon points="146.7 113.3 146.7 140 53.3 140 53.3 113.3 33.3 113.3 33.3 140 33.3 166.7 53.3 166.7 146.7 166.7 166.7 166.7 166.7 140 166.7 113.3"/><polygon points="120 86 120 33.3 80 33.3 80 86 58.7 86 100 127.3 141.3 86"/></svg>' +
                                    '<span class="image-weight">' + file_weight + '</span>' +
                                    '</a>' + 
                                '</div>' +
                            '</div>' +
                            '<h5 class="image-title">' + image_file_name + '</h5>' +
                        '</li>';
                }
                
                // Appends html content to ul element
                $('#wk-overlay .image-list').append(html_content);
                
                // When the images are loaded, fadein overlay
                $('.image-item img').load(function(evt){
                    $('#wk-overlay').fadeIn();
                });
            }
            
            
            const units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            function niceBytes(x){

                let l = 0, n = parseInt(x, 10) || 0;
                while(n >= 1024 && ++l)
                    n = n/1024;

                return(n.toFixed(n >= 10 || l < 1 ? 0 : 1) + ' ' + units[l]);
            }



            // Listener for click in folder item event
            $('.folder-item a').on('click', function(){
                var parent = $(this).attr('data-parent');
                var folder = $(this).attr('data-folder');
                
                populateOverlay("<?php echo __DIR__; ?>/" + parent + "/" + folder, folder);
                
            });
            
            // Listener for click in X event
            $('#wk-overlay .close-overlay').on('click', function(){
                $('#wk-overlay .image-list').empty();
                $('#wk-overlay').fadeOut();
            });

        </script>

    </body>
</html>