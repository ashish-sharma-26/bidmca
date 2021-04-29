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
                            <h5 class="mb-1">Profile Details</h5>
                        </div>
                    </div>


                    <div class="profile-tabs">
                        <div class="tab-content" id="myTabContent">
                            <!----------------------first profile tab-------------------->
                            <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <div class="datainput aos-init aos-animate" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                                <input class="validate" disabled="disabled" id="wa_fname" name="fname" required="" type="text" value="{{auth()->user()->last_name}}" placeholder="Frignani">
                                                <span class="bar"></span>
                                                <label>Last Name</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="datainput aos-init aos-animate" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                                <input class="validate" disabled="disabled" id="wa_fname" name="fname" required="" type="text" value="{{auth()->user()->first_name}}" placeholder="Davide">
                                                <span class="bar"></span>
                                                <label>First Name</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="datainput aos-init" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                                <input class="validate" disabled="disabled" id="email" name="fname" required="" type="email" value="{{auth()->user()->email}}" placeholder="davide@gmail.com">
                                                <span class="bar"></span>
                                                <label>Email</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="datainput aos-init" data-aos="fade-right" data-aos-duration="500" data-aos-easing="linear">
                                                <input class="validate" disabled="disabled" id="cell" name="fname" required="" type="tel" value="{{auth()->user()->phone}}" placeholder="987-654-34">
                                                <span class="bar"></span>
                                                <label>Cell#</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!----------------------/first profile tab-------------------->
                        </div>
                    </div>


                </div>

            </div>

            <!--------------------------/business details--------------------------->
        </div>
    </div>
@endsection
