@extends('admin.layout')
@section('content')
<div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-car icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        <div>Analytics Dashboard
                            <div class="page-title-subheading">Overview of
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-4 mb-3">
                    <div class="card mb-2 widget-content bg-asteroid">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Registered users</div>
                                <div class="widget-subheading">Total number of users</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{$totalUsers}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 mb-3">
                    <div class="card mb-2 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Broker(s)</div>
                                <div class="widget-subheading">Total number of Broker(s)</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{$totalBroker}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 mb-3">
                    <div class="card mb-2 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Lender(s)</div>
                                <div class="widget-subheading">Total number of Lender(s)</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{$totalLender}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 mb-3">
                    <div class="card mb-2 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Borrower(s)</div>
                                <div class="widget-subheading">Total number of Borrower(s)</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{$totalBorrower}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 mb-3">
                    <div class="card mb-2 widget-content bg-danger">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Application(s)</div>
                                <div class="widget-subheading">Total number of Application(s) </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{$totalApplications}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-2 widget-content bg-happy-green">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Bid(s)</div>
                                <div class="widget-subheading">Total number of Bid(s)</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{$totalBids}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card mb-2 widget-content bg-warning">--}}
{{--                        <div class="widget-content-wrapper text-white">--}}
{{--                            <div class="widget-content-left">--}}
{{--                                <div class="widget-heading">Today's ads</div>--}}
{{--                                <div class="widget-subheading">Active ad's today</div>--}}
{{--                            </div>--}}
{{--                            <div class="widget-content-right">--}}
{{--                                <div class="widget-numbers text-white"><span>{{$totalBannerToday}}</span></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card mb-2 widget-content bg-midnight-bloom">--}}
{{--                        <div class="widget-content-wrapper text-white">--}}
{{--                            <div class="widget-content-left">--}}
{{--                                <div class="widget-heading">Purchased leads</div>--}}
{{--                                <div class="widget-subheading">Leads purchased today</div>--}}
{{--                            </div>--}}
{{--                            <div class="widget-content-right">--}}
{{--                                <div class="widget-numbers text-white"><span>{{$totalPurchaseLeadToday}}</span></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card mb-2 widget-content bg-primary">--}}
{{--                        <div class="widget-content-wrapper text-white">--}}
{{--                            <div class="widget-content-left">--}}
{{--                                <div class="widget-heading">Sellers</div>--}}
{{--                                <div class="widget-subheading">Total number of sellers</div>--}}
{{--                            </div>--}}
{{--                            <div class="widget-content-right">--}}
{{--                                <div class="widget-numbers text-white"><span>{{$totalSellers}}</span></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
{{--            <div class="row">--}}
{{--                <div class="col-md-12 col-xl-6">--}}
{{--                    <div class="row">--}}
{{--                        <h5 class="card-title w-100 pl-3">Today's Statistics</h5>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="card mb-3 widget-content">--}}
{{--                                <div class="widget-content-outer">--}}
{{--                                    <div class="widget-content-wrapper">--}}
{{--                                        <div class="widget-content-left">--}}
{{--                                            <div class="widget-heading">Users</div>--}}
{{--                                            <div class="widget-subheading">Users registered today</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="widget-content-right">--}}
{{--                                            <div class="widget-numbers text-success">{{$totalUsersToday}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="card mb-3 widget-content">--}}
{{--                                <div class="widget-content-outer">--}}
{{--                                    <div class="widget-content-wrapper">--}}
{{--                                        <div class="widget-content-left">--}}
{{--                                            <div class="widget-heading">Enquiry</div>--}}
{{--                                            <div class="widget-subheading">Enquiry received today</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="widget-content-right">--}}
{{--                                            <div class="widget-numbers text-warning">{{$totalInquiryToday}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="card mb-2 widget-content">--}}
{{--                                <div class="widget-content-outer">--}}
{{--                                    <div class="widget-content-wrapper">--}}
{{--                                        <div class="widget-content-left">--}}
{{--                                            <div class="widget-heading">Products</div>--}}
{{--                                            <div class="widget-subheading">Products listed today</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="widget-content-right">--}}
{{--                                            <div class="widget-numbers text-danger">{{$totalProductsToday}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="card mb-2 widget-content">--}}
{{--                                <div class="widget-content-outer">--}}
{{--                                    <div class="widget-content-wrapper">--}}
{{--                                        <div class="widget-content-left">--}}
{{--                                            <div class="widget-heading">Leads</div>--}}
{{--                                            <div class="widget-subheading">Requirements received today</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="widget-content-right">--}}
{{--                                            <div class="widget-numbers text-warning">{{$totalBRToday}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-xl-6">--}}
{{--                    <div class="row">--}}
{{--                        <h5 class="card-title w-100 pl-3">Today's Approval</h5>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="card mb-3 widget-content">--}}
{{--                                <div class="widget-content-outer">--}}
{{--                                    <div class="widget-content-wrapper">--}}
{{--                                        <div class="widget-content-left">--}}
{{--                                            <div class="widget-heading">Approved Products</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="widget-content-right">--}}
{{--                                            <div class="widget-numbers text-success">{{$productApprovedToday}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="card mb-2 widget-content">--}}
{{--                                <div class="widget-content-outer">--}}
{{--                                    <div class="widget-content-wrapper">--}}
{{--                                        <div class="widget-content-left">--}}
{{--                                            <div class="widget-heading">Approved buy leads</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="widget-content-right">--}}
{{--                                            <div class="widget-numbers text-danger">{{$leadApprovedToday}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <hr>
        </div>
</div>
@endsection

