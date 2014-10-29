<?php

class Authen extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome(){
		$tmp=unserialize(Cookie::get('user',null));
		if ($tmp==null)
		{
			return Redirect::to('/login');
		}
		if($tmp->getStatus()=='9'){
			return Redirect::to('/admin');
		}
		if($tmp->getStatus()=='1'){
			return 'teacher';
		}
		if($tmp->getStatus()=='0'){
			return 'student';
		}

	//phpinfo();
	}
	public function showLogin(){
		if(Cookie::get('user',null)!=null){
			return Redirect::to('/');
		}
		return View::make('login');
	}
	public function logout(){
		$cookie=Cookie::forget('user');
		return Redirect::to('/')->withCookie($cookie);
	}
	public function actionlogin(){
		$user_id=Input::get('user_id');
		$user_password=md5(Input::get('user_password'));
		$user_tmp = Users::getFromUserPass($user_id,$user_password);
		if($user_tmp!=NULL){
			if($user_tmp->getStatus()=='9'){
				$user_tmp = Admin::getFromUserPass($user_id,$user_password);
				if($user_tmp!=NULL){
					if($user_tmp->getStatus_del()=='0'){
						Cookie::queue('user',serialize($user_tmp),120);
					}
				}
			}
						
		}

		return Redirect::to('/');
	}
}