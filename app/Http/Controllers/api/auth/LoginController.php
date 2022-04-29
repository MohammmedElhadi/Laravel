<?php

namespace App\Http\Controllers\api\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {

        $user = User::where('phone' ,'=', $request->phone)
                 ->get();
        if($user->isEmpty()){
            return response()->json(['message' => 'user_not_found'], 422);
        }

        $credentials = $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ]);
        if(!$user[0]->is_actif){
            return response()->json(['message' => 'disactive_account'] , 401);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Auth::user();
        }
        return response()->json(['message' => 'credentials'] , 401);

    }


    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return response()->json('success' , 200);
    }
}
