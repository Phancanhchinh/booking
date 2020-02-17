<?php
namespace GD\Api\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class BaseServiceProvider extends ServiceProvider{

	protected $commands = [

    ];

    protected $routeMiddleware = [
        'api' => \GD\Api\Http\Middleware\CanAccessMiddleware::class,
    ];

	protected $registerProvider = [
        \GD\Api\Providers\RouteServiceProvider::class,
        \GD\Api\Providers\EventServiceProvider::class,
    ];

	function boot(){
		$this->registerAppServices();
		$this->loadViewsFrom(__DIR__ .'/../../src/views','api');
	}

	function register(){
        $this->commands($this->commands);
        $this->registerRouteMiddleware();
	}
    

    //boot
	protected function registerAppServices(){
        foreach ($this->registerProvider as $value) {
            $this->app->register($value);
        }
    }
    //register
    protected function registerRouteMiddleware()
    {
        foreach ($this->routeMiddleware as $key => $value) {
            app('router')->aliasMiddleware($key, $value);
        }
    }

}