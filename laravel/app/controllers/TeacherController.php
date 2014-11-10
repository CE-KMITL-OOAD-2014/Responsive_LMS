<?php

	class TeacherController extends BaseController {
		public function showHome(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$subjecttmp = array();
			for($i=0;$i<count($tmp->getSubjects());$i++){
				$subjecttmp[$i]=Subject::getFromId($tmp->getSubjects()[$i]);
			}
			$data['subjecttmp']=$subjecttmp;
			return View::make('teacher',$data)->with('active', array('active','','','','','','','',''));
		}
		public function showPage($page){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			$active = array('','','','','','','','','');

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
			/*else if( $page==''){
				$active = array('','','','','','','active','','');
			}
			else if( $page==''){
				$active = array('','','','','','','','active','');
			}
			else if( $page==''){
				$active = array('','','','','','','','','active');
			}*/
			return View::make($page,$data)->with('active', $active);
		}
		public function actionLMS(){
			$subject_id=Input::get('subject');
			$subject_tmp = Subject::getFromID($subject_id);
			if($subject_tmp->getStatus_del()=='0'){
			
				Cookie::queue('subject',serialize($subject_id),120);
			}
			
			return Redirect::to('teacher/subject_profile');
		}
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
		public function searchAssignment($method){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
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
	    			  $output.= '<tr>   
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
		public function addAssignment(){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$id_subj=unserialize(Cookie::get('subject',null));
			$input = new Assignment;
			$input->setId_assignment(Input::get('id_assignment'));
			$input->setTitle(Input::get('title'));
			$input->setDetail(Input::get('detail'));
			$input->setId_doc(Input::get('id_doc'));
			$input->setId_subject($id_subj);
			//$input->setId_teacher($tmp->getID());
			$input->setDate_at(Input::get('date_at'));
			$tmp->addAssignment($input);
			return Redirect::to('teacher/assignment');
		}
		public function submitAssignment($id){
			Authen::refresh();
			$tmp=unserialize(Cookie::get('user',null));
			if(!Teacher::userIsTeacher($tmp)){
				return Redirect::to('/');
			}
			$table_assignment = SubmitAssignment::search($id);
			$header['active']=array('','','','','active','','','','');
			if($subjInput!=NULL && $subjInput->getStatus_del()=='0'){
				return View::make('submit_assignment',$header)->with('submita', $table_assignment);
			}
			return Redirect::to('/');
			
		}
		
	}
	
	
?>