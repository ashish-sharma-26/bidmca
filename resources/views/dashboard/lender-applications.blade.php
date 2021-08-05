@extends('layouts.dashboard')

@section('content')
    <div id="page-content" class="col-12 col-md-8 col-lg-8 col-xl-7 mx-auto">
        <div id="main-content">
            <!--------------------------business details--------------------------->
            <div class="card2 first-screen show">
                <div class="brokder-details confirmation-details">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 offset-md-3 offset-xl-3 offset-xl-3 signin-col">
                            <div class="signup-social-details">
                                <a href="{{route('logout')}}">Logout <span
                                        class="las la-long-arrow-alt-right icons"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="authorized-info">
                            <h5 class="mb-1">Loan Application(s)</h5>
                        </div>
                    </div>

                    <div class="profile-tabs">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-10">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="false">New</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="currently-tab" data-toggle="tab" href="#currently" role="tab" aria-controls="currently" aria-selected="true">Currently Active</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="won-tab" data-toggle="tab" href="#won" role="tab" aria-controls="won" aria-selected="false">Won</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="lost-tab" data-toggle="tab" href="#lost" role="tab" aria-controls="lost" aria-selected="false">Lost</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <!----------------------first profile tab-------------------->
                            <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                                @include('dashboard.sections.application-list', ['apps' => $activeApplication, 'title' => ''])
                            </div>
                            <!----------------------/new tab-------------------->

                            <!----------------------/currentlytab-------------------->
                            <div class="tab-pane fade active show" id="currently" role="tabpanel" aria-labelledby="currently-tab">
                                @include('dashboard.sections.application-list', ['apps' => $openApplications, 'title' => ''])
                            </div>
                            <!----------------------/currently tab-------------------->

                            <!----------------------won tab----------------------->
                            <div class="tab-pane fade" id="won" role="tabpanel" aria-labelledby="won-tab">
                                @include('dashboard.sections.application-list', ['apps' => $wonApplications, 'title' => ''])
                            </div>
                            <!----------------------/won tab----------------------->

                            <!----------------------won tab----------------------->
                            <div class="tab-pane fade" id="lost" role="tabpanel" aria-labelledby="lost-tab">
                                @include('dashboard.sections.application-list', ['apps' => $lostApplications, 'title' => ''])
                            </div>
                            <!----------------------/won tab----------------------->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
