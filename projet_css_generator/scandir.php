<?php

/*                                                                  fluzzy area                                                                */



/*                                                 liste le fichier ou dossier émit                                                 */
// $short = "r:";
// $option = array("recursive:");
// $o = getopt($short, $option);
// $files_array = $argv[$argc-1];
// $tab = array();

// function list_to_files($files_array) 
// {
//    global $tab;
//        $files_array = array($files_array);
//            foreach($files_array as $file) 
//            {  
//                if(is_dir($file)) 
//                {
//                    $tab = scan_all_dir($file);
//                }
//                elseif(file_exists($file)) 
//                {
//                    array_push($tab, $file);
//                }
//                else
//                {
//                    echo "Une erreur c'est produite veuillez réessayer";
//                }
//            }
//            return $tab;
// }

// function scan_all_dir($dir) 
// {
//    $result = array();
//        foreach(scan_dir($dir) as $filename) 
//        {
//            if ($filename[0] == '.') 
//            continue;
           
//            $filePath = $dir . '/' . $filename;
           
//            if (is_dir($filePath)) 
//            {
//                foreach (scan_all_dir($filePath) as $childFilename) 
//                {
//                    $result[] = /*$filename . '/' . */$childFilename;
//                }
//            } 
//            else 
//            {
//            $result[] = $filename;
//            }
//        }
//    return $result;
// }

// function scan_dire($dir)
// {
//    $files = array();
//        if($op = opendir($dir))
//        {
//            while(($filename = readdir($op)) == true) 
//            {
//                if($filename == '.' || $filename == '..')
//                    continue;
//                else
//                    $files[] = $filename;
//            }
//            return $files;
//        }
//        else
//        {
//            return false;
//        }
// }

$short = "r:";
$short .= "i::";
$short .= "s::"; 
$short .= "c::";
$short .= "o::";
$short .= "p::";
// $short .= "z::";
$option = array("recursive:", "output-image::", "output-style::", "columns_number::", "override-size::", "padding::"/*, "resize_img::"*/);
$o = getopt($short, $option);
$tab = array();
$files_array = $argv[$argc-1];


