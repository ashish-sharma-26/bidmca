<?php


use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Aloha\Twilio\Twilio;

function apiResponseHandler($response = [], $message = '', $status = 200, $limit = '')
{
    return [
        'response' => $response,
        'message' => $message,
        'status' => $status,
        'pagination_limit' => $limit,
    ];
}

function sendEmail($email, $subject, $view, $details)
{
    $data = array('details' => $details);
    Mail::send($view, $data, function ($message) use ($email, $subject) {
        $message->to($email)
            ->subject($subject);
    });
}

function uploadDocuments($document)
{
    $common = App\Models\Seller\Product\Products::find(2);
    $common->addMediaFromBase64($document)->usingFileName(time() . '.png')->toMediaCollection('product_images');
    $media = $common->getMedia('product_images');
    $base_path = $media[count($media)-1]->getUrl();

    return $base_path;
}

function uploadImage($requestFile, $path)
{
    $imageName = time() . $requestFile->getClientOriginalName();
    $requestFile->move(storage_path("app/public/" . $path), $imageName);
    $base_path = env('APP_URL') . "/storage/$path/$imageName";

    return $base_path;
}

function creditPoints($point_id, $auth)
{
    $increment = 1;
    $count = \App\Models\Credit\UserCreditPoint::where('point_id', $point_id)->first();
    if ($count) {
        $neglectPoint = array(1, 2, 3, 4, 5, 6);
        $available = in_array($point_id, $neglectPoint);
        if ($available == false) {
            $increment = $count['increments'] + 1;
        }
    }
    \App\Models\Credit\UserCreditPoint::updateOrCreate([
        'user_id' => $auth->id, 'point_id' => $point_id
    ], ['increments' => $increment]);
}


function getUserCreditPoints($auth)
{
    $credits = \App\Models\Buyer\Auth\User::find($auth->id)->creditPoints;
    $total = 0;
    if (isset($credits) && count($credits) > 0) {
        foreach ($credits as $credit) {
            $total = $total + ($credit['pivot']['increments'] * $credit['points']);
        }
    }
    return $total;
}

function twilioSendMessage($phoneWithDial, $message)
{
    $sid = env('TWILIO_ACCOUNT_ID');
    $token = env('TWILIO_AUTH_TOKEN');
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
        ->create("+$phoneWithDial", // to
            ["body" => $message, "from" => "+12064601838"]
        );

    return $message;
}


function ccMasking($number, $maskingCharacter = 'X')
{
    return substr($number, 0, 3) . str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -3);
}


function getIcons($code)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://restcountries.eu/rest/v2/callingcode/".$code,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
        ),
    ));

    return  curl_exec($curl);
}

?>
