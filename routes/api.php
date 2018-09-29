<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/topics','TopicsController@index')->middleware('api');

Route::post('/question/follower',function (Request $request){
    $user = Auth::guard('api')->user();
    if($user->followed($request->get('question'))){
        return response()->json(['followed' => true ]);
    }
    return response()->json(['followed' => false ]);

})->middleware('auth:api');

Route::post('/question/follow',function (Request $request){
    $user = Auth::guard('api')->user();

    $question = \App\Question::find($request->get('question'));
    $followed = $user->followThis($question->id);

    if(count($followed['detached']) > 0) {
        $question->decrement('followers_count');
        return response()->json(['followed' => false ]);
    }
    $question->increment('followers_count');
    return response()->json(['followed' => true ]);

})->middleware('auth:api');

Route::get('/user/followers/{id}','FollowersController@index');
Route::post('/user/follow','FollowersController@follow');

Route::post('/answer/{id}/votes/users','VotesController@users');
Route::post('/answer/vote','VotesController@vote');

Route::post('/message/store','MessagesController@store');

Route::get('answer/{id}/comments','CommentsController@answer');
Route::get('question/{id}/comments','CommentsController@question');

Route::post('comment','CommentsController@store');










