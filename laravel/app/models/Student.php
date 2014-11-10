<?php
	class Student extends Users{
		private $id_student;
		private $nickname;
		private $birthday_at;
		private $sex;
		private $academy;
		private $yearadmission;
		private $faculty;
		private $student_status;
		private $department;
		private $major;
		private $adviser;
		private $status_del;
		private $detail_delete;
		private $subjects;
		const ROWPERPAGE = 10;
		public function __construct() {
			parent::__construct();
			$this->setStatus('0');
		    $this->id_student=NULL;
		    $this->nickname=NULL;
		    $this->birthday_at=NULL;
		    $this->sex=NULL;
		    $this->academy=NULL;
		    $this->yearadmission=NULL;
		    $this->faculty=NULL;
		    $this->student_status=NULL;
		    $this->department=NULL;
		    $this->major=NULL;
		    $this->adviser=NULL;
		    $this->status_del=NULL;
			$this->detail_delete=NULL;
		    $this->subjects=NULL;
		}
		public function copy(Student $user){
			parent::cloneUser($user);
			$this->setStatus('0');
		    $this->id_student=$user->getId_student();
		    $this->nickname=$user->getNickname();
		    $this->birthday_at=$user->getBirthday_at();
		    $this->sex=$user->getSex();
		    $this->academy=$user->getAcademy();
		    $this->yearadmission=$user->getYearadmission();
		    $this->faculty=$user->getFaculty();
		    $this->student_status=$user->getStudent_status();
		    $this->department=$user->getDepartment();
		    $this->major=$user->getMajor();
		    $this->adviser=$user->getAdviser();
		    $this->status_del=getStatus_del();
			$this->detail_delete=getDetail_delete();
		    $this->subjects=$user->getSubjects();
		}
		public static function cloneFromUser(Users $user){
			$obj = new Student;
			$obj->cloneUser($user);
			return $obj;
		} 
		public static function getMaxId(){
			$maxid= StudentRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		public function update(){
			if(parent::update()){
				$dataTmp = StudentRepository::where('id_user','=',$this->getID())->get();
				if(count($dataTmp)==1){
					DB::table('user_student')->where('id_user', '=',$this->getID())->
					update(array('id_student' => $this->getId_student()
					,'nickname' => $this->getNickname(),'sex' => $this->getSex()
					,'academy' => $this->getAcademy(),'yearadmission' => $this->getYearadmission()
					,'faculty' => $this->getFaculty(),'student_status' => $this->getStudent_status()
					,'department' => $this->getDepartment(),'major' => $this->getMajor()
					,'adviser' => $this->getAdviser(),'status_del' => $this->getStatus_del()
					,'detail_delete' => $this->getDetail_delete()));
					//wait subject relation
					return true;
				}
			}	
			return false;
		}
		public static function getFromId($id){
			$userTmp = Users::getFromId($id);
			if($userTmp!=NULL){
				$dataTmp = StudentRepository::where('id_user','=',$id)->get();
				if(count($dataTmp)==1){
					$obj = Student::cloneFromUser($userTmp);
					$obj->setId_student($dataTmp[0]->id_student);
		   		    $obj->setNickname($dataTmp[0]->nickname);
		   		    $obj->setBirthday_at($dataTmp[0]->birthday_at);
		   		    $obj->setSex($dataTmp[0]->sex);
		   		    $obj->setAcademy($dataTmp[0]->academy);
		   		    $obj->setYearadmission($dataTmp[0]->yearadmission);
		   		    $obj->setFaculty($dataTmp[0]->faculty);
		   		    $obj->setStudent_status($dataTmp[0]->student_status);
		   		    $obj->setDepartment($dataTmp[0]->department);
		   		    $obj->setMajor($dataTmp[0]->major);
		   		    $obj->setAdviser($dataTmp[0]->adviser);
		   		    $obj->setStatus_del($dataTmp[0]->status_del);  
					$obj->setDetail_delete($dataTmp[0]->detail_delete);
		   		    $arr = array();
					$table=SubjectStudentRelationshipRepository::where('id_student','=',$id)->where('status_del','=','0')->get();
					for($i=0;$i<count($table);$i++){
						$arr[$i]=$table[$i]->{'id_subject'};
					}
					
		   		    $obj->setSubjects($arr);
					return $obj;
				}
			}
			return NULL;

		}
		public static function getFromUserPass($user,$pass){
			$dataTmp = Users::importFromUserPass($user,$pass);
			if(count($dataTmp)==1){
				return Student::getFromId($dataTmp[0]->ID);
			}
			else{
				return NULL;
			}
		}
		public static function getLastpage($condition){
			$table = DB::table('user_student')
            ->join('user', 'user_student.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user_student.id_student','like','%'.$condition['word'].'%')
                 ->orWhere('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user_student.faculty','like','%'.$condition['word'].'%')
                 ->orWhere('user_student.department','like','%'.$condition['word'].'%');
            })->where('user_student.status_del','=','0')->count();
			return  max(ceil($table/Student::ROWPERPAGE),1);


		}
		public static function getCount($condition){
			$table = DB::table('user_student')
            ->join('user', 'user_student.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user_student.id_student','like','%'.$condition['word'].'%')
                 ->orWhere('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user_student.faculty','like','%'.$condition['word'].'%')
                 ->orWhere('user_student.department','like','%'.$condition['word'].'%');
            })->where('user_student.status_del','=','0')->count();
			return  $table;
		}
		public static function search($condition,$currentPage){
			$table = DB::table('user_student')
            ->join('user', 'user_student.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user_student.id_student','like','%'.$condition['word'].'%')
                 ->orWhere('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user_student.faculty','like','%'.$condition['word'].'%')
                 ->orWhere('user_student.department','like','%'.$condition['word'].'%');
            })->where('user_student.status_del','=','0')->get();
           	$i = ($currentPage-1)* Student::ROWPERPAGE;
            $j = $i+min(Student::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public function setId_student($data){
			$this->id_student = $data;

		}
		public function getId_student(){
			return $this->id_student;
		}
		public function setNickname($data){
			$this->nickname = $data;
		}
		public function getNickname(){
			return $this->nickname;
		}
		public function setBirthday_at($data){
			$this->birthday_at = $data;
		}
		public function getBirthday_at(){
			return $this->birthday_at;
		}
		public function setSex($data){
			$this->sex = $data;
		}
		public function getSex(){
			return $this->sex;
		}
		public function setAcademy($data){
			$this->academy = $data;
		}
		public function getAcademy(){
			return $this->academy;
		}
		public function setYearadmission($data){
			$this->yearadmission = $data;
		}
		public function getYearadmission(){
			return $this->yearadmission;
		}
		public function setFaculty($data){
			$this->faculty = $data;
		}
		public function getFaculty(){
			return $this->faculty;
		}
		public function setStudent_status($data){
			$this->student_status = $data;
		}
		public function getStudent_status(){
			return $this->student_status;
		}
		public function setDepartment($data){
			$this->department = $data;
		}
		public function getDepartment(){
			return $this->department;
		}
		public function setMajor($data){
			$this->major = $data;
		}
		public function getMajor(){
			return $this->major;
		}
		public function setAdviser($data){
			$this->adviser = $data;
		}
		public function getAdviser(){
			return $this->adviser;
		}
		public function setStatus_del($data){
			$this->status_del = $data;
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
		public function setSubjects($data){
			$this->subjects = $data;
		}
		public function getSubjects(){
			return $this->subjects;
		}
		public function toString(){
			return parent::toString().
			'id_student = '.$this->id_student.'<br>'.
			'nickname = '.$this->nickname.'<br>'.
			'birthday_at = '.$this->birthday_at.'<br>'.
			'sex = '.$this->sex.'<br>'.
			'academy = '.$this->academy.'<br>'.
			'yearadmission = '.$this->yearadmission.'<br>'.
			'faculty = '.$this->faculty.'<br>'.
			'student_status = '.$this->student_status.'<br>'.
			'department = '.$this->department.'<br>'.
			'major = '.$this->major.'<br>'.
			'adviser = '.$this->adviser.'<br>'.
			'status_del = '.$this->status_del.'<br>'.
			'detail_delete = '.$this->detail_delete.'<br>'.
			'subjects = '.$this->subjects.'<br>';
		}
	}