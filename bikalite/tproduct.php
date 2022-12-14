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

$varyantlarıylabirlikteurunadet = 0;

$ciftSKU = [];

$i = 0;

while ($i < count($myArrayx)) {
    if ($ECHOPRODUCTDATA) {
        echo "<em>Ürün (" . ($i + 1) . ")</em><br>";
    }
    if ($ECHOPRODUCTDATA) {
        $echoTxt = "ID: " . $myArrayx[$i]["ID"] . " - " . $myArrayx[$i]["UrunAdi"];
        $echoTxt .= " (Status: " . (($myArrayx[$i]["Aktif"]) ? "Aktif" : "Pasif");
        $echoTxt .= ") (<a href='https://bikalite.com" . $myArrayx[$i]["UrunSayfaAdresi"];
        $echoTxt .= "' target='_blank'>Link</a>)<br>";
        echo $echoTxt;
    }
        $varCount = count($myArrayx[$i]['Varyasyonlar']['Varyasyon']);
    if ($ECHOPRODUCTDATA) {
        echo "<details><summary><em>Varyantlar</em></summary>";
    }
    if ($varCount == 165) {
        $id = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["ID"];
        $urunKartiID = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["UrunKartiID"];
        $stokAdedi = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["StokAdedi"];
        $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["StokKodu"];
        $status = (($myArrayx[$i]['Varyasyonlar']['Varyasyon']["Aktif"]) ? "Aktif" : "Pasif");
        if ($ECHOPRODUCTDATA) {
            $echoTxt = "<p><em>(" . ($varyantlarıylabirlikteurunadet + 1) . ")</em> - ";
            $echoTxt .= "(Excelde URUNID kolonu) Varyant ID: " . $id . " - ";
            $echoTxt .= "Urun Kartı ID: " . $urunKartiID . " - " . $stokKod;
            $echoTxt .= " - Stok Adedi: " . $stokAdedi . " (Status: " . $status . ")</p>";
            echo $echoTxt;
        }
        if (array_key_exists($stokKod, $ciftSKU)) {
            $a = $ciftSKU[$stokKod];
            $ciftSKU[$stokKod] = $a + 1;
        } else {
            $ciftSKU[$stokKod] = 1;
        }
        $varyantlarıylabirlikteurunadet++;
    } else {
        $v = 0;
        while ($v < $varCount) {
            $id = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["ID"];
            $urunKartiID = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["UrunKartiID"];
            $stokAdedi = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["StokAdedi"];
            $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["StokKodu"];
            $status = (($myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["Aktif"]) ? "Aktif" : "Pasif");
            if ($ECHOPRODUCTDATA) {
                $echoTxt = "<p><em>(" . ($varyantlarıylabirlikteurunadet + 1) . ")</em> - ";
                $echoTxt .= "(Excelde URUNID kolonu) Varyant ID: " . $id . " - ";
                $echoTxt .= "Urun Kartı ID: " . $urunKartiID . " - ";
                $echoTxt .= $stokKod . " - Stok Adedi: " . $stokAdedi . " (Status: " . $status . ")</p>";
                echo $echoTxt;
            }
            if (array_key_exists($stokKod, $ciftSKU)) {
                $a = $ciftSKU[$stokKod];
                $ciftSKU[$stokKod] = $a + 1;
            } else {
                $ciftSKU[$stokKod] = 1;
            }
            $varyantlarıylabirlikteurunadet++;
            $v++;
        }
    }
    if ($ECHOPRODUCTDATA) {
        echo "</details><hr>";
    }
    $i++;
}

$results = [];

array_push($results, "ürün adet = " . count($myArrayx));

array_push($results, "varyantları ile ürün adet = " . $varyantlarıylabirlikteurunadet);

$ciftKesin = array_filter($ciftSKU, "ciftSKUFilter");

$sonuc = count($ciftKesin);

if ($sonuc == 0) {
    array_push($results, "çift sku'lu ürün yok");
} else {
    array_push($results, "çift olan SKUlar (" . $sonuc . " Adet):");
    foreach ($ciftKesin as $x => $x_value) {
        array_push($results, "SKU=" . $x . ", Adet=" . $x_value);
    }
}

// Render our view
$renderArray = [
    'title' => "Ürünler",
    'results' => $results
  ];

echo $twig->render('tproduct.twig', $renderArray);
