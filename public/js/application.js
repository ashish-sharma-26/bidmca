$(function() {
    $('#dob').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
        var years = moment().diff(start, 'years');
    });

    $('#dob').val('');
    $('#dob').attr("placeholder", "Please select date");

    $('#authCheck').change(
        function(){;
            if ($(this).is(':checked')) {
                $('#authBtn').prop('disabled', false);
                $('#authEmailWrap').hide();
            }
            else{
                $('#authBtn').prop('disabled', true);
                $('#authEmailWrap').show();
            }
        });
});

function changeDueStatus(value) {
    if(value == 1){
        $('.due-wrap').removeClass('d-none');
    }
    if(value == 0){
        $('.due-wrap').addClass('d-none');
    }
}

function checkContract(value) {
    if(value == 1){
        $('#contractFile').removeClass('d-none');
    }
    if(value == 0){
        $('#contractFile').addClass('d-none');
    }
}

function checkMode(value) {
    if(value == 'Rented'){
        $('#modeAmount').removeClass('d-none');
    }
    if(value == 'Owned'){
        $('#modeAmount').addClass('d-none');
    }
}

function addressCheck(element) {
    if($(element).is(":checked")){
        $('#billingAddressWrap').removeClass('d-none');
    }
    if(!$(element).is(":checked")){
        $('#billingAddressWrap').addClass('d-none');
    }
}

function stateChange(value, type){
    api.getCities(value).then((res) => {
        if(type == 1){
            $('#billing_city_id').html(res.data.response.cityHtml);
        }
        if(type == 2){
            $('#billing_city_id2').html(res.data.response.cityHtml);
        }
    }).catch((error) => {
    });
}

function storeApplication(action) {
    // nextStep(action);
    let is_business_operating = 0;
    if($('#is_business_operating').is(":checked")){
        is_business_operating = 1;
    }
    let authCheck = 0;
    if($('#authCheck').is(":checked")){
        authCheck = 1;
    }
    const data = {
        action: action,
        unique_id: $('#unique_id').val(),
        loan_amount: $('#loan_amount').val(),
        business_name: $('#business_name').val(),
        state_incorporation_id: $('#state_incorporation_id').val(),
        is_business_operating: is_business_operating,
        fed_tax_id: $('#fed_tax_id').val(),
        industry_type: $('#industry_type').val(),
        due_status: $('#due_status').val(),
        due_amount: $('#due_amount').val(),
        lender_names: $('#lender_names').val(),
        due_contract: $('#due_contract').val(),
        contract_file: $('#contract_file').val(),
        billing_street_address: $('#billing_street_address').val(),
        billing_city_id: $('#billing_city_id').val(),
        billing_state_id: $('#billing_state_id').val(),
        billing_zipcode: $('#billing_zipcode').val(),
        billing_phone: $('#billing_phone').val(),
        mode: $('#mode').val(),
        amount_per_year: $('#amount_per_year').val(),
        billing_street_address2: $('#billing_street_address2').val(),
        billing_city_id2: $('#billing_city_id2').val(),
        billing_state_id2: $('#billing_state_id2').val(),
        billing_zipcode2: $('#billing_zipcode2').val(),
        billing_phone2: $('#billing_phone2').val(),
        owner: $('#owner').val(),
        ownership_percent: $('#ownership_percent').val(),
        title: $('#title').val(),
        last_name: $('#last_name').val(),
        first_name: $('#first_name').val(),
        dob: $('#dob').val(),
        ssn: $('#ssn').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        account_number: $('#account_number').val(),
        bank: $('#bank').val(),
        account_email: $('#account_email').val(),
        authCheck: authCheck,
        signature_file: $('#signature_file').val(),
    };

    api.storeApplication(data).then((res) => {
        $('#unique_id').val(res.data.response.unique_id);
        if(action === 'draft'){
            showNotification('Application drafted successfully.','success');
        }
        if(action !== 'draft'){
            nextStep(action);
        }
        if(action === 'step4'){
            $('#business_name_t').html($('#business_name').val());
            $('#business_state').html($( "#billing_state_id option:selected" ).text());
            $('#business_city').html($( "#billing_city_id option:selected" ).text());
            $('#business_desc').html(data.industry_type);
            $('#business_load_amount').html(data.loan_amount);
            $('#business_due_amount').html(data.due_amount ? data.due_amount : 0);
            $('#business_status').html(is_business_operating ? 'Operating' : 'Closed');
        }
        if(action === 'step5'){
            window.location.href = webUrl + '/dashboard';
        }
    }).catch((error) => {
        // nextStep(action);
        showNotification(error.response.data.message, 'error');
    });
}

function validateBidScore() {
    const data = {
        application_id: $('#application_id').val(),
        interest_rate: $('#interest_rate').val(),
        timeframe: $('#timeframe').val(),
        bid_amount: $('#bidAmount').val(),
    };

    disableElement('#placeBid', true);
    api.validateBidScore(data).then((res) => {
        if(res.data.message){
            var r = confirm(res.data.message);
            if(r == true){
                placeBidAction();
            }else{
                disableElement('#placeBid', false);
            }
        }else{
            placeBidAction()
        }
    }).catch((error) => {
        showNotification(error.response.data.message, 'error');
    });
}

function placeBidAction() {
    const data = {
        application_id: $('#application_id').val(),
        interest_rate: $('#interest_rate').val(),
        timeframe: $('#timeframe').val(),
        bid_amount: $('#bidAmount').val(),
    };

    disableElement('#placeBid', true);
    api.placeBid(data).then((res) => {
        showNotification('Bid places successfully', 'success')
        disableElement('#placeBid', false);
        window.location.href = webUrl + '/dashboard';
    }).catch((error) => {
        disableElement('#placeBid', false);
        showNotification(error.response.data.message, 'error');
    });
}

function nextStep(action){
    var current_fs = $('#'+action).parent().parent();
    var next_fs = $('#'+action).parent().parent().next();

    $(".prev").css({ 'display' : 'block' });

    $(current_fs).removeClass("show");
    $(next_fs).addClass("show");

    $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");

    current_fs.animate({}, {
        step: function() {

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });

            next_fs.css({
                'display': 'block'
            });
        }
    });
}
