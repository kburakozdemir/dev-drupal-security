<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

use GuzzleHttp\Client;

$headers = [
  'Content-Type' => 'application/json',
  'X-Hasura-Admin-Secret' => $XHASURAADMINSECRET,
];

$client = new Client([
  'headers' => $headers,
]);

$response = $client->get($XHASURAURLLRT);

$content = json_decode($response->getBody()->getContents(), true);
$contentArrayLast = $content["lastruntime"];

$response = $client->get($XHASURAURLSEC);

$content = json_decode($response->getBody()->getContents(), true);
$contentArraySec = $content["securityupdates"];

$response = $client->get($XHASURAURLSPACE);

$content = json_decode($response->getBody()->getContents(), true);
$contentArraySpace = $content["server_space_latest_data"];

// Render our view
$renderArray = [
    'title' => "Misc API Consumers",
    'lastRunTime' => $contentArrayLast,
    'securityUpdates' => $contentArraySec,
    'driveSpaceData' => $contentArraySpace
  ];

echo $twig->render('index.twig', $renderArray);
