<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Transformers\FollowTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GD\Api\Models\Follow;
use GD\Api\Models\User;
use Carbon\Carbon;
use Hash;
use DB;

class FollowController extends BaseController{
    /**
     * @SWG\Post(
     *   path="/follow/new",
     *   summary="New Follow",
     *   operationId="api.newFollow",
     *   produces={"application/json"},
     *   tags={"Follow"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "followUser": "2",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function newFollow(Request $request){
        // Check user login
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }

        // Dont follow yourself
        if($user->id === (int) $request->followUser){
            return $this->respondWithError('Error! Dont follow yourself');
        }

        $followUser = User::where('id' ,$request->followUser)->first();
        if(!$followUser){
            return $this->respondWithError('Error! User follow not found');
        }

        // Check has been followed
        $checkFollow = Follow::where(['user_id' => $user->id , 'follow_user' => $request->followUser])->first();
        if(isset($checkFollow)){
            if((int) $request->followUser === $checkFollow->follow_user && $checkFollow->status === 1){
                return $this->respondWithError('Error! You have been followed this user');
            }
        }
        // Follow user
        $follow = Follow::create([
            'user_id'     => $user->id,
            'follow_user' => $request->followUser,
            'status'      => 1
        ]);
        if(!$follow){
            return $this->respondWithError('Error! Follow Failed');
        }
        return $this->respondWithSuccess($follow ,'You have been followed successful');
    }

    /**
     * @SWG\Get(
     *   path="/follow/list",
     *   description="",
     *   summary="List Follow",
     *   operationId="api.listFollow",
     *   produces={"application/json"},
     *   tags={"Follow"},
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function listFollow(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $follow = Follow::orderBy('id' ,'DESC')->where(['user_id' => $user->id ,'status' => 1])->get();
        if(isset($follow)){
            // Total follow
            $total = Follow::where(['user_id' => $user->id ,'status' => 1])->count();
            $result['data']['total']  = $total;

            // List follow
            $result['data']['follow'] = fractal($follow ,new FollowTransformer())->toArray();
            $result['data']['follow'] = $result['data']['follow']['data'];

            return $this->respondWithSuccess($result ,'Get list follow successful');
        }
        return $this->respondWithError('Get list follow fail');
    }

    /**
     * @SWG\Post(
     *   path="/follow/unfollow",
     *   summary="UnFollow User",
     *   operationId="api.unFollow",
     *   produces={"application/json"},
     *   tags={"Follow"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "unFollowUser": "2",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function unFollow(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $userFollow = User::where('id' ,$request->unFollowUser)->first();
        if(!$userFollow){
            return $this->respondWithError('Error! User follow not found');
        }
        $follow = Follow::where(['user_id' => $user->id ,'follow_user' => (int) $request->unFollowUser])->first();
        if(isset($follow)){
            $follow->delete();
            return $this->respondWithSuccess($follow ,'Unfollow successful');
        }
        return $this->respondWithError('Error! Unfollow fail or Not found user');
    }
}
