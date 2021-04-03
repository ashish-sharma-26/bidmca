@extends('layouts.dashboard')

@section('content')
    <div class="col-md-12 col-md-12 col-lg-10 col-xl-9 mx-auto">
        <div class="form-bg" data-aos="zoom-in" data-aos-duration="1000">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-10 col-xl-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="fas fa-angle-left"></i> <a
                                    href="{{url('/dashboard')}}">All
                                    applications</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ID {{$application->id}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-2 col-md-2 col-lg-2 col-xl-2 back-title">
                    <a href="{{url('/dashboard')}}"> &lt; Back </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-8 col-xl-8">


                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-8 col-xl-12">
                            <div class="status-details mt-0">
                                <h6>{{$application->business_name}}</h6>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$application->city->city_name}}
                                    , {{' '.$application->state->state_name}}</p>
                                <p>{{$application->industry_type}}</p>
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="loan-details">
                                            <h6>${{$application->loan_amount}}</h6>
                                            <p>Loan Asked</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="loan-details">
                                            <h6>${{$application->due_amount ? $application->due_amount : 0 }}</h6>
                                            <p>Current Debt.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="loan-details">
                                            <h6>{{$application->is_business_operating ? 'Operating' : 'Closed'}}</h6>
                                            <p>Status</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-section" aria-label="Question Accordions">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <!--panel1-->
                            <div class="status-details panel panel-default">
                                <div class="panel-heading" role="tab" id="heading1">
                                    <h3 class="panel-title mb-0">
                                        <a class="collapsed" role="button" title="" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapse1" aria-expanded="false"
                                           aria-controls="collapse1">
                                            Business details
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading1" style="">
                                    <div class="panel-body content">
                                        <div class="loan-details loan-business">
                                            <div class="row">
                                                <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                    <p>State of Incorporation</p>
                                                </div>
                                                <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                    <h6>{{$application->stateOfIncorporation->state_name}}</h6>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                    <p>Fed Tax Id</p>
                                                </div>
                                                <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                    <h6>{{$application->fed_tax_id}}</h6>
                                                </div>
                                            </div>

                                            @if($application->lender_names)
                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Lender Name(s)</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$application->lender_names}}</h6>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($application->due_contract)
                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Due Contract</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$application->due_contract ? 'Yes' : 'No'}}</h6>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($application->contract_file)
                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Contract File</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6><a href="{{$application->contract_file}}">View File</a></h6>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/panel1-->


                            <!--panel2-->
                            <div class="status-details panel panel-default">
                                <div class="panel-heading" role="tab" id="heading2">
                                    <h3 class="panel-title  mb-0">
                                        <a class="collapsed" role="button" title="" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapse2" aria-expanded="false"
                                           aria-controls="collapse2">
                                            Banking Folio
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading2">
                                    <div class="panel-body content">
                                        @if(count($application->bankAccount))
                                            @foreach($application->bankAccount AS $bank)
                                                <div class="loan-details loan-business">
                                                    <div class="row">
                                                        <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                            <p>Your banking partner</p>
                                                        </div>
                                                        <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                            <h6>{{$bank->bank}}</h6>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                            <p>Your banking account number</p>
                                                        </div>
                                                        <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                            <h6>{{$bank->account_number}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--/panel2-->

                            <!--panel2-->
                            <div class="status-details panel panel-default">
                                <div class="panel-heading" role="tab" id="heading3">
                                    <h3 class="panel-title  mb-0">
                                        <a class="collapsed" role="button" title="" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapse3" aria-expanded="false"
                                           aria-controls="collapse3">
                                            Confirmation
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading3">
                                    <div class="panel-body content">
                                        <p>lorem ipusum</p>
                                    </div>
                                </div>
                            </div>
                            <!--/panel2-->

                            <!--panel3-->
                            <div class="status-details panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4">
                                    <h3 class="panel-title  mb-0">
                                        <a class="collapsed" role="button" title="" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapse4" aria-expanded="false"
                                           aria-controls="collapse4">
                                            Owner details
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading4">
                                    <div class="panel-body content">
                                        @foreach($application->owner AS $owner)
                                            <div class="loan-details loan-business">
                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Owner</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->owner}}</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Ownership %</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->ownership_percent}}%</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Designation</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->title}}</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Legal last name</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->last_name}}</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Legal first name</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->first_name}}</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>Date of birth</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->dob}}</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-7 col-md-7 col-lg-7 col-xl-7">
                                                        <p>SSN</p>
                                                    </div>
                                                    <div class="col-7 col-md-5 col-lg-5 col-xl-5">
                                                        <h6>{{$owner->ssn}}</h6>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--/panel3-->
                        </div>
                    </div>


                </div>
                @if(auth()->user()->user_type === 2)
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="closes-details">
                            <div class="business-title current-details">
                                <p>Proposal closes on</p>
                                <h6>{{date('F d, Y', strtotime($application->created_at))}}</h6>
                            </div>
                            <div class="business-title current-details">
                                <p>Current Bid Status:</p>
                                <div class="kicked-bg"><p>Placed</p></div>
                            </div>
                        </div>

                        <div class="bidding-details">
                                <input type="hidden" name="application_id" id="application_id"
                                       value="{{$application->id}}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">IR:</label>
                                        <input type="number" min="0"
                                               class="form-control"
                                               id="interest_rate"
                                               name="interest_rate"
                                               placeholder="IR"
                                               value="{{$application->bid ? $application->bid->interest_rate : ''}}"
                                        >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Timeframe:</label>
                                        <input type="number"
                                               class="form-control"
                                               min="1"
                                               id="timeframe"
                                               name="timeframe"
                                               placeholder="Timeframe"
                                               value="{{$application->bid ? $application->bid->duration : ''}}"
                                        >
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="inputPassword4">Your current bid amount:</label>
                                        <input type="text"
                                               class="form-control"
                                               id="bidAmount"
                                               name="bid_amount"
                                               placeholder="Bid Amount"
                                               value="{{$application->bid ? $application->bid->amount : ''}}"
                                        >
                                    </div>

                                    <div>

                                    </div>
                                </div>

                                @if($application->bid)
                                    <div class="profile-button">
                                        <div>
                                            <button class="btn btn1 btn-save mt-3 ml-0 w-100" onclick="placeBidAction()"
                                                    id="placeBid">Update your bid
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="profile-button step-button">
                                        <div>
                                            <button type="button" onclick="placeBidAction()" id="placeBid"
                                                    class="btn btn-getauto mt-3 ml-0 w-100">Submit My Application
                                            </button>
                                        </div>
                                    </div>
                                @endif
                        </div>
                    </div>
                @endif
                @if(auth()->user()->user_type !== 2)
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="closes-details">
                            <div class="business-title current-details">
                                <p>Applied on</p>
                                <h6>{{date('F d, Y', strtotime($application->created_at))}}</h6>
                            </div>
                            <div class="business-title current-details">
                                <p>Current Status</p>
                                <h6 class="required">Open</h6>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>


    </div>
@endsection
