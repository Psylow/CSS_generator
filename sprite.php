<?php
function css_generator($tab)
{
    $renderName = "Sprite";
    $path = getcwd();
    $imgrender = $renderName . ".png";
    $background = 0;
    $column = 0;
    $padding = 0;
    $html = "<!doctype HTML>
        <html>
        <head>
        <title>My Sprite</title>
        <link rel='stylesheet' type='text/css' href='../Render/style.css'>
        </head>
        <body>
        <div class='titre'>
        <p>Sprite created :</p>
        </div>
        <img src=$imgrender class='center'>
        <div class='footer'>
        <p>Sprite created and designed by Mickaël Morel.</p>
        </div>
        </body>
        </html>";
    $css = "    body {
                background-image: url(../../Pictures/backgroundcss.png);
                background-repeat: no-repeat;
                background-position: center;
                background-size: 2000px;
    }
            .titre {
                font-family: Helvetica;
                font-size: 50px;
                text-align: center;
                color: black;
                font-weight: bold;
                margin-top: 100px;
    }
        .footer{
            font-family: Helvetica;
            font-size: 30px;
            text-align: center;
            color: black;
            font-weight: bold;
        }
        .center{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
    .sprite {
        display: inline-block;
    background: url('" . $renderName . ".png') no-repeat;\n
    }";
    for ($i = 0; $i < count($tab[0]); $i++) {
        $css .= "." . $tab[0][$i] . "{\n\tbackground-position: -" . $background . "px;\n\twidth: " . $tab[1][$i] . "px;\n\theight: " . $tab[2][$i] . "px;\n}\n";
        $background += $tab[1][$i];
    }
    $myhtml = fopen($path . '/Render/' . 'index.html', 'w');
    fwrite($myhtml, $html);
    fclose($myhtml);
    $mycss = fopen($path . '/Render/' . 'style.css', 'w');
    fwrite($mycss, $css);
    fclose($mycss);
}
function sprite_generator($tab)
{
    $renderName = "Sprite";
    $array = array();
    $namePicture = array();
    $widthPicture = array();
    $heightPicture = array();
    $path = getcwd();
    $height = 0;
    $width = 0;
    $padding = 0;
    foreach ($tab as $value) {
        $size = getimagesize($value);
        if ($height < $size[1]) {
            $height = $size[1];
        }

        $width += $size[0];
        $value = basename($value);
        $value = str_replace(".png", "", $value);
        $value = str_replace("-", "", $value);
        $value = "sprite-" . $value;
        array_push($namePicture, $value);
        array_push($widthPicture, $size[0]);
        array_push($heightPicture, $size[1]);
    }
    array_push($array, $namePicture);
    array_push($array, $widthPicture);
    array_push($array, $heightPicture);
    $img = @imagecreatetruecolor($width, $height);
    foreach ($tab as $value) {
        $picture = imagecreatefrompng($value);
        $size = getimagesize($value);
        imagecopyresampled($img, $picture, $padding, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
        $padding += $size[0];
    }
    imagepng($img, $path . '/Render/' . $renderName . ".png");
    return $array;
}
function check_dir_images($argv)
{
    $folder = (count($argv) < 2) ? die("Chemin du dossier manquant.\n") : (is_dir($argv[1])) ? $folder = $argv[1] : die("Dossier inexistant.\n");
    if ($handle = opendir($folder)) {
        while (($currentFile = readdir($handle)) !== false) {
            if ($currentFile != "." && $currentFile != "..") {
                if (exif_imagetype($folder . "/" . $currentFile) == IMAGETYPE_PNG) {
                    $results_array[] = $folder . "/" . $currentFile;
                }
            }

        }
    }
    closedir($handle);
    $path = getcwd();
    if (count($results_array) < 2) {
        die("2 photos minimum.\n");
    }

    if (!file_exists($path . '/Render')) {
        mkdir($path . '/Render', 0777, true);
    } else {
        die("Dossier déjà créé.\n");
    }

    return $results_array;
}
function addPadding($argv)
{
    if($argv[3] == NULL){
        die("Veuillez entrer une valeur après l'argument -p.");
    }
    else{
        $css .= ".sprite{
            padding: $padding;
        }";
    }
}
function addSize($argv){
    if($argv[4] == NULL){
        die("Veuillez entrer une valeur après l'argument -o");
    }
    else{
        $css .= ".sprite{
            width: $width;
            height: $height;
        }";
    }
}
function addColumn($argv){
    if(argv[4] == NULL){
        die("Veuillez entrer une valeur après l'argument -c");
    }
    else{
        $css .= ".sprite{
          column-count: $column;
          }";
    }
}

function option($argv)
{
    $opt = (count($argv) < 3) ? die("Options non prises en compte.\n") : (is_string($argv[2])) ? $option = $argv[2] : die("Option inexistante.\n");
    switch($argv[2]){
        case "-p":
            echo "Le padding de l'image";
            addPadding($argv);
            break;
        case "-o":
            echo "la taille de l'image";
            addSize($argv);
            break;
        case "-c":
            echo "le nombre d'élément par colonne horizontale";
            addColumn($argv);
            break;
        default:
            echo "Il n'y a pas d'option.";
            break;
    }
}
function loader()
{
    $i = 0;
    $loader = "";
    while ($i < 50) {
        system('clear');
        echo "Initialisation du sprite en cours : \033[36;46;7m$loader\033[0m \033[36m$i%\033[31m";
        $loader = $loader . "#";
        usleep(50000);
        $i += 2;
    }
    $loader = "";
    while ($i <= 98) {
        system('clear');
        echo "Initialisation prête.\n";
        echo "Création du sprite en cours : \033[36;46;7m$loader\033[0m \033[36m$i%\033[31m";
        $loader = $loader . "#";
        usleep(50000);
        $i++;
    }
    while ($i <= 99) {
        system('clear');
        echo "Initialisation prête.\n";
        echo "Création du sprite en cours : \033[36;46;7m$loader\033[0m \033[36m$i%\033[31m";
        $loader = $loader . "#";
        sleep(1);
        $i++;
    }
    while ($i == 100) {
        system('clear');
        echo "Initialisation prête.\n";
        echo "Création du sprite en cours : \033[36;46;7m$loader\033[0m \033[36m$i%\033[31m";
        $loader = $loader . "#";
        $i++;
    }
    system('clear');
    echo "Création terminée.\n";
    echo "Dossier Rendu crée dans => " . getcwd() . "\n";
}
css_generator(sprite_generator(check_dir_images($argv)));
loader();
