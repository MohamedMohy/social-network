<?php

use App\Http\Controllers\UserController;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'PostsController@create');
//Route::get('/profile', 'UserController@index')->name('profile');
Route::get('/friends', 'UserController@friends')->name('friends');
Route::get('/profile/{id?}', 'UserController@index')->name('profile');
Route::get('/listingUsers','UserController@listingUsers')->name('listingUsers');
Route::post('/profile/{id?}', 'UserController@update');
Route::get('/like/{id}/{postid}','LikesController@create')->name('like');
Route::get('/unlike/{id}/{postid}','LikesController@destroy')->name('unlike');
Route::post('/comment/{id}/{postid}/{ProfileOwnerId}','CommentsController@create')->name('like');
Route::get('/friendship/{recipientid}','UserController@sendfriendrequest')->name('friendship');
Route::get('/deletepost/{postid}','PostsController@delete')->name('deletepost');
Route::get('/notifications', 'UserController@notifications');





