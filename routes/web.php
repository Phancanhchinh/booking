<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Entrust 
Route::group(['middleware' => ['auth']], function() {


	Route::get('/home', 'HomeController@index');


	Route::resource('users','UserController');


	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);


	Route::get('itemCRUD2',['as'=>'itemCRUD2.index','uses'=>'ItemCRUD2Controller@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
	Route::get('itemCRUD2/create',['as'=>'itemCRUD2.create','uses'=>'ItemCRUD2Controller@create','middleware' => ['permission:item-create']]);
	Route::post('itemCRUD2/create',['as'=>'itemCRUD2.store','uses'=>'ItemCRUD2Controller@store','middleware' => ['permission:item-create']]);
	Route::get('itemCRUD2/{id}',['as'=>'itemCRUD2.show','uses'=>'ItemCRUD2Controller@show']);
	Route::get('itemCRUD2/{id}/edit',['as'=>'itemCRUD2.edit','uses'=>'ItemCRUD2Controller@edit','middleware' => ['permission:item-edit']]);
	Route::patch('itemCRUD2/{id}',['as'=>'itemCRUD2.update','uses'=>'ItemCRUD2Controller@update','middleware' => ['permission:item-edit']]);
	Route::delete('itemCRUD2/{id}',['as'=>'itemCRUD2.destroy','uses'=>'ItemCRUD2Controller@destroy','middleware' => ['permission:item-delete']]);

	Route::get('/2fa','PasswordSecurityController@show2faForm');
	Route::post('/generate2faSecret','PasswordSecurityController@generate2faSecret')->name('generate2faSecret');
	Route::post('/2fa','PasswordSecurityController@enable2fa')->name('enable2fa');
	Route::post('/disable2fa','PasswordSecurityController@disable2fa')->name('disable2fa');

});

//Mail
Route::get('email-test','EmailController@sendEmail');

//Select2 Tag
Route::get('/select2-load-more','Select2Controller@select2LoadMore');

//Tagging with Select2
Route::get('articles/list','ArticleController@index')->name('article.index');
Route::get('articles','ArticleController@create')->name('article.create');
Route::post('articles','ArticleController@store');
Route::get('articles/{id}','ArticleController@edit')->name('article.edit');
Route::post('articles/{id}','ArticleController@update')->name('article.update');
Route::delete('articles/{id}/delete','ArticleController@destroy')->name('article.destroy');

//Multiple Languages
Route::get('welcome/{locale}',function($locale){
	App::setLocale($locale);
	return view('languague.index');
});

//Collection
//unique()
Route::get('hello',function(){
	$collection = collect([1,2,2,2,3]);
	$counted = $collection->unique();
	dd($counted->all());
});

//Repositories
Route::get('user/list','UserController@index')->name('user.index');
Route::get('user/{id}/show','UserController@show')->name('user.show');
Route::delete('delete/{id}','UserController@delete')->name('user.destroy');

//Return Json
Route::get('allJson',function(){
	$users = App\User::get();
	dd($users);
	//Response::Json($user);
	return response()->json($users);
	
});

//Charts
Route::get('/chart1','ChartController@chart1');

Route::get('/gg2faregister','RegisterController@register')->name('gg2faregister');