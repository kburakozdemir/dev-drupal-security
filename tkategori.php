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

$params = [
    "UyeKodu" => $TICIMAXUYEKODU,
    "kategoriID" => $catid,
    "dil" => "tr"
  ];

// var_dump($client->__getFunctions());


  // print_r($ticimax->__soapCall("SelectKategori", $params));
	$result = $client->SelectKategori($params);

 $myArray = object_to_array($result->SelectKategoriResult);

 $myArrayx = $myArray["Kategori"];


  if ($params["kategoriID"] > 0) {
    foreach($myArrayx as $x => $x_value) {
      $valToEcho = ((gettype($x_value) == "boolean") ? ($x_value ? 'true' : 'false' ) : $x_value);

      echo "Key=" . $x . ", Value=" . $valToEcho;
      echo "<br>";
    }

  } else {

    $i = 0;

    while($i < count($myArrayx))
    {
    echo $myArrayx[$i]["Tanim"]."<br>";
    $i++;
  }

  }




