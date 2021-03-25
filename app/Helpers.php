<?php

use Aloha\Twilio;

function apiResponseHandler($response = [], $message = '', $status = 200, $limit = '')
{
    return [
        'response' => $response,
        'message' => $message,
        'status' => $status,
        'pagination_limit' => $limit,
    ];
}

function generateOtp($length = 5)
{
    $characters = '0123456789';

    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

function sendEmail($template, $to_email, $subject)
{
    $data = array(
        'email' => $to_email,
        'clientid' => 'BIDMCA',
        'key' => 'wHfWHwpDYFf3rEpbbc1tipQu28jqoOf0qeLNunkrqtwU1J1lPPKepJvJX7ILDpSy',
        'subject' => $subject,
        'message' => $template,
        'file' => '',
        'replyto' => 'noreply@bidmca.com'
    );
    $url = 'https://esmtp.qualwebs.com/qw/api/api.php';
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($handle);
    curl_close($handle);
}

function sendSMS($number, $message){
    $twilio = new Aloha\Twilio\Twilio('ACa15c30576b0673eb35f9499726531d21', 'eea89624c3619b8494fcf9267a2768f0', '+19166194213');
    $twilio->message('+91'.$number, $message);
    return true;
}
