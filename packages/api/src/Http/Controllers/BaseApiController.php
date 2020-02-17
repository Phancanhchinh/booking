<?php
namespace GD\Api\Http\Controllers;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response as Res;
use Illuminate\Http\Request;
use GD\Api\Traits\CanFindUserWithBearerToken;
/**
 * @SWG\Swagger(
 *      schemes={L5_SWAGGER_CONST_HTTP},
 *      basePath="/api",
 *      @SWG\Info(
 *          version="1.0.0",
 *          title="Booking Event 🎄",
 *          description="L5 Swagger API",
 *      )
 *  ),
 *  @SWG\SecurityScheme(
 *    securityDefinition="userToken",
 *    type="apiKey",
 *    in="header",
 *    name="Authorization",
 *  )
 */
class BaseApiController extends Controller{

	use CanFindUserWithBearerToken;

	protected $statusCode = Res::HTTP_OK;

	public function respondWithSuccess($data = null ,$message = 'Action Successfully'){
        if(isset($data['data'])){
            $data = $data['data'];
        }
        return $this->respond([
            'status' 	  => 'success',
            'status_code' => Res::HTTP_OK,
            'message' 	  => $message,
            'data' 		  => $data
        ]);
    }

    public function respond($data, $headers = []){
        if(isset($data['data']['data'])){
            $data['paginator'] = $data['data']['paginator'];
            $data['data'] = $data['data']['data'];
        }
        return Response::json($data, 200, $headers);
    }

    public function respondWithError($message){
        return $this->respond([
            'status' 	  => 'error',
            'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
            'message' 	  => $message,
        ]);
    }
    public function getUser(){
        return $this->findUserWithBearerToken(request()->header('Authorization'));
    }
}
