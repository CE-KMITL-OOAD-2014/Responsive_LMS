<?php

	class AdminController extends BaseController {
		public function showHome(){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			return View::make('admin')->with('active', array('active','','','',''));
		}
		public function showPage($page){
			$tmp=unserialize(Cookie::get('user',null));
			$active = array('','','','','');
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			else if($page=='user_teacher' || $page=='user_student' || $page=='user_admin' 
				|| $page=='add_user_admin'|| $page=='add_user_student'|| $page=='add_user_teacher'){
				$active = array('','active','','','');
			}
			else if($page=='subject'){
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
		public function editUser($type){
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
		public function deleteUser($type){
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
		}
		public function searchTeacher($method){
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
		}
		public function userEdit(){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}

			$tmp->setPassword(md5(Input::get('password')));
			$tmp->update();
			return Redirect::to('/');

		}
		public function userWaitting(){
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
		public function viewEditAdmin($id){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Admin::getFromId($id);
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('view_edit_user_admin')->with('user', $userInput);
			}
			return Redirect::to('/');
		}	
		public function viewEditStudent($id){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Student::getFromId($id);
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('view_edit_user_student')->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function viewEditTeacher($id){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Teacher::getFromId($id);
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('view_edit_user_teacher')->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function deleteAdmin($id){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Admin::getFromId($id);
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('delete_user_admin')->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function deleteStudent($id){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Student::getFromId($id);
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('delete_user_student')->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		public function deleteTeacher($id){
			$tmp=unserialize(Cookie::get('user',null));
			if(!Admin::userIsAdmin($tmp)){
				return Redirect::to('/');
			}
			$userInput = Teacher::getFromId($id);
			if($userInput!=NULL && $userInput->getStatus_del()=='0'){
				return View::make('delete_user_teacher')->with('user', $userInput);
			}
			return Redirect::to('/');
		}
		
	}