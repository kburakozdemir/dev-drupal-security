<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$catid = 0;
if (isset($_GET["catid"]) && !empty($_GET["catid"])) {
    $catid = $_GET["catid"];
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
    'title' => "Kategoriler",
    'resultSingle' => $resultSingle,
    'resultMultiple' => $resultMultiple
  ];

echo $twig->render('tcategory.twig', $renderArray);
