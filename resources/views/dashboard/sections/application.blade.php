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
        @if(auth()->user()->user_type === 1)
            <div class="nxt-details view-button">
                <button class="btn ">View <span class="las la-long-arrow-alt-right icons"></span></button>
            </div>
        @endif
        @if(auth()->user()->user_type === 2)
            <div class="nxt-details view-button">
                <button class="btn ">Participate <span class="las la-long-arrow-alt-right icons"></span></button>
            </div>
        @endif
    </div>
</div>
