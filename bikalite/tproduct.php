<?php

/**
 * @file
 */

$ECHOPRODUCTDATA=false;
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <header>
        <h1>Ürünler</h1>
      </header>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
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
    if ($ECHOPRODUCTDATA) {
        echo "<em>Ürün (" . ($i + 1) . ")</em><br>";
    }
    if ($ECHOPRODUCTDATA) {
        echo "ID: " . $myArrayx[$i]["ID"] . " - " . $myArrayx[$i]["UrunAdi"] . " (Status: " . (($myArrayx[$i]["Aktif"]) ? "Aktif" : "Pasif") . ") (<a href='https://bikalite.com" . $myArrayx[$i]["UrunSayfaAdresi"] . "' target='_blank'>Link</a>)<br>";
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
            echo "<p><em>(" . ($varyantlarıylabirlikteurunadet + 1) . ")</em> - " . "(Excelde URUNID kolonu) Varyant ID: " . $id . " - " . "Urun Kartı ID: " . $urunKartiID . " - " . $stokKod . " - Stok Adedi: " . $stokAdedi . " (Status: " . $status . ")</p>";
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
                echo "<p><em>(" . ($varyantlarıylabirlikteurunadet + 1) . ")</em> - " . "(Excelde URUNID kolonu) Varyant ID: " . $id . " - " . "Urun Kartı ID: " . $urunKartiID . " - " . $stokKod . " - Stok Adedi: " . $stokAdedi . " (Status: " . $status . ")</p>";
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

echo "ürün adet = " . count($myArrayx) . "<br>";

echo "varyantları ile ürün adet = " . $varyantlarıylabirlikteurunadet . "<br>";

/**
 * Callback function forarray_filter.
 */
function filter($var)
{
    return $var > 1;
}

$ciftKesin = array_filter($ciftSKU, "filter");

$sonuc = count($ciftKesin);

if ($sonuc == 0) {
    echo "çift sku'lu ürün yok";
} else {
    echo "çift olan SKUlar (" . $sonuc . " Adet):<br>";
    foreach ($ciftKesin as $x => $x_value) {
        echo "SKU=" . $x . ", Adet=" . $x_value;
        echo "<br>";
    }
}
?>
</div>
</div>
</div>
</body>
</html>
