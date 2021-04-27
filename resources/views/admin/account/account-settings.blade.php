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
                            Account Setting(s)
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
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade-in active" id="tab-content-1" role="tabpanel">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">Password settings</h5>
                            <form method="post" action="{{ route('update_password') }}">
                                @csrf
                                <div class="position-relative row form-group"><label class="col-sm-2 col-form-label">Current password</label>
                                    <div class="col-sm-10"><input name="current_password" placeholder="Enter existing password" type="password" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-group"><label class="col-sm-2 col-form-label">New password</label>
                                    <div class="col-sm-10"><input name="new_password" placeholder="Enter new password" type="password" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-group"><label class="col-sm-2 col-form-label">confirm new password</label>
                                    <div class="col-sm-10"><input name="confirm_password" placeholder="Confirm password" type="password" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-check">
                                    <div class="col-sm-10 offset-sm-2 pl-0">
                                        <button type="submit" class="btn btn-primary">Update password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
