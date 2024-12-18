<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup()
    {
        return view('auth.signup');
    }

    public function registr(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'reader',
        ]);
        // return redirect()->route('login')->with('success', 'User registered successfully');

        return redirect()->route('login')->with('success', 'User registered successfully');

        $response = [
            'name' => $request->name,
            'email' => $request('email'),
            'password' => $request->password
        ];
        return response() ->json($response);

    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        if (auth()->attempt($credentials, $request->remember)) {
            $token = $request->user()->createToken('MyAppToken')->plainTextToken;
            return response($token);
        }
        return response([
            'email' => 'The provided credentials do not match our records.',
        ], 401);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response('logout');
    }
}
