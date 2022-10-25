<?php

/**
 * @file
 */

require_once 'vendor/autoload.php';
require_once 'config.php';

use GuzzleHttp\Client;

$headers = [
  'Content-Type' => 'application/json',
  'X-Hasura-Admin-Secret' => $XHASURAADMINSECRET,
];

$client = new Client([
  'headers' => $headers,
]);


$response = $client->get($XHASURAURLLRT);

print_r($response->getBody()->getContents());

$response = $client->get($XHASURAURLSEC);

print_r($response->getBody()->getContents());
