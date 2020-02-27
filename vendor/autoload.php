<?php

spl_autoload_register(function ($class) {

    $sources = [
        "core/$class.php",
        "app/Controllers/$class.php",
        "app/Validation/$class.php",
        "app/Models/$class.php",
        "app/Helpers/$class.php",
        "config/$class.php",
        "migrations/$class.php"
    ];

    foreach($sources as $source) {
        if(file_exists($source)) {
            include $source;
        }
    }
});