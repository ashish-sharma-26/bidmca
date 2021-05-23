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
        <div class="text-center" id="acc-button">
            <button class="btn btn-primary" type="button" onclick="fetchAccountData('{{$appId}}')">Fetch Latest Information</button>
        </div>
        <div class="text-center" id="acc-loader" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <table class="table table-striped" id="acc-table" style="display: none;">
            <thead>
            <th>Account Name</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Available Balance</th>
            <th>Current Balance</th>
            <th>Limit</th>
            </thead>
            <tbody id="plaidAccountData">
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="form-group w-50 m-auto">
            <input type="text" name="trx_date" class="form-control">
        </div>
        <div class="text-center mt-3 mb-3">
            <input type="hidden" id="appId" value="{{$appId}}">
            <button class="btn btn-primary" id="trx-button" disabled="disabled" type="button" onclick="fetchTrxData('{{$appId}}')">Fetch Latest Information</button>
        </div>
        <div class="text-center" id="trx-loader" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <table class="table table-striped" id="trx-table" style="display: none;">
            <thead>
            <th>Account</th>
            <th>Amount</th>
            <th>Merchant Name</th>
            <th>Category</th>
            <th>Date</th>
            </thead>
            <tbody id="plaidTrxData">
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="text-center" id="lbt-button">
            <button class="btn btn-primary" type="button" onclick="fetchLiabilityData('{{$appId}}')">Fetch Latest Information</button>
        </div>
        <div class="text-center" id="lbt-loader" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="row" id="lbt-credit-table" style="display: none">
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
                    </tbody>
                </table>
            </div>
            <div class="col-12" id="lbt-mortgage-table" style="display: none">
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
                    </tbody>
                </table>
            </div>
            <div class="col-12" id="lbt-student-table" style="display: none">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
