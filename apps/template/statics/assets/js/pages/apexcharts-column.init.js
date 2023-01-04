$(document).ready(function () {
  $.ajax({
    url: "apps/dashboard/controller/CTRLCollateralCategoryChart.php",
    method: "GET",
    dataType: "JSON",

    success: function (data) {

      let normal_loans = [];
      let olem_loans = [];
      let sub_loans = [];
      let doubt_loans = [];
      let loss_loan = [];

      // $.each(data.chart_values_array, function (key, val) {
      //   normal_loans.push(val.all_normal_array);
      // });

      // $.each(data.all_olem_array, function (key, val) {
      //   olem_loans.push(val.all_olem_array);
      // });

      // $.each(data.all_sub_array, function (key, val) {
      //   sub_loans.push(val.all_sub_array);
      // });

      // $.each(data.all_doubt_array, function (key, val) {
      //   doubt_loans.push(val.all_doubt_array);
      // });

      // $.each(data.all_loss_array, function (key, val) {
      //   loss_loan.push(val.all_loss_array);
      // });
      
      console.log(data.all_olem_array);

      var options = {
        series: [
          {
            name: "Normal Loans",
            data: data.all_normal_array,
          },
          {
            name: "OLEM Loans",
            data: data.all_olem_array,
          },
          {
            name: "Sub Standard Loans",
            data: data.all_sub_array,
          },

          {
            name: "Doubtful Loans",
            data: data.all_doubt_array
          },

          {
            name: "Loss Loans",
            data: data.all_loss_array,
          },
        ],
        chart: {
          type: "bar",
          height: 350,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "45%",
            endingShape: "rounded",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        xaxis: {
          categories: [
            "Legal Mortgage",
            "Plants & Machinery",
            "Board Guarantee",
            "Inventory",
          ],
        },
        yaxis: {
          title: {
            text: "Count of Categories",
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val;
            },
          },
        },
      };

      var chart = new ApexCharts(
        document.querySelector("#column_group_labels"),
        options
      );
      chart.render();
    },
  });
});
