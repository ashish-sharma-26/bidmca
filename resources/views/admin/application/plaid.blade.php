<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
           aria-selected="true">Account(s)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
           aria-selected="false">Transaction(s)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
           aria-selected="false">Liability(s)</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        @if(!sizeof($accounts))
            <div class="text-center" id="acc-button">
                <button class="btn btn-primary" type="button" onclick="fetchAccountData('{{$appId}}')">Fetch Latest
                    Information
                </button>
            </div>
            <div class="text-center" id="acc-loader" style="display: none;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @endif
        <table class="table table-striped" id="acc-table" style="{{sizeof($accounts) ? '' : 'display: none'}}">
            <thead>
            <th>Account Name</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Available Balance</th>
            <th>Current Balance</th>
            <th>Limit</th>
            </thead>
            <tbody id="plaidAccountData">
            @if(sizeof($accounts))
                @foreach($accounts AS $account)
                    <tr>
                        <td><p>{{customDecrypt($account->account_name)}} <i class="fa fa-info" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="{{customDecrypt($account->account_name_alias)}}"></i>
                            </p></td>
                        <td><label class="badge badge-primary">{{customDecrypt($account->account_type)}}</label></td>
                        <td><label class="badge badge-info">{{customDecrypt($account->account_subtype)}}</label></td>
                        <td>{{customDecrypt($account->account_available_balance)}}</td>
                        <td>{{customDecrypt($account->account_current_balance)}}</td>
                        <td>{{customDecrypt($account->account_limit)}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        @if(!sizeof($transactions))
            <div class="form-group w-50 m-auto">
                <input type="text" name="trx_date" class="form-control">
            </div>
            <div class="text-center mt-3 mb-3">
                <input type="hidden" id="appId" value="{{$appId}}">
                <button class="btn btn-primary" id="trx-button" disabled="disabled" type="button"
                        onclick="fetchTrxData('{{$appId}}')">Fetch Latest Information
                </button>
            </div>
            <div class="text-center" id="trx-loader" style="display: none;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @endif
        <table class="table table-striped" id="trx-table" style="{{sizeof($transactions) ? '' : 'display: none'}}">
            <thead>
            <th>Account</th>
            <th>Amount</th>
            <th>Merchant Name</th>
            <th>Category</th>
            <th>Date</th>
            </thead>
            <tbody id="plaidTrxData">
            @if(sizeof($transactions))
                @foreach($transactions AS $transaction)
                    <tr>
                        <td>{{customDecrypt($transaction->account_name)}}</td>
                        <td>{{customDecrypt($transaction->amount)}}</td>
                        <td><p>{{customDecrypt($transaction->merchant_name)}} <i class="fa fa-info"
                                                                                 data-toggle="tooltip"
                                                                                 data-placement="top"
                                                                                 title="{{customDecrypt($transaction->merchant_name_alias)}}"></i>
                        </td>
                        <td>{{customDecrypt($transaction->category)}}</td>
                        <td>{{customDecrypt($transaction->date)}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        @if(!sizeof($credits) && !sizeof($mortgages) && !sizeof($students))
            <div class="text-center" id="lbt-button">
                <button class="btn btn-primary" type="button" onclick="fetchLiabilityData('{{$appId}}')">Fetch Latest
                    Information
                </button>
            </div>
            <div class="text-center" id="lbt-loader" style="display: none;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @endif
        <div class="row" id="lbt-credit-table" style="{{(sizeof($credits) || sizeof($mortgages) || sizeof($students)) ? '' : 'display: none'}}">
            <div class="col-12">
                <h4>Credit</h4>
                <table class="table table-striped">
                    <thead>
                    <th>Account</th>
                    <th>Overdue?</th>
                    <th>Last Payment</th>
                    <th>Last Payment Date</th>
                    <th>Last Statement</th>
                    <th>Last Statement Date</th>
                    </thead>
                    <tbody>
                    @if(sizeof($credits))
                        @foreach($credits AS $item)
                            <tr>
                                <td>{{customDecrypt($item->account_name)}}</td>
                                <td>{{customDecrypt($item->overdue)}}</td>
                                <td>{{customDecrypt($item->last_payment)}}</td>
                                <td>{{customDecrypt($item->last_payment_date)}}</td>
                                <td>{{customDecrypt($item->last_statement)}}</td>
                                <td>{{customDecrypt($item->last_statement_date)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="col-12" id="lbt-mortgage-table" style="{{(sizeof($credits) || sizeof($mortgages) || sizeof($students)) ? '' : 'display: none'}}">
                <h4>Mortgage</h4>
                <table class="table table-striped">
                    <thead>
                    <th>Account</th>
                    <th>Principal Amount</th>
                    <th>Origination Date</th>
                    <th>Maturity Date</th>
                    <th>IR</th>
                    <th>Last Payment</th>
                    <th>Last Payment Date</th>
                    </thead>
                    <tbody>
                    @if(sizeof($mortgages))
                        @foreach($mortgages AS $item)
                            <tr>
                                <td>{{customDecrypt($item->account_name)}}</td>
                                <td>{{customDecrypt($item->principal_amount)}}</td>
                                <td>{{customDecrypt($item->originate_date)}}</td>
                                <td>{{customDecrypt($item->maturity_date)}}</td>
                                <td>{{customDecrypt($item->ir)}}</td>
                                <td>{{customDecrypt($item->last_payment)}}</td>
                                <td>{{customDecrypt($item->last_payment_date)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="col-12" id="lbt-student-table" style="{{(sizeof($credits) || sizeof($mortgages) || sizeof($students)) ? '' : 'display: none'}}">
                <h4>Student</h4>
                <table class="table table-striped">
                    <thead>
                    <th>Account</th>
                    <th>Overdue?</th>
                    <th>Guarantor</th>
                    <th>Principal Amount</th>
                    <th>Origination Date</th>
                    <th>End Date</th>
                    <th>IR</th>
                    <th>Last Payment</th>
                    <th>Last Payment Date</th>
                    </thead>
                    <tbody>
                    @if(sizeof($students))
                        @foreach($students AS $item)
                            <tr>
                                <td>{{customDecrypt($item->account_name)}}</td>
                                <td>{{customDecrypt($item->overdue)}}</td>
                                <td>{{customDecrypt($item->guarantor)}}</td>
                                <td>{{customDecrypt($item->principal_amount)}}</td>
                                <td>{{customDecrypt($item->originate_date)}}</td>
                                <td>{{customDecrypt($item->maturity_date)}}</td>
                                <td>{{customDecrypt($item->ir)}}</td>
                                <td>{{customDecrypt($item->last_payment)}}</td>
                                <td>{{customDecrypt($item->last_payment_date)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
