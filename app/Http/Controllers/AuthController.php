<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{    
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'inn' => 'required',
            'kpp' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);        
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }       
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->inn = $request->inn;
        $user->kpp = $request->kpp;
        $user->phone = $request->phone;
        $user->code = bcrypt($this->generateCode());
        $user->password = bcrypt($request->password);
        $user->save(); 

        return response()->json(['status' => 'success'], 200);
    }   
    public function login(Request $request)
    {
        $credentials1 = $request->only('email', 'password');
        $credentials2 = $request->only('code');
              
        if ($token = $this->guard()->attempt($credentials1) || $token = $this->guard()->attempt($credentials2)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        } 

        return response()->json(['error' => 'login_error'], 401);
    }    
    public function logout()
    {
        $this->guard()->logout();  

        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);

    }    
    public function user(Request $request)
    {
        $user = Auth::user(); 

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);

    }    
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }       
        
        return response()->json(['error' => 'refresh_token_error'], 401);
    }   
    private function guard()
    {
        return Auth::guard();
    }
    private function generateCode()
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $max = 8;
        $size = StrLen($chars)-1;  
        $password = null;

        while($max--) $password.=$chars[rand(0,$size)]; 
        
        return $password;
    }
}
