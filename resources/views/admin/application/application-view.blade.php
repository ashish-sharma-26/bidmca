@extends('admin.layout')
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                            </i>
                        </div>
                        <div> {{$application->business_name}} <br/>Status: {!! $application->status !!}
                        </div>
                    </div>
                    <div class="page-title-actions">
                        @if($application['status'] == '<label class="badge badge-warning">Pending for Approval</label>')
                            <a href="javascript:void(0)"
                               onclick="changeStatus('{{$application->id}}','3')"
                               class="btn btn-success btn-sm rounded-0"
                            >Approve</a>
                        @endif
                        @if($application['status'] == '<label class="badge badge-warning">Pending for Approval</label>')
                            <a href="javascript:void(0)"
                               onclick="changeStatus('{{$application->id}}','4')"
                               class="btn btn-danger btn-sm rounded-0"
                            > Reject </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 business-info">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="main-card mb-3 card">
                                        <div class="no-gutters row">
                                            <div class="col-md-12">
                                                <ul class="table-ul">
                                                    <h5 class="card-title w-100 mb-3">Application info</h5>
                                                    <li><span>Business Name</span><span
                                                            class="value">{{$application->business_name}}</span></li>
                                                    <li><span>Location</span><span class="value">{{$application->billing_city_id}}
                                    , {{' '.$application->state->state_name}}</span></li>
                                                    <li><span>Industry Type</span><span
                                                            class="value">{{$application->industry_type}}</span></li>
                                                    <li><span>Loan Amount</span><span
                                                            class="value">${{$application->loan_amount}}</span></li>
                                                    <li><span>Current Debt.</span><span
                                                            class="value">${{$application->due_amount ? $application->due_amount : 0 }}</span>
                                                    </li>
                                                    <li><span>Business Status</span><span
                                                            class="value">{{$application->is_business_operating ? 'Operating' : 'Closed'}}</span>
                                                    </li>
                                                    <li><span>State of Incorporation</span><span
                                                            class="value">{{$application->stateOfIncorporation->state_name}}</span>
                                                    </li>
                                                    <li><span>Fed Tax Id</span><span
                                                            class="value">{{$application->fed_tax_id}}</span></li>
                                                    @if($application->lender_names)
                                                        <li><span>Lender Name(s)</span><span
                                                                class="value">{{$application->lender_names}}</span></li>
                                                    @endif
                                                    @if($application->due_contract)
                                                        <li><span>Due Contract</span><span
                                                                class="value">{{$application->due_contract ? 'Yes' : 'No'}}</span>
                                                        </li>
                                                    @endif
                                                    @if($application->contract_file)
                                                        <li><span>Contract File</span><span class="value"><a
                                                                    href="{{$application->contract_file}}"
                                                                    target="_blank">View File</a></span></li>
                                                    @endif
                                                    <li><span>Billing Address</span><span
                                                            class="value">{{$application->billing_street_address}}</span>
                                                    </li>
                                                    <li><span>Billing City</span><span
                                                            class="value">{{$application->billing_city_id}}</span></li>
                                                    <li><span>Billing State</span><span
                                                            class="value">{{$application->state->state_name}}</span>
                                                    </li>
                                                    <li><span>Billing PostCode</span><span
                                                            class="value">{{$application->billing_zipcode}}</span></li>
                                                    <li><span>Billing Phone</span><span
                                                            class="value">{{$application->	billing_phone}}</span>
                                                    </li>
                                                    <li><span>Mode</span><span
                                                            class="value">{{$application->mode}}</span></li>
                                                    <li><span>Submitted On</span><span
                                                            class="value">{{$application->created_at}}</span></li>
                                                    <li><span>Last Updated</span><span
                                                            class="value">{{$application->updated_at}}</span></li>
                                                </ul>
                                            </div>
                                            @if(count($application->bankAccount))
                                                <div class="col-md-12">
                                                    <ul class="table-ul">
                                                        <h5 class="card-title w-100 mb-3">Banking Folio</h5>
                                                        @foreach($application->bankAccount AS $bank)
                                                            <li><span>Your banking partner</span><span
                                                                    class="value">{{$bank->bank}}</span></li>
                                                            <li><span>Your banking account number</span><span
                                                                    class="value">{{$bank->account_number}}</span></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            @if(count($application->owner))
                                                <div class="col-md-12">
                                                    <ul class="table-ul">
                                                        <h5 class="card-title w-100 mb-3">Owner(s)</h5>
                                                        @foreach($application->owner AS $owner)
                                                            <li><span>Owner</span><span
                                                                    class="value">{{$owner->owner}}</span></li>
                                                            <li><span>Ownership %</span><span
                                                                    class="value">{{$owner->ownership_percent}}</span>
                                                            </li>
                                                            <li><span>Designation</span><span
                                                                    class="value">{{$owner->title}}</span></li>
                                                            <li><span>Legal last name</span><span
                                                                    class="value">{{$owner->last_name}}</span></li>
                                                            <li><span>Legal first name</span><span
                                                                    class="value">{{$owner->first_name}}</span></li>
                                                            <li><span>Date of birth</span><span
                                                                    class="value">{{$owner->dob}}</span></li>
                                                            <li><span>SSN</span><span
                                                                    class="value">{{$owner->ssn}}</span></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <div class="main-card mb-3 card">
                                        <div class="no-gutters row">
                                            @if(count($bids) > 0)
                                                <div class="col-md-10">
                                                    <h3 class="w-100 mb-2 mt-2">Bid(s)</h3>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <button class="btn btn-primary mt-2 mr-2" onclick="javascript: location.reload()">Refresh</button>
                                                </div>
                                                <table class="table table-striped">
                                                    <thead>
                                                    <th>Bid By</th>
                                                    <th>Factor</th>
                                                    <th>Terms</th>
                                                    <th>Amount</th>
                                                    <th>Score</th>
                                                    <th>Status</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bids AS $bid)
                                                        <tr>
                                                            <td>{{$bid->user->first_name}} {{$bid->user->last_name}}</td>
                                                            <td>{{$bid->interest_rate}}</td>
                                                            <td>{{$bid->duration}}</td>
                                                            <td>${{$bid->amount}}</td>
                                                            <td>{{$bid->score}}</td>
                                                            <td>
                                                                @if($bid->status == 1)
                                                                    <label class="badge badge-success">Winning</label>
                                                                @endif
                                                                @if($bid->status == 2)
                                                                    <label class="badge badge-danger">Lost</label>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changeStatus(id, status) {
            if (status == '3') {
                var r = confirm('Are you sure?');
                if (r == true) {
                    window.location.href = '{{url('/admin/application-status')}}/' + status + '?application=' + id;
                }
            }
            if (status == '4') {
                $('#applicationId').val(id);
                $('#rejectModal').modal('show');
            }
        }
    </script>
@endsection
