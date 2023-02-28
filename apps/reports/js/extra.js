$("#bonds_and_guarantee_filter").on("submit", function (e) {
  e.preventDefault();

  let select_client = $("#select_client").val();
  let filter_action = $("#filter_action").val();
  let bonds_start_date = $("#bonds_start_date").val();
  let bonds_end_date = $("#bonds_end_date").val();

  $.ajax({
    url: "apps/reports/controller/CustomerExposureFilterCTRL.php",
    method: "POST",
    //data: new FormData(this),
    //contentType: false,
    dataType: "JSON",
    data: {
      select_client: select_client,
      filter_action: filter_action,
      bonds_start_date: bonds_start_date,
      bonds_end_date: bonds_end_date,
    },
    // cache: false,
    //processData: false,
    success: function (d_data) {
      // let currency_symbols_fl = [];
      // let count_all = [];
      let collateralVal = [];

      let arr = d_data.get_filter_for_collateral_by_currency;

      // $.each(d_data.get_filter_for_collateral_by_currency, function (key, val) {
      //   currency_symbols_fl.push(val.collateral_currency);
      // });

      // $.each(d_data.get_filter_for_collateral_by_currency, function (key, val) {
      //   count_all.push(val.totalNumberOfCollaterals);
      // });

      $.each(d_data.get_filter_for_collateral_by_currency, function (key, val) {
        collateralVal.push(val.collateralVal);
      });

      if (d_data.response == "success") {
        //$("#list_loader").hide();

        //setInterval("location.reload()", 3000);

        //$("#collateral_data_row").append('<div>' +sum_amount+'</div>'+'<div>'+currency_symbols_fl+'</div>');

        // var options = {
        //   series: count_all,
        //   chart: {
        //     width: 380,
        //     type: "pie",
        //   },
        //   labels: currency_symbols_fl,
        //   responsive: [
        //     {
        //       breakpoint: 480,
        //       options: {
        //         chart: {
        //           width: 200,
        //           height: 320,
        //         },
        //         legend: {
        //           position: "bottom",
        //         },
        //       },
        //     },
        //   ],
        // };

        // var chart = new ApexCharts(
        //   document.querySelector("#filter_metrics_charts"),
        //   options
        // );

        // chart.render();

        var myTableBody = $("#exposure_by_collateral_currency_table");

        let tableRows = d_data.get_filter_for_collateral_by_currency.map(
          (resultRow) =>
            `<tr>
              <td>
                ${resultRow.totalNumberOfCollaterals}
              </td>
              <td>
                ${resultRow.collateralVal}
              </td>
              <td>
                ${resultRow.collateral_currency}
              </td>
            </tr>`
        );

        $("#exposure_by_collateral_currency_table").empty().append(tableRows);

        //$(document).ready(function () {
        if ($.fn.dataTable.isDataTable("#exposure_by_facility_table")) {
          $("#exposure_by_facility_table").DataTable().destroy();
          // var table = $("#exposure_by_facility_table").DataTable();
          // table.clear();
          // table.rows.add(data).draw();
        } else {
          $("#exposure_by_facility_table").DataTable({
            order: [[1, "desc"]],
            pageLength: 10,

            ajax: {
              url: "apps/reports/controller/CustomerExposureFilterCTRL.php?mode=filter_for_facility_by_currency_list",
              dataSrc: "filter_for_facility_by_currency_list",
              method: "POST",
              dataType: "JSON",
              data: {
                select_client: select_client,
                filter_action: filter_action,
                bonds_start_date: bonds_start_date,
                bonds_end_date: bonds_end_date,
              },
            },

            columns: [
              { data: "customer_name" },
              { data: "totalAmt" },
              { data: "ccy" },
            ],

            dom: "Bfrtip",

            buttons: ["copy", "csv", "excel", "print"],

            responsive: {
              details: {
                display: $.fn.dataTable.Responsive.display.modal({
                  header: function (row) {
                    var data = row.data();
                    return "Details for " + data[0] + " " + data[1];
                  },
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                  tableClass: "table",
                }),
              },
            },
          });
        }
        //});
      }
    },
  });

  $(document).ready(function () {
    if ($.fn.dataTable.isDataTable("#exposure_by_collateral_table")) {
      $("#exposure_by_collateral_table").DataTable().destroy();
      // var table = $("#exposure_by_collateral_table").DataTable();
      // table.clear();
      // table.rows.add(data).draw();
    } else {
      $("#exposure_by_collateral_table").DataTable({
        order: [[1, "desc"]],
        pageLength: 10,

        ajax: {
          url: "apps/reports/controller/CustomerExposureFilterCTRL.php?mode=get_filter_for_collateral_list",
          dataSrc: "get_filter_for_collateral_list",
          method: "POST",
          dataType: "JSON",
          data: {
            select_client: select_client,
            filter_action: filter_action,
            bonds_start_date: bonds_start_date,
            bonds_end_date: bonds_end_date,
          },
        },

        columns: [
          { data: "collateral_code" },
          { data: "account_number" },
          { data: "branch_name" },
          { data: "collateral_value" },
          { data: "collateral_currency" },
          { data: "classification" },
        ],

        dom: "Bfrtip",

        buttons: ["copy", "csv", "excel", "print"],

        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return "Details for " + data[0] + " " + data[1];
              },
            }),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
              tableClass: "table",
            }),
          },
        },
      });
    }
  });
});

