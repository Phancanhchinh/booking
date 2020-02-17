<?php
Route::prefix('api')->group(function(){
	Route::prefix('auth')->group(function(){
		Route::post('/login' ,'V1\AuthController@login');
		Route::post('/sign-up' ,'V1\AuthController@signUp');
		Route::post('/active' ,'V1\AuthController@active');
		Route::post('/forgot-password' ,'V1\AuthController@forgotPassword')->name('api.forgotPassword');
		Route::post('/new-password' ,'V1\AuthController@newPassword')->name('api.newPassword');
	});
	Route::middleware(['api'])->prefix('auth')->group(function(){
		Route::get('/get-infor','V1\AuthController@getInfor');
	});

	Route::prefix('account')->group(function(){
		Route::post('update-profile' ,'V1\AccountController@updateProfile')->name('api.updateProfile');
		Route::post('change-password' ,'V1\AccountController@changePass')->name('api.changePass');
	});

	Route::prefix('experience')->group(function(){
		Route::post('/create','V1\ExperienceController@create')->name('api.experience.create');
		Route::post('/update','V1\ExperienceController@update')->name('api.experience.update');
		Route::get('/get','V1\ExperienceController@get')->name('api.experience.get');
		Route::post('/delete','V1\ExperienceController@delete')->name('api.experience.delete');
	});

	Route::prefix('follow')->group(function(){
		Route::post('/new' ,'V1\FollowController@newFollow')->name('api.newFollow');
		Route::get('/list' ,'V1\FollowController@listFollow')->name('api.listFollow');
		Route::post('/unfollow' ,'V1\FollowController@unFollow')->name('api.unFollow');
	});
	Route::prefix('post')->group(function(){
        Route::get('/get-all-post' ,'V1\PostController@getAllPost')->name('api.getAllPost');
        Route::get('/get-all-post-by-user' ,'V1\PostController@getAllPostByUser')->name('api.getAllPostByUser');
		Route::post('/create' ,'V1\PostController@createPost')->name('api.createPost');
		Route::post('/update' ,'V1\PostController@updatePost')->name('api.updatePost');
        Route::post('/delete','V1\PostController@deletePost')->name('api.deletePost');
        Route::post('/delete-post-by-user','V1\PostController@deletePostByUser')->name('api.deletePostByUser');
        Route::post('/register-work','V1\PostController@register')->name('api.register');
	});

	Route::prefix('comment')->group(function(){
		Route::post('/create','V1\CommentController@createComment')->name('api.createComment');
		Route::get('/get-all-comment','V1\CommentController@getAllCommentByPost')->name('api.getAllCommentByPost');
		Route::post('/update','V1\CommentController@updateComment')->name('api.updateComment');
		Route::post('/delete','V1\CommentController@deleteComment')->name('api.deleteComment');
    });

    Route::prefix('reply')->group(function(){
		Route::post('/create','V1\CommentReplyController@createReply')->name('api.createReply');
		Route::post('/get-all-reply','V1\CommentReplyController@getAllReplyByCommentId')->name('api.getAllReplyByCommentId');
		Route::post('/update','V1\CommentReplyController@updateReply')->name('api.updateReply');
		Route::post('/delete','V1\CommentReplyController@deleteReply')->name('api.deleteReply');
	});
});
