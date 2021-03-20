AOS.init();

const api = new API();

$(document).ready(function () {
    $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function () {
        $(this).toggleClass('open');
    });
});

var cleave = new Cleave('#phone', {
    phone: true,
    phoneRegionCode: 'US'
});

// GLOBAL NOTIFY JS CONFIG
function showNotification(message, type){
    $.notify(
        message,
        type,
        { position:'bottom center' }
    );
}

function disableElement(element, type){
    $(element).prop('disabled', type);
}

function sendOtp(e){
    if(!$('input[name="tnc"]:checked').val()){
        showNotification('Please accept terms & conditions.', 'error');
        return false;
    }
    disableElement($('#submitUser'), true);
    const inputData = {
        otp: $('#otp').val(),
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        password: $('#password').val(),
        user_type: $('input[name="user_type"]:checked').val(),
        tnc: $('input[name="tnc"]:checked').val()
    };
    api.sendOtp(inputData).then((res) => {
        showNotification('Otp sent successfully', 'success');
        $('#otpModal').modal('show');
    }).catch((error) => {
        disableElement($('#submitUser'), false);
        showNotification(error.response.data.message, 'error');
    });
}

function verifyOtp(element){
    disableElement(element, true);
    const inputData = {
        otp: $('#otp').val(),
        phone: $('#phone').val()
    };
    api.register(inputData).then((res) => {
        register();
    }).catch((error) => {
        disableElement(element, false);
        showNotification(error.response.data.message, 'error');
    });
}

function register(){
    disableElement($('#submitOtp'), true);
    const inputData = {
        otp: $('#otp').val(),
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        password: $('#password').val(),
        user_type: $('input[name="user_type"]').val(),
        tnc: $('input[name="tnc"]').val()
    };

    api.register(inputData).then((res) => {
        showNotification('Account created successfully.', 'success');
        $('#otpModal').modal('hide');
    }).catch((error) => {
        showNotification(error.response.data.message, 'error');
    });
}
