<?php

// Load our autoloader and config
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Specify our Twig templates/views locations
$paths=[
    __DIR__.'/views',
    __DIR__.'/views/partials',
    __DIR__.'/views/partials-layout'
];

$loader = new \Twig\Loader\FilesystemLoader($paths);

 // Instantiate our Twig
$twig = new \Twig\Environment($loader);
