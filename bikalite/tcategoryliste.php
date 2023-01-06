<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$catid = 0;
if (isset($_GET["catid"]) && !empty($_GET["catid"])) {
    $catid = $_GET["catid"];
}

$type = "simple";
if (isset($_GET["type"]) && !empty($_GET["type"])) {
    $type = $_GET["type"];
}

$wsdl_url = $TICIMAXWSDLURLURU;
$client = new SOAPClient($wsdl_url, ["trace" => 1]);

$params = [
  "UyeKodu" => $TICIMAXWSDLUYEKOD,
  "kategoriID" => $catid,
  "dil" => "tr",
];

$result = $client->SelectKategori($params);

$categoryResults = object_to_array($result->SelectKategoriResult);

if ($params["kategoriID"] > 0) {
    $resultSingle = $categoryResults["Kategori"];
    $resultMultiple = [];
} else {
    $resultSingle = [];
    $resultMultiple = $categoryResults["Kategori"];
}

// Render our view
$renderArray = [
    'title' => "Kategori Listesi",
    'type' => $type,
    'resultSingle' => $resultSingle,
    'resultMultiple' => $resultMultiple
  ];

echo $twig->render('tcategoryliste.twig', $renderArray);
