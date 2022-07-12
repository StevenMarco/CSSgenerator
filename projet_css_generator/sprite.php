<?php
function sprite_fichier($img, $nbr_image = array())
{
    $tab = "    ";
    $first_result = ".sprite {\n" .
                    $tab . "background-image: url($img);\n" .
                    $tab . "background-repeat: no-repeat;\n" .
                    $tab . "display: block;\n" . 
                    "}\n\n";
    // echo $first_result;
    file_put_contents("generator.css", $first_result); // creation file and write $first_result

    for($i = 0; $i < count($nbr_image); $i++)
    {
        static $o = 5;
        $result = ".sprite-$i {\n" .
            /*$tab . "width: 30px;\n" . 
            $tab . "height: 30px;\n" . */
            $tab . "background-position: -" . $o . "px -5px;\n" . 
        "}\n\n";
        file_put_contents("generator.css", $result, FILE_APPEND); // add $result to generator.cdd
        $o += 40;
    }
}
// var_dump(sprite_fichier("monimg.png", array("(1)ducati.png", "(2)demonstration.png")));
