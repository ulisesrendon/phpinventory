<?php

spl_autoload_register(function ($class_name) {

    $class_name = str_replace('\\', '/', $class_name);
    $file_path = "App/$class_name.php";

    if (file_exists($file_path)) {
        require_once $file_path;

        return true;
    }

    return false;
});
