<!DOCTYPE html>
<html lang="en">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
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
