<?php

// Load our autoloader
require_once __DIR__.'/vendor/autoload.php';

// Specify our Twig templates locations
$paths=[
    __DIR__.'/templates',
    __DIR__.'/templates/partials'
];

$loader = new \Twig\Loader\FilesystemLoader($paths);

 // Instantiate our Twig
$twig = new \Twig\Environment($loader);
