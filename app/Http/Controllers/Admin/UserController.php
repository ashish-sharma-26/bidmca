<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(Request $request){
        $users = new User();
        if($request->keyword && $request->keyword != ''){
            $users = $users->where('first_name', 'LIKE', '%'.$request->keyword.'%')->whereOr('last_name', '%'.$request->keyword.'%');
        }
        if($request->type && $request->type != ''){
            $users = $users->where('user_type', $request->type);
        }
        $users = $users->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.user.users', compact('users'));
    }

    public function userStatus($id, $status){
        User::where('id', $id)->update(['is_active' => $status]);
        return redirect()->back();
    }
}
