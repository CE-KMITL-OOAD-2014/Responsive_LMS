<?php

	class StudentController extends BaseController {
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
			/*
			else if( $page==''){
				$active = array('','','','','','','','','active');
			}
			*/
			return View::make($page,$data)->with('active', $active);
		}
		public function actionLMS(){
			$subject_id=Input::get('subject');
			$subject_tmp = Subject::getFromID($subject_id);
			if($subject_tmp->getStatus_del()=='0'){
			
				Cookie::queue('subject',serialize($subject_id),120);
			}
			
			return Redirect::to('student/s_subject_profile');
		}
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
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Assignment::getLastpage_s($condition,$id_subj,$id_user);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Assignment::getCount_s($condition,$id_subj,$id_user);
			}
		}
		public function searchAbsentletter($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$id_user=$tmp->getID();
			//$id_user='12';
			$condition = Input::get('condition');
			$currentPage = Input::get('currentPage');
			//$condition['approve'] ='1';
			//$condition['Pending'] = '1';
			//$condition['unapprove'] ='1';
			//$currentPage ='1';
			if($method=='search'){
				$table_absent = Absent::search_s($condition,$currentPage,$id_user,$id_subj);
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
							        </tr>    ';
				}
				return $output;
			}
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				$condition = Input::get('condition');
				return Absent::getLastpage_s($condition,$id_user,$id_subj);
			}
			if($method=='get_count'){
				//return 'get_count';
				$condition = Input::get('condition');
				return Absent::getCount_s($condition,$id_user,$id_subj);
			}
		}
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
		public function userEdit(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');   
			}

			$tmp->setPassword(md5(Input::get('password')));
			$tmp->update();
			return Redirect::to('/');

		}
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
			if($method=='get_lastpage'){
				//return 'get_lastpage';
				return Study::getLastpage($id_subj);
			}
			if($method=='get_count'){
				//return 'get_count';
				return Study::getCount($id_subj);
			}
		}
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
		public function addMessage(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);
			$input = new Message;
			$input->setTitle(Input::get('title'));
			$input->setMessage(Input::get('message'));
			$input->setStatus("0");
			$id_subtable=$subj->addMessage($input);
			
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
		public function viewMessage($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
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
		public function addAbsentletter(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
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
		public function downloadFile(SubmitAssignment $sma){
			$file = $sma->getContent_file();
			$contents = stream_get_contents($file);
			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=".$sma->getName_file());
			return  $contents;
		}
		public function addSubmitAssignment(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$subj= Subject::getFromID($id_subj);

			$input = new SubmitAssignment;
			$input->setId_assignment(Input::get('id_ass'));
			$input->setDetail(Input::get('detail'));
			$input->setStatus("0");
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
			$id_subtable=$subj->addSubmitAssignment($input);
				
			$subject= Subject::getFromID($id_subj);
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
		public function score(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Student::userIsStudent($tmp)){
				return Redirect::to('/');
			}
			$id_student = $tmp->getID();
			$id_subj=unserialize(Cookie::get('subject',null));
			$input = new SubmitAssignment;
			$scInput=$input->getscore($id_student,$id_subj);
			$header['active']=array('','','','','','active','','','');
			if($scInput!=NULL){
				return View::make('s_score',$header)->with('sc', $scInput);
			}
			return Redirect::to('/');
		}	
		
		
	}
	
	
?>