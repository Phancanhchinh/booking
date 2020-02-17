<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Transformers\UserTransformer;
use GD\Api\Transformers\ExperienceTransformer;
use GD\Api\Transformers\UserDetailTransformer;
use GD\Api\Http\Requests\Authenticate\SignupRequest;
use GD\Api\Http\Requests\Authenticate\LoginRequest;
use GD\Api\Http\Requests\Authenticate\ActiveRequest;
use GD\Api\Http\Requests\Authenticate\NewpassRequest;
use GD\Api\Http\Requests\Authenticate\ForgotRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GD\Api\Models\UserToken;
use GD\Api\Models\UserDetail;
use GD\Api\Models\Experience;
use GD\Api\Models\User;
use Carbon\Carbon;
use Hash;
use DB;

class AuthController extends BaseController{
	/**
     * @SWG\Post(
     *   path="/auth/login",
     *   summary="Login User",
     *   operationId="/auth/login",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Authenticate Login",
     *     required=true,
     *    @SWG\Schema(example={
     *          "email": "thanhlong@gmail.com",
     *          "password": "123456",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!")
     * )
     */
	public function login(LoginRequest $request){
	     $user = User::where('email' ,$request->email)->first();
          if($user){
               if(!$user->status){
                    return $this->respondWithError('Error! Please activation account');
               }
               if(Hash::check($request->password ,$user->password)){
                    $userToken = UserToken::where('user_id' ,$user->id)->first();
                    if($userToken){
                         $userToken->delete();
                    }

                    $token = strtolower(env('APP_NAME','PGPB')).'-'.(string) \Str::random(30);
                    UserToken::create([
                        'user_id'      => $user->id ,
                        'access_token' =>  $token
                    ]);
                    $user['access_token'] = $token;

                    $result = fractal($user ,new UserTransformer())->toArray();
                    // user detail
                    $userDetail = UserDetail::where('user_id' ,$user->id)->first();
                    $result['data']['detail'] = fractal($userDetail ,new UserDetailTransformer())->toArray();
                    $result['data']['detail'] = $result['data']['detail']['data'];
                    // experience
                    $list = Experience::where('user_id' ,$user->id)->get();
                    $result['data']['experience']   = fractal($list ,new ExperienceTransformer())->toArray();
                    $result['data']['experience']   = $result['data']['experience']['data'];
                    $result['data']['access_token'] = $token;
                    return $this->respondWithSuccess($result, "Log in succesful!");
               }
               return $this->respondWithError("Email or password doesn't match");
          }
     }

	/**
     * @SWG\Post(
     *   path="/auth/sign-up",
     *   summary="Sign Up User",
     *   operationId="api.v1.signUp",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Authenticate Sign Up",
     *     required=true,
     *    @SWG\Schema(example={
     *          "first_name" : "Thanh",
     *          "last_name" : "Long",
     *          "username" : "thanhlong97",
     *          "password": "123456",
     *          "email": "thanhlong@gmail.com",
     *          "dob"  : "1998/11/02",
     *          "phone" : "0987654321",
     *          "gender" : "1",
     *          "address" : "TPHCM",
     *          "type" : "1"
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!")
     * )
     */
	public function signUp(SignupRequest $request){
		/**
		* @author Truong Vu
		*/
		$user = User::create([
               'first_name' => $request->first_name,
               'last_name'  => $request->last_name,
			'email'      => $request->email,
			'username'   => $request->username,
			'password'   => Hash::make($request->password),
               'phone'      => $request->phone,
               'dob'        => Carbon::parse($request->dob)->format('Y-m-d'),
               'gender'     => $request->gender,
               'address'    => $request->address,
               'type'       => $request->type,
               'status'     => ''
		]);
          if(!$user['status']){
               event(new \GD\Api\Events\SendMailActiveEvent($user));
          }
          $result = fractal($user ,new UserTransformer())->toArray();
	     return $this->respondWithSuccess($result ,'Sign up successful');
	}
	/**
     * @SWG\Post(
     *   path="/auth/active",
     *   summary="Active User",
     *   operationId="/auth/active",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Authenticate Active",
     *     required=true,
     *    @SWG\Schema(example={
     *		 "token": "58088415d56f49d7b1c048255d99c297",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!")
     * )
     */
	public function active(ActiveRequest $request){
		$token = $request->token;
		$data = DB::table('password_resets')->where('token', $token)->first();
		if(!$data){
			return $this->respondWithError('Token is incorrect');
		}
		$email = $data->email;
		$user = User::where('email' ,$email)->first();
		if($user){
			$user->status = 1;
			$user->save();
			DB::table('password_resets')->where('token' ,$token)->delete();

               $result = fractal($user ,new UserTransformer())->toArray();
		     return $this->respondWithSuccess($user ,'Activation user successful');
		}
          return $this->respondWithError('Error! Activation user failed');
	}

     /**
     * @SWG\Post(
     *   path="/auth/forgot-password",
     *   summary="Forgot Password",
     *   operationId="api.forgotPassword",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *          "email": "huythanhlong1997@gmail.com",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!")
     * )
     */

     public function forgotPassword(ForgotRequest $request){
          $user = User::where('email' ,$request->email)->first();

          $token = str_replace('-', '', (string) \Str::uuid());

          DB::table('password_resets')->insert([
               'email' => $user->email,
               'token' => $token
          ]);

          // Send Mail
          $mail = [
            'token'     => $token,
            'email'     => $user->email,
            'fullName'  => $user->name,
            'urlActive' => env('CUSTOMER_LINK_FOTGOT',true)
          ];
          Mail::to($user->email)->send(new \GD\Api\Mail\ForgotPasswordUserMail($mail));
          return $this->respondWithSuccess($user->email ,'Forgot Password Successful');
     }

     /**
     * @SWG\Post(
     *   path="/auth/new-password",
     *   summary="New Password",
     *   operationId="api.newPassword",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *          "token" : "",
     *          "password": "",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!")
     * )
     */

     public function newPassword(NewpassRequest $request){
          $token = $request->token;
          $password_resets = DB::table('password_resets')->where('token' ,$token)->first();
          if($password_resets){
               $user = User::where('email' ,$password_resets->email)->first();
               $user->update([
                    'password' => Hash::make($request->password)
               ]);

               DB::table('password_resets')->where('token' ,$token)->delete();

               $result = fractal($user ,new UserTransformer())->toArray();
               return $this->respondWithSuccess($result ,'Reset Password Successful');
          }
          return $this->respondWithError('Reset Password Fail');
     }

	/**
     * @SWG\Get(
     *   path="/auth/get-infor",
     *   summary="Get User Info",
     *   operationId="/auth/get-infor",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */
	public function getInfor(Request $request){
		$user = $this->getUser();
		if(!$user){
			return $this->respondWithError('Error! User not found');
		}
          $result = fractal($user ,new UserTransformer())->toArray();
          // user detail
          $userDetail = UserDetail::where('user_id' ,$user->id)->first();
          $result['data']['detail'] = fractal($userDetail ,new UserDetailTransformer())->toArray();
          $result['data']['detail'] = $result['data']['detail']['data'];
          // experience
          $list = Experience::where('user_id' ,$user->id)->get();
          $result['data']['experience']   = fractal($list ,new ExperienceTransformer())->toArray();
          $result['data']['experience']   = $result['data']['experience']['data'];
		return $this->respondWithSuccess($result ,'Get information user successful');
	}
}
