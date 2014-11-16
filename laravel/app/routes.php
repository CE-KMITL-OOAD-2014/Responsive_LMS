<?php
	//require_once 'sdkazure\vendor\microsoft\windowsazure\WindowsAzure\WindowsAzure.php';
	//require_once 'sdkazure\vendor\autoload.php';

	//use WindowsAzure\Common\ServicesBuilder;
	//use WindowsAzure\Common\ServiceException;
	//use windowsAzure\blob\models\createcontaineroptions;
	//use windowsAzure\blob\models\PublicAccessType;
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
Route::post('/user_management/edit/teacher','TeacherController@userEdit');
Route::post('/user_management/waitting/teacher','TeacherController@userWaitting');
Route::post('/user_management/edit/student','StudentController@userEdit');
Route::post('/user_management/waitting/student','StudentController@userWaitting');
Route::post('/add_subject','AdminController@addSubject');
Route::post('/edit_subject','AdminController@editSubject');
Route::get('/delete_subject/{id}','AdminController@deleteSubject');
Route::post('admin_delete_subject','AdminController@AdmindeleteSubject');
Route::post('/subject_edit_teacher','AdminController@subjectEditTeacher');
Route::post('/subject_edit_student','AdminController@subjectEditStudent');
Route::get('/test/user_is_admin','Test@userIsAdmin');
Route::get('/test/search_exclude_delUser','Test@searchExcludeDelUser');

