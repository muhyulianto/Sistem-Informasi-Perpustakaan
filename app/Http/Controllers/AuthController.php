<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request){
        $v = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:5',
        ]);

        if ($v->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->kelas = $request->kelas;
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Login user and return a token
     */
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json([
            'errors' => 'login_error! please check your email and password again'
        ], 401);
    }

    /**
     * Logout User
     */
    public function logout(){
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request){
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Refresh JWT token
     */
    public function refresh(){
      if ($token = $this->guard()->refresh()) {
        return response()
          ->json(['status' => 'successs'], 200)
          ->header('Authorization', $token);
      }
      return response()->json(['error' => 'refresh_token_error'], 401);
    }
    
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
