<?php

	class AdminController extends BaseController {
		public function showHome(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			return View::make('admin')->with('active', array('active','','','',''));
		}
		public function showPage($page){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			$active = array('','','','','');
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			else if($page=='user_teacher' || $page=='user_student' || $page=='user_admin' 
				|| $page=='add_user_admin'|| $page=='add_user_student'|| $page=='add_user_teacher'){
				$active = array('','active','','','');
			}
			else if($page=='subject' || $page=='add_subject'){
				$active = array('','','active','','');
			}
			else if( $page=='relationship' ){
				$active = array('','','','active','');
			}
			else if($page=='user_management_admin'){
				$active = array('','','','','active');
			}
			return View::make($page)->with('active', $active);
		}
		public function addUser($type){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			if($type=='admin'){
				$userInput = new Admin;
				$userInput->setUsername(Input::get('username'));
				$userInput->setPassword(md5(Input::get('password')));
				$userInput->setTitle(Input::get('title'));
				$userInput->setName(Input::get('name'));
				$userInput->setSurname(Input::get('surname'));
				$userInput->setStatus('9');
				$userInput->setEmail(Input::get('email'));
				$userInput->setTelephone(Input::get('telephone'));
				$userInput->setPosition(Input::get('position'));
				$userInput->setStatus_del('0');
				$userInput->setDetail_delete(Input::get('detail_delete'));
				$tmp->addAdmin($userInput);
				return Redirect::to('admin/user_admin');

			}
			else if($type=='student'){
				$userInput = new Student;
				$userInput->setUsername(Input::get('username'));
				$userInput->setPassword(md5(Input::get('password')));
				$userInput->setId_student(Input::get('id_student'));
				$userInput->setAdviser(Input::get('adviser'));
				$userInput->setTitle(Input::get('title'));
				$userInput->setNickname(Input::get('nickname'));
				$userInput->setName(Input::get('name'));
				$userInput->setSurname(Input::get('surname'));
				$userInput->setStatus('0');
				$userInput->setBirthday_at(Input::get('birthday_at'));
				$userInput->setSex(Input::get('sex'));
				$userInput->setAcademy(Input::get('academy'));
				$userInput->setYearadmission(Input::get('yearadmission'));
				$userInput->setFaculty(Input::get('faculty'));
				$userInput->setStudent_status(Input::get('student_status'));
				$userInput->setDepartment(Input::get('department'));
				$userInput->setMajor(Input::get('major'));		
				$userInput->setStatus_del('0');
				$userInput->setDetail_delete(Input::get('detail_delete'));
				$userInput->setSubjects(NULL);
				$tmp->addStudent($userInput);
				return Redirect::to('admin/user_student');

			}
			else if($type=='teacher'){
				$userInput = new Teacher;
				$userInput->setUsername(Input::get('username'));
				$userInput->setPassword(md5(Input::get('password')));
				$userInput->setTitle(Input::get('title'));
				$userInput->setName(Input::get('name'));
				$userInput->setSurname(Input::get('surname'));
				$userInput->setStatus('1');
				$userInput->setEmail(Input::get('email'));
			 	$userInput->setName_user(Input::get('name_user'));
				$userInput->setTelephone(Input::get('telephone'));
				$userInput->setRoom(Input::get('room'));
				$userInput->setHistory(Input::get('history'));
				$userInput->setExperience(Input::get('experience'));
				$userInput->setStatus_del('0');
				$userInput->setDetail_delete(Input::get('detail_delete'));
				$userInput->setSubjects(NULL);
				$tmp->addTeacher($userInput);
				return Redirect::to('admin/user_teacher');


			}
		}
		public function addSubject(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$input = new Subject;
			$input->setId_subject(Input::get('id_subject'));
			$input->setName(Input::get('name'));
			$input->setGroup(Input::get('group'));

			$input->setStart_at(Input::get('start_at'));
			$input->setEnd_at(Input::get('end_at'));
			$input->setDay(Input::get('day'));
   
			$input->setRoom(Input::get('room'));
			$input->setBuild(Input::get('build'));
			$input->setDetail_thai(Input::get('detail_thai'));
			$input->setDetail_eng(Input::get('detail_eng'));
			$tmp->addSubject($input);
			return Redirect::to('admin/subject');
		}
		public function editUser($type){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if($tmp==NULL || $tmp->getStatus()!= '9'){
				return Redirect::to('/');
			}
			if($type=='admin'){
				$userInput = Admin::getFromId(Input::get('id'));
				$userInput->setUsername(Input::get('username'));
				if(strlen(Input::get('password'))>0){
					$userInput->setPassword(md5(Input::get('password')));
				}
				$userInput->setTitle(Input::get('title'));
				$userInput->setName(Input::get('name'));
				$userInput->setSurname(Input::get('surname'));
				$userInput->setStatus('9');
				$userInput->setEmail(Input::get('email'));
				$userInput->setTelephone(Input::get('telephone'));
				$userInput->setPosition(Input::get('position'));
				//$userInput->setStatus_del('0');
				//$userInput->setDetail_delete(Input::get('detail_delete'));
				$tmp->editAdmin($userInput);
				return Redirect::to('admin/user_admin');
			}

			else if($type=='student'){
				$userInput = Student::getFromId(Input::get('id'));
				$userInput->setUsername(Input::get('username'));
				if(strlen(Input::get('password'))>0){
					$userInput->setPassword(md5(Input::get('password')));
				}
				$userInput->setId_student(Input::get('id_student'));
				$userInput->setAdviser(Input::get('adviser'));
				$userInput->setTitle(Input::get('title'));
				$userInput->setNickname(Input::get('nickname'));
				$userInput->setName(Input::get('name'));
				$userInput->setSurname(Input::get('surname'));
				$userInput->setStatus('0');
				$userInput->setBirthday_at(Input::get('birthday_at'));
				$userInput->setSex(Input::get('sex'));
				$userInput->setAcademy(Input::get('academy'));
				$userInput->setYearadmission(Input::get('yearadmission'));
				$userInput->setFaculty(Input::get('faculty'));
				$userInput->setStudent_status(Input::get('student_status'));
				$userInput->setDepartment(Input::get('department'));
				$userInput->setMajor(Input::get('major'));		
				//$userInput->setStatus_del('0');
				//$userInput->setDetail_delete(Input::get('detail_delete'));
				//$userInput->setSubjects(Input::get('subjects'));
				$tmp->editStudent($userInput);
				return Redirect::to('admin/user_student');

			}
			else if($type=='teacher'){
				Authen::refresh();
				$userInput = Teacher::getFromId(Input::get('id'));
				$userInput->setUsername(Input::get('username'));
				if(strlen(Input::get('password'))>0){
					$userInput->setPassword(md5(Input::get('password')));
				}
				$userInput->setTitle(Input::get('title'));
				$userInput->setName(Input::get('name'));
				$userInput->setSurname(Input::get('surname'));
				$userInput->setStatus('1');
				$userInput->setName_user(Input::get('name_user'));
				$userInput->setEmail(Input::get('email'));
				$userInput->setTelephone(Input::get('telephone'));
				$userInput->setRoom(Input::get('room'));
				$userInput->setHistory(Input::get('history'));
				$userInput->setExperience(Input::get('experience'));

				//$userInput->setStatus_del('0');
				//$userInput->setDetail_delete(Input::get('detail_delete'));
				//$userInput->setSubjects(Input::get('subjects'));
				$tmp->editTeacher($userInput);
				return Redirect::to('admin/user_teacher');

			}


		}
		public function editSubject(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if($tmp==NULL || $tmp->getStatus()!= '9'){
				return Redirect::to('/');
			}
			$subjInput = Subject::getFromId(Input::get('id'));
			$subjInput->setId_subject(Input::get('id_subject'));
			$subjInput->setName(Input::get('name'));
			$subjInput->setGroup(Input::get('group'));
			$subjInput->setRoom(Input::get('room'));
			$subjInput->setBuild(Input::get('build'));
			$subjInput->setStart_at(Input::get('start_at'));
			$subjInput->setEnd_at(Input::get('end_at'));
			$subjInput->setDay(Input::get('day'));
			$subjInput->setDetail_thai(Input::get('detail_thai'));
			$subjInput->setDetail_eng(Input::get('detail_eng'));
			$tmp->editSubject($subjInput);
			return Redirect::to('admin/subject');
		}

		public function deleteUser($type){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			if($type=='admin'){
				$userInput = Admin::getFromId(Input::get('id'));
				$detail_delete = Input::get('detail_delete');
				$tmp->delAdmin($userInput,$detail_delete);
				return Redirect::to('admin/user_admin');

			}
			if($type=='student'){
				$userInput = Student::getFromId(Input::get('id'));
				$detail_delete = Input::get('detail_delete');
				$tmp->delStudent($userInput,$detail_delete);
				return Redirect::to('admin/user_student');

			}
			if($type=='teacher'){
				$userInput = Teacher::getFromId(Input::get('id'));
				$detail_delete = Input::get('detail_delete');
				$tmp->delTeacher($userInput,$detail_delete);
				return Redirect::to('admin/user_teacher');

			}
		}
		public function searchAdmin($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_admin = Admin::search($condition,$currentPage);

				$output = '';
				for ($i=0;$i<count($table_admin);$i++) {
	    			  $output.= '<tr>   
	    			 				 <td>'.$table_admin[$i]->{'username'}.'</td>   
								 	<td>'.$table_admin[$i]->{'title'}.'</td>
						            <td>'.$table_admin[$i]->{'name'}.'</td>
						            <td>'.$table_admin[$i]->{'surname'}.'</td>    
									<td>'.$table_admin[$i]->{'email'}.'</td>
									<td>'.$table_admin[$i]->{'telephone'}.'</td>
									<td>'.$table_admin[$i]->{'position'}.'</td>*/
									<td><div class="btn-group">
						                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						                  <li><a href="'.url('view_edit_user_admin/'.$table_admin[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						                  <li><a href="'.url('delete_user_admin/'.$table_admin[$i]->{'ID'}).'">ลบผู้ใช้งาน</a></li>
						                </ul>
						              </div></td>
						          </tr>    ';

				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Admin::getLastpage($condition);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Admin::getCount($condition);
			}
		}
		public function searchStudent($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_student = Student::search($condition,$currentPage);
				$output = '';
				for ($i=0;$i<count($table_student);$i++) {
	    			  $output.= '<tr>   
	    			 				 <td>'.$table_student[$i]->{'username'}.'</td>   
								 	<td>'.$table_student[$i]->{'id_student'}.'</td>
						            <td>'.$table_student[$i]->{'title'}.'</td>
						            <td>'.$table_student[$i]->{'name'}.'</td>    
									<td>'.$table_student[$i]->{'surname'}.'</td>
									<td>'.$table_student[$i]->{'faculty'}.'</td>
									<td>'.$table_student[$i]->{'department'}.'</td>*/
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('view_edit_user_student/'.$table_student[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						 	                <li><a href="'.url('delete_user_student/'.$table_student[$i]->{'ID'}).'">ลบผู้ใช้งาน</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Student::getLastpage($condition);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Student::getCount($condition);
			}
			if($method=='search_subject_add'){
				$table_student = Student::search($condition,$currentPage);
				$output = '';
				for ($i=0;$i<count($table_student);$i++) {
	    			  $output.= '<tr id="table'.$table_student[$i]->{'ID'}.'">   

	    			 			    <td>'.$table_student[$i]->{'id_student'}.'</td>   
								 	<td>'.$table_student[$i]->{'title'}.'</td>
						            <td>'.$table_student[$i]->{'name'}.'</td>    
									<td>'.$table_student[$i]->{'surname'}.'</td>
									<td>'.$table_student[$i]->{'faculty'}.'</td>
									<td>'.$table_student[$i]->{'department'}.'</td>
									<td><div class="btn-group">
						             <button type="button" id="'.$table_student[$i]->{'ID'}.'" onclick="add_student(\''.$table_student[$i]->{'ID'}.'\');"  class="btn btn-primary addstudent">เพิ่มไปยังวิชา</button>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
		}
		public function searchTeacher($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_teacher = Teacher::search($condition,$currentPage);
				$output = '';
				for ($i=0;$i<count($table_teacher);$i++) {
	    			  $output.= '<tr>   
	    			 			    <td>'.$table_teacher[$i]->{'username'}.'</td>   
								 	<td>'.$table_teacher[$i]->{'title'}.'</td>
						            <td>'.$table_teacher[$i]->{'name'}.'</td>    
									<td>'.$table_teacher[$i]->{'surname'}.'</td>
									<td>'.$table_teacher[$i]->{'room'}.'</td>
									<td>'.$table_teacher[$i]->{'telephone'}.'</td>
									<td>'.$table_teacher[$i]->{'email'}.'</td>
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('view_edit_user_teacher/'.$table_teacher[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						 	                <li><a href="'.url('delete_user_teacher/'.$table_teacher[$i]->{'ID'}).'">ลบผู้ใช้งาน</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Teacher::getLastpage($condition);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Teacher::getCount($condition);
			}
			if($method=='search_subject_add'){
				$table_teacher = Teacher::search($condition,$currentPage);
				$output = '';
				for ($i=0;$i<count($table_teacher);$i++) {
	    			  $output.= '<tr id="table'.$table_teacher[$i]->{'ID'}.'">   

	    			 			    <td>'.$table_teacher[$i]->{'username'}.'</td>   
								 	<td>'.$table_teacher[$i]->{'title'}.'</td>
						            <td>'.$table_teacher[$i]->{'name'}.'</td>    
									<td>'.$table_teacher[$i]->{'surname'}.'</td>
									<td>'.$table_teacher[$i]->{'room'}.'</td>
									<td>'.$table_teacher[$i]->{'telephone'}.'</td>
									<td>'.$table_teacher[$i]->{'email'}.'</td>
									<td><div class="btn-group">
						             <button type="button" id="'.$table_teacher[$i]->{'ID'}.'" onclick="add_teacher(\''.$table_teacher[$i]->{'ID'}.'\');"  class="btn btn-primary addteacher">เพิ่มไปยังวิชา</button>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
		}
		
		public function searchSubject($method){
			Authen::refresh();
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
						 	                <li><a href="'.url('delete_subject/'.$table_subject[$i]->{'ID'}).'">ลบรายวิชา</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Subject::getLastpage($condition);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Subject::getCount($condition);
			}
		}
		public function subjectEditTeacher(){
			$teachers = Input::get('teachers');
			$subjInput = Subject::getFromID(Input::get('id'));
			$tmpTeacher = array();
			for($i=0;$i<count($teachers);$i++){
				$tmpTeacher[$i] = Teacher::getFromID($teachers[$i]);
			}
			$subjInput->setTeachers($tmpTeacher);
			$subjInput->teacherUpdate();
			return Redirect::to('/subject_add_teacher/'.Input::get('id')); 
		}
		public function subjectEditStudent(){
			$students = Input::get('students');
			$subjInput = Subject::getFromID(Input::get('id'));
			$tmpStudent = array();
			for($i=0;$i<count($students);$i++){
				$tmpStudent[$i] = Student::getFromID($students[$i]);
			}
			$subjInput->setStudents($tmpStudent);
			$subjInput->studentUpdate();
			return Redirect::to('/subject_add_student/'.Input::get('id')); 
		}
		
		public function userEdit(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');   
			}

			$tmp->setPassword(md5(Input::get('password')));
			$tmp->update();
			return Redirect::to('/');

		}
		public function userWaitting(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$tmp->setTitle(Input::get('title'));
			$tmp->setName(Input::get('name'));
			$tmp->setSurname(Input::get('surname'));
			$tmp->setEmail(Input::get('email'));
			$tmp->setTelephone(Input::get('telephone'));
			$tmp->setPosition(Input::get('position'));
			$tmp->update();
			return Redirect::to('/');

		}
		public function subjectAddTeacher($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$subjInput = Subject::getFromId($id);

			$header['active']=array('','active','','','');
			if($subjInput!=NULL && $subjInput->getStatus_del()=='0'){
				return View::make('subject_add_teacher',$header)->with('subj', $subjInput);
			}
			return Redirect::to('/');

		}
		public function subjectAddStudent($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$subjInput = Subject::getFromId($id);

			$header['active']=array('','active','','','');
			if($subjInput!=NULL && $subjInput->getStatus_del()=='0'){
				return View::make('subject_add_student',$header)->with('subj', $subjInput);
			}
			return Redirect::to('/');

		}
		
		public function viewEditAdmin($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Admin::getFromId($id);
			$header['active']=array('','active','','','');
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('view_edit_user_admin',$header)->with('user', $userInput);
			}
			return Redirect::to('/');
		}	
		public function viewEditStudent($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Student::getFromId($id);
			$header['active']=array('','active','','','');
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('view_edit_user_student',$header)->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function viewEditTeacher($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Teacher::getFromId($id);
			$header['active']=array('','active','','','');
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('view_edit_user_teacher',$header)->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function viewEditSubject($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$subjInput = Subject::getFromId($id);
			$header['active']=array('','active','','','');
			if($subjInput!=NULL && $subjInput->getStatus_del()=='0'){
				return View::make('view_edit_subject',$header)->with('subj', $subjInput);
			}
			return Redirect::to('/');
		}
		public function deleteAdmin($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Admin::getFromId($id);
			$header['active']=array('','active','','','');
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('delete_user_admin',$header)->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function deleteStudent($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Student::getFromId($id);
			$header['active']=array('','active','','','');
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('delete_user_student',$header)->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function deleteTeacher($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Teacher::getFromId($id);
			$header['active']=array('','active','','','');
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('delete_user_teacher',$header)->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function deleteSubject($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$subjInput = Subject::getFromId($id);
			$header['active']=array('','','active','','');
			if($subjInput!=NULL && $subjInput->getStatus_del()=='0'){
				return View::make('delete_subject',$header)->with('subj', $subjInput);
			}
			return Redirect::to('/');
		}
		
		
	}