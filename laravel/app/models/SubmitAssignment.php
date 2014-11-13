<?php
class SubmitAssignment extends Contact{
		private $id;
		private $id_assignment;
		private $detail;
		private $id_doc;
		private $name_file;
		private $content_file;
		private $status;
		private $update_at;
		private $id_subject;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id=NULL;
			$this->id_assignment=NULL;
			$this->detail=NULL;
			$this->id_doc=NULL;
			$this->name_file=NULL;
			$this->content_file=NULL;
			$this->status=NULL;
			$this->update_at=NULL;
			$this->id_subject=NULL;
					
	    }
	    public function copy(SubmitAssignment $assign){
	    	if($assign!=NULL){
	    		$this->id=$assign->getID();
				$this->id_assignment=$assign->getId_assignment();
				$this->detail=$assign->getDetail();
				$this->id_doc=$assign->getId_doc();
				$this->name_file=$assign->getName_file();;
				$this->content_file=$assign->getContent_file();
				$this->status=$assign->getStatus();
				$this->update_at=$assign->getUpdate_at();
				$this->id_subject=$assign->getId_subject();
				
				
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
		public static function getMaxFileID(){
			$maxid= FileRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= FileRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public static function getLastpage($condition,$id_user){
			if($condition['check'] =='1'){
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('submit_assignment.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('submit_assignment.status','=','0')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			
			return  max(ceil($table/Assignment::ROWPERPAGE),1);
		}
		public static function getCount($condition,$id_user){
			if($condition['check'] =='1'){
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('submit_assignment.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('submit_assignment.status','=','0')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			return  $table;
		}
		public static function search($condition,$currentPage,$id_user){
			if($condition['check'] =='1'){
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('contact.receiver','=',$id_user)->get();
				}
				else{
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('submit_assignment.status','=','1')
            				->where('contact.receiver','=',$id_user)->get();
				}
			}
			else{
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$$condition['idass'])
            				->where('submit_assignment.status','=','0')
            				->where('contact.receiver','=',$id_user)->get();
				}
				else{
						$table = NULL;
				}				
			}
           	$i = ($currentPage-1)* Assignment::ROWPERPAGE;
            $j = $i+min(Assignment::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public static function getFromId($id){
			$dataTmp = SubmitAssignmentRepository::find($id);
			$fileTmp = FileRepository::find($dataTmp->id_doc);
			$obj = new SubmitAssignment;
			
			if($dataTmp!=NULL){
				$obj->setId($dataTmp->ID);
				$obj->setId_assignment($dataTmp->id_assignment);				
				$obj->setDetail($dataTmp->detail);
				$obj->setId_doc($dataTmp->id_doc);
				$obj->setContent_file($fileTmp->ID);
				$obj->getName_file($fileTmp->name);
				$obj->setStatus($dataTmp->status);
				$obj->setUpdate_at($dataTmp->update_at);
				$obj->setId_subject($dataTmp->id_subject);

				return $obj;
			}
			else{
				return NULL;
			}

		}
		public function update(){
				$dataTmp = SubmitAssignmentRepository::where('ID','=',$this->getID())->get();

				if(count($dataTmp)==1){
					DB::table('submit_assignment')->where('ID', '=',$this->getID())->
					update(array(
					'id_assignment' => $this->getId_assignment()
					 ,'detail' => $this->getDetail() 
					 ,'id_doc' => $this->getId_doc() 
					 ,'status' => $this->getStatus() 
					 ,'id_subject' => $this->getId_subject() 
					 
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
		public function setUpdate_at($data){
			$this->update_at=$data;
		}
		public function getUpdate_at(){
			return $this->update_at;
		}
		public function setId_subject($data){
			$this->id_subject=$data;
		}
		public function getId_subject(){
			return $this->id_subject;
		}
		public function setContent_file($data){
			$this->content_file=$data;
		}
		public function getContent_file(){
			return $this->content_file;
		}
		public function setName_file($data){
			$this->name_file=$data;
		}
		public function getName_file(){
			return $this->name_file;
		}

		public function toString(){
			return 
					'id = '.$this->id.'<br>'.
					'id_assignment = '.$this->id_assignment.'<br>'.
					'detail = '.$this->detail.'<br>'.
					'id_doc = '.$this->id_doc.'<br>'.
					'status = '.$this->status.'<br>'.
					'update_at = '.$this->update_at.'<br>'.
					'id_subject = '.$this->id_subject.'<br>';
		}
	}
		
?>