@extends('layouts.dashboard')

@section('content')
<div  id="page-content" class="col-12 col-md-12 col-lg-8 col-xl-7 mx-auto">
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
                        <h5 class="mb-1">Welcome, {{ auth()->user()->first_name}}!</h5>
                    </div>
                    <div class="business-title form-title">
                        <p>Last login, {{date('m/d/Y', time())}}</p>
                    </div>
                </div>

                @if(auth()->user()->user_type === 'Broker' || auth()->user()->user_type === 'Borrower')
                    @include('dashboard.sections.broker-notice')
                    @include('dashboard.sections.application-list', ['apps' => $applications, 'title' => 'Recent Loan Application(s)'])
                @endif

                @if(auth()->user()->user_type === 'Lender')
                    @include('dashboard.sections.lender-statistics')
                    @include('dashboard.sections.application-list', ['apps' => $openApplications, 'title' => 'Trending Proposals on Bidmca'])
                @endif
            </div>

        </div>

        <!--------------------------/business details--------------------------->
    </div>
</div>
@endsection
