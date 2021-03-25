<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('css/aos-animation.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/media.css')}}" rel="stylesheet">
</head>
<body id="main-background">
<header id="header" class="bg-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg logo-width">
            <a class="navbar-brand" href="{{url('/')}}"><img src="images/logo1.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <div id="nav-icon1">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav menu ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('howItWork')}}">How Bidmca works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">Partners</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn btn-application" href="{{url('/application')}}">Start Application</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn btn-login" href="#">Login <i class="las la-long-arrow-alt-right icons"></i></a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</header>
<!-----------------------/header---------------------->
@yield('content')
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                <div class="call-details">
                    <h6>Call us at:</h6>
                    <h6>(876) 987 678</h6>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4 col-xl-4 copyright-col">
                <div class="call-details">
                    <h6>copyright@2021</h6>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4 col-xl-4 social-col">
                <div class="call-details social-details">
                    <h6>follow :</h6>
                    <i class="lab la-facebook-f"></i>
                    <i class="lab la-twitter"></i>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/aos-animation.js') }}" defer></script>
    <script src="{{ asset('js/api.services.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
</body>
</html>
