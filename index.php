<?php

/**
 * @file
 */

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$headers = [
  'Content-Type' => 'application/json',
  'X-Hasura-Admin-Secret' => $_ENV['XHASURAADMINSECRET'],
];

$client = new Client([
  'headers' => $headers,
]);


$response = $client->get($_ENV['XHASURAURLLRT']);

print_r($response->getBody()->getContents());

$response = $client->get($_ENV['XHASURAURLSEC']);

print_r($response->getBody()->getContents());
