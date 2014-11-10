<?php
class Assignment {
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
		public static function getLastpage($condition,$id_subj){
			$table = DB::table('assignment')->where(function($query) use($condition) {
              $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->count();
			return  max(ceil($table/Assignment::ROWPERPAGE),1);
		}
		public static function getCount($condition,$id_subj){
			$table = DB::table('assignment')->where(function($query) use($condition) {
                $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->count();
			return  $table;
		}
		public static function search($condition,$currentPage,$id_subj){
			$table = DB::table('assignment')->where(function($query) use($condition) {
                $query->where('id_assignment','like','%'.$condition['word'].'%')
                 ->orWhere('title','like','%'.$condition['word'].'%');
            })->where('id_subject','=',$id_subj)->get();
           	$i = ($currentPage-1)* Assignment::ROWPERPAGE;
            $j = $i+min(Assignment::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public static function getFromId($id){
			$dataTmp = AssignmentRepository::find($id);
			$obj = new Assignment;
			
			if($dataTmp!=NULL){
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
			else{
				return NULL;
			}

		}
		public function update(){
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
			return 
					'id = '.$this->id.'<br>'.
					'id_assignment = '.$this->id_assignment.'<br>'.
					'title = '.$this->title.'<br>'.
					'detail = '.$this->detail.'<br>'.
					'id_doc = '.$this->id_doc.'<br>'.
					'id_subject = '.$this->id_subject.'<br>'.
					'id_teacher = '.$this->id_teacher.'<br>'.
					'date_at = '.$this->date_at.'<br>';
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
				return true;
			}
			else{
				return false;
			}
		}
	}
		
?>