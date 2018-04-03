<?php 

//require __DIR__.'/assets/Settings.php';
require __DIR__.'/assets/functions.php';

?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes ">
    

    <style>

        .bloccosroll {
            position: fixed;
            overflow: hidden;
        }

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

        #wk-overlay .sk-cube-grid {
            position: fixed;
            top: 50vh;
            left: 50vw;
            transform: translateX(-50%) translateY(-50%);
        }


        .sk-cube-grid {
            width: 80px;
            height: 80px;
        }

        .sk-cube-grid .sk-cube {
            width: 33%;
            height: 33%;
            background-color: #000;
            float: left;
            -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
                    animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out; 
        }
            .sk-cube-grid .sk-cube1 {
            -webkit-animation-delay: 0.2s;
                    animation-delay: 0.2s; }
            .sk-cube-grid .sk-cube2 {
            -webkit-animation-delay: 0.3s;
                    animation-delay: 0.3s; }
            .sk-cube-grid .sk-cube3 {
            -webkit-animation-delay: 0.4s;
                    animation-delay: 0.4s; }
            .sk-cube-grid .sk-cube4 {
            -webkit-animation-delay: 0.1s;
                    animation-delay: 0.1s; }
            .sk-cube-grid .sk-cube5 {
            -webkit-animation-delay: 0.2s;
                    animation-delay: 0.2s; }
            .sk-cube-grid .sk-cube6 {
            -webkit-animation-delay: 0.3s;
                    animation-delay: 0.3s; }
            .sk-cube-grid .sk-cube7 {
            -webkit-animation-delay: 0s;
                    animation-delay: 0s; }
            .sk-cube-grid .sk-cube8 {
            -webkit-animation-delay: 0.1s;
                    animation-delay: 0.1s; }
            .sk-cube-grid .sk-cube9 {
            -webkit-animation-delay: 0.2s;
                    animation-delay: 0.2s; }

            @-webkit-keyframes sk-cubeGridScaleDelay {
            0%, 70%, 100% {
                -webkit-transform: scale3D(1, 1, 1);
                        transform: scale3D(1, 1, 1);
            } 35% {
                -webkit-transform: scale3D(0, 0, 1);
                        transform: scale3D(0, 0, 1); 
            }
            }

            @keyframes sk-cubeGridScaleDelay {
            0%, 70%, 100% {
                -webkit-transform: scale3D(1, 1, 1);
                        transform: scale3D(1, 1, 1);
            } 35% {
                -webkit-transform: scale3D(0, 0, 1);
                        transform: scale3D(0, 0, 1);
            } 
            }

        #wk-overlay .close-overlay {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
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
            display:none;
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
            display:none;
        }

        li.folder-item {
            width: calc(50% - 30px);
            max-width: 150px;
            padding-left: 15px;
            padding-right: 15px;
            cursor: pointer;
            
        }


        
        li.folder-item:hover a img, li.folder-item:hover a h5 {
            opacity: .5;
            transition: opacity .2s;
        }

        .folder-item a img {
            width: 100%;
             background-color: #f1f1f1;
             transition: opacity .2s;
        }

        .folder-item a h5 {
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 400;
            transition: opacity .2s;
            color: #000;
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
            color: #000;
        }

        h5.image-title {
           word-wrap: break-word;
           color: #000;
        }


        a.folder-title.ajax-link {
            color: black;
            text-decoration: none;
        }

        
        .files-list {
            list-style-type: none;
            padding-left: 15px;
            display: flex;
            width: 100%;
            justify-content: space-between;
            display: block;
            position: relative;
            flex-wrap: wrap;
        }
        
        .files-list .file-item {
            width: 100%;
            display: inline-block;
            padding-right: 20px;
            word-wrap: break-word;
            color: #000;
            
        }  

        .files-list .file-item a h5 {
            position: relative;
            width: 100%;
            margin: .7em 0;
            color: black;
            transition: opacity .2s;
            text-decoration: none;
        }

        .files-list .file-item a:hover h5 {
            opacity: .5;
             transition: opacity .2s;
        }

        .files-list .file-item a {
            display: inline-block;
            text-decoration: none;
        }



        @media screen and (min-width: 768px) {

            .sk-cube-grid .sk-cube {
                background-color: #fff;
            }

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

            .files-list .file-item {
                width: 45%;
            }

            .folder-item a img {
                height: 150px;
            }
        }

        @media screen and (min-width: 1000px) {
            .files-list .file-item {
                width: 30%;
            }
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
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
            <h2 class="image-folder-title"></h2>
            <ul class="image-list"></ul>
        </div>
        <div class="wk-ap">
            <?php
            
            // Codice inline da spezzettare in più funzioni

            // Get json array

            $thumb_src = "http://res.cloudinary.com/verywood/image/upload/c_fill,h_150,w_150/v1/photo_high_res/Blanc/Blanc_01";

            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";   

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
                            foreach ($folders as $folder) { 
                                
                                $current_dir_path = $images_dir . "/" . $root_folder ."/". $folder;
                                $current_thumb = get_thumb_uri( $root_folder ."/". $folder,scandir($current_dir_path)[2]);
                                ?>
                                <li class="folder-item <?php echo $folder; ?>">
                                    <a class="folder-title ajax-link" href="#!<?php echo $folder; ?>" data-parent="<?php echo $folder; ?>" data-folder="<?php echo $current_dir_path; ?>" >
                                        <img src="<?php echo $current_thumb; ?>" alt="<?php echo $folder; ?>" />
                                        <h3><?php echo $folder; ?></h3>
                                    </a>
                                </li>
                            <?php } // END FOR FOLDERS ?>
                        </ul>
                    <?php } // END IF ?>
                </div>
            <?php } 
            
            print_noimages_folders('documents');
            print_noimages_folders('2d');
            print_noimages_folders('3d');
            
            
            
            ?>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script>

            /** 
             *  Insert content in overlay element and fadein it when images are loaded
             *  @param  folder (object)
             */
            function populateOverlay(folder, name){
                // RICHIESTA AJAX PER SEARCH
                $.ajax({
                    url: './ajax-overlay.php',
                    type: 'post',
                    data: {
                        action: 'webkolm_ajax_populateOverlay',
                        folder_path: folder
                    },
                    success: function( result ) {
                    
                        // SE LA RICERCA NON VA A BUON FINE
                        if( result === 'error' ) {
                            
                        
                        // SE LA RICERCA VA A BUON FINE
                        } else {
                           
                            $('.image-folder-title').html(name);
                            $('.image-list').html(result);
                            $('.sk-cube-grid').fadeOut();
                            $('#wk-overlay .image-list, #wk-overlay h2').fadeIn();
                            $('#wk-overlay .image-list').css({display: 'flex'});
                            
                            /*
                            //to change the browser URL to the given link location
                            if(pageurl!=window.location){
                                window.history.pushState({path:pageurl},'',pageurl);
                            }
                            */
                        }
                    }
                });

            }
            
            // Listener for click in folder item event
            $('.folder-item a').on('click', function(){
                $('html').addClass('bloccosroll');
                $('#wk-overlay').fadeIn();
                $('.sk-cube-grid').fadeIn();
                var parent = $(this).attr('data-parent');
                var folder = $(this).attr('data-folder');
                
                populateOverlay(folder, parent);
            });
            
            // Listener for click in X event
            $('#wk-overlay .close-overlay').on('click', function(){
                $('#wk-overlay .image-list').empty();
                $('#wk-overlay').fadeOut();
                $('html').removeClass('bloccosroll');
            });

        </script>

    </body>
</html>