/*                                                             concatenation                                                             */
function concatenation()
{
    global $o;
    global $files_array;
    $fileList = array();
    $recursive = (array_key_exists("recursive", $o) || array_key_exists("r", $o));

    scan_dir($files_array, $recursive, $fileList); // function scan_dir

    $maxHeight = 0;
    $totalWidth = 0;
    
    var_dump($o); // -------------------------------------------------------------------------------------

    
    $result = type($fileList, $totalWidth, $maxHeight); // function type
    $nbr_images = count($result); // récupère le nombre d'image
    
    
    if(array_key_exists("override-size", $o))
    {
        $image = imagecreatetruecolor($o["override-size"], $o["override-size"]);   // mettre en commentaire puis utiliser imagecopyresize() à imagecopy 
        $background = imagecolorallocatealpha($image, 0, 0, 0, 0);
    }
    elseif(array_key_exists("o", $o))
    {
        
        $image = imagecreatetruecolor($o["o"], $o["o"]);
        $background = imagecolorallocatealpha($image, 0, 0, 0, 0);
    }
    elseif(array_key_exists("c", $o))
    {
        $image = imagecreatetruecolor(1000, 1000);
        $background = imagecolorallocatealpha($image, 0, 0, 0, 0);
    }
    else
    {
        $image = imagecreatetruecolor($totalWidth, $maxHeight); // creation image black - width maximum de l'image; (w, h)
        $background = imagecolorallocatealpha($image, 0, 0, 0, 0); // generation copy picture in the image black
    }


    $i = 0;
    $spaceX = 0;
    $spaceY1 = 0;
    $spaceY = $result[$i]["height"];
    
            if(array_key_exists("c", $o))
            {
                for($h = 0; $h < ($nbr_images - 1); $h++)
                {
                    for($w = 0; $w < $o["c"]; $w++)
                    {
                        imagecopy($image, $result[$i]["img"], $spaceX, $spaceY1, 0, 0, $result[$i]["width"], $result[$i]["height"]);
                        $spaceX += (0 + $result[$i]["width"]); // + copy de la largeur de l'image;
                        $w += $result[$i]["width"];
                        $i++;
                    }
                    var_dump($w);
                    if($i == $o["c"])
                    {
                        imagecopy($image, $result[$i]["img"], 0, $spaceY, 0, 0, $result[$i]["width"], $result[$i]["height"]);
                        $spaceY += $result[$i]["height"];
                        $i++;
                        // $spaceX = 0;
                        // $spaceY1 = $result[$i]["height"];
                        // $w = 0;
                    }
                }
            }
            elseif(array_key_exists("p", $o))
            {
                $xray = floor(($o["p"] / $nbr_images) + $o["p"]);
                $yray = floor(($o["p"] / $nbr_images) + $o["p"]);
                
                for($w = 0; $w < $totalWidth; $w++)
                {
                    imagecopyresampled($image, $result[$i]["img"], $spaceX, 0, 0, 0, $xray, $yray/* modify for height*/, $result[$i]["width"], $result[$i]["height"]);
                    $spaceX += (0 + $xray);
                    $w += $result[$i]["width"];
                    $i++;
                }
            }
            elseif(array_key_exists("o", $o))
            {
                $xray = floor(($o["o"] / $nbr_images));
                $yray = floor(($o["o"] / $nbr_images));
                
                for($w = 0; $w < $totalWidth; $w++)
                {
                    imagecopyresampled($image, $result[$i]["img"], $spaceX, 0, 0, 0, $xray, $yray/* modify for height*/, $result[$i]["width"], $result[$i]["height"]);
                    $spaceX += (0 + $xray);
                    $w += $result[$i]["width"];
                    $i++;
                }
            }
            elseif(array_key_exists("override", $o))
            {
                $xray = floor(($o["override"] / $nbr_images));
                $yray = floor(($o["override"] / $nbr_images));
                
                for($w = 0; $w < $totalWidth; $w++)
                {
                    imagecopyresampled($image, $result[$i]["img"], $spaceX, 0, 0, 0, $xray, $yray, $result[$i]["width"], $result[$i]["height"]);
                    $spaceX += (0 + $xray);
                    $w += $result[$i]["width"];
                    $i++;
                }
            }
            else
            {
                for($w = 0; $w < $totalWidth; $w++)
                {
                    imagecopy($image, $result[$i]["img"], $spaceX, 0, 0, 0, $result[$i]["width"], $result[$i]["height"]); // moitié de width maximum; (w, h) // taille de l'image
                    $spaceX += (0 + $result[$i]["width"]); // + copy de la largeur de l'image;
                    $w += $result[$i]["width"];
                    $i++;
                    // imagecopy($image, $img_type, 0, $spaceY, 0, 0, $file["width"], $file["height"]); // moitié de width maximum; (w, h) // taille de l'image
                    // $spaceY += 0 + $file["height"];
                    // $spaceX += (0 /*spacing*/ + $file["width"]); // + copy de la largeur de l'image;
                }
            }

    if(array_key_exists("output-image", $o))
    {
        $outfile = "img_final\\" . $o["output-image"];
        $create_img = imagepng($image, $outfile);
        $name_for_sprite = $o["output-image"];
    }
    elseif(array_key_exists("i", $o))
    {
        $outfile = "img_final\\" . $o["i"];
        $create_img = imagepng($image, $outfile);
        $name_for_sprite = $o["i"];
    }
    else
    {
        $outfile = "img_final\sprite.png";
        $create_img = imagepng($image, $outfile);
        $name_for_sprite = "sprite.png";
    }

    // to execut a sprite file
sprite_fichier($name_for_sprite, $nbr_images, $result);
}



var_dump(concatenation($argv));


/* function                                             scan/recursive                                                          */
function scan_dir($dir, $recursive, &$localFiles)
{
    if($op = opendir($dir))
    {
        while(false !== ($filename = readdir($op))) 
        {
            if(!($filename == '.' || $filename == '..'))
            {
                $filePath = $dir . "\\" . $filename;
            
                if (is_dir($filePath) && ($recursive)) 
                {
                    scan_dir($filePath, $recursive, $localFiles);
                }
                elseif(is_file($filePath))
                {
                    $localFiles[] = $filePath;                    
                }
            }
        }
    }
}

