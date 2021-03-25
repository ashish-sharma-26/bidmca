@extends('layouts.dashboard')

@section('content')
    <div id="page-content" class="content">
        <div id="main-content">
            <!--------------------------business details--------------------------->
            <div class="card2 first-screen show">
                <div class="confirmation-details" data-aos="fade-right" data-aos-duration="500"
                     data-aos-easing="linear">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="signup-social-details">
                                <p>Step 1 of 5</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 signin-col">
                            <div class="signup-social-details">
                                <p>Lost or have trouble? <a href="#">Get Help <span
                                            class="las la-long-arrow-alt-right icons"></span></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="authorized-info">
                                    <h5>Business Details</h5>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 draft">
{{--                                <div class="signup-social-details">--}}
{{--                                    <a href="javascript:void(0)" onclick="storeApplication('draft')">Save to draft <span--}}
{{--                                            class="las la-long-arrow-alt-right icons"></span></a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="business-title form-title">
                                    <p>Welcome to the BIDMCA Portal, we are glad to see you! Let’s get started by
                                        entering some business details</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-form">
                        <div class="form-bg">
                            <form>
                                <input type="hidden" name="unique_id" id="unique_id">
                                <input type="hidden" name="step" id="step">
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <div class="datainput">
                                            <input class="validate" id="business_name" name="business_name" required=""
                                                   type="text" value=''
                                                   placeholder="Business Name"/>
                                            <span class="bar"></span>
                                            <label>Business Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <div class="datainput">
                                            <input class="validate" id="industry_type" name="industry_type" required=""
                                                   type="text" value=''
                                                   placeholder="Industry Type (SIC Code or Description)"/>
                                            <span class="bar"></span>
                                            <label>Industry Type (SIC Code or Description)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput select">
                                            <select class="select-text" required name="state_incorporation_id"
                                                    id="state_incorporation_id">
                                                <option value="">Please select</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="select-bar"></span>
                                            <label class="">State of Incorporation</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="fed_tax_id" name="fed_tax_id" required=""
                                                   type="number" value='' placeholder="FED Tax ID#"/>
                                            <span class="bar"></span>
                                            <label>Fed Tax ID #</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-5 relation-details custom-check step-check m-0 pb-3 pt-3">
                                        <ul class="list-group-horizontal aos-init">
                                            <li class="mr-0">
                                                <input type="checkbox" id="is_business_operating"
                                                       name="is_business_operating" value="1">
                                                <label for="is_business_operating">Is this business operating?</label>
                                                <div class="check"></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="loan_amount" name="loan_amount" required=""
                                                   type="tel" value="{{ Request::get('loan_amount') }}" placeholder="Loan Amount"/>
                                            <span class="bar"></span>
                                            <label>Loan Amount in $</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput select">
                                            <select class="select-text" required id="due_status" name="due_status" onchange="changeDueStatus(this.value)">
                                                <!--<option value="" disabled selected></option>-->
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <!--<span class="select-highlight"></span>-->
                                            <span class="select-bar"></span>
                                            <label class="">Does Business have current dues?</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 due-wrap d-none">
                                        <div class="datainput">
                                            <input class="validate" id="due_amount" name="due_amount" required=""
                                                   type="tel" value='' placeholder="Due Amount"/>
                                            <span class="bar"></span>
                                            <label>Due Amount in $</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row due-wrap d-none">
                                    <div class="form-group col-md-10">
                                        <div class="datainput">
                                            <input class="validate" id="lender_names" name="lender_names" required=""
                                                   type="text" value='' placeholder="Lender(s) Name(s)"/>
                                            <span class="bar"></span>
                                            <label>Lender(s) Name(s) //If multiple, please insert with a ,</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row due-wrap d-none">
                                    <div class="form-group col-md-5">
                                        <div class="datainput select">
                                            <select class="select-text" required id="due_contract" name="due_contract" onchange="checkContract(this.value)">
                                                <!--<option value="" disabled selected></option>-->
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <!--<span class="select-highlight"></span>-->
                                            <span class="select-bar"></span>
                                            <label class="">Do you’ve any contract?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="contractFile">
                                    <div class="col-12 col-md-12 col-lg-4 col-xl-11">
                                        <input type="hidden" id="contract_file">
                                        <div class="signature-details upload-file mt-0" id="contract_file-wrap">
                                            <div class=" uplaoad-doc">
                                                <div class="form-group">
                                                    <div class="file-upload-wrapper" data-text="Drag &amp; drop your contract file here or click to upload it from a computer">
                                                        <input type="file" class="file-upload-field" name="contract_file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" uplaoad-doc" id="contract_file-a-wrap" style="display: none;">
                                            <div class="form-group">
                                                <a href="" id="contract_file-a" target="_blank">
                                                    <div class="file-upload-wrapper"
                                                         data-text="View uploaded file">
                                                    </div>
                                                </a>
                                                <a href="javascript:void (0)" onclick="resetUpload('contract_file')">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="previous-page">
                    <div class="signup-social-details back-title">
                        <a href="{{url('/dashboard')}}"><span
                                class="las la-long-arrow-alt-left icons"></span> Back to the dashboard</a>
                    </div>
                </div>
                <div class="nxt-details">
                    <button class="btn next-button"  id="step1" onclick="storeApplication('step1')">Next step <span class="las la-long-arrow-alt-right icons"></span>
                    </button>
                </div>

            </div>

            <!--------------------------/business details--------------------------->

            <!--------------------------Address details--------------------------->
            <div class="card2">
                <div class="confirmation-details" data-aos="fade-right" data-aos-duration="500"
                     data-aos-easing="linear">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="signup-social-details">
                                <p>Step 2 of 5</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 signin-col">
                            <div class="signup-social-details">
                                <p>Lost or have trouble? <a href="#">Get Help <span
                                            class="las la-long-arrow-alt-right icons"></span></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="authorized-info">
                                    <h5>Business address details</h5>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 draft">
{{--                                <div class="signup-social-details">--}}
{{--                                    <a href="javascript:void(0)" onclick="storeApplication('draft')">Save to draft <span--}}
{{--                                            class="las la-long-arrow-alt-right icons"></span></a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="business-title form-title">
                                    <p>Welcome to the BIDMCA Portal, we are glad to see you! Let’s get started by
                                        entering some business details</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-form">
                        <div class="form-bg">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <div class="datainput">
                                            <input class="validate" id="billing_street_address" name="billing_street_address" required=""
                                                   type="text"
                                                   placeholder="Physical Street Address"/>
                                            <span class="bar"></span>
                                            <label>Physical Street Address</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput select">
                                            <select class="select-text" id="billing_state_id" name="billing_state_id" required onchange="stateChange(this.value)">
                                                    <option value="">Please select</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                    @endforeach
                                            </select>
                                            <!--<span class="select-highlight"></span>-->
                                            <span class="select-bar"></span>
                                            <label class="">State</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput select">
                                            <select class="select-text" id="billing_city_id" name="billing_city_id" required>
                                                <option value="">Please select state</option>
                                            </select>
                                            <!--<span class="select-highlight"></span>-->
                                            <span class="select-bar"></span>
                                            <label class="">City</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="billing_zipcode" name="billing_zipcode" required="" type="number"
                                                   value='' placeholder="Zipcode"/>
                                            <span class="bar"></span>
                                            <label>Zipcode</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="billing_phone" name="billing_phone" required=""
                                                   placeholder="Phone Number"/>
                                            <span class="bar"></span>
                                            <label>Phone Number</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput select">
                                            <select class="select-text" id="mode" name="mode" onchange="checkMode(this.value)" required>
                                                <!--<option value="" disabled selected></option>-->
                                                <option value="Owned">Owned</option>
                                                <option value="Rented">Rented</option>
                                            </select>
                                            <!--<span class="select-highlight"></span>-->
                                            <span class="select-bar"></span>
                                            <label class="">Mode</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 d-none" id="modeAmount">
                                        <div class="datainput">
                                            <input class="validate" id="amount_per_year" name="amount_per_year" required=""
                                                   placeholder="Amount in $ per year"/>
                                            <span class="bar"></span>
                                            <label>Amount in $ per year</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="relation-details custom-check step-check">
                                    <ul class="list-group-horizontal aos-init">
                                        <li>
                                            <input type="checkbox" id="check-option" name="selector1">
                                            <label for="check-option">Billing details same as physical address
                                                details</label>
                                            <div class="check"></div>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="previous-page">
                    <div class="signup-social-details back-title">
                        <a href="{{url('/dashboard')}}"><span
                                class="las la-long-arrow-alt-left icons"></span> Back to the dashboard</a>
                    </div>
                </div>
                <div class="nxt-details">
                    <button class="btn next-button" id="step2" onclick="storeApplication('step2')">Next step <span class="las la-long-arrow-alt-right icons"></span>
                    </button>
                </div>

            </div>
            <!-----------------------------/Address details------------------------>

            <!-----------------------------Owner details------------------------>
            <div class="card2">
                <div class="confirmation-details" data-aos="fade-right" data-aos-duration="500"
                     data-aos-easing="linear">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="signup-social-details">
                                <p>Step 3 of 5</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 signin-col">
                            <div class="signup-social-details">
                                <p>Lost or have trouble? <a href="#">Get Help <span
                                            class="las la-long-arrow-alt-right icons"></span></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="authorized-info">
                                    <h5>Owner details</h5>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 draft">
                                <div class="signup-social-details">
                                    <a href="javascript:void(0)" onclick="storeApplication('draft')">Save to draft <span
                                            class="las la-long-arrow-alt-right icons"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="business-title form-title">
                                    <p>Welcome to the BIDMCA Portal, we are glad to see you! Let’s get started by
                                        entering some business details</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-form">
                        <div class="form-bg">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <div class="datainput">
                                            <input class="validate" id="owner" name="owner" required="" type="text"
                                                   value='' placeholder="Owner/Officer"/>
                                            <span class="bar"></span>
                                            <label>Owner/Officer</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="ownership_percent" name="ownership_percent" required=""
                                                   type="number" max="3" value='' placeholder="Ownership %"/>
                                            <span class="bar"></span>
                                            <label>Ownership %</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="title" name="title" required="" type="text"
                                                   value='' placeholder="Title"/>
                                            <span class="bar"></span>
                                            <label>Title</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="last_name" name="last_name" required=""
                                                   type="text" value='' placeholder="Legal Last Name"/>
                                            <span class="bar"></span>
                                            <label>Legal Last Name</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="first_name" name="first_name" required=""
                                                   type="text" value='' placeholder="Legal First Name"/>
                                            <span class="bar"></span>
                                            <label>Legal First Name</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="dob" name="dob" required=""
                                                   value='' placeholder="Date of Birth"/>
                                            <span class="bar"></span>
                                            <label>Date of Birth</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="ssn" name="ssn" required="" type="number"
                                                   value='' placeholder="SSN#"/>
                                            <span class="bar"></span>
                                            <label>SSN#</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="email" name="email" required="" type="email"
                                                   value='' placeholder="Email"/>
                                            <span class="bar"></span>
                                            <label>Email</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="datainput">
                                            <input class="validate" id="phone" name="phone" required="" type="text"
                                                   value='' placeholder="Cell#"/>
                                            <span class="bar"></span>
                                            <label>Cell#</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="previous-page">
                    <div class="signup-social-details back-title">
                        <a href="{{url('/dashboard')}}"><span
                                class="las la-long-arrow-alt-left icons"></span> Back to the dashboard</a>
                    </div>
                </div>

                <div class="nxt-details">
                    <button class="btn next-button"  id="step3" onclick="storeApplication('step3')">Next <span class="las la-long-arrow-alt-right icons"></span>
                    </button>
                </div>

            </div>

            <!-----------------------------/Owner details------------------------>

            <!----------------------------banking authorization------------>
            <div class="card2">
                <div class="confirmation-details" data-aos="fade-right" data-aos-duration="500"
                     data-aos-easing="linear">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="signup-social-details">
                                <p>Step 4 of 5</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 signin-col">
                            <div class="signup-social-details">
                                <p>Lost or have trouble? <a href="#">Get Help <span
                                            class="las la-long-arrow-alt-right icons"></span></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="authorized-info">
                                    <h5>Banking Authorization</h5>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 draft">
                                <div class="signup-social-details">
                                    <a href="javascript:void(0)" onclick="storeApplication('draft')">Save to draft <span
                                            class="las la-long-arrow-alt-right icons"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="business-title form-title">
                            <p>BIDMCA Portal, in partnership with plaid will access your bank transactions to
                                authenticate your banking folio. Please fill in below details for the same:</p>
                        </div>

                    </div>

                    <div class="step-form">
                        <div class="form-bg">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                        <div class="datainput select">
                                            <select class="select-text" id="bank" name="bank" required>
                                                <!--<option value="" disabled selected></option>-->
                                                <option value="Chase Bank">Chase Bank</option>
                                                <option value="Bank of America">Bank of America</option>
                                                <option value="Wells Fargo">Wells Fargo</option>
                                            </select>
                                            <!--<span class="select-highlight"></span>-->
                                            <span class="select-bar"></span>
                                            <label class="">Your banking partners are</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                        <div class="datainput mt-0">
                                            <input class="validate" id="account_number" name="account_number" required=""
                                                   type="number" value='' placeholder="Your bank account number"/>
                                            <span class="bar"></span>
                                            <label>Your bank account number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="relation-details custom-check step-check">
                                    <ul class="list-group-horizontal">
                                        <li>
                                            <input type="checkbox" id="authCheck" name="authCheck">
                                            <label for="authCheck">I am authorized to sign on the behalf of
                                                entity.</label>
                                            <div class="check"></div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="row step-button">
                                    <div class="col-xl-3">
                                        <button class="btn btn-getauto" disabled="true" id="authBtn">Authorize <span
                                                class="las la-long-arrow-alt-right icons"></span></button>
                                    </div>
                                    <div class="col-xl-12">
                                        <p class="step-note">Note: After authorising first account you will be able to
                                            add another account.</p>
                                    </div>
                                    <div class="form-group col-xl-12" id="authEmailWrap">
                                        <div class="datainput">
                                            <input class="validate" id="account_email" name="account_email" required="" type="email"
                                                   value='' placeholder="Email"/>
                                            <span class="bar"></span>
                                            <label>Email</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="previous-page">
                    <div class="signup-social-details back-title">
                        <a href="{{url('/dashboard')}}"><span
                                class="las la-long-arrow-alt-left icons"></span> Back to the dashboard</a>
                    </div>
                </div>

                <div class="nxt-details">
                    <button class="btn next-button" id="step4" onclick="storeApplication('step4')">Next step <span class="las la-long-arrow-alt-right icons"></span>
                    </button>
                </div>

            </div>
            <!---------------------------/banking authorization-------------------------->

            <!----------------------------confirmation------------>
            <div class="card2">
                <div class="confirmation-details" data-aos="fade-right" data-aos-duration="500"
                     data-aos-easing="linear">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="signup-social-details">
                                <p>Step 5 of 5</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9 col-xl-9 signin-col">
                            <div class="signup-social-details">
                                <p>Lost or have trouble? <a href="#">Get Help <span
                                            class="las la-long-arrow-alt-right icons"></span></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="banking-details">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                <div class="authorized-info">
                                    <h5>Confirmations</h5>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 draft">
                                <div class="signup-social-details">
                                    <a href="javascript:void(0)" onclick="storeApplication('draft')">Save to draft <span
                                            class="las la-long-arrow-alt-right icons"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="business-title form-title">
                            <p>Authorizations: By signing below, each of the above listed business and business
                                owner/officers (individually and collectively, “you”) authorize “Bridge Bay Capital” and
                                each of its representatives, <a href="#">read more</a></p>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-8 col-xl-7">
                            <div class="status-details">
                                <h6 id="business_name_t"></h6>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i><span id="business_city"></span>, <span id="business_state"></span></p>
                                <p><span id="business_desc"></span></p>
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="loan-details details1">
                                            <h6>$<span id="business_load_amount"></span></h6>
                                            <p>Loan Asked</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="loan-details">
                                            <h6>$<span id="business_due_amount"></span></h6>
                                            <p>Current Debt.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="loan-details">
                                            <h6><span id="business_status"></span></h6>
                                            <p>Status</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="signature_file">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-5">
                            <div class="signature-details">
                                <h6>Signature</h6>

                                <div class=" uplaoad-doc" id="signature_file-wrap">
                                    <div class="form-group">
                                        <div class="file-upload-wrapper"
                                             data-text="Drag & drop your signature files here or click to upload it from a computer">
                                            <input name="signature_file" type="file" class="file-upload-field"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                                <div class=" uplaoad-doc" id="signature_file-a-wrap" style="display: none;">
                                    <div class="form-group">
                                        <a href="" id="signature_file-a" target="_blank">
                                        <div class="file-upload-wrapper"
                                             data-text="View uploaded file">
                                        </div>
                                        </a>
                                        <a href="javascript:void (0)" onclick="resetUpload('signature_file')">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="previous-page">

                    <div class="signup-social-details back-title">
                        <a href="{{url('/dashboard')}}"><span
                                class="las la-long-arrow-alt-left icons"></span> Back to the dashboard</a>
                    </div>
                </div>
                <div class="nxt-details step-button">
                    <button class="btn btn-getauto" onclick="storeApplication('step5')">Submit My Application
                    </button>
                </div>


            </div>
            <!---------------------------/confirmation-------------------------->

        </div>
    </div>
@endsection
