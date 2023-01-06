<?php

/**
 * @file
 * Gets the product list from bikalite web service.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$ECHOPRODUCTDATA=false;

$wsdl_url = $TICIMAXWSDLURLURU;
$client = new SOAPClient($wsdl_url, ["trace" => 1]);

$urunFiltre = [
  "Aktif" => -1,
  "Firsat" => -1,
  "Indirimli" => -1,
  "Vitrin" => -1,
  "KategoriID" => 0,
  "MarkaID" => 0,
  "UrunKartiID" => 0,
];

$urunSayfalama = [
// Başlangıç değeri.
  "BaslangicIndex" => 0,
// Bir sayfada görüntülenecek ürün sayısı.
  "KayitSayisi" => 10000,
// Hangi sütuna göre sıralanacağı.
  "SiralamaDegeri" => "ID",
// Artan "ASC", azalan "DESC".
  "SiralamaYonu" => "ASC",
];

$params = [
  "UyeKodu" => $TICIMAXWSDLUYEKOD,
  "f" => $urunFiltre,
  "s" => $urunSayfalama,
];

$results = $client->SelectUrun($params);

$myArray = object_to_array($results->SelectUrunResult);

$myArrayx = $myArray["UrunKarti"];

$i = 0;

$resultListe = [];

while ($i < count($myArrayx)) {
        $varCount = count($myArrayx[$i]['Varyasyonlar']['Varyasyon']);

    if ($varCount == 165) {
        $id = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["ID"];
        $urunKartiID = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["UrunKartiID"];
        $stokAdedi = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["StokAdedi"];
        $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["StokKodu"];
        $status = (($myArrayx[$i]['Varyasyonlar']['Varyasyon']["Aktif"]) ? "Aktif" : "Pasif");

        $productArray = [
            "URUNADI" => $myArrayx[$i]["UrunAdi"],
            "URUNKARTIID" => $urunKartiID,
            "URUNID" => $id,
            "STOKKODU" => $stokKod,
            "UrunSayfaAdresi" => $myArrayx[$i]["UrunSayfaAdresi"],
            "Aktif" => $status,
            "StokAdedi" => $stokAdedi,
        ];

        array_push($resultListe, $productArray);
    } else {
        $v = 0;
        while ($v < $varCount) {
            $id = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["ID"];
            $urunKartiID = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["UrunKartiID"];
            $stokAdedi = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["StokAdedi"];
            $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["StokKodu"];
            $status = (($myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["Aktif"]) ? "Aktif" : "Pasif");

            $productArray = [
                "URUNADI" => $myArrayx[$i]["UrunAdi"],
                "URUNKARTIID" => $urunKartiID,
                "URUNID" => $id,
                "STOKKODU" => $stokKod,
                "UrunSayfaAdresi" => $myArrayx[$i]["UrunSayfaAdresi"],
                "Aktif" => $status,
                "StokAdedi" => $stokAdedi,
            ];
            array_push($resultListe, $productArray);

            $v++;
        }
    }

    $i++;
}

// Render our view
$renderArray = [
    'title' => "Ürün Listesi",
    'results' => $results,
    "resultListe" => $resultListe,
  ];

echo $twig->render('tproductliste.twig', $renderArray);