function collateral_by_currency(itm) {
  let liability_id = $(itm).attr("data-id");
  let group_by = "currency";

  let post_data = {
    liability_id: liability_id,
    group_by: group_by,
  };
  let paramsThis = $.param(post_data);

  $("<div>").load(
    "apps/reports/view/modals/collateral_by_currency.phtml?" + paramsThis,
    function (data) {
      $("#modal_content_here").html(data);
    }
  );
}

function collateral_by_category(itm) {
  let liability_id = $(itm).attr("data-id");
  let group_by = "category";

  let post_data = {
    liability_id: liability_id,
    group_by: group_by,
  };
  let paramsThis = $.param(post_data);

  $("<div>").load(
    "apps/reports/view/modals/collateral_by_category.phtml?" + paramsThis,
    function (data) {
      $("#modal_content_here").html(data);
    }
  );
}

function collateral_by_type(itm) {
  let liability_id = $(itm).attr("data-id");
  let group_by = "type";

  let post_data = {
    liability_id: liability_id,
    group_by: group_by,
  };
  let paramsThis = $.param(post_data);

  $("<div>").load(
    "apps/reports/view/modals/collateral_by_type.phtml?" + paramsThis,
    function (data) {
      $("#modal_content_here").html(data);
    }
  );
}

function collateral_by_classification(itm) {
  let liability_id = $(itm).attr("data-id");
  let group_by = "classification";

  let post_data = {
    liability_id: liability_id,
    group_by: group_by,
  };
  let paramsThis = $.param(post_data);

  $("<div>").load(
    "apps/reports/view/modals/collateral_by_classification.phtml?" + paramsThis,
    function (data) {
      $("#modal_content_here").html(data);
    }
  );
}

// function collateral_grouping(itm) {
//   let group_by_val = $(itm).attr("data-grp");

//   $.ajax({
//     url: "apps/reports/controller/CollateralGroupingCTRL.php",
//     method: "POST",
//     //data: new FormData(this),
//     //contentType: false,
//     dataType: "JSON",
//     data: {
//       group_by_val: group_by_val
//     },
//     // cache: false,
//     //processData: false,
//     success: function (data_b) {
    
//       if (data_b.response == "success") {
        
//         $('#collateral_grouping_here').empty();
       
//           $("#exposure_by_facility_table").DataTable({
//             order: [[1, "desc"]],
//             pageLength: 10,

//             ajax: {
//               url: "apps/reports/controller/CollateralGroupingCTRL.php?mode=filter_for_facility_by_currency_list",
//               dataSrc: "filter_for_facility_by_currency_list",
//               method: "POST",
//               dataType: "JSON",
//               data: {
//                 select_client: select_client,
//                 filter_action: filter_action,
//                 bonds_start_date: bonds_start_date,
//                 bonds_end_date: bonds_end_date,
//               },
//             },

//             columns: [
//               { data: "customer_name" },
//               { data: "totalAmt" },
//               { data: "ccy" },
//             ],

//             dom: "Bfrtip",

//             buttons: ["copy", "csv", "excel", "print"],

//             responsive: {
//               details: {
//                 display: $.fn.dataTable.Responsive.display.modal({
//                   header: function (row) {
//                     var data = row.data();
//                     return "Details for " + data[0] + " " + data[1];
//                   },
//                 }),
//                 renderer: $.fn.dataTable.Responsive.renderer.tableAll({
//                   tableClass: "table",
//                 }),
//               },
//             },
//           });
//         //}
//         //});
//       }
//     },
//   });

//   $(document).ready(function () {
//     if ($.fn.dataTable.isDataTable("#exposure_by_collateral_table")) {
//       $("#exposure_by_collateral_table").DataTable().destroy();
//       // var table = $("#exposure_by_collateral_table").DataTable();
//       // table.clear();
//       // table.rows.add(data).draw();
//     } else {
//       $("#exposure_by_collateral_table").DataTable({
//         order: [[1, "desc"]],
//         pageLength: 10,

//         ajax: {
//           url: "apps/reports/controller/CustomerExposureFilterCTRL.php?mode=get_filter_for_collateral_list",
//           dataSrc: "get_filter_for_collateral_list",
//           method: "POST",
//           dataType: "JSON",
//           data: {
//             select_client: select_client,
//             filter_action: filter_action,
//             bonds_start_date: bonds_start_date,
//             bonds_end_date: bonds_end_date,
//           },
//         },

//         columns: [
//           { data: "collateral_code" },
//           { data: "account_number" },
//           { data: "branch_name" },
//           { data: "collateral_value" },
//           { data: "collateral_currency" },
//           { data: "classification" },
//         ],

//         dom: "Bfrtip",

//         buttons: ["copy", "csv", "excel", "print"],

//         responsive: {
//           details: {
//             display: $.fn.dataTable.Responsive.display.modal({
//               header: function (row) {
//                 var data = row.data();
//                 return "Details for " + data[0] + " " + data[1];
//               },
//             }),
//             renderer: $.fn.dataTable.Responsive.renderer.tableAll({
//               tableClass: "table",
//             }),
//           },
//         },
//       });
//     }
//   });
// }
