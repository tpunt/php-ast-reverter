<?php

spl_autoload_register(function ($className) {
    $classFile = __DIR__ . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';

    if (is_readable($classFile)) {
        require $classFile;
    }
});
