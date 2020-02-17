<?php
namespace GD\Api\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GD\Api\Traits\CanFindUserWithBearerToken;
class CanAccessMiddleware
{
    /**
     * @var GD\Api\Traits\CanFindUserWithBearerToken
     */
    use CanFindUserWithBearerToken;
    
    public function handle(Request $request, \Closure $next){
        $checkAuthenticate = $this->findUserWithBearerToken($request->header('Authorization'));
        if ($request->header('Authorization') === null || $checkAuthenticate === null) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 403,
                    'message' => 'Unauthorized',
                    'data' => [],
                ], 200);
            }
            else{
                return new Response('Forbidden', 403);
            }
        }
        return $next($request);
    }
}
