<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Transformers\PostTransformer;
use App\Http\Controllers\Controller;
use GD\Api\Http\Requests\Post\CreatePostRequest;
use GD\Api\Http\Requests\Post\UpdatePostRequest;
use GD\Api\Http\Requests\Post\DeletePostRequest;
use Illuminate\Support\Facades\Mail;
use GD\Api\Models\RegisterWork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GD\Api\Models\User;
use GD\Api\Models\Post;
use Carbon\Carbon;

use Hash;
use DB;

class PostController extends BaseController{
    /**
     * @SWG\Post(
     *   path="/post/create",
     *   summary="Create Post",
     *   operationId="api.createPost",
     *   produces={"application/json"},
     *   tags={"Post"},
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(
     *         name="title",
     *         in="formData",
     *         type="string",
     *         description="title post",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="content",
     *         in="formData",
     *         type="string",
     *         description="content post",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="image[]",
     *         in="formData",
     *         type="file",
     *         description="image post",
     *         required=false,
     *   ),
     *   @SWG\Parameter(
     *         name="video",
     *         in="formData",
     *         type="string",
     *         description="video post",
     *         required=false,
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function createPost(CreatePostRequest $request){
            // Check User Login (token)
            $user = $this->getUser();
            if(!$user){
                return $this->respondWithError('Error! User not found');
            }
            // Check type User
            if($user->type === User::Admin || $user->type === User::Employer){
                $data = $request->all();
                if($request->hasFile('image')){
                    foreach($request->file('image') as $image)    // multi image
                    {
                        $name = $image->getClientOriginalName();
                        $image->move('uploads/images/posts',$name);
                        $arrayImage[] = $name;
                    }
                    $jsonImage = json_encode($arrayImage);
                    $post = Post::create([
                        'title' => $data['title'],
                        'slug' => Str::slug($data['title']),
                        'content' => $data['content'],
                        'image' => $jsonImage,
                        'video' => isset($data['video'])? $data['video'] : '',
                        'author_id' => $user['id'],
                        'status' => 0,     //  0 = not approved or approved
                        'type_post' => 0,   // 0 = recruitment or 1 = ads
                        'number_view' => 0,
                        'rate_star' => 0
                    ]);
                    if(!isset($post)){
                        return $this->respondWithError('created Post Failed');
                    }else{
                        $result = fractal($post ,new PostTransformer())->toArray();
                        return $this->respondWithSuccess($result ,'Created Post Successfully');
                    }
                }
            }else{
                return $this->respondWithError('Posting is not allowed');
            }
    }

    /**
     * @SWG\Get(
     *   path="/post/get-all-post",
     *   summary="Get All Post",
     *   operationId="api.getAllPost",
     *   produces={"application/json"},
     *   tags={"Post"},
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     * )
     */
    public function getAllPost(Request $request){
        $post = Post::paginate(5);
        // if($post){
        //     $data = [];
        //     foreach($post as $key => $value){
        //         $data[$value->title] = fractal($value ,new PostTransformer())->toArray();
        //     }
        //     return $this->respondWithSuccess($data, 'Get All Post Successfully!');
        // }else{
        //     return $this->respondWithError('Get All Post Unsuccessfully!');
        // }
        if($post){
            return $this->respondWithSuccess($post, 'Get All Post Successfully!');
        }else{
            return $this->respondWithError('Get All Post Unsuccessfully!');
        }
    }

    /**
     * @SWG\Get(
     *   path="/post/get-all-post-by-user",
     *   summary="Get All Post By User",
     *   operationId="api.getAllPostByUser",
     *   produces={"application/json"},
     *   tags={"Post"},
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *       security={
     *       {"userToken": {}}
     *   }
     * )
     */
    public function getAllPostByUser(Request $request){
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        $idUser = $user->id;
        $postByUser = Post::where('author_id',$idUser)->paginate(3);
        // if($postByUser){
        //     $data = [];
        //     foreach($postByUser as $key => $value){
        //         $data[$value->title] = fractal($value ,new PostTransformer())->toArray();
        //     }
        //     return $this->respondWithSuccess($data, 'Get Post By User Successfully!');
        // }else{
        //     return $this->respondWithError('Get Post By User Unsuccessfully!');
        // }
        if($postByUser){
            return $this->respondWithSuccess($postByUser, 'Get Post By User Successfully!');
        }else{
            return $this->respondWithError('Get Post By User Unsuccessfully!');
        }
    }

