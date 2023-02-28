document.addEventListener("DOMContentLoaded", function () {
  new DataTable(".buttons-datatables", {
    dom: "Bfrtip",

    buttons: ["copy", "csv", "excel", "print"],

    initComplete: function () {
      // Apply the search
      this.api()
        .columns()
        .every(function () {
          var that = this;

          $("input", this.footer()).on("keyup change clear", function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
    },
  });
});

  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#ajax-datatables", { ajax: "assets/json/datatable.json" });
  });

$(".buttons-datatables tfoot th").each(function () {
  var title = $(this).text();
  $(this).html('<input type="text" placeholder="Search ' + title + '" />');
});
