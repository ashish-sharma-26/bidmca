$(document).ready(function () {
    $(".close").click(function () {
        $(".modal").modal('hide');
    });
    $(".btn-secondary").click(function () {
        $(".modal").modal('hide');
    });
    $(".close-modal ").click(function () {
        $(".modal").modal('hide');
    });
});

var trxStartDate = '';
var trxEndDate = '';
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
        maxYear: parseInt(moment().format('YYYY'), 10)
    });
    $('input[name="trx_date"]').daterangepicker({
        showDropdowns: true,
        drops: 'up',
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "alwaysShowCalendars": true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    }, function (start, end, label) {
        // var id = $('#appId').val();
        // fetchTrxData(id, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
        trxStartDate = start.format('YYYY-MM-DD');
        trxEndDate = end.format('YYYY-MM-DD');
        $('#trx-button').prop('disabled', false);
    });
    $('input[name="trx_date"]').val('');
    $('input[name="trx_date"]').attr("placeholder", "Please select date");
})();

function changeStatus(id, status) {
    $('#appStatus').val(status);
    $('#applicationId').val(id);
    if (status == '3') {
        $('#dateField').show();
        $('#initBid').show();
        $('#labelNote').text('Note');
        $('#rejectModal').modal('show');
    }
    if (status == '4') {
        $('#dateField').hide();
        $('#initBid').hide();
        $('#labelNote').text('Reason for rejection');
        $('#rejectModal').modal('show');
    }
}

function fetchAccountData(id) {
    $('#acc-button').hide();
    $('#acc-loader').show();
    $.ajax({
        url: BASE_URL + 'admin/plaid/fetch-account-data/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (success) {
            $('#acc-loader').hide();
            $('#acc-table').show();
            $('#plaidAccountData').html(success.response.data);
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip();
            }, 1000)
        }
    });
}

function fetchLiabilityData(id) {
    $('#lbt-button').hide();
    $('#lbt-loader').show();
    $.ajax({
        url: BASE_URL + 'admin/plaid/fetch-liability-data/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (success) {
            $('#lbt-loader').hide();
            $('#lbt-table').show();

            if (success.response.credit) {
                $('#lbt-credit-table').show();
                $('#lbt-credit-table tbody').html(success.response.credit);
            }
            if (success.response.mortgage) {
                $('#lbt-mortgage-table').show();
                $('#lbt-mortgage-table tbody').html(success.response.mortgage);
            }
            if (success.response.student) {
                $('#lbt-student-table').show();
                $('#lbt-student-table tbody').html(success.response.student);
            }

            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip();
            }, 1000)
        }
    });
}

function fetchTrxData(id) {
    $('#trx-button').prop('disabled', true);
    $('#trx-loader').show();
    $('#trx-table').hide();
    $.ajax({
        url: BASE_URL + 'admin/plaid/fetch-transaction-data/' + id + '?start=' + trxStartDate + '&end=' + trxEndDate,
        type: 'GET',
        dataType: 'JSON',
        success: function (success) {
            $('#trx-loader').hide();
            $('#trx-table').show();
            $('#plaidTrxData').html(success.response.data);
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip();
            }, 1000)
        }
    });
}
