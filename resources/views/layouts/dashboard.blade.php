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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="{{asset('css/aos-animation.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/media.css')}}" rel="stylesheet">
</head>
<body>
<div class="preloader" style="display: none"><svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-ripple" style="background:0 0"><circle cx="50" cy="50" r="4.719" fill="none" stroke="#1d3f72" stroke-width="2"><animate attributeName="r" calcMode="spline" values="0;40" keyTimes="0;1" dur="3" keySplines="0 0.2 0.8 1" begin="-1.5s" repeatCount="indefinite"/><animate attributeName="opacity" calcMode="spline" values="1;0" keyTimes="0;1" dur="3" keySplines="0.2 0 0.8 1" begin="-1.5s" repeatCount="indefinite"/></circle><circle cx="50" cy="50" r="27.591" fill="none" stroke="#5699d2" stroke-width="2"><animate attributeName="r" calcMode="spline" values="0;40" keyTimes="0;1" dur="3" keySplines="0 0.2 0.8 1" begin="0s" repeatCount="indefinite"/><animate attributeName="opacity" calcMode="spline" values="1;0" keyTimes="0;1" dur="3" keySplines="0.2 0 0.8 1" begin="0s" repeatCount="indefinite"/></circle></svg></div>
<section>
    <div class="container-fluid">
        <!-----------------sidebar for mobile view------------------->
        <div class="mobile-header">
            <div class="row">
                <div class="col-10 col-md-10">
                    <div class="logo-width">
                        <a href="{{url('/')}}"><img src="images/logo1.png" class="img-fluid"></a></div>
                </div>
                <div class="col-2 col-md-2 text-right">
                    <div class="menubars"><span class="fa fa-bars" data-toggle="modal" data-target="#left-sidebar"></span></div>
                </div>
            </div>
        </div>

        <!-----------------/sidebar for mobile view------------------->
        <div class="row">
            <!--================start left side bar for web==================-->
            @if (Route::currentRouteName() != 'app_view')
            <div id="side-bar-content" class=" mobile-hide">
                <div id="side-bar">
                    <a href="{{url('/')}}"><img src="images/logo.png" data-aos="zoom-in"></a>

                    @if (Request::path() == 'application')
                        @include('dashboard.sections.application-menu')
                    @else
                        @include('dashboard.sections.dashboard-menu')
                    @endif

                    <div class="bottom-quotes signature-details">
                        <h6>Call us at:</h6>
                        <h6>(876) 987 678</h6>
                        <div class="loan-application follow-details">
                            <h5>follow:</h5>
                            <i class="fa fa-facebook"></i>
                            <i class="fa fa-twitter"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @yield('content')
        </div>
    </div>
</section>

<!----------------filter for mobile and tablet--------------->
<div class="mob-modal d-block d-md-block d-lg-none d-xl-none">
    <div id="filter-mob" class="modal left fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="side-bar-content">

                        <div id="side-bar pt-0">
                            <div class="sidebar-menu">
                                <ul id="side-menu">
                                    <li class="menu-title">
                                        <a href="#" class="menu-link"><span class="fa fa-bar-chart"></span>Dashboard</a>
                                    </li>
                                    <li class="menu-title">
                                        <a href="http://159.65.142.31/beemur-design/mystore.html" class="menu-link"><span class="fa fa-bar-chart"></span>My Store</a>
                                    </li>
                                    <li class="menu-title">
                                        <a href="http://159.65.142.31/beemur-design/inventory.html" class="menu-link"><span class="fa fa-bar-chart"></span>Inventory</a>
                                        <ul class="sub-menu">
                                            <li ><a href="http://159.65.142.31/beemur-design/inventory.html" >Product list</a></li>
                                            <li class="active"><a href="http://159.65.142.31/beemur-design/addproduct(step1).html" >Add Product</a></li>
                                            <li><a href="http://159.65.142.31/beemur-design/Customizables(inventory).html
              ">Customizables / Ad ons</a></li>
                                            <li><a href="#">Drafts</a></li>
                                        </ul>
                                    </li>


                                    <li class="menu-title">
                                        <a href="http://159.65.142.31/beemur-design/order-table.html" class="menu-link"><span class="fa fa-bar-chart"></span>Orders</a>
                                    </li>
                                    <li class="menu-title">
                                        <a href="#" class="menu-link"><span class="fa fa-bar-chart"></span>Payments</a>
                                    </li>
                                    <li class="menu-title">
                                        <a href="#" class="menu-link"><span class="fa fa-bar-chart"></span>Chats</a>
                                    </li>
                                    <li class="menu-title">
                                        <a href="#" class="menu-link"><span class="fa fa-bar-chart"></span>Reviews</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>

<!--------------------sidebar mobile modal-------------------------->
<div class="sidebar-modal modal left fade" id="left-sidebar" tabindex="-1" role="dialog" aria-labelledby="left_modal_sm">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--================start left side bar for web==================-->
                <div id="side-bar-content">
                    <div id="side-bar">
                        <div class="card1 position-sidebar" >
                            <ul id="progressbar" class="text-center" data-aos="fade-right" data-aos-duration="500">
                                <li class="active step0"></li>
                                <li class="step0"></li>
                                <li class="step0"></li>
                                <li class="step0"></li>
                                <li class="step0"></li>
                            </ul>
                            <a href="http://159.65.142.31/bidmca-design/dashboard(lender).html"> <h6 class="details1 active"  data-aos="fade-right" data-aos-duration="500">Dashboard</h6></a>
                            <a href="http://159.65.142.31/bidmca-design/dashboard-lender(profile).html"><h6 class="details2" data-aos="fade-right" data-aos-duration="600"  data-aos-easing="linear">Profile Details</h6></a>
                            <a href="http://159.65.142.31/bidmca-design/dashboard-lender(loan-application).html"><h6 class="details3" data-aos="fade-right" data-aos-duration="700"  data-aos-easing="linear">Loan Applications</h6></a>

                            <a href="http://159.65.142.31/bidmca-design/dashboard-lender(settings).html"><h6 class="details4" data-aos="fade-right" data-aos-duration="800"  data-aos-easing="linear">Settings</h6></a>

                            <a href="http://159.65.142.31/bidmca-design/dashboard-lender(contact).html"><h6 class="details4" data-aos="fade-right" data-aos-duration="800"  data-aos-easing="linear">Contact Support</h6></a>
                        </div>

                        <div class="bottom-quotes signature-details">
                            <h6>Call us at:</h6>
                            <h6>(876) 987 678</h6>
                            <div class="loan-application follow-details">
                                <h5>follow:</h5>
                                <i class="fa fa-facebook"></i>
                                <i class="fa fa-twitter"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--================/left side bar for web===================-->
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/aos-animation.js') }}" defer></script>
<script src="{{ asset('js/api.services.js') }}" defer></script>
<script src="{{ asset('js/moment.min.js') }}" defer></script>
<script src="{{ asset('js/daterangepicker.js') }}" defer></script>
<script src="{{ asset('js/custom.js') }}" defer></script>
<script src="{{ asset('js/application.js') }}" defer></script>
</body>
</html>
