function facility_datils(itm) {
    let account_number = $(itm).attr("data-id");
    $('<div>').load('bamboo/view/modules/crm/modals/setCreditLimit.php?id=' + account_number, function(data) {
        $("#modal_content_here").html(data);
    });

}