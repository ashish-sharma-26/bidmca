<div class="col-12 col-md-5 col-lg-4 col-xl-5">
    <div class="business-title current-details">
        <p>Applied on</p>
        <h6>{{date('m/d/Y', strtotime($application->created_at))}}</h6>
    </div>
    <div class="business-title current-details">
        <p>Current Status</p>
        @if($application->plaid_access_token)
            @if($application->getStatusIdAttribute() == 'Rejected')
                <h6 class="required">{{$application->getStatusIdAttribute()}}</h6>
                <p class="text-danger">{{$application->reject_reason}}</p>
            @endif
            @if($application->getStatusIdAttribute() == 'Approved')
                <h6 class="required3">Inviting proposals</h6>
            @endif
            @if($application->getStatusIdAttribute() == 'Pending Review')
                <h6 class="required1">Pending Review</h6>
            @endif
            @if($application->getStatusIdAttribute() == 'Draft')
                <h6 class="text-primary">Draft</h6>
            @endif
            @if($application->getStatusIdAttribute() == 'Closed')
                <h6 class="text-success">
                    Loan Finalised</h6>
                <div class="loan-secured">
                    <p>Congratulations! your loan amount is secured from lenders our consultants will get in touch
                        shortly!</p>
                </div>
            @endif
        @else
            <h6 class="required1">Pending Bank Verification</h6>
        @endif
    </div>
    <div class="nxt-details view-button">
        <a href="{{url('/')}}/application/{{$application->unique_id}}">
            <button class="btn ">View <span class="las la-long-arrow-alt-right icons"></span></button>
        </a>
    </div>
</div>
