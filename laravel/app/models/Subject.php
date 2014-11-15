<?php
	require_once 'sdkazure\vendor\microsoft\windowsazure\WindowsAzure\WindowsAzure.php';
	require_once 'sdkazure\vendor\autoload.php';

	use WindowsAzure\Common\ServicesBuilder;
	use WindowsAzure\Common\ServiceException;
	use windowsAzure\blob\models\createcontaineroptions;
	use windowsAzure\blob\models\PublicAccessType;
	class Subject {
		private $id;
		private $id_subject;
		private $name;
		private $students;
		private $teachers;
		private $group;
		private $room;
		private $build;
		private $start_at;
		private $end_at;
		private $day;
		private $detail_thai;
		private $detail_eng;
		private $status_del;
		private $detail_delete;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id=NULL;
			$this->id_subject=NULL;
			$this->students=NULL;
			$this->teachers=NULL;
			$this->name=NULL;
			$this->group=NULL;
			$this->room=NULL;
			$this->build=NULL;
			$this->start_at=NULL;
			$this->end_at=NULL;
			$this->day=NULL;
			$this->detail_thai=NULL;
			$this->detail_eng=NULL;
			$this->status_del=0;
			$this->detail_delete=NULL;

	    }
	    public function copy(Subject $subj){
	    	if($subj!=NULL){
	    		$this->id=$subj->getID();
				$this->id_subject=$subj->getId_subject();
				$this->students=$subj->getStudents();
				$this->teachers=$subj->getTeachers();
				$this->name=$subj->getName();
				$this->group=$subj->getGroup();
				$this->room=$subj->getRoom();
				$this->build=$subj->getBuild();
				$this->start_at=$subj->getStart_at();
				$this->end_at=$subj->getEnd_at();
				$this->day=$subj->getDay();
				$this->detail_thai=$subj->getDetail_thai();
				$this->detail_eng=$subj->getDetail_eng();
				$this->status_del=$subj->getStatus_del();
				$this->detail_delete=$subj->getDetail_delete();

			}
	    }
	    public static function getMaxId(){
	    	$maxid= SubjectRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= SubjectRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public static function getLastpage($condition){
			$table = DB::table('subject')->where(function($query) use($condition) {
              $query->where('id_subject','like','%'.$condition['word'].'%')
                 ->orWhere('name','like','%'.$condition['word'].'%')
                 ->orWhere('start_at','like','%'.$condition['word'].'%')
                 ->orWhere('room','like','%'.$condition['word'].'%');
            })->where('status_del','=','0')->count();
			return  max(ceil($table/Subject::ROWPERPAGE),1);
		}
		public static function getCount($condition){
			$table = DB::table('subject')->where(function($query) use($condition) {
                $query->where('id_subject','like','%'.$condition['word'].'%')
                 ->orWhere('name','like','%'.$condition['word'].'%')
                 ->orWhere('start_at','like','%'.$condition['word'].'%')
                 ->orWhere('room','like','%'.$condition['word'].'%');
            })->where('status_del','=','0')->count();
			return  $table;
		}
		public static function search($condition,$currentPage){
			$table = DB::table('subject')->where(function($query) use($condition) {
                $query->where('id_subject','like','%'.$condition['word'].'%')
                 ->orWhere('name','like','%'.$condition['word'].'%')
                 ->orWhere('start_at','like','%'.$condition['word'].'%')
                 ->orWhere('room','like','%'.$condition['word'].'%');
            })->where('status_del','=','0')->get();
           	$i = ($currentPage-1)* Subject::ROWPERPAGE;
            $j = $i+min(Subject::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public static function getFromId($id){
			$dataTmp = SubjectRepository::find($id);
			$obj = new Subject;
			
			if($dataTmp!=NULL){
				$obj->setId($dataTmp->ID);
				$obj->setId_subject($dataTmp->id_subject);
				$students=array();
				$studentsTmp = SubjectStudentRelationshipRepository::where('id_subject','=',$dataTmp->ID)->where('status_del','=','0')->get();
				for($i=0;$i<count($studentsTmp);$i++){
					$students[$i]=Student::getFromID($studentsTmp[$i]->{'id_student'});
					//$students[$i]=$studentsTmp[$i]->{'id_student'};
				}
				$obj->setStudents($students);
				$teachers=array();
				$teachersTmp = SubjectTeacherRelationshipRepository::where('id_subject','=',$dataTmp->ID)->where('status_del','=','0')->get();
				for($i=0;$i<count($teachersTmp);$i++){
					$teachers[$i]=Teacher::getFromID($teachersTmp[$i]->{'id_teacher'});
				}
				$obj->setTeachers($teachers);
				$obj->setName($dataTmp->name);
				$obj->setGroup($dataTmp->group);
				$obj->setRoom($dataTmp->room);
				$obj->setBuild($dataTmp->build);
				$obj->setStart_at($dataTmp->start_at);
				$obj->setEnd_at($dataTmp->end_at);
				$obj->setDay($dataTmp->day);
				$obj->setDetail_thai($dataTmp->detail_thai);
				$obj->setDetail_eng($dataTmp->detail_eng);
				$obj->setStatus_del($dataTmp->status_del);
				$obj->setDetail_delete($dataTmp->detail_delete);
				return $obj;
			}
			else{
				return NULL;
			}

		}
		protected static function  importFromId_subject($id_subject){
			return SubjectRepository::where('id_subject','=',$id_subject)->get();
		}
		public static function getFromId_subject($id_subject){
			$dataTmp = Subject::importFromId_subject($id_subject);
			if(count($dataTmp)==1){
				return Subject::getFromId($dataTmp[0]->ID);
			}
			else{
				return NULL;
			}
		}
		public function update(){
				$dataTmp = SubjectRepository::where('ID','=',$this->getID())->get();

				if(count($dataTmp)==1){
					DB::table('subject')->where('ID', '=',$this->getID())->
					update(array(
					'id_subject' => $this->getId_subject()
					 ,'name' => $this->getName() 
					 ,'group' => $this->getGroup() 
					 ,'room' => $this->getRoom() 
					 ,'build' => $this->getBuild() 
					 ,'start_at' => $this->getStart_at() 
					 ,'end_at' => $this->getEnd_at() 
					 ,'day' => $this->getDay() 
					 ,'detail_thai' => $this->getDetail_thai() 
					 ,'detail_eng' => $this->getDetail_eng() 
					 ,'status_del' => $this->getStatus_del() 
					 ,'detail_delete' => $this->getDetail_delete() 
					));
					return true;
				}
			return false;
		}
		public static function getStudentRelationMaxId(){
			$maxid= SubjectStudentRelationshipRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= SubjectStudentRelationshipRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public static function getTeacherRelationMaxId(){
			$maxid= SubjectTeacherRelationshipRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= SubjectTeacherRelationshipRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public function teacherUpdate(){
			$subjectTeacher = SubjectTeacherRelationshipRepository::where('id_subject','=',$this->getID())->
					where('status_del','=','0')->get();
			if(count($subjectTeacher)>0){
				DB::table('subject_teacher_relationship')->where('id_subject', '=',$this->getID())->
					update(array(
					'status_del' => '1'
				));
			}
			for($i=0;$i<count($this->getTeachers());$i++){	
				if(SubjectTeacherRelationshipRepository::where('id_subject','=',$this->getID())->
					where('id_teacher', '=',$this->getTeachers()[$i]->getID())->count()=='1'){
					DB::table('subject_teacher_relationship')->where('id_subject', '=',$this->getID())->
						where('id_teacher', '=',$this->getTeachers()[$i]->getID())->
						update(array(
						'status_del' => '0'
						));
				}
				else{
					$subjectTeacherTmp = new SubjectTeacherRelationshipRepository;
					$subjectTeacherTmp->ID=Subject::getTeacherRelationMaxId()+1;
					$subjectTeacherTmp->id_subject=$this->getID();
					$subjectTeacherTmp->id_teacher=$this->getTeachers()[$i]->getID();
					$subjectTeacherTmp->save();
				}
			}

		}
		public function addAssignment(Assignment $assign){
			$dataTmp = AssignmentRepository::where('ID','=',$assign->getID())->get();
			if(count($dataTmp)==0){
				$dataTmp = new AssignmentRepository;
				$dataTmp->ID = Assignment::getMaxId()+1;
				$dataTmp->id_assignment = $assign->getId_assignment();
				$dataTmp->title = $assign->getTitle();
				$dataTmp->detail = $assign->getDetail();
				$dataTmp->id_doc = $assign->getId_doc();
				$dataTmp->id_subject = $assign->getId_subject();
				$dataTmp->id_teacher= $assign->getId_teacher();
				$dataTmp->date_at = $assign->getDate_at();
				$dataTmp->save();
				return $dataTmp->ID;
			}
			else{
				return false;
			}
		}
		public function addStudy(Study $study){
			$dataTmp = StudyRepository::where('ID','=',$study->getID())->get();
			if(count($dataTmp)==0){
				$dataTmp = new StudyRepository;
				$dataTmp->ID = Study::getMaxId()+1;
				$dataTmp->id_subject = $study->getId_subject();
				$dataTmp->date_at = $study->getDate_at();
				$dataTmp->detail = $study->getDetail();
				$dataTmp->notification = $study->getNotification();
				$dataTmp->save();
				return $dataTmp->ID;
			}
			else{
				return false;
			}
		}
		public function addMessage(Message $message){
			$dataTmp = MessageRepository::where('ID','=',$message->getID())->get();
			if(count($dataTmp)==0){
				$dataTmp = new MessageRepository;
				$dataTmp->ID = Message::getMaxId()+1;
				$dataTmp->title = $message->getTitle();
				$dataTmp->message = $message->getMessage();
				$dataTmp->status = $message->getStatus();
				$dataTmp->detail_delete = $message->getDetail_delete();
				$dataTmp->save();
				return $dataTmp->ID;
			}
			else{
				return false;
			}
		}
		public function addAbsentletter(Absent $abl){
			$dataTmp = AbsentLetterRepository::where('ID','=',$abl->getID())->get();
			if(count($dataTmp)==0){
				$dataTmp = new AbsentLetterRepository;
				$fileTmp = new FileRepository; 
				$dataTmp->ID = Absent::getMaxId()+1;
				$dataTmp->date_at = $abl->getDate_at();
				$dataTmp->detail = $abl->getDetail();
				$dataTmp->status = $abl->getStatus();
				$dataTmp->detail_delete = $abl->getDetail_delete();
				$dataTmp->status_read = $abl->getStatus_read();
				$dataTmp->id_subject = $abl->getId_subject();
				if($abl->getName_file()!=NULL){
					$dataTmp->id_doc = Absent::getMaxFileID()+1;
					$fileTmp->ID = Absent::getMaxFileID()+1;
					$fileTmp->name= $abl->getName_file();
					$fileTmp->save();
					//storage zone
					$connectionString = "DefaultEndpointsProtocol=http;AccountName=rpslmssr;AccountKey=NJ7zmjCLPbw6n7ySPWZRQ0EgR48jjzolffMpMApBVPl2yYfOqgfz0To4C57/lAACSrGL/1AElzeIuwbc6lJNTA==";
					$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
					$content=$abl->getContent_file();
					$blob_name = $abl->getName_file();
					try {
						$blobRestProxy->createBlockBlob("docs", $blob_name, $content);
					}
					catch(ServiceException $e){
						$code = $e->getCode();
						$error_message = $e->getMessage();
						echo $code.": ".$error_message."<br />";
					}
				}
				else{
					$dataTmp->id_doc = 0;
				}

				$dataTmp->save();
				return $dataTmp->ID;
			}
			else{
				return false;
			}
		}
		public function addSubmitAssignment(SubmitAssignment $sma){
			$dataTmp = SubmitAssignmentRepository::where('ID','=',$sma->getID())->get();
			if(count($dataTmp)==0){
				$dataTmp = new SubmitAssignmentRepository;
				$fileTmp = new FileRepository; 
				$dataTmp->ID = SubmitAssignment::getMaxId()+1;
				$dataTmp->id_assignment = $sma->getId_assignment();
				$dataTmp->detail = $sma->getDetail();
				if($sma->getName_file()!=NULL){
					$dataTmp->id_doc = SubmitAssignment::getMaxFileID()+1;
					$fileTmp->ID = SubmitAssignment::getMaxFileID()+1;
					$fileTmp->name= $sma->getName_file();
					$fileTmp->save();
					//storage zone
					$connectionString = "DefaultEndpointsProtocol=http;AccountName=rpslmssr;AccountKey=NJ7zmjCLPbw6n7ySPWZRQ0EgR48jjzolffMpMApBVPl2yYfOqgfz0To4C57/lAACSrGL/1AElzeIuwbc6lJNTA==";
					$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
					$content=$sma->getContent_file();
					$blob_name = $sma->getName_file();
					try {
						$blobRestProxy->createBlockBlob("docs", $blob_name, $content);
					}
					catch(ServiceException $e){
						$code = $e->getCode();
						$error_message = $e->getMessage();
						echo $code.": ".$error_message."<br />";
					}
				}
				else{
					$dataTmp->id_doc = 0;
				}
				$dataTmp->status = $sma->getStatus();
				$dataTmp->id_subject = $sma->getId_subject();
				$dataTmp->save();
				return $dataTmp->ID;
			}
			else{
				DB::table('submit_assignment')->where('ID', '=',$sma->getID())->
					update(array(
					'id_assignment' => $sma->getId_assignment()
					 ,'detail' => $sma->getDetail() 
					 ,'id_doc' => $sma->getId_doc() 
					 ,'status' => $sma->getStatus() 
					 ,'id_subject' => $sma->getId_subject() 
					 
					));
					return $sma->getID();
			}
		}
		public function getAllSubjectFromStudent(){
			$allsubject = array();
			for($i=0;$i<count($this->getStudents());$i++){
				$allsubject= $allsubject+$this->getStudents()[$i]->getSubjects();
			}

			$allsubject = array_unique($allsubject);
			$allObjectSubject = array();
			for($i=0;$i<count($allsubject);$i++){
				$allObjectSubject[$i]= Subject::getFromID($allsubject[$i]);
			}
			return $allObjectSubject;
		}
		public function studentUpdate(){
			$subjectStudent = SubjectStudentRelationshipRepository::where('id_subject','=',$this->getID())->
					where('status_del','=','0')->get();
			if(count($subjectStudent)>0){
				DB::table('subject_student_relationship')->where('id_subject', '=',$this->getID())->
					update(array(
					'status_del' => '1'
				));
			}
			for($i=0;$i<count($this->getStudents());$i++){	
				if(SubjectStudentRelationshipRepository::where('id_subject','=',$this->getID())->
					where('id_student', '=',$this->getStudents()[$i]->getID())->count()=='1'){
					DB::table('subject_student_relationship')->where('id_subject', '=',$this->getID())->
						where('id_student', '=',$this->getStudents()[$i]->getID())->
						update(array(
						'status_del' => '0'
						));
				}
				else{
					$subjectStudentTmp = new SubjectStudentRelationshipRepository;
					$subjectStudentTmp->ID=Subject::getStudentRelationMaxId()+1;
					$subjectStudentTmp->id_subject=$this->getID();
					$subjectStudentTmp->id_student=$this->getStudents()[$i]->getID();
					$subjectStudentTmp->save();
				}
			}
		}
		public function setClassStatus($id_student,$id,$i){
			$tmp = ClassStatus::getFromIDStudy($id);
			if($tmp!=NULL){
				$tmpStudent = $tmp->getId_student();
				$tmpStatus = $tmp->getStatus();
				if(in_array($id_student,$tmpStudent)){
					$index = array_search($id_student,$tmpStudent);
					$tmpStatus[$index] = $i;
				}
				else{
					$tmpStudent[max(array_keys($tmpStudent))+1] = $id_student;
					$tmpStatus[max(array_keys($tmpStatus))+1] = $i;
				}
				$tmp->setId_student($tmpStudent);
				$tmp->setStatus($tmpStatus);

			}
			else{
				$tmp = new ClassStatus;
				$tmp->setId_study($id);
				$tmp->setId_student(array($id_student));
				$tmp->setStatus(array($i));
			}
			$tmp->update();


		}
		public function setClassAssess($id_student,$id,$score){
			$tmp = ClassAssess::getFromIDStudy($id);
			if($tmp!=NULL){
				$tmpStudent = $tmp->getId_student();
				$tmpScore = $tmp->getScore();
				if(in_array($id_student,$tmpStudent)){
					$index = array_search($id_student,$tmpStudent);
					$tmpScore[$index] = $score;
				}
				else{
					$tmpStudent[max(array_keys($tmpStudent))+1] = $id_student;
					$tmpScore[max(array_keys($tmpScore))+1] = $score;
				}
				$tmp->setId_student($tmpStudent);
				$tmp->setScore($tmpScore);
			}
			else{
				$tmp = new ClassAssess;
				$tmp->setId_study($id);
				$tmp->setId_student(array($id_student));
				$tmp->setScore(array($score));
			}
			$tmp->update();
		}
		public function setID($data){
			$this->id=$data;
		}
		public function getID(){
			return $this->id;
		}
		public function setId_subject($data){
			$this->id_subject=$data;
		}
		public function getId_subject(){
			return $this->id_subject;
		}
		public function setName($data){
			$this->name=$data;
		}
		public function getName(){
			return $this->name;
		}
		public function setStudents($data){
			$this->students=$data;
		}
		public function getStudents(){
			return $this->students;
		}
		public function setTeachers($data){
			$this->teachers=$data;
		}
		public function getTeachers(){
			return $this->teachers;
		}	
		public function setGroup($data){
			$this->group=$data;
		}
		public function getGroup(){
			return $this->group;
		}	
		public function setRoom($data){
			$this->room=$data;
		}
		public function getRoom(){
			return $this->room;
		}	
		public function setBuild($data){
			$this->build=$data;
		}
		public function getBuild(){
			return $this->build;
		}	
		public function setStart_at($data){
			$this->start_at=$data;
		}
		public function getStart_at(){
			return $this->start_at;
		}	
		public function setEnd_at($data){
			$this->end_at=$data;
		}
		public function getEnd_at(){
			return $this->end_at;
		}	
		public function setDay($data){
			$this->day=$data;
		}
		public function getDay(){
			return $this->day;
		}		
		public function setDetail_thai($data){
			$this->detail_thai=$data;
		}
		public function getDetail_thai(){
			return $this->detail_thai;
		}	
		public function setDetail_eng($data){
			$this->detail_eng=$data;
		}
		public function getDetail_eng(){
			return $this->detail_eng;
		}		
		public function setStatus_del($data){
			$this->status_del=$data;
		}
		public function getStatus_del(){
			return $this->status_del;
		}
		public function setDetail_delete($data){
			$this->detail_delete = $data;
		}   		
		public function getDetail_delete(){
			return $this->detail_delete;
		}
		public function toString(){
			return 
					'id = '.$this->id.'<br>'.
					'id_subject = '.$this->id_subject.'<br>'.
					'name = '.$this->name.'<br>'.
					'group = '.$this->group.'<br>'.
					'room = '.$this->room.'<br>'.
					'build = '.$this->build.'<br>'.
					'start_at = '.$this->start_at.'<br>'.
					'end_at = '.$this->end_at.'<br>'.
					'day = '.$this->day.'<br>'.
					'detail_thai = '.$this->detail_thai.'<br>'.
					'detail_eng = '.$this->detail_eng.'<br>'.
					'status_del = '.$this->status_del.'<br>'.
					'detail_delete ='.$this->detail_delete.'<br>';
		}
	}	