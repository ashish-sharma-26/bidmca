<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&amp;display=swap"
          rel="stylesheet">
    <title>bidmca</title>
    <style>
        body {
            font-family: Montserrat !important;
        }
    </style>
    <style>
        body{
            font-family: 'Montserrat', sans-serif !important;
            text-transform: capitalize;
        }
        h1, h2, h3, h4, h5, h6, p, a, button{
            font-family: 'Montserrat', sans-serif !important;
        }
    </style>
</head>
<body style="background-color: #fff;font-family: 'Montserrat', sans-serif !important;">

<div class="container"
     style="margin: 0 auto; max-width: 600px; text-align: center; font-family: Montserrat;">

    <div><img src="http://159.65.142.31/bidmca-design/images/logo.png" style="width: 100px"/> </div>
    <div style="background-color: #f6f6f6;margin: 55px 0 0 0;padding-bottom: 1rem">
        <h2 style="margin: 0;padding: 15px;font-weight: 600;color: #30D667;padding-bottom: 0;">Hi {{$owner}},</h2>
        <hr style="border: 2px solid #30D667; width: 50px; margin-bottom: 0 auto">
        <p style="font-weight: bold;font-size: 1rem;padding-bottom: 1rem;margin: 0;">Please authorize the loan application submitted by {{auth()->user()->first_name}} {{auth()->user()->last_name}}.</p>
        <p><a href="{{route('plaid_auth', ['key' => $key])}}"><button style="background: #30D667;color: #fff;padding: 15px;border: none;box-shadow: none;cursor: pointer">View & Authorize</button></a></p>
    </div>
    <div class="footer" style="padding: 1px 2rem 1rem 2rem; background-color: #30D667; color: #ffffff;">
        <div style="width: 100%; display:none;visibility: hidden">
            <h3 style="margin-top: 0; font-weight: normal">Download App</h3>
            <a href="#"><img alt="" src="https://admin.farmersfreshkitchen.com/public/images/itunes.png"
                             style="max-width: 132px; height: auto;"></a>
            <a href="#"><img alt=""
                             src="https://admin.farmersfreshkitchen.com/public/images/playstore.png" style="max-width: 132px; height: auto;"></a>
        </div>
        <p style="font-size: 16px; margin-top: 1rem; margin-bottom: 0">
            <a href="#" style="color: #ffffff;
    text-decoration: none;">Contact Us</a>
            <span style="padding: 0 10px"> | </span> <a style="color: #ffffff;
    text-decoration: none;" href="#">Legal</a>
        </p>
    </div>
</div>
</body>
</html>
