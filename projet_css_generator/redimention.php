<?php

/*                                                          resize for JPEG                                                     */
function resize_jpeg($files = array(), $imgwidth = 250, $imgheight = 250)
{

    $i = 1;
    foreach ($files as $file) {

        list($w1, $h2, $t) = getimagesize($file);
        // Content type
        header('Content-Type: image/jpeg');


        // Get new dimensions
        $w = $imgwidth;
        $h = $imgheight;

        // Resample
        $image_p = imagecreatetruecolor($w, $h);
        $image = imagecreatefromjpeg($file);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $w1, $h2);
        // Output
        imagejpeg($image_p, 'output' . $i . ".jpeg", 100);
        $i++;
    }
}
// resize_jpeg($files = array("ducati.png", "fleurs_violettes.jpeg"), $imgwidth = 250, $imgheight = 250);


/*                                                       resize for PNG                                                          */
function resize_png($files = array(), $imgwidth = 250, $imgheight =250) {

    $i = 1;
    foreach ($files as $file){
        list ($w1, $h2, $t) = getimagesize($file);
        // Content type
        header('Content-Type: image/png');


        // Get new dimensions
        $w = $imgwidth;
        $h = $imgheight;

        // Resample
        $image_p = imagecreatetruecolor($w, $h);
        $image = imagecreatefrompng($file);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $w1, $h2);
        // Output
        imagepng($image_p, 'output' . $i . ".png"); 
        $i++;
    }
}
// resize_png(array("ducati.png", "demonstration.png"), $imgwidth = 250, $imgheight =250);


/*                                                        rezise all type                                                         */

function resize($files = array(), $imgwidth = 100, $imgheight = 50) // taille de l'image // 
{
    $files = type($files);
    $i = 1;
    foreach ($files as $file) 
    {
        if($file["type"] == IMAGETYPE_PNG)
        {
            // $i = 1;
            // list($w1, $h2, $t) = getimagesize($file["file"]);
                // Content type
                header('Content-Type: image/png');

                // Get new dimensions
                $w = $imgwidth;
                $h = $imgheight;
        
                // Resample
                $image_p = imagecreatetruecolor($w, $h);
                $image = imagecreatefrompng($file["file"]);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $file["width"], $file["height"]);
                // Output
                imagepng($image_p, "($i)" . $file["file"]); 
                $i++;
        }
        elseif($file["type"] == IMAGETYPE_JPEG)
        {
            // Content type
            header('Content-Type: image/jpeg');

            // Get new dimensions
            $w = $imgwidth;
            $h = $imgheight;

            // Resample
            $image_p = imagecreatetruecolor($w, $h);
            $image = imagecreatefromjpeg($file["file"]);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $file["width"], $file["height"]);
            // Output
            imagejpeg($image_p, "($i)" . $file["file"]);
            $i++;
        }
        elseif($file["type"] == IMAGETYPE_GIF)
        {
            // Content type
            header('Content-Type: image/gif');

            // Get new dimensions
            $w = $imgwidth;
            $h = $imgheight;

            // Resample
            $image_p = imagecreatetruecolor($w, $h);
            $image = imagecreatefromgif($file["file"]);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $file["width"], $file["height"]);
            // Output
            imagegif($image_p, "($i)" . $file["file"]);
            $i++;
        }
    }
}
// resize(array("fleurs_violettes.jpeg"));


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
// resize($files = array("ducati.png"/*, "fleurs_violettes.jpeg"*/), $imgwidth = 250, $imgheight = 250);
// var_dump(resize($files = array("ducati.png", "fleurs_violettes.jpeg"), $imgwidth = 250, $imgheight = 250));









/*                                                         fluzzy area                                                          */


function compréhension_array_push($array)
{
    $ok = array();
    foreach($array as $key => $value)
    {
        array_push($ok, $value);
        //$ok .= $value;
        // return $o;
      //  print_r($o);  

    }
    return $ok;
}
// var_dump(compréhension_array_push(array("yo ", "ge ", "bvz ")));