    /**
     * @SWG\Post(
     *   path="/post/update",
     *   summary="Update Post",
     *   operationId="api.updatePost",
     *   produces={"application/json"},
     *   tags={"Post"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "id" : "1",
     *       "title" : "title 1",
     *       "content": "content 1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function updatePost(UpdatePostRequest $request){
        // Check User Login (token)
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        if($user->type === User::Admin || $user->type === User::Employer){
            $idPost = $request->id;
            $post = Post::find($idPost);
            $data = $request->all();
            if(!$post){
                return $this->respondWithError('Error! Post Not Found');
            }else{
                $update = $post->update([
                    'title' => $data['title'],
                    'slug' =>  str_slug($data['title']),
                    'content' => $data['content'],
                ]);
                return $this->respondWithSuccess($update, 'Updated Successfully!');
            }
        }else{
            return $this->respondWithError('Error! Account Not Allowed Update');
        }
    }

    /**
     * @SWG\Post(
     *   path="/post/delete",
     *   summary="Delete Post",
     *   operationId="api.deletePost",
     *   produces={"application/json"},
     *   tags={"Post"},
     * @SWG\Parameter(
     *     name="id",
     *     in="body",
     *     description="id post",
     *     required=true,
     *    @SWG\Schema(example={
     *       "id": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */
    public function deletePost(DeletePostRequest $request){
        // Check User Login (token)
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        if($user->type === User::Admin){
            $idPost = $request->id;
            $post = Post::find($idPost);
            if(!$post){
                return $this->respondWithError('Error! No Posts Found');
            }else{
                return $this->respondWithSuccess($post->delete(), 'Delete Post Successfully!');
            }
        }else{
            return $this->respondWithError('Error! Account not allowed delete');
        }
    }

    /**
     * @SWG\Post(
     *   path="/post/delete-post-by-user",
     *   summary="Delete Post By User",
     *   operationId="api.deletePostByUser",
     *   produces={"application/json"},
     *   tags={"Post"},
     * @SWG\Parameter(
     *     name="id User",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *       "idUserPost": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */
    public function deletePostByUser(Request $request){
        // Check User Login (token)
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }
        if($user->type === User::Admin){
            $idAuthor = $request->idUserPost;
            $post = Post::where('author_id',$idAuthor);
            if(!$post){
                return $this->respondWithError('Error! No Posts Found');
            }else{
                return $this->respondWithSuccess($post->delete(), 'Delete Post Successfully!');
            }
        }else{
            return $this->respondWithError('Error! Account not allowed delete');
        }
    }

    /**
     * @SWG\Post(
     *   path="/post/register-work",
     *   summary="Register work",
     *   operationId="api.register",
     *   produces={"application/json"},
     *   tags={"Post"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="body",
     *     description="id post",
     *     required=true,
     *    @SWG\Schema(example={
     *       "postID": "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

    public function register(Request $request){
        // Check user login
        $user = $this->getUser();
        if(!$user){
            return $this->respondWithError('Error! User not found');
        }

        // Handle
        if($user->type === User::Customer){
            // Check post
            $post = Post::where('id' ,(int) $request->postID)->first();
            if(!$post){
                return $this->respondWithError('Error! Post not found');
            }

            // Check user register ?
            $register = RegisterWork::where(['user_id' => $user->id ,'post_id' => $post->id])->first();
            if($register && $user->id === $register->user_id){
                return $this->respondWithError('Error! You have been register in this post');
            }

            // Log employee information
            $data = RegisterWork::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
                'email'   => $user->email,
                'gender'  => $user->gender,
                'address' => $user->address
            ]);
            if($data){
                \Log::info("Register: " .$data);
                return $this->respondWithSuccess($data ,'Register work successful');
            } else {
                return $this->respondWithError('Register work unsuccessful');
            }
        } else {
            return $this->respondWithError("You aren't employee");
        }
    }
}
