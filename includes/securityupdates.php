<?php

/**
 * @file
 */

$response = $client->get($XHASURAURLSEC);

$content = json_decode($response->getBody()->getContents(), TRUE);
$contentArray = $content["securityupdates"];

for ($i = 0; $i < count($contentArray); $i++) {
  echo '<tr>';
  echo "<td>" . $contentArray[$i]["id"] . "</td>";
  echo "<td>" . $contentArray[$i]["server"] . "</td>";
  echo "<td>" . $contentArray[$i]["instancename"] . "</td>";
  echo "<td>" . $contentArray[$i]["module"] . "</td>";
  echo "<td>" . $contentArray[$i]["module_version"] . "</td>";
  echo "<td>" . $contentArray[$i]["servertime"] . "</td>";
  echo '</tr>';
}
