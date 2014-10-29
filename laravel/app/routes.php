<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','Authen@showHome');
Route::get('/login', 'Authen@showLogin');
Route::get('/logout', 'Authen@logout');
Route::post('/action_login','Authen@actionlogin' );
Route::get('/admin','AdminController@showHome' );
Route::get('/admin/{page}','AdminController@showPage' );
Route::post('/admin_add/{page}','AdminController@addUser' );
Route::post('/admin_edit/{page}','AdminController@editUser' );
Route::post('/admin_delete/{page}','AdminController@deleteUser' );
Route::get('/search_admin/{method}','AdminController@searchAdmin');
Route::get('/search_student/{method}','AdminController@searchStudent');
Route::get('/search_teacher/{method}','AdminController@searchTeacher');
Route::get('/view_edit_user_admin/{id}','AdminController@viewEditAdmin');
Route::get('/view_edit_user_student/{id}','AdminController@viewEditStudent');
Route::get('/view_edit_user_teacher/{id}','AdminController@viewEditTeacher');
Route::get('/delete_user_admin/{id}','AdminController@deleteAdmin');
Route::get('/delete_user_student/{id}','AdminController@deleteStudent');
Route::get('/delete_user_teacher/{id}','AdminController@deleteTeacher');
Route::post('/user_management/edit/admin','AdminController@userEdit');
Route::post('/user_management/waitting/admin','AdminController@userWaitting');
Route::get('/test/user_is_admin','Test@userIsAdmin');
Route::get('/test/search_exclude_delUser','Test@searchExcludeDelUser');
Route::get('/info', function(){
	phpinfo();
});