/*                                                            function type                                                     */
function type($array, &$totalWidth, &$maxHeight)
{
    global $o;
    $result = array();

    foreach($array as $i => $img)
    {
        list($w, $h, $t) = getimagesize($img);
        
        if($t == IMAGETYPE_PNG)
        {
            $gd_image = imagecreatefrompng($img);
        }
        elseif($t == IMAGETYPE_JPEG)
        {
            $gd_image = imagecreatefromjpeg($img);            
        }
        elseif($t == IMAGETYPE_GIF)
        {
            $gd_image = imagecreatefromgif($img); 
        }
        else
        {
            echo "Attention. Vérifier que toute les images souhaités soit bien prises en charges\n" . 
                "Nous gérons des images .PNG .JPEG et .GIF, veuillez vérifier le type d'image que vous nous envoyez\n";
        }        

        $r = array("file" => $img, "type" => $t, "width" => $w, "height" => $h, "img" => $gd_image);   
        if(array_key_exists("c", $o))
        {
            $c = $o["c"];
            static $i = 0;
            if($i < $c)
            {
                $totalWidth += $w;
                $i += 1;
            }
        }
        else
        {
            $totalWidth += $w; 
        }
        if ($h > $maxHeight) $maxHeight = $h;
        array_push($result, $r);
    }
    return $result;
}


/*                                                             sprite_fichier                                                              */
function sprite_fichier($img_sprite, $nbr_images, $result)
{   
    global $o;
    $tab = "    ";
    $first_result = ".sprite {\n" .
                    $tab . "background-image: url($img_sprite);\n" .
                    $tab . "background-repeat: no-repeat;\n" .
                    $tab . "display: block;\n" . 
                    "}\n\n";
    if(array_key_exists("output-style", $o))
    {
        $name = $o["output-style"];
        file_put_contents($name, $first_result); // creation file and write $first_result
    }
    elseif(array_key_exists("s", $o))
    {
        $name = $o["s"];
        file_put_contents($name, $first_result); // creation file and write $first_result
    }
    else
    {
        $name = "style.css";
        file_put_contents($name, $first_result); // creation file and write $first_result
    }

    for($i = 0; $i < $nbr_images; $i++)
    {
        static $y = 5;
        $last_result = ".sprite-" . substr(strchr($result[$i]["file"], "\\", 0), 1)  . " {\n" .
            $tab . "width: " . $result[$i]["width"] . "px;\n" . 
            $tab . "height: " . $result[$i]["height"] . "px;\n" . 
            $tab . "background-position: -" . $y . "px -5px;\n" . 
        "}\n\n";
        file_put_contents($name, $last_result, FILE_APPEND); // add $result to style.css
        $y += /*10 + */$result[$i]["width"]; // width to picture
    }
}

/*                                                            resize picture                                                                  */
function resize($result = array(), $nbr_images = 0, $imgwidth = 100, $imgheight = 50, $totalWidth = 0) // taille de l'image // donner le tableaux image
{
    $i = 0;
    for($w = 0; $w < $totalWidth && $i < $nbr_images; $w++)
    {
        if($result[$i]["type"] == IMAGETYPE_PNG)
        {
                // Content type
                // header('Content-Type: image/png');

                // Get new dimensions
                $w = $imgwidth;
                $h = $imgheight;
        
                // Resample
                $image_p = imagecreatetruecolor($w, $h);
                $image = imagecreatefrompng($result[$i]["file"]);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $result[$i]["width"], $result[$i]["height"]);
                // Output
                imagepng($image_p, /*"($i)" .*/$result[$i]["file"]); 
                $i++;
        }
        elseif($result[$i]["type"] == IMAGETYPE_JPEG)
        {
            // Content type
            // header('Content-Type: image/jpeg');

            // Get new dimensions
            $w = $imgwidth;
            $h = $imgheight;

            // Resample
            $image_p = imagecreatetruecolor($w, $h);
            $image = imagecreatefromjpeg($result[$i]["file"]);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $result[$i]["width"], $result[$i]["height"]);
            // Output
            imagejpeg($image_p, /*"($i)" .*/$result[$i]["file"]);
            $i++;
        }
        elseif($result[$i]["type"] == IMAGETYPE_GIF)
        {
            // Content type
            // header('Content-Type: image/gif');

            // Get new dimensions
            $w = $imgwidth;
            $h = $imgheight;

            // Resample
            $image_p = imagecreatetruecolor($w, $h);
            $image = imagecreatefromgif($result[$i]["file"]);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $result[$i]["width"], $result[$i]["height"]);
            // Output
            imagegif($image_p, /*"($i)" .*/$result[$i]["file"]);
            $i++;
        }
    }      
}
// resize($argv);