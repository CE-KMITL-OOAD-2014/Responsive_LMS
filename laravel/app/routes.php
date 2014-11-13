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

Route::get('/test/user_is_admin','Test@userIsAdmin');
Route::get('/test/search_exclude_delUser','Test@searchExcludeDelUser');
Route::get('/testmethod/',function(){
          $method='search';
			$condition['word']='';
			$currentPage=1;
            $tmp=unserialize(Cookie::get('user',null));
            if(!Admin::userIsAdmin($tmp)){
                return Redirect::to('/');
            }
            $condition = Input::get('condition');
            $currentPage = Input::get('currentPage');
            if($method=='search'){
                $table_subject = Subject::search($condition,$currentPage);
                $day = array('อา. ','จ. ','อ. ','พ. ','พฤ. ','ศ. ','ส. ');
                $output = '';
                for ($i=0;$i<count($table_subject);$i++) {
                      $output.= '<tr>   
                                    <td>'.$table_subject[$i]->{'id_subject'}.'</td>   
                                    <td>'.$table_subject[$i]->{'name'}.'</td>
                                    <td>'.$table_subject[$i]->{'group'}.'</td>    
                                    <td>'. $day[$table_subject[$i]->{'day'}].substr($table_subject[$i]->{'start_at'},0,5).' - '.substr($table_subject[$i]->{'end_at'},0,5).'</td>
                                    <td>'.$table_subject[$i]->{'room'}.'</td>
                                    <td><div class="btn-group">
                                     <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                           <li><a href="'.url('view_edit_subject/'.$table_subject[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
                                           <li><a href="'.url('subject_add_teacher/'.$table_subject[$i]->{'ID'}).'">เพิ่มอาจารย์</a></li>
                                           <li><a href="'.url('subject_add_student/'.$table_subject[$i]->{'ID'}).'">เพิ่มนักศึกษา</a></li>
                                            <li><a href="'.url('delete_user_subject/'.$table_subject[$i]->{'ID'}).'">ลบผู้ใช้งาน</a></li>
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

