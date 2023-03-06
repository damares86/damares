<?php

require __DIR__."/coreConfig.php";


$operation = filter_input(INPUT_POST,"operation") ;

if($operation == "lang"){ 

    $lang = filter_input(INPUT_POST,"lang");
    $setting_name= filter_input(INPUT_POST,"setting_name");
    $setting->name=$setting_name;
    $setting->value=$lang;

    if($setting->updateValue()){
        header("Location: ../index.php?p=allSettings&msg=langUpdate");
        exit;
    }else{
        header("Location: ../index.php?p=allSettings&err=langUpdateErr");
        exit;
    }
}