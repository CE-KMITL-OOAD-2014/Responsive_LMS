<?php
	//classควบคุมการทำงานต่างๆของระบบนักศึกษา
	class StudentController extends BaseController {
		//แสดงหน้าหลักเวลาloginเสร็จเรียบร้อย
		public function showHome(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$subjecttmp = array();
			for($i=0;$i<count($tmp->getSubjects());$i++){
				$subjecttmp[$i]=Subject::getFromId($tmp->getSubjects()[$i]);
			}
			$data['subjecttmp']=$subjecttmp;
			return View::make('student',$data)->with('active', array('active','','','','','','','',''));
		}
		//แสดงหน้าviewจากการกดเมนูต่างๆเช่นเมนูบน header
		public function showPage($page){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			$active = array('','','','','','','');
			$subj=null;
			$id_subj=unserialize(Cookie::get('subject',null));
			if($id_subj!=null){
				$subj= Subject::getFromID($id_subj);
			}
			
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			
			if($subj==null){					
				return Redirect::to('/student');
			}
			$data['subj']=$subj;
			
			if($page=='s_subject_profile' || $page=='s_edit_subject_profile'){
				$active = array('','active','','','','','');
			}
			else if($page=='s_study' || $page=='s_add_study' || $page=='s_study_doc' || $page=='s_add_study_doc' ){
				$active = array('','','active','','','','');
			}
			else if( $page=='s_message' || $page=='s_add_message' ){
				$active = array('','','','active','','','');
			}
			else if($page=='s_assignment' || $page=='s_submit_assignment'
					 || $page=='score'){
				$active = array('','','','','active','','');
			}
			else if( $page=='s_absentletter' || $page=='s_add_absentletter' ){
				$active = array('','','','','','active','');
			}
			return View::make($page,$data)->with('active', $active);
		}
		//ควบคุมการทำงานของระบบเลือกวิชาเพื่อเข้าในระบบต่างๆ
		public function actionLMS(){
			$subject_id=Input::get('subject');
			$subject_tmp = Subject::getFromID($subject_id);
			if($subject_tmp->getStatus_del()=='0'){
			
				Cookie::queue('subject',serialize($subject_id),120);
			}
			
			return Redirect::to('student/s_subject_profile');
		}
		//ควบคุมการทำงานของระบบค้นหางานในหน้าดูงานที่สั่ง 
		public function searchAssignment($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$id_user=$tmp->getID();
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_assignment = Assignment::search_s($condition,$currentPage,$id_subj,$id_user);
				//return json_encode($table_assignment);
				$output = '';
				for ($i=0;$i<count($table_assignment);$i++) {
					  //แปลง ค.ศ. เป็น พ.ศ. 
					  $date_at=$table_assignment[$i]->{'date_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);
							$date_at = $day."-".$month."-".$year;
					  }
					  //แสดงแถบสถานะว่าเป็นงานใหม่ที่ยังไม่เคยดู
					  if($table_assignment[$i]->{'notification'}==0){
							$bg = 'class="bghover_red"';
					  }				 
					  else{
							$bg = ' ';
					  }
					  if($i==0){
						$output.= '<tr '.$bg.' >
	    			 			    <td>'.$date_at.'</td>   
								 	<td>'.$table_assignment[$i]->{'id_assignment'}.'</td>
						            <td>'.$table_assignment[$i]->{'title'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/student/view_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						  	               <li><a href="'.url('/student/view_add_submit_assignment/'.$table_assignment[$i]->{'ID'}).'">ส่งงาน</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
					  }					  
					  else if($table_assignment[$i-1]->{'idsubtable'}!=$table_assignment[$i]->{'idsubtable'}){
						$output.= '<tr '.$bg.' >   
	    			 			    <td>'.$date_at.'</td>   
								 	<td>'.$table_assignment[$i]->{'id_assignment'}.'</td>
						            <td>'.$table_assignment[$i]->{'title'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/student/view_assignment/'.$table_assignment[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
						  	               <li><a href="'.url('/student/view_add_submit_assignment/'.$table_assignment[$i]->{'ID'}).'">ส่งงาน</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
					  }				
				}
				return $output;
			}
			//หาจำนวนหน้าในการแสดงผล
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Assignment::getLastpage_s($condition,$id_subj,$id_user);
			}
			//หาจำนวนงานทั้งหมด
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Assignment::getCount_s($condition,$id_subj,$id_user);
			}
		}
		//ควบคุมการทำงานของระบบค้นหาใบลาในหน้าดูใบลา จะแสดงใบลาที่ส่งทั้งหมด 
		public function searchAbsentletter($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$id_user=$tmp->getID();
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_absent = Absent::search_s($condition,$currentPage,$id_user,$id_subj);
				$output = '';
				for ($i=0;$i<count($table_absent);$i++) {
					  //แปลง ค.ศ. เป็น พ.ศ. 
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
					  //แสดงสถานะของใบลา อนุมัติแล้ว รอการอนุมัติ ไม่อนุมัติ
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
							        </tr>    ';
				}
				return $output;
			}
			//หาจำนวนหน้าในการแสดงผล
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Absent::getLastpage_s($condition,$id_user,$id_subj);
			}
			//หาจำนวนใบลา
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Absent::getCount_s($condition,$id_user,$id_subj);
			}
		}
		//ควบคุมการทำงานของหน้าดูรายละเอียดงาน 
		public function viewAssignment($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$assInput = Assignment::getFromId($id);
			$assInput->setNotification("1");
			$assInput->update();
			$header['active']=array('','','','','active','','','','');
			if($assInput!=NULL){
				return View::make('s_view_assignment',$header)->with('ass', $assInput);
			}
			return Redirect::to('/');
		}
		//ควบคุมระบบแก้ไขpasswordใช้ในการเปลี่ยนรหัสผ่าน
		public function userEdit(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');   
			}
			//md5 เพื่อเข้ารหัส password 
			$tmp->setPassword(md5(Input::get('password')));
			$tmp->update();
			return Redirect::to('/');

		}
		//ควบคุมระบบแก้ไขข้อมูลส่วนตัว 
		public function userWaitting(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$tmp->setTitle(Input::get('title'));
			$tmp->setName(Input::get('name'));
			$tmp->setSurname(Input::get('surname'));
			$tmp->setNickname(Input::get('nickname'));
			$tmp->setAdviser(Input::get('adviser'));
			$tmp->setFaculty(Input::get('faculty'));
			$tmp->setDepartment(Input::get('department'));
			$tmp->setMajor(Input::get('major'));
			$tmp->update();
			return Redirect::to('/');
		}
		//ควบคุมการทำงานของระบบค้นหาในหน้าจัดการการเรียน จะแสดงรายการเวลาเรียนทั้งหมด 
		public function searchStudy($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_study = Study::search($currentPage,$id_subj);
				$output = '';
				for ($i=0;$i<count($table_study);$i++) {
					  //แปลง ค.ศ. เป็น พ.ศ. 
					  $date_at=$table_study[$i]->{'date_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
	    			  $output.= '<tr>   
	    			 			    <td>'.$date_at.'</td>   
								 	<td>'.$table_study[$i]->{'detail'}.'</td>  
								 	<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/student/s_class_assess/'.$table_study[$i]->{'ID'}).'">ประเมิน</a></li>
						  	               <li><a href="'.url('/student/s_class_status/'.$table_study[$i]->{'ID'}).'">สถานะขณะเรียน</a></li>
							               </ul>
							             </div></td>									
							        </tr>    ';
				}
				return $output;
			}
			//หาจำนวนหน้าในการแสดงผล
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				return Study::getLastpage($id_subj);
			}
			//หาจำนวนการเรียน
			if($method=='get_count'){
				//return 'get_count';
				return Study::getCount($id_subj);
			}
		}
		//ควบคุมการทำงานของระบบค้นหาในหน้าจัดกาารข้อความ จะแสดงรายการข้อความทั้งหมด 
		public function searchMessage($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}

			$id_user=$tmp->getID();
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			if($method=='search'){
				$table_message = Message::search($condition,$currentPage,$id_user);
				$output = '';
				for ($i=0;$i<count($table_message);$i++) {
					  //แปลง ค.ศ. เป็น พ.ศ. 
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
						  	               <li><a href="'.url('/student/view_message/'.$table_message[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
							               </ul>
							             </div></td>
							        </tr>    ';
				}
				return $output;
			}
			//หาจำนวนหน้าในการแสดงผล
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Message::getLastpage($condition,$id_user);
			}
			//หาจำนวนข้อความ
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Message::getCount($condition,$id_user);
			}
		}
		//ควบคุมการทำงานของระบบส่งข้อความ 
		public function addMessage(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			//เพิ่มข้อมูลลงในDatabaseของmessage
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$input = new Message;
			$input->setTitle(Input::get('title'));
			$input->setMessage(Input::get('message'));
			$input->setStatus("0");
			$id_subtable=$subj->addMessage($input);
			
			//เพิ่มข้อมูลลงในDatabaseของcontact
			$contact = new Contact;
			$contact->setSender($tmp->getID());
			$contact->setReceiver(Input::get('receiver'));
			$contact->setAnonymous("0");			
			$contact->setGroupid("message");
			$contact->setIdsubtable($id_subtable);
			$contact->setNotification("0");
			$contact->addContact($contact);
					
			return Redirect::to('student/s_message');
		}
		//ควบคุมการทำงานของหน้าดูรายละเอียดข้อความ
		public function viewMessage($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			//เปลี่ยน status เป็นอ่านแล้วเมื่อเข้ามาหน้าดูรายละเอียด
			$messInput = Message::getFromId($id);
			$messInput->setStatus("1");
			$messInput->update();
			//$conInput = Contact::getFromId($id);
			$header['active']=array('','','','active','','','','','');
			if($messInput!=NULL){
				return View::make('s_view_message',$header)->with('mess', $messInput);
			}
			return Redirect::to('/');
		}
		//ควบคุมการทำงานของระบบส่งใบลา
		public function addAbsentletter(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			//เพิ่มข้อมูลลงในDatabaseของ absent_letter
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$input = new Absent;
			$input->setDate_at(Input::get('date_at'));
			$input->setDetail(Input::get('detail'));
			$input->setStatus("1");
			$input->setStatus_read("0");
			$input->setId_subject($id_subj);
			if (Input::hasFile('id_doc')){
				$content = Input::file('id_doc');
				$file = fopen($content->getRealPath(), "r");
			  //  $content = file_get_contents(Input::file('id_doc'));
			    $tmpName = date("Y-m-d H:i:s").'_'.Input::file('id_doc')->getClientOriginalName();
			    $input->setName_file($tmpName);
			    $input->setContent_file($file);
			}		
			else{
				$input->setName_file(NULL);
			    $input->setContent_file(NULL);
			}			
			$id_subtable=$subj->addAbsentletter($input);
			
			//เพิ่มข้อมูลลงในDatabaseของcontact	
			$subject= Subject::getFromID($id_subj);
			for($i=0;$i<count($subject->getTeachers());$i++){
				$contact = new Contact;
				$contact->setSender($tmp->getID());
				$contact->setReceiver($subject->getTeachers()[$i]->getID());
				$contact->setAnonymous("0");			
				$contact->setGroupid("absentletter");
				$contact->setIdsubtable($id_subtable);
				$contact->setNotification("0");
				$contact->addContact($contact);
			}
			return Redirect::to('student/s_absentletter');
		}
		//ควบคุมระบบแสดงหน้าส่งงาน
		public function viewAddSubmitAssignment($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$assInput = Assignment::getFromId($id);
			$header['active']=array('','','','','active','','','','');
			if($assInput!=NULL){
				return View::make('s_add_submit_assignment',$header)->with('ass', $assInput);
			}
			return Redirect::to('/');
		}	
		//ควบคุมระบบdownloadไฟล์
		public function downloadFile(SubmitAssignment $sma){
			$file = $sma->getContent_file();
			$contents = stream_get_contents($file);
			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=".$sma->getName_file());
			return  $contents;
		}
		//ควบคุมการทำงานของระบบส่งงาน
		public function addSubmitAssignment(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			//เพิ่มข้อมูลลงในDatabaseของ submit_assignment
			$input = new SubmitAssignment;
			$input->setId_assignment(Input::get('id_ass'));
			$input->setDetail(Input::get('detail'));
			$input->setStatus("0");
			$input->setId_subject($id_subj);
			if (Input::hasFile('id_doc')){
				$content = Input::file('id_doc');
				$file = fopen($content->getRealPath(), "r");
			    $tmpName = date("Y-m-d H:i:s").'_'.Input::file('id_doc')->getClientOriginalName();
			    $input->setName_file($tmpName);
			    $input->setContent_file($file);
			}		
			else{
				$input->setName_file(NULL);
			    $input->setContent_file(NULL);
			}			
			$id_subtable=$subj->addSubmitAssignment($input);
				
			$subject= Subject::getFromID($id_subj);
			//เพิ่มข้อมูลลงในDatabaseของcontact โดยส่งงานให้กับอาจารย์ทุกคนที่สอนในวิชานั้นๆๆ
			for($i=0;$i<count($subject->getTeachers());$i++){
				$contact = new Contact;
				$contact->setSender($tmp->getID());
				$contact->setReceiver($subject->getTeachers()[$i]->getID());
				$contact->setAnonymous("0");			
				$contact->setGroupid("submit_assignment");
				$contact->setIdsubtable($id_subtable);
				$contact->setNotification("0");
				$contact->addContact($contact);
			}
			return Redirect::to('student/s_assignment');
			
		}
		//ควบคุมการแสดงผลหน้ากำหนดสถานะของชั้นเรียน
		public function setClassStatus($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$result=ClassStatus::makeEmptyStatus();
			$header['active']=array('','','active','','','','','','');
			return View::make('s_class_status',$header)->with('result', $result)->with('id',$id);
		}
		//ประมวลผลการทำงานของการกำหนดสถานะของชั้นเรียน
		public function setClassStatusAction($id,$i){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_student = $tmp->getID();
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$subj->setClassStatus($id_student,$id,$i);
			return Redirect::to('/student/s_study');
		}
		//ควบคุมการแสดงผลหน้าประเมิณชั้นเรียน
		public function setClassAssess($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$result=ClassAssess::makeEmptyResult();
			$header['active']=array('','','active','','','','','','');
			return View::make('s_class_assess',$header)->with('result', $result)->with('id',$id);
		}
		//ประมวลผลการทำงานของการประเมิณชั้นเรียน
		public function setClassAssessAction($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_student = $tmp->getID();
			$score = array();
			for($i=0;$i<Input::get('num');$i++){
				$score[$i]=Input::get('score'.$i);
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$subj->setClassAssess($id_student,$id,$score);
			return Redirect::to('/student/s_study');
		}
		//ควบคุมการแสดงคะแนนของงานแต่ละชิ้นที่ส่งของนักศึกษา
		public function score(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_student = $tmp->getID();
			$id_subj=unserialize(Cookie::get('subject',null));
			$scInput=SubmitAssignment::getScoreAll($id_student,$id_subj);
			$header['active']=array('','','','','','active','','','');
			if($scInput!=NULL){
				return View::make('s_score',$header)->with('sc', $scInput);
			}
			//return Redirect::to('/');
		}	
		
		
	}
	
	
?>