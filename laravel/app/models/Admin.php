<?php
	class Admin extends Users{
		private $telephone;
		private $position;
		private $status_del;
		private $detail_delete;
		const ROWPERPAGE = 10;
		public function __construct() {
			parent::__construct();
			$this->setStatus('9');
			$this->telephone=NULL;
		   	$this->position=NULL;
		   	$this->status_del=0;
		   	$this->detail_delete=NULL;
		}
		public function copy(Admin $user){
			parent::cloneUser($user);
			$this->setStatus('9');
		    $this->telephone=$user->getelephone();
		    $this->position=$user->getPosition();
		    $this->status_del=$user->getStatus_del();
		    $this->detail_delete=$user->getDetail_delete();
		}
		public static function cloneFromUser(Users $user){
			$obj = new Admin;
			$obj->cloneUser($user);
			return $obj;
		} 
		public static function getMaxId(){
			$maxid= AdminRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		
		public function update(){
			if(parent::update()){
				$dataTmp = AdminRepository::where('id_user','=',$this->getID())->get();
				if(count($dataTmp)==1){
					DB::table('user_admin')->where('id_user', '=',$this->getID())->
					update(array('telephone' => $this->getTelephone()
					,'position' => $this->getPosition(),'status_del' => $this->getStatus_del()
					,'detail_delete' => $this->getDetail_delete()));
					return $dataTmp;
				}
			}	
			return true;
		}
		public static function getFromId($id){
			$userTmp = Users::getFromId($id);
			if($userTmp!=NULL){
				$dataTmp = AdminRepository::where('id_user','=',$id)->get();
				if(count($dataTmp)==1){
					$obj = Admin::cloneFromUser($userTmp);
					$obj->setTelephone($dataTmp[0]->telephone);
		   		    $obj->setPosition($dataTmp[0]->position);
		   		    $obj->setStatus_del($dataTmp[0]->status_del);
		   		    $obj->setDetail_delete($dataTmp[0]->detail_delete);
					return $obj;
				}
			}
			return NULL;
		}
		public static function getFromUserPass($user,$pass){
			$dataTmp = Users::importFromUserPass($user,$pass);
			if(count($dataTmp)==1){
				return Admin::getFromId($dataTmp[0]->ID);
			}
			else{
				return NULL;
			}
		}
		public static function getLastpage($condition){
			$table = DB::table('user_admin')
            ->join('user', 'user_admin.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user_admin.position','like','%'.$condition['word'].'%');
            })->where('user_admin.status_del','=','0')->count();
			return  max(ceil($table/Admin::ROWPERPAGE),1);
		}
		public static function getCount($condition){
			$table = DB::table('user_admin')
            ->join('user', 'user_admin.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user_admin.position','like','%'.$condition['word'].'%');
            	})->where('user_admin.status_del','=','0')->count();
			return  $table;
		}
		public static function search($condition,$currentPage){
			$table = DB::table('user_admin')
            ->join('user', 'user_admin.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user_admin.position','like','%'.$condition['word'].'%');
            })->where('user_admin.status_del','=','0')->get();
           	$i = ($currentPage-1)* Admin::ROWPERPAGE;
            $j = $i+min(Admin::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
			

		public function addUser(Users $user){
			$dataTmp = UsersRepository::where('ID','=',$user->getID())->orWhere('username','=',$user->getUsername())->get();
			if(count($dataTmp)==0){
				$dataTmp = new UsersRepository;
				$dataTmp->ID = Users::getMaxId()+1;
				$dataTmp->username = $user->getUsername();
				$dataTmp->password = $user->getPassword();
				$dataTmp->title = $user->getTitle();
				$dataTmp->name = $user->getName();
				$dataTmp->surname = $user->getSurname();
				$dataTmp->email = $user->getEmail();
				$dataTmp->status = $user->getStatus();
				$dataTmp->save();
				return $dataTmp->ID;
			}
			else{
				return false;
			}
		}
		public function addAdmin(Admin $user){
			$user_id=$this->addUser($user);
			if($user_id!=false){
				$dataTmp = AdminRepository::where('id_user','=',$user_id)->get();
				if(count($dataTmp)==0){
					$dataTmp = new AdminRepository;
					$dataTmp->ID = Admin::getMaxId()+1;
					$dataTmp->id_user = $user_id;
					$dataTmp->telephone = $user->getTelephone();
					$dataTmp->position = $user->getPosition();
					$dataTmp->status_del = $user->getStatus_del();
					$dataTmp->detail_delete = $user->getDetail_delete();	
					$dataTmp->save();				
					return true;
				}	
			}
			return false;
		}
		public function addStudent(Student $user){
			$user_id=$this->addUser($user);
			if($user_id!=false){
				$dataTmp = StudentRepository::where('id_user','=',$user_id)->get();
				if(count($dataTmp)==0){
					$dataTmp = new StudentRepository;
					$dataTmp->ID = Student::getMaxId()+1;
					$dataTmp->id_user = $user_id;
					$dataTmp->id_student = $user->getId_student(); 
					$dataTmp->nickname = $user->getNickname(); 
					$dataTmp->birthday_at = $user->getBirthday_at(); 
					$dataTmp->sex = $user->getSex(); 
					$dataTmp->academy = $user->getAcademy(); 
					$dataTmp->yearadmission = $user->getYearadmission(); 
					$dataTmp->faculty = $user->getFaculty(); 
					$dataTmp->student_status = $user->getStudent_status(); 
					$dataTmp->department = $user->getDepartment(); 
					$dataTmp->major = $user->getMajor(); 
					$dataTmp->adviser = $user->getAdviser(); 
					$dataTmp->status_del = $user->getStatus_del(); 
					$dataTmp->detail_delete = $user->getDetail_delete(); 
					//wait subject relation
					$dataTmp->save();				
					return true;
				}	
			}
			return false;
		}
		public function addTeacher(Teacher $user){
			$user_id=$this->addUser($user);
			if($user_id!=false){
				$dataTmp = TeacherRepository::where('id_user','=',$user_id)->get();
				if(count($dataTmp)==0){
					$dataTmp = new TeacherRepository;
					$dataTmp->ID = Teacher::getMaxId()+1;
					$dataTmp->id_user = $user_id;
					$dataTmp->name_user = $user->getName_user();
					$dataTmp->telephone = $user->getTelephone();
					$dataTmp->room = $user->getRoom();
					$dataTmp->history = $user->getHistory();
					$dataTmp->experience = $user->getExperience();
					$dataTmp->status_del = $user->getStatus_del();
					$dataTmp->detail_delete = $user->getDetail_delete();	
					$dataTmp->save();				
					return true;
				}	
			}
			return false;
		}
		public function editUser(Users $user){
			return $user->update();
		}
		public function editAdmin(Admin $user){
			return $user->update();
		}
		public function editStudent(Student $user){
			return $user->update();
		}
		public function editTeacher(Teacher $user){
			return $user->update();
		}
		public function delAdmin(Admin $user,$detail_delete){
			$user->setDetail_delete($detail_delete);
			$user->setStatus_del('1');
			$this->editAdmin($user);
		}
		public function delStudent(Student $user,$detail_delete){
			$user->setDetail_delete($detail_delete);
			$user->setStatus_del('1');
			$this->editStudent($user);
		}
		public function delTeacher(Teacher $user,$detail_delete){
			$user->setDetail_delete($detail_delete);
			$user->setStatus_del('1');
			$this->editTeacher($user);
		}
		public function setTelephone($data){
			$this->telephone = $data;

		}
		public function getTelephone(){
			return $this->telephone;
		}
		public function setPosition($data){
			$this->position = $data;
		}
		public function getPosition(){
			return $this->position;
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
		public function toString(){
			return parent::toString().'telephone = '.$this->telephone.'<br>'.
			'position = '.$this->position.'<br>'.
			'status_del = '.$this->status_del.'<br>'.
			'detail_delete = '.$this->detail_delete.'<br>';
		}
		public static function userIsAdmin(Users $user){
			return ($user!=NULL) && ($user->getStatus()== '9');
		}
		public static function searchExcludeDelUser($table){
			$stack=array();
			foreach ($table as &$value) {
	 			if($value['status_del']=='0'){
	 				array_push($stack,$value);
	 			}
			}
			return $stack;
		}

	}