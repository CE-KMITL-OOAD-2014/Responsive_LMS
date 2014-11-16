<?php

	class TeacherController extends BaseController {
		//แสดงหน้าหลักเวลาloginเสร็จเรียบร้อย
		public function showHome(){
			Authen::refresh();//update cookie ผู้ใช้งานจาก DB
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){//ตรวจสอบสิทธิ์ผู้ใช้งาน
				return Redirect::to('/');
			}
			$subjecttmp = array();
			for($i=0;$i<count($tmp->getSubjects());$i++){
				$subjecttmp[$i]=Subject::getFromId($tmp->getSubjects()[$i]);
			}
			$data['subjecttmp']=$subjecttmp;
			return View::make('teacher',$data)->with('active', array('active','','','','','','','',''));
		}
		//แสดงหน้าviewจากการกดเมนูต่างๆเช่นเมนูบน header
		public function showPage($page){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			$active = array('','','','','','','','','');
			$subj=null;
			$id_subj=unserialize(Cookie::get('subject',null));
			if($id_subj!=null){
				$subj= Subject::getFromID($id_subj);
			}
			
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			
			if($subj==null){					
				return Redirect::to('/teacher');
			}
			$data['subj']=$subj;
			
			if($page=='subject_profile' || $page=='edit_subject_profile'){
				$active = array('','active','','','','','','','');
			}
			else if($page=='study' || $page=='add_study' || $page=='study_doc' || $page=='add_study_doc' ){
				$active = array('','','active','','','','','','');
			}
			else if( $page=='message' || $page=='add_message' ){
				$active = array('','','','active','','','','','');
			}
			else if($page=='assignment' || $page=='add_assignment' || $page=='submit_assignment'
					 || $page=='score'){
				$active = array('','','','','active','','','','');
			}
			else if( $page=='absentletter' || $page=='add_absentletter' ){
				$active = array('','','','','','active','','','');
			}
			return View::make($page,$data)->with('active', $active);
		}
		//กำหนดวิชาที่จะทำรายการก่อนทำรายการอื่นๆ
		public function actionLMS(){
			$subject_id=Input::get('subject');
			$subject_tmp = Subject::getFromID($subject_id);
			if($subject_tmp->getStatus_del()=='0'){
			
				Cookie::queue('subject',serialize($subject_id),120);
			}
			
			return Redirect::to('teacher/subject_profile');
		}
		//แก้ไขข้อมูลรายวิชา
		public function teacherEdit(){
			$detail_thai=Input::get('detail_thai');
			$detail_eng=Input::get('detail_eng');
			$id_subj=unserialize(Cookie::get('subject',null));
			if($id_subj!=null){
				$subj= Subject::getFromID($id_subj);
			}
			$subj->setDetail_thai($detail_thai);
			$subj->setDetail_eng($detail_eng);
			$subj->update();
			return Redirect::to('teacher/subject_profile');
		}
		//ค้นหางานออกมาแสดงผลในรูปของตาราง
		public function searchAssignment($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_user=$tmp->getID();
			$id_subj=unserialize(Cookie::get('subject',null));
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_assignment = Assignment::search($condition,$currentPage,$id_subj);
				$output = '';
				for ($i=0;$i<count($table_assignment);$i++) {
					  $date_at=$table_assignment[$i]->{'date_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
	    			  					  if($i==0){
						$output.= '<tr  >
	    			 			    <td>'.$date_at.'</td>   
								 	<td>'.$table_assignment[$i]->{'id_assignment'}.'</td>
						            <td>'.$table_assignment[$i]->{'title'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/teacher/view_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						  	               <li><a href="'.url('/teacher/submit_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูงานที่ส่ง</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
					  }					  
					  else if($table_assignment[$i-1]->{'idsubtable'}!=$table_assignment[$i]->{'idsubtable'}){
						$output.= '<tr  >   
	    			 			    <td>'.$date_at.'</td>   
								 	<td>'.$table_assignment[$i]->{'id_assignment'}.'</td>
						            <td>'.$table_assignment[$i]->{'title'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/teacher/view_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						  	               <li><a href="'.url('/teacher/submit_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูงานที่ส่ง</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
					  }						}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Assignment::getLastpage($condition,$id_subj);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Assignment::getCount($condition,$id_subj);
			}
		}
		//แก้ไขข้อมูลรหัสผ่านของตนเอง
		public function userEdit(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');   
			}

			$tmp->setPassword(md5(Input::get('password')));
			$tmp->update();
			return Redirect::to('/');

		}
		//แก้ไขข้อมูลส่วนตัวอื่นๆ
		public function userWaitting(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$tmp->setTitle(Input::get('title'));
			$tmp->setName(Input::get('name'));
			$tmp->setSurname(Input::get('surname'));
			$tmp->setName_user(Input::get('name_user'));
			$tmp->setEmail(Input::get('email'));
			$tmp->setTelephone(Input::get('telephone'));
			$tmp->setRoom(Input::get('room'));
			$tmp->setHistory(Input::get('history'));
			$tmp->setExperience(Input::get('experience'));

			$tmp->update();
			return Redirect::to('/');

		}
		//คนหา Class เรียนที่เปิดหรือเปลี่ยนแปลงเวลาเรียนแล้ว
		public function searchStudy($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_study = Study::search($currentPage,$id_subj);
				$output = '';
				for ($i=0;$i<count($table_study);$i++) {//จัดรูปแบบให้อยู่ในรูปของตาราง
					  $date_at=$table_study[$i]->{'date_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;//จัดการรูปแบบวันที่
					  }
	    			  $output.= '<tr>   
	    			 			    <td>'.$date_at.'</td>   
								 	<td>'.$table_study[$i]->{'detail'}.'</td>  
								 	<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/teacher/class_assess/'.$table_study[$i]->{'ID'}).'">ดูผลการประเมิน</a></li>
						  	               <li><a href="'.url('/teacher/class_status/'.$table_study[$i]->{'ID'}).'">ดูสถานะขณะเรียน</a></li>
							               </ul>
							             </div></td>									
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				return Study::getLastpage($id_subj);
			}
			if($method=='get_count'){
				//return 'get_count';
				return Study::getCount($id_subj);
			}
		}
		//ค้นหาข้อความที่นักเรียนส่งมา
		public function searchMessage($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}

			$id_user=$tmp->getID();
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_message = Message::search($condition,$currentPage,$id_user);
				$output = '';
				for ($i=0;$i<count($table_message);$i++) {
					  $date_at=$table_message[$i]->{'created_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
	    			  $output.= '<tr>'.   
	    			  (($table_message[$i]->{'status'}=='1')?
	    			 ' <td class=" text-center"><span class="glyphicon glyphicon-ok-sign green"></span></td>':
	    			  '<td class=" text-center"><span class="glyphicon glyphicon-info-sign yellow"></span></td>')
	    			 			   .' <td>'.$date_at.'</td>   
								 	<td>'.$table_message[$i]->{'title'}.'</td>
						            <td>'.$table_message[$i]->{'message'}.'</td>    	 								
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/teacher/view_message/'.$table_message[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Message::getLastpage($condition,$id_user);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Message::getCount($condition,$id_user);
			}
		}
		//ค้นหาใบมาที่นักเรียนส่งมา
		public function searchAbsentletter($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$id_user=$tmp->getID();
			//$id_user='12';
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_absent = Absent::search($condition,$currentPage,$id_user,$id_subj);
				$output = '';
				for ($i=0;$i<count($table_absent);$i++) {
					  $created_at=$table_absent[$i]->{'created_at'};
					  if($created_at!=''){
							$year = substr($created_at, 0, 4);
							$year  = $year + 543;
							$month = substr($created_at, 5, 2);
							$day = substr($created_at, 8, 2);

							$created_at = $day."-".$month."-".$year;
					  }
					  $date_at=$table_absent[$i]->{'date_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
					  if($table_absent[$i]->{'status'}=='0'){
							$status='<td class=" text-center"><span class="glyphicon glyphicon-ok-sign green"></span></td>';
						}
						else if($table_absent[$i]->{'status'}=='1'){					
							$status='<td class=" text-center"><span class="glyphicon glyphicon-info-sign yellow"></span></td>';
						}
						else{
							$status='<td class=" text-center"><span class="glyphicon glyphicon-info-sign red"></span></td>';
						}	
	    			  $output.= '<tr>
									'.$status.' 
									<td>'.$created_at.'</td>   
								 	<td>'.$date_at.'</td>
						            <td>'.$table_absent[$i]->{'detail'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/teacher/view_absentletter/'.$table_absent[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				$condition = Input::get('condition');
				return Absent::getLastpage($condition,$id_user,$id_subj);
			}
			if($method=='get_count'){
				$condition = Input::get('condition');
				return Absent::getCount($condition,$id_user,$id_subj);
			}
		}
		//คนหางานที่นักเรียนส่งมา
		public function searchSubmitAssignment($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_user=$tmp->getID();
			
			$condition = Input::get('condition');
			
			$currentPage = Input::get('currentPage');
			//$condition['check']='1';
			//$condition['uncheck']='1';
			//$condition['idass']='1';
			//$id_user='12';
			//$currentPage ='1';
			if($method=='search'){
				$table_submitassignment = SubmitAssignment::search($condition,$currentPage,$id_user);
				$output = '';
				//var_dump($table_submitassignment);
				for ($i=0;$i<count($table_submitassignment);$i++) {
					  $date_at=$table_submitassignment[$i]->{'created_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
					  
	    			  $output.= '<tr>'.   
	    			  (($table_submitassignment[$i]->{'status'}=='1')?
	    			 ' <td class=" text-center"><span class="glyphicon glyphicon-ok-sign green"></span></td>':
	    			  '<td class=" text-center"><span class="glyphicon glyphicon-info-sign yellow"></span></td>')
	    			 			   .'<td>'.$date_at.'</td>   
								 	<td>'.$table_submitassignment[$i]->{'id_student'}.'</td>
						            <td>'.$table_submitassignment[$i]->{'detail'}.'</td>
									<td>'.(($table_submitassignment[$i]->{'id_doc'}!='0')?($table_submitassignment[$i] ->{'name'}):('ไม่มีเอกสาร')).'</td>
									<td>'.$table_submitassignment[$i]->{'score'}.'</td>									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/teacher/view_submit_assignment/'.$table_submitassignment[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return SubmitAssignment::getLastpage($condition,$id_user);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return SubmitAssignment::getCount($condition,$id_user);
			}
		}
		//เปิดดูรายละเอียดต่างๆของงานที่สั่ง
		public function viewAssignment($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$assInput = Assignment::getFromId($id);
			$header['active']=array('','','','','active','','','','');
			if($assInput!=NULL){
				return View::make('view_assignment',$header)->with('ass', $assInput);
			}
			return Redirect::to('/');
		}	
		//เปิดดูรายละเอียดของงานที่นักเรียนส่ง
		public function viewSubmitAssignment($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$sassInput = SubmitAssignment::getFromId($id);
			//return $sassInput->toString();
			$header['active']=array('','','','','active','','','','');
			if($sassInput!=NULL){
				return View::make('view_submit_assignment',$header)->with('sass', $sassInput);
			}
			return Redirect::to('/');
		}
		//Download เอกสารแนบจากงาน
		public function downloadFileAssignment($id){
			$smaTmp = SubmitAssignment::getFromID($id);
			$smaTmp->downloadFile();
		}
		//Download เอกสารแนบจากใบลา
		public function downloadFileAbsent($id){
			$absTmp = Absent::getFromID($id);
			$absTmp->downloadFile();
		}
		//สั่งงานนักศึกษาโดยกรอกแบบฟอร์มรายละเอียด
		public function addAssignment(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$input = new Assignment;
			$input->setId_assignment(Input::get('id_assignment'));
			$input->setTitle(Input::get('title'));
			$input->setDetail(Input::get('detail'));
			$input->setId_doc(Input::get('id_doc'));
			$input->setId_subject($id_subj);
			$input->setDate_at(Input::get('date_at'));
			$id_subtable=$subj->addAssignment($input);
			$subject= Subject::getFromID($id_subj);
			for($i=0;$i<count($subject->getTeachers());$i++){
				for($j=0;$j<count($subject->getStudents());$j++){
					$contact = new Contact;
					$contact->setSender($subject->getTeachers()[$i]->getID());
					$contact->setReceiver($subject->getStudents()[$j]->getID());
					$contact->setAnonymous("0");
					$contact->setGroupid("assignment");
					$contact->setIdsubtable($id_subtable);
					$contact->setNotification("0");
					$contact->addContact($contact);
				}
			}
			
			
			return Redirect::to('teacher/assignment');
		}
		//เพิ่มคลาสเรียนในวิชากำหนดวันเวลาตามแบบฟอร์ม
		public function addStudy(){
				Authen::refresh();
				$tmp=unserialize(Cookie::get('user',null));
				if(!Teacher::userIsTeacher($tmp)){
					return Redirect::to('/');
				}
				$id_subj=unserialize(Cookie::get('subject',null));
				if($id_subj==null){
					return Redirect::to('/');
				}
				$subj= Subject::getFromID($id_subj);
				$subjectTmp = new Study;
				$subjectTmp->setId_subject($id_subj);
				$subjectTmp->setDate_at(Input::get('date_at'));
				$subjectTmp->setDetail(Input::get('detail'));
				$subjectTmp->setNotification(Input::get('change'));	
				$subj->addStudy($subjectTmp);
				return Redirect::to('/teacher/study');
		}
		//แสดงรายละเอียดงานของนักเรียน
		public function submitAssignment($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$assInput = Assignment::getFromId($id);
			$header['active']=array('','','','','active','','','','');
			if($assInput!=NULL){
				return View::make('submit_assignment',$header)->with('ass', $assInput);
			}
			return Redirect::to('/');
			
		}
		//ดูรายละเอียดสถานะขณะเียนของคลาส
		public function viewClassStatus($id){
			$cstatusTmp=ClassStatus::getFromIDStudy($id);
			if($cstatusTmp!=NULL){
				$result = $cstatusTmp->calculateStatus();
			}
			else{
				$result=ClassStatus::makeEmptyStatus();
			}
			$header['active']=array('','','active','','','','','','');
			return View::make('class_status',$header)->with('result', $result);
			var_dump($result);
		}
		//ดูผลการประเมิณของคลาส
		public function viewClassAssess($id){
			$cassessTmp=ClassAssess::getFromIDStudy($id);
			if($cassessTmp!=NULL){
				$result = $cassessTmp->calculateResult();
			}
			else{
				$result=ClassAssess::makeEmptyResult();
			}
			$header['active']=array('','','active','','','','','','');
			return View::make('class_assess',$header)->with('result', $result);
			var_dump($result);
		}
		//ให้คะแนนงาน
		public function editSubmitAssignment(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$input = SubmitAssignment::getFromId(Input::get('id'));

			$input->setStatus("1");
			$input->setScore(Input::get('score'));
			$input->setDetail_score(Input::get('detail_score'));
			if(Input::get('scstatus')==1){
				$input->setStatus_score("1");
			}
			$input->update();
			return Redirect::to('teacher/assignment/');
		}
		//ส่งข้อความหานักเรียน
		public function addMessage(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$input = new Message;
			$input->setTitle(Input::get('title'));
			$input->setMessage(Input::get('message'));
			$input->setStatus("0");
			$id_subtable=$subj->addMessage($input);
			
			if(Input::get('receiver')=="0"){		
				$subject= Subject::getFromID($id_subj);
				for($j=0;$j<count($subject->getStudents());$j++){
					$contact = new Contact;
					$contact->setSender($tmp->getID());
					$contact->setReceiver($subject->getStudents()[$j]->getID());
					$contact->setAnonymous("0");			
					$contact->setGroupid("message");
					$contact->setIdsubtable($id_subtable);
					$contact->setNotification("0");
					$contact->addContact($contact);
				}
			}
			else{
				$contact = new Contact;
				$contact->setSender($tmp->getID());
				$contact->setReceiver(Input::get('receiver'));
				$contact->setAnonymous("0");			
				$contact->setGroupid("message");
				$contact->setIdsubtable($id_subtable);
				$contact->setNotification("0");
				$contact->addContact($contact);
			
			}
			
			
			return Redirect::to('teacher/message');
		}
		//ดูรายละเอียดข้อความที่นักเรียนส่งมา
		public function viewMessage($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$messInput = Message::getFromId($id);
			$messInput->setStatus("1");
			$messInput->update();
			//$conInput = Contact::getFromId($id);
			$header['active']=array('','','','active','','','','','');
			if($messInput!=NULL){
				return View::make('view_message',$header)->with('mess', $messInput);
			}
			return Redirect::to('/');
		}
		//ดูรายละเอียดของใบลาที่นักเรียนส่งมา
		public function viewAbsentletter($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$absentInput = Absent::getFromId($id);
			$absentInput->setStatus_read("1");
			$absentInput->update();
			$header['active']=array('','','','','','active','','','');
			if($absentInput!=NULL){
				return View::make('view_absentletter',$header)->with('absent', $absentInput);
			}
			return Redirect::to('/');
		}
		//อนุมัติใบลาของนักเรียน
		public function actionApprove($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$absentInput = Absent::getFromId($id);
			$absentInput->setStatus("0");
			$absentInput->update();
			return Redirect::to('teacher/absentletter');
		}		
		//ไม่อนุมัติใบลา
		public function actionUnApprove($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$absentInput = Absent::getFromId($id);
			$absentInput->setStatus("2");
			$absentInput->update();
			return Redirect::to('teacher/absentletter');
		}	
		
	}
	
	
?>