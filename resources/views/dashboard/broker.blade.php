@extends('layouts.dashboard')

@section('content')
<div  id="page-content">
    <div id="main-content">
        <!--------------------------business details--------------------------->
        <div class="card2 first-screen show">
            <div class="brokder-details confirmation-details">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                    </div>
                    <div class="col-12 col-md-9 col-lg-9 col-xl-9 offset-md-3 offset-xl-3 offset-xl-3 signin-col">
                        <div class="signup-social-details">
                            <a href="{{route('logout')}}">Logout <span class="las la-long-arrow-alt-right icons"></span></a>
                        </div>
                    </div>
                </div>
                <div class="banking-details">
                    <div class="authorized-info">
                        <h5 class="mb-1">Welcome, {{\Illuminate\Support\Facades\Auth::user()->first_name}}!</h5>
                    </div>
                    <div class="business-title form-title">
                        <p>Last login, February 10, 21</p>
                    </div>
                </div>

                <div class="notice-details">
                    <h6>Notice</h6>
                    <p>February 10, 2020 - Your current application is pending for corrections, please check application status messages to look for corrections/reasons.</p>
                </div>


                <div class="loan-application">
                    <h5>Recent Loan Application</h5>
                    @foreach($applications AS $application)

                        <div class="row">
                            <div class="col-12 col-md-7 col-lg-8 col-xl-7">
                                <div class="status-details mt-0">
                                    <h6>{{$application->business_name}}</h6>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$application->city->city_name}}, {{' '.$application->state->state_name}}</p>
                                    <p>{{$application->business_name}}</p>
                                    <div class="row">
                                        <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                                            <div class="loan-details details1">
                                                <h6>${{$application->loan_amount}}</h6>
                                                <p>Loan Asked</p>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                                            <div class="loan-details">
                                                <h6>${{$application->due_amount ? $application->due_amount : 0 }}</h6>
                                                <p>Current Debt.</p>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                                            <div class="loan-details">
                                                <h6>Status</h6>
                                                <p>{{$application->is_business_operating ? 'Operating' : 'Closed'}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-5 col-lg-4 col-xl-5">
                                <div class="business-title current-details">
                                    <p>Applied on</p>
                                    <h6>{{date('F d, Y', strtotime($application->created_at))}}</h6>
                                </div>
                                <div class="business-title current-details">
                                    <p>Current Status</p>
                                    <h6 class="required">Pending</h6>
                                </div>
                                <div class="nxt-details view-button">
                                    <button class="btn ">View <span class="las la-long-arrow-alt-right icons"></span> </button>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>




            </div>

        </div>

        <!--------------------------/business details--------------------------->
    </div>
</div>
@endsection
