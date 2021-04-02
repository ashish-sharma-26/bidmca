<div class="row">
    <div class="col-12 col-md-7 col-lg-8 col-xl-7">
        <div class="status-details mt-0">
            <h6>{{$application->business_name}}</h6>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$application->city->city_name}}
                , {{' '.$application->state->state_name}}</p>
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
                        <h6>{{$application->is_business_operating ? 'Operating' : 'Closed'}}</h6>
                        <p>Status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->user_type === 1)
        @include('dashboard.sections.application.broker-action', ['application' => $application])
    @endif
    @if(auth()->user()->user_type === 2)
        @include('dashboard.sections.application.lender-action', ['application' => $application])
    @endif
</div>
