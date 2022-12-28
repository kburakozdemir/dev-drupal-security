<?php

// Load our autoloader and config
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Specify our Twig templates locations
$paths=[
    __DIR__.'/templates',
    __DIR__.'/templates/partials',
    __DIR__.'/templates/partials-layout'
];

$loader = new \Twig\Loader\FilesystemLoader($paths);

 // Instantiate our Twig
$twig = new \Twig\Environment($loader);
