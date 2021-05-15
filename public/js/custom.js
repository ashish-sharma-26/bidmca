AOS.init();

const api = new API();

$(document).ready(function () {
    $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function () {
        $(this).toggleClass('open');
    });
    var current_fs, next_fs, previous_fs;

// No BACK button on first screen
    if($(".show").hasClass("first-screen")) {
        $(".prev").css({ 'display' : 'none' });
    }

// Next button
//     $(".next-button").click(function(){
//
//         current_fs = $(this).parent().parent();
//         next_fs = $(this).parent().parent().next();
//
//         $(".prev").css({ 'display' : 'block' });
//
//         $(current_fs).removeClass("show");
//         $(next_fs).addClass("show");
//
//         $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");
//
//         current_fs.animate({}, {
//             step: function() {
//
//                 current_fs.css({
//                     'display': 'none',
//                     'position': 'relative'
//                 });
//
//                 next_fs.css({
//                     'display': 'block'
//                 });
//             }
//         });
//     });

// Previous button
    $(".prev").click(function(){

        current_fs = $(".show");
        previous_fs = $(".show").prev();

        $(current_fs).removeClass("show");
        $(previous_fs).addClass("show");

        $(".prev").css({ 'display' : 'block' });

        if($(".show").hasClass("first-screen")) {
            $(".prev").css({ 'display' : 'none' });
        }

        $("#progressbar li").eq($(".card2").index(current_fs)).removeClass("active");

        current_fs.animate({}, {
            step: function() {

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });

                previous_fs.css({
                    'display': 'block'
                });
            }
        });
    });

    $('input[type="file"]').change(function(e) {
        $('.preloader').show();
        var file = e.target.files[0];

        var Element = e.currentTarget.attributes.name.value;

        let formData = new FormData();

        formData.append('file', file);

        api.fileUpload(formData).then((res) => {
            $('.preloader').hide();
            $('#' + Element + '-wrap').hide();
            $('#' + Element + '-a-wrap').show();
            $('#' + Element + '-a').prop('href',storageURL+res.data.response.path);
            showNotification('File uploaded successfully.', 'success');
            $('#' + Element).val(res.data.response.path);
        }).catch((error) => {
            $('.preloader').hide();
            showNotification(error.response.data.message, 'error');
        });
    });
});

if($('#phone').length){
    new Cleave('#phone', {
        phone: true,
        phoneRegionCode: 'US'
    });
}

if($('#billing_phone').length){
    new Cleave('#billing_phone', {
        phone: true,
        phoneRegionCode: 'US'
    });
}
if($('#billing_phone2').length){
    new Cleave('#billing_phone', {
        phone: true,
        phoneRegionCode: 'US'
    });
}
var loan_amount;
if($('#loan_amount').length){
    loan_amount = new Cleave('#loan_amount', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
}

var due_amount;
if($('#due_amount').length){
    due_amount = new Cleave('#due_amount', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
}

var bidAmount;
if($('#bidAmount').length){
    bidAmount = new Cleave('#bidAmount', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
}

if($('#amount_per_year').length){
    new Cleave('#amount_per_year', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
}

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
        _token: $("input[name=_token]").val(),
        otp: $('#otp').val(),
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        password: $('#password').val(),
        user_type: $('input[name="user_type"]:checked').val(),
        tnc: $('input[name="tnc"]').val()
    };

    api.register(inputData).then((res) => {
        showNotification('Account created successfully.', 'success');
        $('#otpModal').modal('hide');
        window.location.href = webUrl + '/dashboard';
    }).catch((error) => {
        showNotification(error.response.data.message, 'error');
    });
}

function resetUpload(Element) {
    $('#' + Element + '-wrap').show();
    $('#' + Element + '-a-wrap').hide();
    $('#' + Element + '-a').prop('href','');
    $('#' + Element).val('');
}

// const handler = Plaid.create({
//     token: 'link-sandbox-cfa53167-716e-450d-9071-0ba8728d167a',
//     onSuccess: (public_token, metadata) => {
//         console.log(public_token);
//         console.log(metadata);
//     },
//     onLoad: () => {},
//     onExit: (err, metadata) => {
//         console.log(err)
//     },
//     onEvent: (eventName, metadata) => {},
//     receivedRedirectUri: null,
// });

// handler.open();

if (!window.Notification) {
    console.log('Browser does not support notifications.');
} else {
    // check if permission is already granted
    if (Notification.permission === 'granted') {
        // show notification here
    } else {
        // request permission from user
        Notification.requestPermission().then(function(p) {
            if(p === 'granted') {
                console.log('notifications Granted.');
            } else {
                console.log('User blocked notifications.');
            }
        }).catch(function(err) {
            console.error(err);
        });
    }
}