Route::get('/test',function(){
	$file =fopen("https://rpslmssr.blob.core.windows.net/docs/2014-11-13%2017:27:123%20Numerical%20Methods.pdf","r");
	//$file ="https://rpslmssr.blob.core.windows.net/docs/2014-11-13%2017:27:123%20Numerical%20Methods.pdf";
	$contents = stream_get_contents($file);
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=test.pdf");
	return  $contents;
	
});
Route::get('/testmethod/create_container',function(){

	$connectionString = "DefaultEndpointsProtocol=http;AccountName=rpslmssr;AccountKey=NJ7zmjCLPbw6n7ySPWZRQ0EgR48jjzolffMpMApBVPl2yYfOqgfz0To4C57/lAACSrGL/1AElzeIuwbc6lJNTA==";
	$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
	$createContainerOptions = new CreateContainerOptions();
	$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
	$createContainerOptions->addMetaData("key1", "value1");
	try {
		$blobRestProxy->createContainer("docs", $createContainerOptions);
				echo "Container 'docs' created. ";
	}
	catch(ServiceException $e){
		$code = $e->getCode();
		$error_message = $e->getMessage();
		echo $code.": ".$error_message."<br />";
	}
	$blobRestProxy  = null;

});
Route::get('/testmethod/showfile',function(){
		$connectionString = "DefaultEndpointsProtocol=http;AccountName=rpslmssr;AccountKey=NJ7zmjCLPbw6n7ySPWZRQ0EgR48jjzolffMpMApBVPl2yYfOqgfz0To4C57/lAACSrGL/1AElzeIuwbc6lJNTA==";
	$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
	try {
	// List blobs.
		$blob_list = $blobRestProxy->listBlobs("pictures");
		$blobs = $blob_list->getBlobs();
		echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
		foreach($blobs as $blob)
		{
			echo "
			<tr>
			<td width=\"100\">".$blob->getName()."</td>
			<td width=\"400\">".$blob->getUrl()."</td>
			</tr> ";
		}
		echo "</table>";
	}
	catch(ServiceException $e){
	// Handle exception based on error codes and messages.
	// Error codes and messages are here:
	// http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
	$code = $e->getCode();
	$error_message = $e->getMessage();
	echo $code.": ".$error_message."<br />";
	}
	$blobRestProxy  = null;
});
Route::get('/testmethod/savefile',function(){
	$connectionString = "DefaultEndpointsProtocol=http;AccountName=rpslmssr;AccountKey=NJ7zmjCLPbw6n7ySPWZRQ0EgR48jjzolffMpMApBVPl2yYfOqgfz0To4C57/lAACSrGL/1AElzeIuwbc6lJNTA==";
	$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
	$content = fopen("./LegoCE.png", "r");
	$blob_name = "win.jpg";
	try {
		$blobRestProxy->createBlockBlob("pictures", $blob_name, $content);
			echo "'$blob_name' has been uploaded.";
	}
	catch(ServiceException $e){
		$code = $e->getCode();
		$error_message = $e->getMessage();
		echo $code.": ".$error_message."<br />";
	}
});
Route::get('/info', function(){
	phpinfo();
});
Route::get('/teacher','TeacherController@showHome');
Route::get('/teacher/{page}','TeacherController@showPage' );
Route::post('/teacher/action_lms','TeacherController@actionLMS' );
Route::post('/teacher/teacher_edit','TeacherController@teacherEdit' );
Route::get('/teacher/search_assignment/{method}','TeacherController@searchAssignment' );
Route::get('/teacher/view_assignment/{id}','TeacherController@viewAssignment' );
Route::post('/teacher/add_assignment','TeacherController@addAssignment');
Route::get('/teacher/submit_assignment/{id}','TeacherController@submitAssignment' );
Route::post('/teacher/add_study','TeacherController@addStudy');
Route::get('/teacher/search_study/{method}','TeacherController@searchStudy' );
Route::post('/teacher/add_message','TeacherController@addMessage' );
Route::get('/teacher/class_status/{id}','TeacherController@viewClassStatus');
Route::get('/teacher/class_assess/{id}','TeacherController@viewClassAssess');
Route::get('/teacher/view_message/{id}','TeacherController@viewMessage' );
Route::get('/teacher/search_message/{method}','TeacherController@searchMessage' );
Route::get('/teacher/download_file_assignment/{id}','TeacherController@downloadFileAssignment');
Route::get('/teacher/download_file_absent/{id}','TeacherController@downloadFileAbsent');
Route::get('/teacher/search_absentletter/{method}','TeacherController@searchAbsentletter' );
Route::get('/teacher/view_absentletter/{id}','TeacherController@viewAbsentletter' );
Route::get('/teacher/action_approve/{id}','TeacherController@actionApprove' );
Route::get('/teacher/action_unapprove/{id}','TeacherController@actionUnApprove' );
Route::get('/teacher/search_submit_assignment/{method}','TeacherController@searchSubmitAssignment' );
Route::get('/teacher/view_submit_assignment/{id}','TeacherController@viewSubmitAssignment' );
Route::post('/teacher/edit_submit_assignment','TeacherController@editSubmitAssignment');
Route::get('/student/s_score','StudentController@score' );
Route::get('/student/s_class_status/{id}','StudentController@setClassStatus');
Route::get('/student/s_class_assess/{id}','StudentController@setClassAssess');
Route::get('student/set_class_status/{id}/{i}','StudentController@setClassStatusAction');
Route::get('student/set_class_assess/{id}','StudentController@setClassAssessAction');
Route::get('/student','StudentController@showHome');
Route::get('/student/{page}','StudentController@showPage' );
Route::post('/student/action_lms','StudentController@actionLMS' );
Route::get('/student/search_assignment/{method}','StudentController@searchAssignment' );
Route::get('/student/view_assignment/{id}','StudentController@viewAssignment' );
Route::get('/student/search_study/{method}','StudentController@searchStudy' );
Route::post('/student/add_message','StudentController@addMessage' );
Route::get('/student/search_message/{method}','StudentController@searchMessage' );
Route::get('/student/view_message/{id}','StudentController@viewMessage' );
Route::post('/student/add_absentletter','StudentController@addAbsentletter' );
Route::get('/student/view_add_submit_assignment/{id}','StudentController@viewAddSubmitAssignment' );
Route::post('/student/add_submit_assignment','StudentController@addSubmitAssignment' );
Route::get('/student/search_absentletter/{method}','StudentController@searchAbsentletter' );
