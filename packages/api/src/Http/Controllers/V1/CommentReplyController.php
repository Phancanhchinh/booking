<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Transformers\ReplyTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use GD\Api\Http\Requests\Reply\CreateReplyRequest;
use GD\Api\Http\Requests\Reply\UpdateReplyRequest;
use GD\Api\Http\Requests\Reply\DeleteReplyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GD\Api\Models\User;
use GD\Api\Models\Reply;
use Carbon\Carbon;
use Hash;
use DB;

class CommentReplyController extends BaseController{
    /**
     * @SWG\Post(
     *   path="/reply/create",
     *   summary="Create Reply Comment",
     *   operationId="api.createReplyComment",
     *   produces={"application/json"},
     *   tags={"Reply Comment"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "comment_id": "1",
     *       "content" : "Còn Nhé Bạn?",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function createReply(CreateReplyRequest $request){    //validate them sau
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $reply = Reply::create([
            'comment_id' => $request->comment_id,
            'name' => $user->getFullName(),
            'content' => $request->content,
            'user_id' => $user->id,
        ]);
        if(!isset($reply)){
            return $this->respondWithError('Post reply failed');
        }else{
            $result = fractal($reply ,new ReplyTransformer())->toArray();
            return $this->respondWithSuccess($result ,'Post reply Successful');
        }
    }
     /**
     * @SWG\Post(
     *   path="/reply/get-all-reply",
     *   description="",
     *   summary="Get Reply By Id Comment",
     *   operationId="api.getAllReplyByCommentId",
     *   produces={"application/json"},
     *   tags={"Reply Comment"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "comment_id": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     * )
     */
    public function getAllReplyByCommentId(Request $request){
        $reply = Reply::where('comment_id',$request->comment_id);
        if(!$reply){
            return $this->respondWithError('No reply found');
        }
        return $this->respondWithSuccess($reply->paginate(3), 'Get All reply Successfully!');
    }
        /**
     * @SWG\Post(
     *   path="/reply/update",
     *   summary="Update Reply By User",
     *   operationId="api.updateReply",
     *   produces={"application/json"},
     *   tags={"Reply Comment"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "id_reply" : "1",
     *       "content" : "hủy bỏ đăng ký!",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function updateReply(UpdateReplyRequest $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $reply = Reply::where('id',$request->id_reply)->where('user_id',$user->id)->first();
        if(!$reply){
            return $this->respondWithError('No Reply found');
        }
        $update = $reply->update([
            'content' => $request->content,
        ]);
        return $this->respondWithSuccess($update ,'Update Reply Successful');
    }

    /**
     * @SWG\Post(
     *   path="/reply/delete",
     *   summary="Delete Reply By User",
     *   operationId="api.deleteReply",
     *   produces={"application/json"},
     *   tags={"Reply Comment"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "id_reply": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */
    public function deleteReply(DeleteReplyRequest $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $userReply = Reply::where('id',$request->id_reply)->where('user_id',$user->id)->count();
        if($user->type === User::Admin || $userReply > 0){
            $reply = Reply::find($request->id_reply);
            if(!$reply){
                return $this->respondWithError('No reply found');
            }
            return $this->respondWithSuccess($reply->delete(),'Deleted reply Successfully');
        }else{
            return $this->respondWithError('Cant deleled');
        }
    }
}
