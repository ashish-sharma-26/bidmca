@extends('layouts.app')

@section('content')
    <div class="view-height">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-6 col-lg-6 col-xl-7 mx-auto">
                    <div class="form-bg" data-aos="zoom-in" data-aos-duration="1000">
                        <form>
                            @csrf
                            <div class="row">
                                <div class="col-10 col-md-10 col-lg-10 col-xl-10">
                                    <div class="process-details">
                                        <h6>Hi,</h6>
                                        <p>Please fill in details to begin the registration process:</p>
                                    </div>
                                </div>
                                <div class="col-2 col-md-2 col-lg-2 col-xl-2 back-title">
                                    <a href="http://159.65.142.31/bidmca-design/works.html"> < Back </a>
                                </div>
                            </div>
                            <div class="relation-details">
                                <p>Your relationship with bidmca</p>
                                <ul class="list-group-horizontal">
                                    <li>
                                        <input type="radio" value="1" id="f-option" name="user_type">
                                        <label for="f-option">Broker</label>
                                        <div class="check"></div>
                                    </li>
                                    <li>
                                        <input type="radio" value="2" id="s-option" name="user_type">
                                        <label for="s-option">Lender</label>
                                        <div class="check">
                                            <div class="inside"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 datainput-col">
                                    <div class="datainput">
                                        <input class="validate" id="last_name" name="last_name" type="text"
                                               placeholder="Last Name" required=""/>
                                        <span class="bar"></span>
                                        <label>Last Name</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 datainput-col1">
                                    <div class="datainput">
                                        <input class="validate" id="first_name" name="first_name" required=""
                                               type="text" value='' placeholder="First Name"/>
                                        <span class="bar"></span>
                                        <label>First Name</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 datainput-col">
                                    <div class="datainput">
                                        <input class="validate" id="email" name="email" required="" type="email"
                                               value='' placeholder="example@example.com"/>
                                        <span class="bar"></span>
                                        <label>Email</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 datainput-col1">
                                    <div class="datainput">
                                        <input class="validate" id="phone" name="phone" required="" type="text"
                                               placeholder="987 654 34"/>
                                        <span class="bar"></span>
                                        <label>Call#</label>
                                    </div>
                                    <p class="note">Note: We will send a SMS with verification code.</p>
                                </div>
                                <div class="form-group col-md-6 datainput-col">
                                    <div class="datainput">
                                        <input class="validate" id="password" name="password" required="" type="password"
                                               value='' placeholder="*****"/>
                                        <span class="bar"></span>
                                        <label>Password</label>
                                    </div>
                                </div>
                            </div>

                            <div class="relation-details custom-check">
                                <ul class="list-group-horizontal">
                                    <li>
                                        <input type="checkbox" value="1" id="check-option" name="tnc">
                                        <label for="check-option">I agree to terms & conditions for data usage
                                            policy.</label>

                                        <div class="check"></div>
                                    </li>

                                </ul>
                            </div>

                            <div class="submit-button">
                                <button class="btn" type="button" onclick="sendOtp(this)" id="submitUser">Submit</button>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="signup-social-details">
                                        <p>Or SignUp with ----</p>
                                        <i class="lab la-facebook-f"></i>
                                        <i class="lab la-twitter"></i>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 col-lg-8 col-xl-8 signin-col">
                                    <div class="signup-social-details">
                                        <p>Having trouble signing in? <a href="#">Get Help</a></p>
                                    </div>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="otpModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Phone Verification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please enter OTP to complete the registration.</p>
                        <div class="form-group">
                            <div class="datainput">
                                <input name="otp" placeholder="XXXX" id="otp" class="form-control" type="tel" max="4">
                                <span class="bar"></span>
                                <label>OTP</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" onclick="verifyOtp(this)">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
