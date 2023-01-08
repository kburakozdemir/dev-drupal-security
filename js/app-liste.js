$(document).ready(function () {
  $("#dataListTable").DataTable({
    dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "pdf", "print"],
    columnDefs: [{ width: "400", targets: 0 }],
    scrollY: "500px",
    scrollX: true,
    scrollCollapse: true,
    fixedColumns: true,
  });
});
