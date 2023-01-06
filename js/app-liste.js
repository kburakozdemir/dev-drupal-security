let table;

$(document).ready(function () {
  $("#tableCreate").hide();
  $("tfoot").show();

  $("#tableCreate").on("click", function () {
    table = $("#xxx").DataTable();
    $("tfoot").show();
    $("#tableCreate").hide();
    $("#tableDestroy").show();
  });

  $("#tableDestroy").on("click", function () {
    table.destroy();
    $("tfoot").hide();
    $("#tableCreate").show();
    $("#tableDestroy").hide();
  });

  table = $("#xxx").DataTable();
});
