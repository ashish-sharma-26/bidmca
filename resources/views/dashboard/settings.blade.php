@extends('layouts.dashboard')

@section('content')
    <div id="page-content">
        <div id="main-content">
            <!--------------------------business details--------------------------->
            <div class="card2 first-screen show">
                <div class="brokder-details confirmation-details">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 offset-md-3 offset-xl-3 offset-xl-3 signin-col">
                            <div class="signup-social-details">
                                <a href="{{route('logout')}}">Logout <span class="las la-long-arrow-alt-right icons"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="authorized-info">
                            <h5 class="mb-1">Settings</h5>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{$errors->first()}}
                        </div>
                    @endif
                    @if(Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            Password updated successfully.
                        </div>
                    @endif
                    <form method="post" action="{{route('user_update_password')}}">
                        @csrf
                        <div class="password-details">
                            <span class="psd-title">Password Details</span>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="datainput aos-init aos-animate" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                        <input class="validate" id="password1" name="current_password" required type="password">
                                        <span class="bar"></span>
                                        <label>Enter Current password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="datainput aos-init" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                        <input class="validate" id="password2" name="new_password" required type="password">
                                        <span class="bar"></span>
                                        <label>Enter New Password</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="datainput aos-init" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                        <input class="validate" id="password3" name="confirm_password" required type="password">
                                        <span class="bar"></span>
                                        <label>Enter New Password Again</label>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-button profile-block">
                                <div>
                                    <button type="submit" class="btn btn1 btn-save ml-0">Change Password</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

            <!--------------------------/business details--------------------------->
        </div>
    </div>
@endsection
