<?php
	class Teacher extends Users{
		private $name_user;
		private $telephone;
		private $room;
		private $history;
		private $experience;
		private $status_del;
		private $detail_delete;
		private $subjects;
		const ROWPERPAGE = 10;
		public function __construct() {
			parent::__construct();
			$this->setStatus('1');
		    $this->name_user=NULL;
			$this->telephone=NULL;
			$this->room=NULL;
			$this->history=NULL;
			$this->experience=NULL;
			$this->status_del=NULL;
			$this->detail_delete=NULL;
			$this->subjects=NULL;
		}
		public function copy(Teacher $user){
			parent::cloneUser($user);
			$this->setStatus('1');
			$this->name_user=$user->getName_user();
			$this->telephone=$user->getTelephone();
			$this->room=$user->getRoom();
			$this->history=$user->getHistory();
			$this->experience=$user->getExperience();
			$this->status_del=$user->getStatus_del();
			$this->detail_delete=$user->getDetail_delete();
			$this->subjects=$user->getSubjects();
		}
		public static function cloneFromUser(Users $user){
			$obj = new Teacher;
			$obj->cloneUser($user);
			return $obj;
		} 
		public static function getMaxId(){
			$maxid= TeacherRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		public function update(){
			if(parent::update()){
				$dataTmp = TeacherRepository::where('id_user','=',$this->getID())->get();
				if(count($dataTmp)==1){
					DB::table('user_teacher')->where('id_user', '=',$this->getID())->
					update(array(
					 'name_user' => $this->getName_user()
					,'telephone' => $this->getTelephone()
					,'room' => $this->getRoom()
					,'history' => $this->getHistory()
					,'experience' => $this->getExperience()
					,'status_del' => $this->getStatus_del()
					,'detail_delete' => $this->getDetail_delete()));
					return true;
				}
			}	
			return false;
		}
		public static function getFromId($id){
			$userTmp = Users::getFromId($id);
			if($userTmp!=NULL){
				$dataTmp = TeacherRepository::where('id_user','=',$id)->get();
				if(count($dataTmp)==1){
					$obj = Teacher::cloneFromUser($userTmp);
					$obj->setName_user($dataTmp[0]->name_user);
					$obj->setTelephone($dataTmp[0]->telephone);
					$obj->setRoom($dataTmp[0]->room);
					$obj->setHistory($dataTmp[0]->history);
					$obj->setExperience($dataTmp[0]->experience);
					$obj->setStatus_del($dataTmp[0]->status_del);
					$obj->setDetail_delete($dataTmp[0]->detail_delete);
					$arr = array();
					$table=SubjectTeacherRelationshipRepository::where('id_teacher','=',$id)->where('status_del','=','0')->get();
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
				return Teacher::getFromId($dataTmp[0]->ID);
			}
			else{
				return NULL;
			}
		}
		public static function getLastpage($condition){
			$table = DB::table('user_teacher')
            ->join('user', 'user_teacher.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user.title','like','%'.$condition['word'].'%')
                 ->orWhere('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user.email','like','%'.$condition['word'].'%');
            })->where('user_teacher.status_del','=','0')->count();
			return  max(ceil($table/Teacher::ROWPERPAGE),1);


		}
		public static function getCount($condition){
			$table = DB::table('user_teacher')
            ->join('user', 'user_teacher.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user.title','like','%'.$condition['word'].'%')
                 ->orWhere('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user.email','like','%'.$condition['word'].'%');
            })->where('user_teacher.status_del','=','0')->count();
			return  $table;
		}
		public static function search($condition,$currentPage){
			$table = DB::table('user_teacher')
            ->join('user', 'user_teacher.id_user', '=', 'user.ID')->where(function($query) use($condition) {
                $query->where('user.title','like','%'.$condition['word'].'%')
                 ->orWhere('user.name','like','%'.$condition['word'].'%')
                 ->orWhere('user.surname','like','%'.$condition['word'].'%')
                 ->orWhere('user.email','like','%'.$condition['word'].'%');
            })->where('user_teacher.status_del','=','0')->get();
           	$i = ($currentPage-1)* Teacher::ROWPERPAGE;
            $j = $i+min(Teacher::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public function setName_user($data){
			$this->name_user = $data;
		}
		public function getName_user(){
			return $this->name_user;
		}
		public function setTelephone($data){
			$this->telephone = $data;
		}   		
		public function gettelephone(){
			return $this->telephone;
		}
		public function setRoom($data){
			$this->room = $data;
		} 		
		public function getRoom(){
			return $this->room;
		}
		public function setHistory($data){
			$this->history = $data;
		}   		
		public function getHistory(){
			return $this->history;
		}
		public function setExperience($data){
			$this->experience = $data;
		}   		
		public function getExperience(){
			return $this->experience;
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
			'name_user ='.$this->name_user.'<br>'.
			'telephone ='.$this->telephone.'<br>'.
			'room ='.$this->room.'<br>'.			
			'history ='.$this->history.'<br>'.
			'experience ='.$this->experience.'<br>'.
			'status_del ='.$this->status_del.'<br>'.
			'detail_delete ='.$this->detail_delete.'<br>'.
			'subjects ='.json_encode($this->subjects);
		}
		public static function userIsTeacher($user){
			return ($user!=NULL) && ($user->getStatus()== '1');
		}
		public function getSubjectsFromeId($id){
			$userTmp = Users::getFromId($id);
			$arr = array();
			$obj = Teacher::cloneFromUser($userTmp);
			$table=SubjectTeacherRelationshipRepository::where('id_teacher','=',$id)->where('status_del','=','0')->get();
					for($i=0;$i<count($table);$i++){
						$arr[$i]=$table[$i]->{'id_subject'};
					}
		   		    $obj->setSubjects($arr);
			return $obj;		
		}
	}