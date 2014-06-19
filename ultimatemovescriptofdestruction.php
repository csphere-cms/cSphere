<?php

//This script restrucutres the whole freaking cSphere folder.
//Hide your kids, lock the door and press the button.
//P.S. I am not responsible for any damaged git repo's, lulz.

echo 'cSphere Ultimate Move Script of Desctruction - v0.1 Alpha'.PHP_EOL;
echo '(P.S. There won\'t be a v0.2, lulz.)';

$backendFilesPHP=['manage','create','edit','options'];
$backendFilesTPL=['manage','form','options'];

foreach (glob("csphere/plugins/*") as $filename) {
    echo 'Trying to restructure '.$filename.'...'.PHP_EOL;

    //Restructure Actions
    if(is_dir($filename."/actions")){
        rename($filename."/actions",$filename."/frontend");
        mkdir($filename."/actions/backend",0777,true);
        rename($filename."/frontend",$filename."/actions/frontend");

        if(is_dir($filename."/boxes")){
            rename($filename."/boxes",$filename."/actions/boxes");
        }

        foreach($backendFilesPHP as $backendFile){
            if(file_exists($filename."/actions/frontend/".$backendFile.".php")){
                rename($filename."/actions/frontend/".$backendFile.".php",$filename."/actions/backend/".$backendFile.".php");
            }
        }

        //Restructure Templates
        rename($filename."/templates",$filename."/frontend");
        mkdir($filename."/templates/backend",0777,true);
        mkdir($filename."/templates/boxes",0777,true);
        rename($filename."/frontend",$filename."/templates/frontend");

        foreach (glob($filename."/templates/frontend/*") as $templateFrontend) {
            if(substr_count($templateFrontend,"box_")>0){
                rename($templateFrontend,str_replace("/templates/frontend/box_","/templates/boxes/",$templateFrontend));
            }
        }

        foreach($backendFilesTPL as $backendFile){
            if(file_exists($filename."/templates/frontend/".$backendFile.".tpl")){
                rename($filename."/templates/frontend/".$backendFile.".tpl",$filename."/templates/backend/".$backendFile.".tpl");
            }
        }
    }

}