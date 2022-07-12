<?php

$files = $argv[1]; 
static $text = "";

function help()
{
    global $files;
    global $text;
    $array = array();
    
    $op = fopen($files, "r");
    $read = fread($op, filesize($files));
    fclose($op);

    for($i = 0; $i < strlen($read); $i++)
    {


        if($read[$i] != ".")
        {
            $text .= $read[$i];
        }
        else
        {
            $j = $i;
            array_push($array, $text);
            
        }        
    }
};
var_dump(help());