<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Http\Requests\Authenticate\ChangepassRequest;
use GD\Api\Transformers\AccountTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GD\Api\Models\User;
use GD\Api\Models\UserDetail;
use GD\Api\Models\Experience;
use Carbon\Carbon;
use Hash;
use DB;

class AccountController extends BaseController{
    /**
     * @SWG\Post(
     *   path="/account/update-profile",
     *   summary="Update Profile",
     *   operationId="api.updateProfile",
     *   produces={"application/json"},
     *   tags={"Account"},
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(
     *         name="background",
     *         in="formData",
     *         type="file",
     *         description="Background",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="image",
     *         in="formData",
     *         type="file",
     *         description="Image",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="image_intro",
     *         in="formData",
     *         type="file",
     *         description="Image Introduce",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="flag",
     *         in="formData",
     *         type="file",
     *         description="Flag",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="description",
     *         in="formData",
     *         type="string",
     *         description="Description",
     *         required=false,
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function updateProfile(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        if($request->hasFile('background') || $request->hasFile('image') || $request->hasFile('image_intro') || $request->hasFile('flag')){
            $fileBackGround = $request->file('background');
            $imageBG        = $fileBackGround->getClientOriginalName();
            $fileBackGround->move('uploads/images',$imageBG);

            $fileImage  = $request->file('image');
            $imageName  = $fileImage->getClientOriginalName();
            $fileImage->move('uploads/images',$imageName);

            $fileIntro  = $request->file('image_intro');
            $imageIntro = $fileIntro->getClientOriginalName();
            $fileIntro->move('uploads/images',$imageIntro);

            $fileFlag   = $request->file('flag');
            $imageFlag  = $fileFlag->getClientOriginalName();
            $fileFlag->move('uploads/images',$imageFlag);

            $userDetail = UserDetail::where('user_id' ,$user->id)->first();
            if($userDetail !== null){
                $userDetail->update([
                    'id'          => $userDetail->id,
                    'background'  => $imageBG,
                    'user_id'     => $user->id,
                    'image'       => $imageName,
                    'image_intro' => $imageIntro,
                    'flag'        => $imageFlag,
                    'description' => $request->description
                ]);
                if(!$userDetail){
                    return $this->respondWithError('Error! Update Profile Failed');
                }
                $result = fractal($userDetail ,new AccountTransformer())->toArray();
                return $this->respondWithSuccess($result ,'Update Profile Successful');
            }
            else {
                $createNew = UserDetail::create([
                    'background'  => $imageBG,
                    'user_id'     => $user->id,
                    'image'       => $imageName,
                    'image_intro' => $imageIntro,
                    'flag'        => $imageFlag,
                    'description' => $request->description
                ]);
                if(!$createNew){
                    return $this->respondWithError('Error! Update Profile Failed');
                }
                $result = fractal($createNew ,new AccountTransformer())->toArray();
                return $this->respondWithSuccess($result ,'Update Profile Successful');
            }
        }
    }

    /**
     * @SWG\Post(
     *   path="/account/change-password",
     *   summary="Change Password",
     *   operationId="api.changePass",
     *   produces={"application/json"},
     *   tags={"Account"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "old_password": "thanhlong",
     *       "new_password" : "123456",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function changePass(ChangepassRequest $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        if(Hash::check($request->old_password ,$user->password)){
            $result = $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            return $this->respondWithSuccess($result ,'Change password successful');
        }
        return $this->respondWithError("Old password incorrect");
    }

    // public function experience(Request $request){
    //     $user = $this->getUser();
    //     if(!$user){
    //         return $this->respondWithError('Error! User not found');
    //     }
    //     $experience = Experience::where('user_id' ,$user->id)->first();
    //     if($experience !== null){
    //         $experience->update([
    //             'id'            => $experience->id,
    //             'user_id'       => $user->id,
    //             'title'         => $request->title,
    //             'post_time'     => Carbon::parse($request->post_time)->format('Y-m-d'),
    //             'description'   => $request->description,
    //         ]);
    //         if(!$experience){
    //             return $this->respondWithError('Error! Update failed');
    //         }
    //         return $this->respondWithSuccess($experience ,'Update experience successful');
    //     }
    //     else {
    //         $createNew = Experience::create([
    //             'user_id'       => $user->id,
    //             'title'         => $request->title,
    //             'post_time'     => Carbon::parse($request->post_time)->format('Y-m-d'),
    //             'description'   => $request->description,
    //         ]);
    //         if(!$createNew){
    //             return $this->respondWithError('Error! Update failed');
    //         }
    //         return $this->respondWithSuccess($createNew ,'Update experience successful');
    //     }
    // }

}
