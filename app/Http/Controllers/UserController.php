<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(Request $request){
        $user = User::where('name', 'like', '%'.$request->search_query.'%')
            ->where('role', 1)
            ->paginate($request->entries);

        return response()->json([
            'users' => $user->toArray()
        ]);
    }

    public function user(Request $request) {
        $user = User::where('id', $request->id)->first();

        return response()->json([
            'user' => $user
        ]);
    }

}
