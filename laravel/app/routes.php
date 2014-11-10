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
Route::get('/search_subject/{method}','AdminController@searchSubject');
Route::get('/subject_add_teacher/{id}','AdminController@subjectAddTeacher');
Route::get('/subject_add_student/{id}','AdminController@subjectAddStudent');
Route::get('/view_edit_user_admin/{id}','AdminController@viewEditAdmin');
Route::get('/view_edit_user_student/{id}','AdminController@viewEditStudent');
Route::get('/view_edit_user_teacher/{id}','AdminController@viewEditTeacher');
Route::get('/view_edit_subject/{id}','AdminController@viewEditSubject');
Route::get('/delete_user_admin/{id}','AdminController@deleteAdmin');
Route::get('/delete_user_student/{id}','AdminController@deleteStudent');
Route::get('/delete_user_teacher/{id}','AdminController@deleteTeacher');
Route::post('/user_management/edit/admin','AdminController@userEdit');
Route::post('/user_management/waitting/admin','AdminController@userWaitting');
Route::post('/add_subject','AdminController@addSubject');
Route::post('/edit_subject','AdminController@editSubject');
Route::post('/delete_subject','AdminController@deleteSubject');

Route::post('/subject_edit_teacher','AdminController@subjectEditTeacher');
Route::get('/test/user_is_admin','Test@userIsAdmin');
Route::get('/test/search_exclude_delUser','Test@searchExcludeDelUser');

Route::get('/testmethod/',function(){
	Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$condition['word'] = '';
			$currentPage = '1';
			$method = 'search';
			if($method=='search'){
				$table_assignment = Assignment::search($condition,$currentPage,$id_subj);
				$output = '';
				for ($i=0;$i<count($table_assignment);$i++) {
	    			  $output.= '<tr>   
	    			 			    <td>'.$table_assignment[$i]->{'date_at'}.'</td>   
								 	<td>'.$table_assignment[$i]->{'id_assignment'}.'</td>
						            <td>'.$table_assignment[$i]->{'title'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('view_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						  	               <li><a href="'.url('/'.$table_assignment[$i]->{'ID'}).'">ดูงานที่ส่ง</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
			return $output;
			}
});
Route::get('/info', function(){
	phpinfo();
});
Route::get('/teacher','TeacherController@showHome' );
Route::get('/teacher/{page}','TeacherController@showPage' );
Route::post('/teacher/action_lms','TeacherController@actionLMS' );
Route::post('/teacher/teacher_edit','TeacherController@teacherEdit' );
Route::get('/teacher/search_assignment/{method}','TeacherController@searchAssignment' );
Route::get('/teacher/view_assignment/{id}','TeacherController@viewAssignment' );
Route::post('/teacher/add_assignment','TeacherController@addAssignment');
Route::get('/teacher/submit_assignment/{id}','TeacherController@submitAssignment' );