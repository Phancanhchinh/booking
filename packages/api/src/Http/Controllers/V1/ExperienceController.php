<?php
namespace GD\Api\Http\Controllers\V1;
use GD\Api\Http\Controllers\BaseApiController as BaseController;
use GD\Api\Transformers\AccountTransformer;
use GD\Api\Transformers\ExperienceTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GD\Api\Models\User;
use GD\Api\Models\UserDetail;
use GD\Api\Models\Experience;
use Carbon\Carbon;
use Hash;
use DB;

class ExperienceController extends BaseController{

	/**
     * @SWG\Post(
     *   path="/experience/create",
     *   summary="Experience create",
     *   operationId="api.experience.create",
     *   produces={"application/json"},
     *   tags={"Experience"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *          "title": "kinh nghiệm xyz",
     *			"post_time": "2019/12/10",
     *          "description": "abc",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */
	public function create(Request $request){
		$user = $this->getUser();
		if(!$user){
			return $this->respondWithError('Error! User not found');
		}
		$experience = Experience::create([
			'user_id'     => $user->id,
			'title'   	  => $request->title,
			'post_time'   => Carbon::parse($request->post_time)->format('Y-m-d'),
			'description' => $request->description
		]);
		if(!$experience){
			return $this->respondWithError('Error! Created experience unsuccessful');
		}
		$result = fractal($experience ,new ExperienceTransformer())->toArray();
		return $this->respondWithSuccess($result ,'Created experience successful');
	}

	/**
     * @SWG\Post(
     *   path="/experience/update",
     *   summary="Experience update",
     *   operationId="api.experience.update",
     *   produces={"application/json"},
     *   tags={"Experience"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *			"id": "1",
     *          "title": "kinh nghiệm abc",
     *			"post_time": "2019/12/10",
     *          "description": "abc",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */
	public function update(Request $request){

		$user = $this->getUser();
		if(!$user){
			return $this->respondWithError('Error! User not found');
		}
		$experience = Experience::where(['id' => $request->id ,'user_id' => $user->id])->first();
		if(!$experience){
			return $this->respondWithError('Error! Experience not found');
		}
		$experience->update([
			'id'		  => $experience->id,
			'user_id'     => $user->id,
			'title'   	  => $request->title,
			'post_time'   => Carbon::parse($request->post_time)->format('Y-m-d'),
			'description' => $request->description
		]);
		if(!$experience){
			return $this->respondWithError('Error! Updated experience unsuccessful');
		}
		$result = fractal($experience ,new ExperienceTransformer())->toArray();
		return $this->respondWithSuccess($result ,'Updated experience successful');
	}

	/**
     * @SWG\Get(
     *   path="/experience/get",
     *   summary="Get experience",
     *   operationId="api.experience.get",
     *   produces={"application/json"},
     *   tags={"Experience"},
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

	public function get(){
		$user = $this->getUser();
		if(!$user){
			return $this->respondWithError('Error! User not found');
		}
		$list = Experience::where('user_id' ,$user->id)->get();
		if(!$list){
			return $this->respondWithError('Error! Get list experience unsuccessful');
		}
		$result = fractal($list ,new ExperienceTransformer())->toArray();
		return $this->respondWithSuccess($result ,'Get list experience successful');
	}

	/**
     * @SWG\Post(
     *   path="/experience/delete",
     *   summary="Experience delete",
     *   operationId="api.experience.delete",
     *   produces={"application/json"},
     *   tags={"Experience"},
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="",
     *     required=true,
     *    @SWG\Schema(example={
     *		 "id"	: "1",
     *      })
     *   ),
     * @SWG\Response(response=200, description="Server is OK!"),
     * @SWG\Response(response=500, description="Internal server error!"),
     *   security={
     *       {"userToken": {}}
     *   }
     * )
     */

	public function delete(Request $request){
		$user = $this->getUser();
		if(!$user){
			return $this->respondWithError('Error! User not found');
		}
		$experience = Experience::where(['id' => $request->id ,'user_id' => $user->id])->first();
		if(!$experience){
			return $this->respondWithError('Error! Experience not found');
		}
		$experience->delete();
		return $this->respondWithSuccess($experience ,'Deleted experience successful');
	}
}
