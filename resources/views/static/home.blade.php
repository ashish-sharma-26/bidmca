@extends('layouts.app')

@section('content')
    <div class="view-height">
        <div class="container">
            <!--------------section1---------------->
            <div class="funding-info">
                <div class="row funding-row">
                    <div class="col-12 col-md-7 col-lg-7 col-xl-8">
                        <div class="funding-details">
                            <p data-aos="fade-right" data-aos-easing="linear" data-aos-duration="500">Transparent pricing.
                                Quick decisions. Personal service.</p>
                            <h1 data-aos="fade-right" data-aos-easing="linear" data-aos-duration="500">The money you
                                need, when you need it.</h1>
                        </div>
                        <div class="funding-display">
                            <div class="fund-services">
                                <p data-aos="fade-right" data-aos-duration="1000"><i class="fa fa-check-circle"></i>
                                    Transparent Pricing</p>
                            </div>
                            <div class="fund-services">
                                <p data-aos="fade-right" data-aos-duration="1200"><i class="fa fa-check-circle"></i>
                                    Quick decisions</p>
                            </div>
                            <div class="fund-services">
                                <p data-aos="fade-left" data-aos-duration="1400"><i class="fa fa-check-circle"></i>
                                    Personal service.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5 col-xl-3 offset-xl-1 form-col">
                        <div class="loan-form">
                            <form action="{{url('/application')}}">
                                <div class="form-group" data-aos="fade-left" data-aos-easing="linear"
                                     data-aos-duration="500">
                                    <input class="form-control" name="loan_amount" id="loan_amount"
                                           placeholder="Enter the loan amount here">
                                </div>
                                <div data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500">
                                    <button class="btn btn-get">Get Started <span
                                            class="las la-long-arrow-alt-right icons"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--------------section1---------------->

                <!--------------section2---------------->
                <div class="row application-row">
                    <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="application-details" data-aos="zoom-in" data-aos-easing="linear"
                             data-aos-duration="500">
                            <h5>One</h5>
                            <h6>Application</h6>
                            <p>Answer just a few questions about your business to see which lending products you qualify
                                for.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="application-details" data-aos="zoom-in" data-aos-easing="linear"
                             data-aos-duration="600">
                            <h5>One</h5>
                            <h6>Application</h6>
                            <p>Answer just a few questions about your business to see which lending products you qualify
                                for.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="application-details" data-aos="zoom-in" data-aos-easing="linear"
                             data-aos-duration="700">
                            <h5>One</h5>
                            <h6>Application</h6>
                            <p>Answer just a few questions about your business to see which lending products you qualify
                                for.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="application-details" data-aos="zoom-in" data-aos-easing="linear"
                             data-aos-duration="800">
                            <h5>One</h5>
                            <h6>Application</h6>
                            <p>Answer just a few questions about your business to see which lending products you qualify
                                for.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------section2---------------->
        </div>
    </div>
@endsection
