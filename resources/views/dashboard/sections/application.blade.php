<div class="row cursor-pointer" onclick="javascript: window.location.href = '{{url('/application')}}/{{$application->unique_id}}'">
    <div class="col-12 col-md-7 col-lg-8 col-xl-7">
        <div class="status-details mt-0">
            <h6>{{$application->business_name}}</h6>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$application->billing_city_id}}
                , {{' '.$application->state->state_name}}</p>
            <p>{{$application->industry_type}}</p>
            <div class="row">
                <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="loan-details details1">
                        <h6>${{$application->loan_amount}}</h6>
                        <p>Loan Asked</p>
                    </div>
                </div>
                <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="loan-details">
                        <h6>{{$application->lender_names ? count(explode(',',$application->lender_names)).' @ ' : ''}} ${{$application->due_amount ? $application->due_amount : 0 }}</h6>
                        <p>Current Balance</p>
                    </div>
                </div>
                <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="loan-details">
                        <h6>{{$application->is_business_operating ? 'Operating' : 'Closed'}}</h6>
                        <p>Status</p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="loan-details">
                        <h6 id="avg_factor_{{$application->id}}">{{$application->avg_factor}}</h6>
                        <p>Average Factor(%)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="loan-details">
                        <h6 id="avg_term_{{$application->id}}">{{$application->avg_term}}</h6>
                        <p>Average Term(MO)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->user_type === 'Broker' || auth()->user()->user_type === 'Borrower')
        @include('dashboard.sections.application.broker-action', ['application' => $application])
    @endif
    @if(auth()->user()->user_type === 'Lender')
        @include('dashboard.sections.application.lender-action', ['application' => $application])
    @endif
</div>
