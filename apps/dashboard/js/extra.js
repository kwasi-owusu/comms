$(document).ready(function () {
  $.ajax({
    url: "apps/dashboard/controller/CTRLDashboard.php",
    method: "GET",
    dataType: "JSON",
    success: function (data) {
      $("#total_normal_loans").text(data.total_normal_loans);
      $("#total_olem_loans").text(data.total_olem_loans);
      $("#total_total_sub_standard_loans").text(
        data.total_total_sub_standard_loans
      );
      $("#total_doubtful_loans").text(data.total_doubtful_loans);
      $("#sum_normal_loans").text(data.sum_normal_loans);
      $("#sum_olem_loans").text(data.sum_olem_loans);
      $("#sum_total_sub_standard_loans").text(
        data.sum_total_sub_standard_loans
      );
      $("#sum_doubtful_loans").text(data.sum_doubtful_loans);
      $("#total_loss_loans").text(data.total_loss_loans);
      $("#sum_loss_loans").text(data.sum_loss_loans);
      $("#total_bonds_and_guarantees").text(data.total_bonds_and_guarantees);
      $("#total_loans").text(data.total_loans);
      $("#total_overdraft").text(data.total_overdraft);
      $("#total_breached_overdraft").text(data.total_breached_overdraft);
      $("#total_loan_principal_overdue").text(
        data.total_loan_principal_overdue
      );
      $("#total_loan_penalty_overdue").text(data.total_loan_penalty_overdue);
      $("#total_loan_penalty_due").text(data.total_loan_penalty_due);

      let currency_symbols = [];
      let sum_facility = [];

      let arr = data.collateral_grouped_by_currency;

      $.each(data.collateral_grouped_by_currency, function (key, val) {
        currency_symbols.push(val.collateral_currency);
      });

      $.each(data.collateral_grouped_by_currency, function (key, val) {
        sum_facility.push(val.TotalFacilityDisbursedByCurrency);
      });


      // for (var i = 0; i < currency_symbols.length; i++) {
        
      //   //console.log(arr[i]);
      // }

      //$("#collateral_data_row").append('<div>' +sum_facility+'</div>'+'<div>'+currency_symbols+'</div>');

      var options = {
        series: sum_facility,
        chart: {
          width: 380,
          type: "pie",
        },
        labels: currency_symbols,
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
                height: 320,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      };

      var chart = new ApexCharts(
        document.querySelector("#audiences_metrics_charts"),
        options
      );
      chart.render();
    },
  });
});


function facility_details(itm) {
  let customer_id = $(itm).attr("data-id");
 
  $('<div>').load('apps/dashboard/view/modals/collateral_facility_details.phtml?customer_id=' + customer_id, function(data) {
      $("#modal_content_here").html(data);
  });

}


function collateral_status_list(itm) {
  let status_id = $(itm).attr("data-id");
 
  $('<div>').load('apps/dashboard/view/modals/collateral_status_details.phtml?id=' + status_id, function(data) {
      $("#modal_content_here").html(data);
  });

}

function collateral_status_by_branch(itm) {
  let status_id = $(itm).attr("data-id");
 
  $('<div>').load('apps/dashboard/view/modals/collateral_filter_by_branchs.phtml?id=' + status_id, function(data) {
      $("#modal_content_here").html(data);
  });

}


function facility_filter_list(itm) {
  let facility_id = $(itm).attr("data-id");
 
  $('<div>').load('apps/dashboard/view/modals/facility_filter_list.phtml?id=' + facility_id, function(data) {
      $("#modal_content_here").html(data);
  });

}

function facility_filter_list_by_branch(itm) {
  let facility_id = $(itm).attr("data-id");
 
  $('<div>').load('apps/dashboard/view/modals/facility_filter_list_by_branch.phtml?id=' + facility_id, function(data) {
      $("#modal_content_here").html(data);
  });

}

