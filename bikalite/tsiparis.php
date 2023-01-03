<?php

/**
 * @file
 * Gets the product list from bikalite web service.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';

$ECHOPRODUCTDATA=false;

$wsdl_url = $TICIMAXWSDLURLSIP;
$client = new SOAPClient($wsdl_url, ["trace" => 1]);

$id = -1;
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];
}

$urunFiltre = [
    "EntegrasyonAktarildi" => -1,
    "SiparisDurumu" => -1,
    "SiparisID" => $id,
    "SiparisKaynagi" => "",
    "SiparisKodu" => "",
    "OdemeDurumu" => -1,
    "OdemeTipi" => -1,
    "TedarikciID" => -1,
    "UyeID" => -1,
];

$urunSayfalama = [
// Başlangıç değeri.
  "BaslangicIndex" => 0,
// Bir sayfada görüntülenecek ürün sayısı.
  "KayitSayisi" => 10000,
// Hangi sütuna göre sıralanacağı.
  "SiralamaDegeri" => "id",
// Artan "ASC", azalan "DESC".
  "SiralamaYonu" => "DESC",
];

$params = [
  "UyeKodu" => $TICIMAXWSDLUYEKOD,
  "f" => $urunFiltre,
  "s" => $urunSayfalama,
];

$results = $client->SelectSiparis($params);

$myArray = object_to_array($results->SelectSiparisResult);

// Render our view
$renderArray = [
    'title' => "Siparişler",
    'results' => $myArray["WebSiparis"],
  ];

echo $twig->render('tsiparis.twig', $renderArray);
