@extends('layouts.app')

@section('content')
<div class="view-height">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                <div class="form-bg login-form" data-aos="zoom-in" data-aos-duration="1000">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="process-details text-center">
                                    <h5>Login</h5>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 datainput-col">
                                <div class="datainput">
                                    <input id="email" type="email" class="validate @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <span class="bar"></span>
                                    <label>Email ID</label>
                                </div>
                            </div>
                            <div class="form-group col-md-12 datainput-col">
                                <div class="datainput">
                                    <input id="password" type="password" class="validate @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror                                                            <span class="bar"></span>
                                    <label>Password</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="relation-details custom-check">
                                    <ul class="list-group-horizontal">
                                        <li>
                                            <input type="checkbox" id="check-option" name="selector1">
                                            <label for="check-option">Remember Me</label>

                                            <div class="check"></div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 forget-details">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>

                        <div class="submit-button text-center my-4">
                            <button class="btn">Login</button>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="signup-social-details text-center">
                                    <p>New User? <a href="{{url('/register?ref=borrower')}}">Create an Account</a></p>
                                </div>

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
