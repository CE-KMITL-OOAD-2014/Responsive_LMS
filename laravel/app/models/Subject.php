<?php
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
				$this->status_del=$user->getStatus_del();
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
		public function toString(){
			return 
					'id = '.$this->id.'<br>'.
					'id_subject = '.$this->id_subject.'<br>'.
					'name = '.$this->name.'<br>'.
					'students = '.json_encode($this->students).'<br>'.
					'teachers = '.json_encode($this->teachers).'<br>'.
					'group = '.$this->group.'<br>'.
					'room = '.$this->room.'<br>'.
					'build = '.$this->build.'<br>'.
					'start_at = '.$this->start_at.'<br>'.
					'end_at = '.$this->end_at.'<br>'.
					'day = '.$this->day.'<br>'.
					'detail_thai = '.$this->detail_thai.'<br>'.
					'detail_eng = '.$this->detail_eng.'<br>'.
					'status_del = '.$this->status_del.'<br>';
		}
	}	