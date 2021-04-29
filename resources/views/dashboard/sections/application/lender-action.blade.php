<div class="col-12 col-md-5 col-lg-4 col-xl-5">
    @if($application->status != '<label class="badge badge-info">Closed</label>')
    <div class="business-title current-details">
        <p>Proposal closes on</p>
        <h6>{{date('F d, Y h:i a', strtotime($application->closing_date))}}</h6>
    </div>
    @endif
    @if($application->bid)
        <div class="business-title current-details">
            <p>Your Bid Status :<span class="required4"> ${{$application->bid->amount}}</span></p>
            <h6 class="required4"><span>{{$application->bid->interest_rate}} Factor</span> <span>{{$application->bid->duration}} Mo</span>
            </h6>
        </div>
    @endif
    @if($application->getStatusIdAttribute() != 'Closed')
        <div class="nxt-details view-button">
            <a href="{{url('/')}}/application/{{$application->unique_id}}">
                @if(!$application->bid)
                    <button class="btn ">Participate
                        <span class="las la-long-arrow-alt-right icons"></span>
                    </button>
                @endif
                @if($application->bid)
                    <button class="btn btn-red">
                        Update Bid <span class="las la-long-arrow-alt-right icons"></span>
                    </button>
                @endif
            </a>
        </div>
    @endif
</div>
