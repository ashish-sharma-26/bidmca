<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RealtimeController extends Controller
{
    public function pushFirebase($collection, $data){
        $database = app('firebase.database');
        $database->getReference($collection)->set($data);
    }
}
