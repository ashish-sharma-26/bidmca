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
                        <div>
                            Manage Application(s)
                        </div>
                    </div>
                    {{--                    <div class="page-title-actions">--}}
                    {{--                        <div class="d-inline-block dropdown">--}}
                    {{--                            <a href="{{ route('createUser') }}" type="button" class="btn btn-lg btn-info">--}}
                    {{--                                Create User--}}
                    {{--                            </a>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-12 users">
                    <div class="col-12 search-filter card my-3" style="margin-top: 0px !important;">
                        <div class="row py-4">
                            <div class="col-sm-11 fields-sec">
                                <form id="userForm" method="get" action="{{ route('admin_applications') }}">
                                    <div class="col-12 input-group">
                                        {{--                                        <input name="keyword" id="keyword" class="form-control mr-3"--}}
                                        {{--                                               placeholder="search by name" value="{{ request()->get("keyword") }}">--}}
                                        <select class="form-control" name="status">
                                            <option value="">All</option>
                                            <option value="1" {{ request()->get("status") == 1 ? 'selected' : '' }}>
                                                Drafted
                                            </option>
                                            <option value="2" {{ request()->get("status") == 2 ? 'selected' : '' }}>
                                                Pending for Approval
                                            </option>
                                            <option value="3" {{ request()->get("status") == 3 ? 'selected' : '' }}>
                                                Approved
                                            </option>
                                            <option value="4" {{ request()->get("status") == 4 ? 'selected' : '' }}>
                                                Rejected
                                            </option>
                                        </select>
                                        <button type="submit" class="btn btn-primary ml-0">Search</button>
                                        <a href="{{route('admin_applications')}}">
                                            <button id="reset" type="button" class="btn btn-info ml-2"
                                            >RESET
                                            </button>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="main-card mb-3 p-0 card col-12">
                                <div class="card-body">
                                    <h5 class="card-title">Application list</h5>
                                    <table class="mb-0 table">
                                        <thead>
                                        <tr>
                                            <th>Applied By</th>
                                            <th>Business Name</th>
                                            <th>Loan Amount</th>
                                            <th>Status</th>
                                            <th>Submitted At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($applications as $application)
                                            <tr>
                                                <td>
                                                    <a href="#">{{ ucfirst($application->user['first_name']) }} {{ ucfirst($application->user['last_name']) }}</a>
                                                </td>
                                                <td>{{ $application['business_name'] }}</td>
                                                <td>${{ $application['loan_amount'] }}
                                                <td>{!! $application['status'] !!}</td>
                                                <td>{{ $application['created_at'] }}</td>
                                                <td>
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
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
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('admin_application', $application->id)}}"
                                                               class="btn btn-danger btn-sm rounded-0 deleteUser"
                                                               data-toggle="tooltip" data-placement="top"
                                                               title="View"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="clearfix">
                                        <ul style="float:right" class="pagination">
                                            {{ $applications->appends($_GET)->links() }}
                                        </ul>
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
