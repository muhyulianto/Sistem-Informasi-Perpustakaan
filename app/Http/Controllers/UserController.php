<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Buku;
use Auth;

class UserController extends Controller
{
    public function index(){
        $user = User::get();
        return response()->json([
            'data_user' => $user->toArray()
        ]);
    }

    public function show($id){
        $user = User::Find($id);
        return response()->json($user);
    }

}
