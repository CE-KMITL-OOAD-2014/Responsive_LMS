<?php
class Assignment extends Contact{
		private $id;
		private $id_assignment;
		private $title;
		private $detail;
		private $id_doc;
		private $id_subject;
		private $id_teacher;
		private $date_at;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id=NULL;
			$this->id_assignment=NULL;
			$this->title=NULL;
			$this->detail=NULL;
			$this->id_doc=NULL;
			$this->id_subject=NULL;
			$this->id_teacher=NULL;
			$this->date_at=NULL;		
	    }
	    public function copy(Assignment $assign){
	    	if($assign!=NULL){
	    		$this->id=$assign->getID();
				$this->id_assignment=$assign->getId_assignment();
				$this->title=$assign->getTitle();
				$this->detail=$assign->getDetail();
				$this->id_doc=$assign->getId_doc();
				$this->id_subject=$assign->getId_subject();
				$this->id_teacher=$assign->getId_teacher();
				$this->date_at=$assign->getDate_at();
				
			}
	    }
		//copy constructor
		public static function cloneFromContact(Contact $contact){
			$obj = new Assignment;
			$obj->cloneContact($contact);
			return $obj;
		} 
		//get maximum column 'id'
		public static function getMaxId(){
	    	$maxid= AssignmentRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= AssignmentRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		//get หน้าสุดท้ายที่ใช้สำหรับแสดงผล
		public static function getLastpage($condition,$id_subj){
			$table = DB::table('assignment')->where(function($query) use($condition) {
              $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->count();
			return  max(ceil($table/Assignment::ROWPERPAGE),1);
		}
		//get จำนวนทั้งหมดของงานที่สั่ง
		public static function getCount($condition,$id_subj){
			$table = DB::table('assignment')->where(function($query) use($condition) {
                $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->count();
			return  $table;
		}
		//ค้นหาข้อมูลของงานที่สั่งตามเงื่อนไข
		public static function search($condition,$currentPage,$id_subj){
			$table = DB::table('assignment')
				->join('contact', 'contact.idsubtable','=','assignment.ID' )
				->where(function($query) use($condition) {
                $query->where('assignment.id_assignment','like','%'.$condition['word'].'%')
                ->orWhere('assignment.title','like','%'.$condition['word'].'%');
            })->where('contact.group_id','=','assignment')
			->where('assignment.id_subject','=',$id_subj)->get(array('contact.ID','assignment.date_at','contact.notification'
				,'assignment.id_assignment','assignment.title','contact.idsubtable'));
           	$i = ($currentPage-1)* Assignment::ROWPERPAGE;
            $j = $i+min(Assignment::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public static function getLastpage_s($condition,$id_subj,$id_user){
			$table = DB::table('assignment')->where(function($query) use($condition) {
                $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->count();
			return  max(ceil($table/Assignment::ROWPERPAGE),1);
		}
		public static function getCount_s($condition,$id_subj,$id_user){
			$table = DB::table('assignment')->where(function($query) use($condition) {
                $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->count();
			return  $table;
		}
		public static function search_s($condition,$currentPage,$id_subj,$id_user){
			$table = DB::table('assignment')
				->join('contact', 'contact.idsubtable','=','assignment.ID' )
				->where(function($query) use($condition) {
                $query->where('assignment.id_assignment','like','%'.$condition['word'].'%')
                ->orWhere('assignment.title','like','%'.$condition['word'].'%');
            })->where('contact.group_id','=','assignment')
			->where('contact.receiver','=',$id_user)
			->where('assignment.id_subject','=',$id_subj)->get(array('contact.ID','assignment.date_at','contact.notification'
				,'assignment.id_assignment','assignment.title','contact.idsubtable'));
           	$i = ($currentPage-1)* Assignment::ROWPERPAGE;
            $j = $i+min(Assignment::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		//get this object ด้วย id ของ contact แล้วใช้ idsubtable ในการค้นหางานที่สั่งด้วย id 
		public static function getFromId($id){
			$conTmp = Contact::getFromId($id);
			if($conTmp!=NULL){
				$dataTmp = AssignmentRepository::find($conTmp->getIdsubtable());
				$obj = new Assignment;
				if($dataTmp!=NULL){
					$obj = Assignment::cloneFromContact($conTmp);
					$obj->setId($dataTmp->ID);
					$obj->setId_assignment($dataTmp->id_assignment);				
					$obj->setTitle($dataTmp->title);
					$obj->setDetail($dataTmp->detail);
					$obj->setId_doc($dataTmp->id_doc);
					$obj->setId_subject($dataTmp->id_subject);
					$obj->setId_teacher($dataTmp->id_teacher);
					$obj->setDate_at($dataTmp->date_at);
					return $obj;
				}
			}
			return NULL;
			
		}

		public function update(){
				parent::update();
				$dataTmp = AssignmentRepository::where('ID','=',$this->getID())->get();

				if(count($dataTmp)==1){
					DB::table('assignment')->where('ID', '=',$this->getID())->
					update(array(
					'id_assignment' => $this->getId_assignment()
					 ,'title' => $this->getTitle() 
					 ,'detail' => $this->getDetail() 
					 ,'id_doc' => $this->getId_doc() 
					 ,'id_subject' => $this->getId_subject() 
					 ,'id_teacher' => $this->getId_teacher() 
					 ,'date_at' => $this->getDate_at() 
					));
					return true;
				}
			return false;
		}
		public function setID($data){
			$this->id=$data;
		}
		public function getID(){
			return $this->id;
		}
		public function setId_assignment($data){
			$this->id_assignment=$data;
		}
		public function getId_assignment(){
			return $this->id_assignment;
		}
		public function setTitle($data){
			$this->title=$data;
		}
		public function getTitle(){
			return $this->title;
		}
		public function setDetail($data){
			$this->detail=$data;
		}
		public function getDetail(){
			return $this->detail;
		}
		public function setId_doc($data){
			$this->id_doc=$data;
		}
		public function getId_doc(){
			return $this->id_doc;
		}
		public function setId_subject($data){
			$this->id_subject=$data;
		}
		public function getId_subject(){
			return $this->id_subject;
		}
		public function setId_teacher($data){
			$this->id_teacher=$data;
		}
		public function getId_teacher(){
			return $this->id_teacher;
		}
		public function setDate_at($data){
			$this->date_at=$data;
		}
		public function getDate_at(){
			return $this->date_at;
		}
		public function toString(){
			return parent::toString().
					'id = '.$this->id.'<br>'.
					'id_assignment = '.$this->id_assignment.'<br>'.
					'title = '.$this->title.'<br>'.
					'detail = '.$this->detail.'<br>'.
					'id_doc = '.$this->id_doc.'<br>'.
					'id_subject = '.$this->id_subject.'<br>'.
					'id_teacher = '.$this->id_teacher.'<br>'.
					'date_at = '.$this->date_at.'<br>';
		}
	}
		
?>