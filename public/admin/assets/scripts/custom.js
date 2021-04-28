$(document).ready(function () {
    $(".close").click(function(){
        $(".modal").modal('hide');
    });
    $(".btn-secondary").click(function(){
        $(".modal").modal('hide');
    });
    $(".close-modal ").click(function(){
        $(".modal").modal('hide');
    });
});

(function () {
    $('input[name="closing_date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true,
        timePickerIncrement: 10,
        timePicker24Hour: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        },
        minDate: moment().format('YYYY-MM-DD HH:mm'),
        maxYear: parseInt(moment().format('YYYY'),10)
    });
})();
function changeStatus(id, status) {
    $('#appStatus').val(status);
    $('#applicationId').val(id);
    if (status == '3') {
        $('#dateField').show();
        $('#reasonField').hide();
        $('#rejectModal').modal('show');
    }
    if (status == '4') {
        $('#dateField').hide();
        $('#reasonField').show();
        $('#rejectModal').modal('show');
    }
}
