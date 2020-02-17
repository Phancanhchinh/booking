<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Transformers\CommentTransformer;
use GD\Api\Http\Requests\Comment\CreateCommentRequest;
use GD\Api\Http\Requests\Comment\UpdateCommentRequest;
use GD\Api\Http\Requests\Comment\DeleteCommentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GD\Api\Models\Post;
use GD\Api\Models\Comment;
use GD\Api\Models\Reply;
use GD\Api\Models\User;
use Carbon\Carbon;
use Hash;
use DB;

class CommentController extends BaseController{
    /**
     * @SWG\Post(
     *   path="/comment/create",
     *   summary="Create Comment",
     *   operationId="api.createComment",
     *   produces={"application/json"},
     *   tags={"Comment"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "post_id": "1",
     *       "content" : "Còn Nhận Người dự sự kiện không ?",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function createComment(CreateCommentRequest $request){    //validate them sau
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $post = Post::find($request->post_id);
        if(!$post ){
            return $this->respondWithError('Post comment failed');
        }
        $comment = Comment::create([
            'name' => $user->getFullName(),
            'content' => $request->content,
            'post_id' =>  $request->post_id,
            'user_id' => $user->id,
        ]);
        if(!isset($comment)){
            return $this->respondWithError('Post comment failed');
        }else{
            $result = fractal($comment ,new CommentTransformer())->toArray();
            return $this->respondWithSuccess($result ,'Post comment Successful');
        }
    }
    /**
     * @SWG\Get(
     *   path="/comment/get-all-comment",
     *   description="",
     *   summary="Get Comment By Id Post",
     *   operationId="api.getAllCommentByPost",
     *   produces={"application/json"},
     *   tags={"Comment"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "post_id": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     * )
     */
    public function getAllCommentByPost(Request $request){
        $comment = Comment::where('post_id',$request->post_id);
        if(!$comment){
            return $this->respondWithError('No posts found');
        }
        return $this->respondWithSuccess($comment->paginate(3), 'Get All Comment Successfully!');
    }

    /**
     * @SWG\Post(
     *   path="/comment/update",
     *   summary="Update Comment",
     *   operationId="api.updateComment",
     *   produces={"application/json"},
     *   tags={"Comment"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "id_comment" : "1",
     *       "content" : "",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function updateComment(UpdateCommentRequest $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $comment = Comment::find($request->id_comment);
        if(!$comment){
            return $this->respondWithError('No comments found');
        }else{
            $comment = $comment->update([
                'content' => $request->content,
            ]);
            return $this->respondWithSuccess($comment ,'Update comment Successful');
        }
    }

    /**
     * @SWG\Post(
     *   path="/comment/delete",
     *   summary="Delete Comment",
     *   operationId="api.deleteComment",
     *   produces={"application/json"},
     *   tags={"Comment"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "id_comment": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function deleteComment(DeleteCommentRequest $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $userComment = Comment::where('id',$request->id_comment)->where('user_id',$user->id)->count();
        if($user->type === User::Admin || $userComment > 0){
            $comment = Comment::find($request->id_comment);
            if(!$comment){
                return $this->respondWithError('No comments found');
            }
            $deleteReply = Reply::where('comment_id',$comment->id)->delete();
            return $this->respondWithSuccess($comment->delete(),'Deleted comment Successfully');
        }else{
            return $this->respondWithError('Cant deleled');
        }
    }
}
