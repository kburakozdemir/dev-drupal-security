<?php

/**
 * @file
 * Gets the product list from bikalite web service.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$wsdl_url = $TICIMAXWSDLURL;
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
  "UyeKodu" => $TICIMAXUYEKODU,
  "f" => $urunFiltre,
  "s" => $urunSayfalama,
];

$result = $client->SelectUrun($params);

$myArray = object_to_array($result->SelectUrunResult);

$myArrayx = $myArray["UrunKarti"];

$varyantlarıylabirlikteurunadet = 0;

$ciftSKU = [];

$i = 0;

while ($i < count($myArrayx)) {
  // Echo $myArrayx[$i]["ID"] . "-" . $myArrayx[$i]["UrunAdi"] . "<br>";.
  $varCount = count($myArrayx[$i]['Varyasyonlar']['Varyasyon']);
  if ($varCount == 165) {
    $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["StokKodu"];
    // Echo $stokKod . "<br>";.
    if (array_key_exists($stokKod, $ciftSKU)) {
      $a = $ciftSKU[$stokKod];
      $ciftSKU[$stokKod] = $a + 1;
    }
    else {
      $ciftSKU[$stokKod] = 1;
    }
    $varyantlarıylabirlikteurunadet++;
  }
  else {
    $v = 0;
    while ($v < $varCount) {
      $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["StokKodu"];
      // Echo $stokKod . "<br>";.
      if (array_key_exists($stokKod, $ciftSKU)) {
        $a = $ciftSKU[$stokKod];
        $ciftSKU[$stokKod] = $a + 1;
      }
      else {
        $ciftSKU[$stokKod] = 1;
      }
      $varyantlarıylabirlikteurunadet++;
      $v++;
    }
  }

  $i++;

}

echo "ürün adet = " . count($myArrayx) . "<br>";

echo "varyantları ile ürün adet = " . $varyantlarıylabirlikteurunadet . "<br>";

/**
 * Callback function forarray_filter.
 */
function filter($var) {
  return $var > 1;
}

$ciftKesin = array_filter($ciftSKU, "filter");

$sonuc = count($ciftKesin);

if ($sonuc == 0) {
  echo "çift sku'lu ürün yok";
}
else {
  echo "çift olan SKUlar (" . $sonuc . " Adet): " . "<br>";
  foreach ($ciftKesin as $x => $x_value) {
    echo "SKU=" . $x . ", Adet=" . $x_value;
    echo "<br>";
  }
}
