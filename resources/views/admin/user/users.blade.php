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
                            Manage User
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
                                <form id="userForm" method="get" action="{{ route('admin_users') }}">
                                    <div class="col-12 input-group">
                                        <input name="keyword" id="keyword" class="form-control mr-3"
                                               placeholder="search by name" value="{{ request()->get("keyword") }}">
                                        <select class="form-control" name="type">
                                            <option value="">All</option>
                                            <option value="1" {{ request()->get("type") == 1 ? 'selected' : '' }}>
                                                Broker
                                            </option>
                                            <option value="2" {{ request()->get("type") == 2 ? 'selected' : '' }}>
                                                Lender
                                            </option>
                                            <option value="3" {{ request()->get("type") == 3 ? 'selected' : '' }}>
                                                Borrower
                                            </option>
                                        </select>
                                        <button type="submit" class="btn btn-primary ml-0">Search</button>
                                        <a href="{{route('admin_users')}}">
                                            <button id="reset" type="button" class="btn btn-info ml-2"
                                                    onClick="window.location.href=window.location.href">RESET
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
                                    <h5 class="card-title">User's list</h5>
                                    <table class="mb-0 table">
                                        <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Registered At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    <a href="#">{{ ucfirst($user['first_name']) }} {{ ucfirst($user['last_name']) }}</a>
                                                </td>
                                                <td>{{ $user['email'] }}</td>
                                                <td>{{ $user['phone'] }}</td>
                                                <td>{{ $user['user_type'] }}
                                                <td>{{ $user['is_active'] }}</td>
                                                <td>{{ $user['created_at'] }}</td>
                                                <td>
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            @if($user['is_active'] == 'Active')
                                                                <a href="javascript:void(0)"
                                                                   onclick="changeStatus('{{url('/admin/user-status/')}}/{{$user->id}}/0')"
                                                                   class="btn btn-danger btn-sm rounded-0"
                                                                >Deactivate</a>
                                                            @endif
                                                            @if($user['is_active'] == 'Inactive')
                                                                <a href="javascript:void(0)"
                                                                   onclick="changeStatus('{{url('/admin/user-status/')}}/{{$user->id}}/1')"
                                                                   class="btn btn-success btn-sm rounded-0"
                                                                > Activate </a>
                                                            @endif
                                                        </li>
{{--                                                        <li class="list-inline-item">--}}
{{--                                                            <a href="javascript:void(0);" data-id="{{$user->id}}"--}}
{{--                                                               class="btn btn-danger btn-sm rounded-0 deleteUser"--}}
{{--                                                               data-toggle="tooltip" data-placement="top"--}}
{{--                                                               title="Delete"><i--}}
{{--                                                                    class="fa fa-trash"></i></a>--}}
{{--                                                        </li>--}}
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="clearfix">
                                        <ul style="float:right" class="pagination">
                                            {{ $users->appends($_GET)->links() }}
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
        function changeStatus(link) {
            var r = confirm('Are you sure?')
            if(r == true){
                window.location.href = link
            }
        }
    </script>
@endsection
