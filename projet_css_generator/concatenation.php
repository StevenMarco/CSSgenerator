<?php

                                                // créer un fichier vide / image sur HTML // 
function create() // création d'image PNG
{
    // header("Content-Type: image/png"); // utile pour HTML

    $image = imagecreate(250, 250);

    $result = imagepng($image, "img_final\monimg.png");
}
// create();


function create_HTML() // a voir avec html et CSS http://calamar.univ-ag.fr/uag/ufrsen/coursenligne/vpage/new_site/doc/librairie_gd_php.pdf
{
        header("Content-Type: image/png");

        $image = imagecreate(250, 250);

        imagepng($image);
}

/*                                                   concaténation d'image depuis un fichier                                                     */

                                                

function list_to_files($files_array) 
{
    global $tab;
        $files_array = array($files_array);
            foreach($files_array as $file) 
            {  
                if(is_dir($file)) 
                {
                    $tab = scan_all_dir($file);
                }
                elseif(file_exists($file)) 
                {
                    array_push($tab, $file);
                }
                else
                {
                    echo "Une erreur c'est produite veuillez réessayer";
                }
            }
            return $tab;
}

function scan_all_dir($dir) 
{
    $result = array();
        foreach(scan_dir($dir) as $filename) 
        {
            if ($filename[0] == '.') 
            continue;
            
            $filePath = $dir . '/' . $filename;
            
            if (is_dir($filePath)) 
            {
                foreach (scan_all_dir($filePath) as $childFilename) 
                {
                    $result[] = /*$filename . '/' .*/ $childFilename;
                }
            } 
            else 
            {
            $result[] = $filename;
            }
        }
    return $result;
}


function scan_dir($dir)
{
    $files = array();
        if($op = opendir($dir))
        {
            while(false !== ($filename = readdir($op))) 
            {
                if($filename == '.' || $filename == '..')
                    continue;
                else
                    $files[] = $filename;
            }
            return $files;
        }
        else
        {
            return false;
        }
}


// concatenation //
function concatenation($array)
{
    $array = list_to_files($array);
// fonction type
    $result = type($array); 
// creation image black
    $image = imagecreatetruecolor($total_w = 300, $h = 50); // width maximum de l'image; (w, h) / $total_w = $w * count($w)
    $background = imagecolorallocatealpha($image, 0, 0, 0, 0);
// generation copy picture in the image black
    $space  = 0;
    foreach($result as $file)
    {
        if($file["type"] == IMAGETYPE_PNG)
        {
            $img_type = imagecreatefrompng($file["file"]);
        }
        elseif($file["type"] == IMAGETYPE_JPEG)
        {
            $img_type = imagecreatefromjpeg($file["file"]);            
        }
        elseif($file["type"] == IMAGETYPE_GIF)
        {
            $img_type = imagecreatefromgif($file["file"]); 
        }
        else
        {
            echo "nous ne reconnaissons pas votre type d'image ? \n" . "Nous gérons des images .PNG .JPEG et .GIF, veuillez vérifier le type d'image que vous nous envoyez.";
        }

        imagecopy($image, $img_type, $space, 0, 0, 0, $w = 100, $h = 50); // moitié de width maximum; (w, h) // taille de l'image
        $space += (0 /*spacing*/ + $w); // + copy de la largeur de l'image;
        // imagedestroy($img_type);
    }
    
    $create_img = imagepng($image, "img_final\monimg.png");
}

function type($array)
{
    $result = array();
    foreach($array as $img)
    {
        list($w, $h, $t) = getimagesize($img);
        $r = array("file" => $img, "type" => $t, "width" => $w, "height" => $h);
        array_push($result, $r);
    }
    return $result;
}
// var_dump(type(array("(1)ducati.png")));


// var_dump(print_r(concatenation("img_original")));  
                                                



/* objectif : 
    - générer fichier CSS : voir website_performance.
*/








                                                // test // 
function test()
{
  //  header("Content-type: image/png");
    $img = imagecreatetruecolor(250, 250); // créer une nouvelle image (width , height)
    $background = imagecolorallocatealpha($img, 0, 0, 0, 0); // alloue une couleur à une image
    // imagefill($img, 0, 0, $background); // remplissage d'image 
    // imagealphablending($img, false); // 
    // imagesavealpha($img, true);
    imagepng($img, "img_final\monimg.png");
}

// test();


function ok()
{
    header("Content-Type: image/png");
$im = @imagecreate(110, 20);
$background_color = imagecolorallocate($im, 0, 0, 0);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5, "", $text_color);
imagepng($im);
imagedestroy($im);
}

// ok();
    
        //créer une image vide

        // ajouter les images 

        //sauvegarde