<?php

require_once __DIR__ . '/config.php';

$catid = 0;
if (isset($_GET["catid"]) && !empty($_GET["catid"])){
  $catid = $_GET["catid"];
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = [];
        foreach ($data as $key => $value)
        {
            $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
        }
        return $result;
    }
    return $data;
}

$wsdl_url = $TICIMAXWSDLURL;
$client = new SOAPClient($wsdl_url, array("trace" => 1));

$UrunFiltre = [
  "Aktif" => -1,
  "Firsat" => -1,
  "Indirimli" => -1,
  "Vitrin" => -1,
  "KategoriID" => 0,
  "MarkaID" => 0,
  "UrunKartiID" => 0,
  ];

$UrunSayfalama = [
  "BaslangicIndex" => 0, // Başlangıç değeri
  "KayitSayisi" => 10000, // Bir sayfada görüntülenecek ürün sayısı
  "SiralamaDegeri" => "ID", // Hangi sütuna göre sıralanacağı
  "SiralamaYonu" => "ASC" // Artan "ASC", azalan "DESC"
];

$params = [
  "UyeKodu" => $TICIMAXUYEKODU,
  "f" => $UrunFiltre,
  "s" => $UrunSayfalama
];

	$result = $client->SelectUrun($params);

 $myArray = object_to_array($result->SelectUrunResult);

 $myArrayx = $myArray["UrunKarti"];

$varyantlarıylabirlikteurunadet = 0;

  $ciftSKU = [];

    $i = 0;

    while($i < count($myArrayx))
    {
    // echo $myArrayx[$i]["ID"] . "-" . $myArrayx[$i]["UrunAdi"] . "<br>";

    $varCount = count($myArrayx[$i]['Varyasyonlar']['Varyasyon']);
    if ($varCount == 165) {
      $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon']["StokKodu"];
      // echo $stokKod . "<br>";
        if (array_key_exists($stokKod,$ciftSKU)) {
          $a = $ciftSKU[$stokKod];
          $ciftSKU[$stokKod] = $a + 1;
        } else {
          $ciftSKU[$stokKod] = 1;
        }
        $varyantlarıylabirlikteurunadet++;
      } else {
        $v = 0;
        while($v < $varCount) {
          $stokKod = $myArrayx[$i]['Varyasyonlar']['Varyasyon'][$v]["StokKodu"];
          // echo $stokKod . "<br>";
          if (array_key_exists($stokKod,$ciftSKU)) {
            $a = $ciftSKU[$stokKod];
            $ciftSKU[$stokKod] = $a + 1;
          } else {
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

  function filter($var){
    return $var > 1;
  }


$ciftKesin = array_filter($ciftSKU, "filter");

$sonuc = count($ciftKesin);

if ($sonuc == 0) {
  echo "çift sku'lu ürün yok";
} else {
  echo "çift olan SKUlar (" . $sonuc . " Adet): " . "<br>";
  foreach($ciftKesin as $x => $x_value) {
    echo "SKU=" . $x . ", Adet=" . $x_value;
    echo "<br>";
  }
}

