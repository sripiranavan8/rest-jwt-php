<?php
    require_once('vendor/autoload.php');
    spl_autoload_register(function($className){
        $path = strtolower($className) . ".php";
        if (file_exists($path)) {
            require_once($path);
        }
        else {
            header("Content-Type:application/json");
            echo json_encode(["error" =>["from"=>"Database Connection","message" =>"File $path is not found."]]);
        }
    });
?>