<?php
class Absent extends Contact{
		private $id;
		private $date_at;
		private $detail;
		private $status;
		private $detail_delete;
		private $status_read;
		private $id_subject;
		private $id_doc;
		private $created_at;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id=NULL;
			$this->date_at=NULL;
			$this->detail=NULL;
			$this->status=NULL;
			$this->detail_delete=NULL;
			$this->status_read=NULL;
			$this->id_subject=NULL;
			$this->id_doc=NULL;
			$this->created_at=NULL;
	    }
	    public function copy(Absent $absentletter){
	    	if($absentletter!=NULL){
	    		$this->id=$absentletter->getID();
				$this->date_at=$absentletter->getDate_at();
				$this->detail=$absentletter->getDetail();
				$this->status=$absentletter->getStatus();
				$this->detail_delete=$absentletter->getDetail_delete();
				$this->status_read=$absentletter->getStatus_read();
				$this->id_subject=$absentletter->getId_subject();
				$this->id_doc=$absentletter->getId_doc();
				$this->created_at=$absentletter->getCreated_at();
			}
	    }
		public static function getMaxId(){
	    	$maxid= AbsentLetterRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= AbsentLetterRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public static function getLastpage($condition,$id_user){

			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else if($condition['Pending'] =='1'){
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','1')
								->orWhere('absentletter.status','=','2');
							})
            				->where('contact.receiver','=',$id_user)->count();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			
			return  max(ceil($table/Absent::ROWPERPAGE),1);
		}
		public static function getCount($condition,$id_user){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else if($condition['Pending'] =='1'){
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','1')
								->orWhere('absentletter.status','=','2');
							})
            				->where('contact.receiver','=',$id_user)->count();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->orWhere('absentletter.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			return  $table;
		}
		public static function search($condition,$currentPage,$id_user){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('contact.receiver','=',$id_user)->get();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
            				->where('contact.receiver','=',$id_user)->get();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
            				->where('contact.receiver','=',$id_user)->get();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
            				->where('contact.receiver','=',$id_user)->get();
				}
			}
			else if($condition['Pending'] =='1'){
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','1')
								->orWhere('absentletter.status','=','2');
							})
            				->where('contact.receiver','=',$id_user)->get();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','1')
            				->where('contact.receiver','=',$id_user)->get();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
            				->where('contact.receiver','=',$id_user)->get();
				}
				else{
						$table = 0;
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
			$dataTmp = AbsentLetterRepository::find($id);
			$obj = new Absent;
			
			if($dataTmp!=NULL){
				$obj->setID($dataTmp->ID);
				$obj->setDate_at($dataTmp->date_at);
				$obj->setDetail($dataTmp->detail);
				$obj->setStatus($dataTmp->status);
				$obj->setDetail_delete($dataTmp->detail_delete);
				$obj->setStatus_read($dataTmp->status_read);
				$obj->setId_subject($dataTmp->id_subject);
				$obj->setId_doc($dataTmp->id_doc);
				$obj->setCreated_at($dataTmp->created_at);			
				return $obj;
			}
			else{
				return NULL;
			}
		}
		public function update(){
			$dataTmp = AbsentLetterRepository::find($this->id);
			if($dataTmp!=NULL){
				DB::table('absentletter')->where('ID', '=',$this->id)->update(array('status' => $this->status,'status_read' => $this->status_read)); 
				return true;
			}
			else{
				return false;
			}

		}

		public function setID($data){
			$this->id=$data;
		}
		public function getID(){
			return $this->id;
		}
		public function setDate_at($data){
			$this->date_at=$data;
		}
		public function getDate_at(){
			return $this->date_at;
		}
		public function setDetail($data){
			$this->detail=$data;
		}
		public function getDetail(){
			return $this->detail;
		}
		public function setStatus($data){
			$this->status=$data;
		}
		public function getStatus(){
			return $this->status;
		}
		public function setDetail_delete($data){
			$this->detail_delete=$data;
		}
		public function getDetail_delete(){
			return $this->detail_delete;
		}
		public function setStatus_read($data){
			$this->status_read=$data;
		}
		public function getStatus_read(){
			return $this->status_read;
		}
		public function setId_subject($data){
			$this->id_subject=$data;
		}
		public function getId_subject(){
			return $this->id_subject;
		}
		public function setId_doc($data){
			$this->id_doc=$data;
		}
		public function getId_doc(){
			return $this->id_doc;
		}
		public function setCreated_at($data){
			$this->created_at=$data;
		}
		public function getCreated_at(){
			return $this->created_at;
		}
		public function toString(){
			return 
					'id = '.$this->id.'<br>'.
					'date_at = '.$this->date_at.'<br>'.
					'detail = '.$this->detail.'<br>'.
					'status = '.$this->status.'<br>'.
					'detail_delete = '.$this->detail_delete.'<br>'.
					'status_read = '.$this->status_read.'<br>'.
					'id_subject = '.$this->id_subject.'<br>'.
					'id_doc = '.$this->id_doc.'<br>'.
					'created_at = '.$this->created_at.'<br>';
		}
	}
		