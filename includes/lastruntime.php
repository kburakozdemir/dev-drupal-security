<?php

/**
 * @file
 */

$response = $client->get($XHASURAURLLRT);

$content = json_decode($response->getBody()->getContents(), TRUE);
$contentArray = $content["lastruntime"];

// var_dump($content);
for ($i = 0; $i < count($contentArray); $i++) {
  // Echo $users[$i]."\n";.
  echo '<tr>';
  echo "<td>" . $contentArray[$i]["server"] . "</td>";
  echo "<td>" . $contentArray[$i]["servertime"] . "</td>";
  echo "<td>" . $contentArray[$i]["created"] . "</td>";
  echo '</tr>';
}
