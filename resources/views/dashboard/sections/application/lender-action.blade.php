<div class="col-12 col-md-5 col-lg-4 col-xl-5">
    @if($application->status != '<label class="badge badge-info">Closed</label>')
    <div class="business-title current-details">
        <p>Proposal closes on</p>
        <h6 class="mb-0">{{date('F d, Y h:i a', strtotime($application->closing_date))}}</h6>
    </div>
    @endif
    @if($application->bid)
        <div class="business-title current-details">
            @if($application->bid->status == 1)
                <p>Your Bid Status :<label class="badge badge-success">Winning</label></p>
            @endif
                @if($application->bid->status == 2)
                    <p>Your Bid Status :<label class="badge badge-danger">Kicked</label></p>
                @endif
            <h6 class="required4"><span>${{$application->bid->amount}} <span class="text-black-50">|</span> F {{$application->bid->interest_rate}} <span class="text-black-50">|</span> </span> <span>M {{$application->bid->duration}}</span>
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
