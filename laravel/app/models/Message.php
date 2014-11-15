<?php
class Message extends Contact{
		private $id;
		private $title;
		private $message;
		private $status;
		private $detail_delete;
		private $created_at;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id=NULL;
			$this->title=NULL;
			$this->message=NULL;
			$this->status=NULL;
			$this->detail_delete=NULL;
			$this->created_at=NULL;
	    }
	    public function copy(Message $message){
	    	if($message!=NULL){
	    		$this->id=$message->getID();
				$this->title=$message->getTitle();
				$this->message=$message->getMessage();
				$this->status=$message->getStatus();
				$this->detail_delete=$message->getDetail_delete();
				$this->created_at=$message->getCreated_at();
			}
	    }
		public static function cloneFromContact(Contact $contact){
			$obj = new Message;
			$obj->cloneContact($contact);
			return $obj;
		} 
		public static function getMaxId(){
	    	$maxid= MessageRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
					$maxid= MessageRepository::orderBy('ID', 'DESC')->first();
					return $maxid->ID;
			}
		}
		public static function getLastpage($condition,$id_user){

			if($condition['read'] =='1'){
				if($condition['unread'] == '1'){
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('message.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['unread'] == '1'){
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('message.status','=','0')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			
			return  max(ceil($table/Assignment::ROWPERPAGE),1);
		}
		public static function getCount($condition,$id_user){
			if($condition['read'] =='1'){
				if($condition['unread'] == '1'){
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('message.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['unread'] == '1'){
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('message.status','=','0')
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			return  $table;
		}
		public static function search($condition,$currentPage,$id_user){
			if($condition['read'] =='1'){
				if($condition['unread'] == '1'){
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('contact.receiver','=',$id_user)->get();
				}
				else{
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('message.status','=','1')
            				->where('contact.receiver','=',$id_user)->get();
				}
			}
			else{
				if($condition['unread'] == '1'){
						$table = DB::table('contact')
            				->join('message', 'contact.idsubtable', '=', 'message.ID')->where('contact.group_id','=','message')
            				->where('message.status','=','0')
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
			$conTmp = Contact::getFromId($id);
			if($conTmp!=NULL){
				$dataTmp = MessageRepository::find($conTmp->getIdsubtable());
				$obj = new Message;
				if($dataTmp!=NULL){
					$obj = Message::cloneFromContact($conTmp);
					$obj->setID($dataTmp->ID);
					$obj->setTitle($dataTmp->title);
					$obj->setMessage($dataTmp->message);
					$obj->setStatus($dataTmp->status);
					$obj->setDetail_delete($dataTmp->detail_delete);
					$obj->setCreated_at($dataTmp->created_at);
					return $obj;
				}
			}
			return NULL;
			
		}
		public function update(){
			$dataTmp = MessageRepository::find($this->id);
			if($dataTmp!=NULL){
				DB::table('message')->where('ID', '=',$this->id)->update(array('status' => $this->status));
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
		public function setTitle($data){
			$this->title=$data;
		}
		public function getTitle(){
			return $this->title;
		}
		public function setMessage($data){
			$this->message=$data;
		}
		public function getMessage(){
			return $this->message;
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
		public function setCreated_at($data){
			$this->created_at=$data;
		}
		public function getCreated_at(){
			return $this->created_at;
		}
		public function toString(){
			return parent::toString().
					'id = '.$this->id.'<br>'.
					'title = '.$this->title.'<br>'.
					'message = '.$this->message.'<br>'.
					'status = '.$this->status.'<br>'.
					'detail_delete = '.$this->detail_delete.'<br>'.
					'created_at = '.$this->created_at.'<br>';
		}
	}
		
?>