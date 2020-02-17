<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Mail\ActiveUserMail;
use Carbon\Carbon;
use Mail;
use App\User;
use DB;
use Hash;
use Auth;
class AuthenticateController extends Controller
{

    public function register(Request $request)
    {
 		$validate = $request->validate([
 			'name' 	   => 'required|max:55',
 			'email'    => 'email|required|unique:users',
 			'password' => 'required|same:confirm-password'
 		]);

 		$validate['password'] = Hash::make($request['password']);

 		$user = User::create($validate);

 		$accessToken  = $user->createToken('authToken')->accessToken;

        // $token = str_replace('-', '', (string) \Str::uuid());
        // $mail = [
        //  'token'     => $token,
        //  'email'     => $user['email'],
        //  'fullName'  => $user['name'],
        //  'urlActive' => env('CUSTOMER_LINK_ACTIVE',true)
        // ] ;
        // Mail::to($user['email'])->send(new \App\Mail\ActiveUserMail($mail));
        
 		return response(['user' => $user,'access_token' => $accessToken]);
    }


    public function login(Request $request){
   //  	$loginUser = $request->validate([
 		// 	'email'    => 'email|required',
 		// 	'password' => 'required',
 		// ]);

 		// if(!Auth::attempt($loginUser)){
 		// 	return response(['message' => 'Invalid credentials']);
 		// }

 		// $accessToken  = Auth::user()->createToken('authToken')->accessToken;

        //return response(['user' => Auth::user(),'access_token' => $accessToken]);
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'token' => $token,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

   

}