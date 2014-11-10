<?php
class SubmitAssignment {
		private $id;
		private $id_assignment;
		private $date_at;
		private $id_student;
		private $detail;
		private $id_doc;
		private $status;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id=NULL;
			$this->id_assignment=NULL;
			$this->date_at=NULL;
			$this->id_student=NULL;
			$this->detail=NULL;
			$this->id_doc=NULL;
			$this->status=NULL;	
	    }
	    public function copy(SubmitAssignment $subassign){
	    	if($subassign!=NULL){
	    		$this->id=$subassign->getID();
				$this->id_assignment=$subassign->getId_assignment();
				$this->date_at=$subassign->getDate_at();
				$this->id_student=$subassign->getId_student();
				$this->detail=$subassign->getDetail();
				$this->id_doc=$subassign->getId_doc();
				$this->status=$subassign->getStatus();
			}
	    }
		public static function getMaxId(){
	    	$maxid= SubmitAssignmentRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= SubmitAssignmentRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public static function getFromId($id){
			$dataTmp = SubmitAssignmentRepository::find($id);
			$obj = new SubmitAssignment;
			
			if($dataTmp!=NULL){
				$obj->setId($dataTmp->ID);
				$obj->setId_assignment($dataTmp->id_assignment);
				$obj->setDate_at($dataTmp->date_at);				
				$obj->setId_student($dataTmp->id_student);
				$obj->setDetail($dataTmp->detail);
				$obj->setId_doc($dataTmp->id_doc);
				$obj->setStatus($dataTmp->status);
				
				return $obj;
			}
			else{
				return NULL;
			}

		}
		public static function search($id_assign){
			$table = DB::table('submit_assignment')->where('id_assignment','=',$id_assign)->get();  
            return $table;

		}
		public function update(){
				$dataTmp = SubmitAssignmentRepository::where('ID','=',$this->getID())->get();

				if(count($dataTmp)==1){
					DB::table('submit_assignment')->where('ID', '=',$this->getID())->
					update(array(
					'id_assignment' => $this->getId_assignment()
					 ,'date_at' => $this->getDate_at() 
					 ,'id_student' => $this->getId_student() 
					 ,'detail' => $this->getDetail() 
					 ,'id_doc' => $this->getId_doc() 
					 ,'status' => $this->getStatus() 
					 
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
		public function setDate_at($data){
			$this->date_at=$data;
		}
		public function getDate_at(){
			return $this->date_at;
		}
		public function setId_student($data){
			$this->id_student=$data;
		}
		public function getId_student(){
			return $this->id_student;
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
		public function setStatus($data){
			$this->status=$data;
		}
		public function getStatus(){
			return $this->status;
		}
		public function toString(){
			return 
					'id = '.$this->id.'<br>'.
					'id_assignment = '.$this->id_assignment.'<br>'.
					'date_at = '.$this->date_at.'<br>'.
					'id_student = '.$this->id_student.'<br>'.
					'detail = '.$this->detail.'<br>'.
					'id_doc = '.$this->id_doc.'<br>'.
					'status = '.$this->status.'<br>'.;
					
		}
		/*public function addAssignment(Assignment $assign){
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
		}*/
	}
		
?>