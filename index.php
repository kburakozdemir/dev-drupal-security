<?php

/**
 * @file
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use GuzzleHttp\Client;

$headers = [
  'Content-Type' => 'application/json',
  'X-Hasura-Admin-Secret' => $XHASURAADMINSECRET,
];

$client = new Client([
  'headers' => $headers,
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Security Updates</title>
  <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <header>
        <h1>Drupal Updates <em>(PHP)</em></h1>
      </header>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="table-responsive">
        <table
          class="table table-striped table-bordered table-sm caption-top"
                  >
          <caption>
            Last Runtime
          </caption>
          <tr>
            <th>server</th>
            <th>servertime</th>
            <th>created</th>
          </tr>
          <?php require_once __DIR__ . '/includes/lastruntime.php'; ?>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="table-responsive">
          <table
            class="table table-striped table-bordered table-sm caption-top"
                    >
            <caption>
              Security Updates
            </caption>
            <tr>
              <th>id</th>
              <th>server</th>
              <th>instancename</th>
              <th>module</th>
              <th>module_version</th>
              <th>servertime</th>
            </tr>
            <?php require_once __DIR__ . '/includes/securityupdates.php'; ?>
            </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h2>Ticimax Web Service Denemeleri</h2>
      <a href="bikalite/tkategori.php" target="_blank">ticimax kategori</a>
      <br>
      <a href="bikalite/turun.php" target="_blank">ticimax çift ürün</a>
    </div>
  </div>
</div>
</body>
</html>
