<?php

/**
 * @file
 * Gets the category list from bikalite web service.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$catid = 0;
if (isset($_GET["catid"]) && !empty($_GET["catid"])) {
  $catid = $_GET["catid"];
}

$wsdl_url = $TICIMAXWSDLURL;
$client = new SOAPClient($wsdl_url, ["trace" => 1]);

$params = [
  "UyeKodu" => $TICIMAXUYEKODU,
  "kategoriID" => $catid,
  "dil" => "tr",
];

// var_dump($client->__getFunctions());
// print_r($ticimax->__soapCall("SelectKategori", $params));.
$result = $client->SelectKategori($params);

$myArray = object_to_array($result->SelectKategoriResult);

$myArrayx = $myArray["Kategori"];


if ($params["kategoriID"] > 0) {
  foreach ($myArrayx as $x => $x_value) {
    $valToEcho = ((gettype($x_value) == "boolean") ? ($x_value ? 'true' : 'false') : $x_value);

    echo "Key=" . $x . ", Value=" . $valToEcho;
    echo "<br>";
  }

}
else {

  $i = 0;

  while ($i < count($myArrayx)) {
    echo $myArrayx[$i]["Tanim"] . "<br>";
    $i++;
  }

}
