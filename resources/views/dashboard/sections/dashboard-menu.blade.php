<div class="card1 position-sidebar">
    <ul id="progressbar" class="text-center" data-aos="fade-right" data-aos-duration="500">
        <li class="active step0"></li>
        <li class="step0"></li>
        <li class="step0"></li>
        <li class="step0"></li>
        <li class="step0"></li>
    </ul>
    <a href="{{url('/dashboard')}}">
        <h6 class="details1 active"
            data-aos="fade-right"
            data-aos-duration="500">Dashboard</h6>
    </a>
    <a href="#">
        <h6 class="details2"
            data-aos="fade-right"
            data-aos-duration="600"
            data-aos-easing="linear">Profile
            Details</h6></a>
    @if(auth()->user()->user_type != 2)
        <a href="{{route('application')}}">
            <h6 class="details3"
                data-aos="fade-right"
                data-aos-duration="700"
                data-aos-easing="linear">
                Loan Applications</h6>
        </a>
    @endif
    @if(auth()->user()->user_type == 2)
        <a href="#">
            <h6 class="details3"
                data-aos="fade-right"
                data-aos-duration="700"
                data-aos-easing="linear">
                Loan Applications</h6>
        </a>
    @endif


    <a href="#"><h6 class="details4"
                    data-aos="fade-right"
                    data-aos-duration="800"
                    data-aos-easing="linear">
            Settings</h6></a>

    <a href="#"><h6 class="details4"
                    data-aos="fade-right"
                    data-aos-duration="800"
                    data-aos-easing="linear">Contact
            Support</h6></a>
</div>
