<div class="col-12 col-md-5 col-lg-4 col-xl-5">
    <div class="business-title current-details">
        <p>Applied on</p>
        <h6>{{date('F d, Y', strtotime($application->created_at))}}</h6>
    </div>
    <div class="business-title current-details">
        <p>Current Status</p>
        <h6 class="required">Open</h6>
    </div>
    <div class="nxt-details view-button">
        <a href="{{url('/')}}/application/{{$application->unique_id}}">
            <button class="btn ">View <span class="las la-long-arrow-alt-right icons"></span></button>
        </a>
    </div>
</div>
