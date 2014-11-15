<?php
	class Contact{
		private $id;
		private $sender;
		private $receiver;
		private $anonymous;
		private $group_id;
		private $idsubtable;
		private $notification;		
		public function __construct() {
   			$this->id=NULL;
			$this->sender=NULL;
			$this->receiver=NULL;
			$this->anonymous=NULL;
			$this->group_id=NULL;
			$this->idsubtable=NULL;
			$this->notification=NULL;
    	}
    	public function cloneContact(Contact $contact){	
			if($contact!=NULL){
				$this->id=$contact->getID();
				$this->sender=$contact->getSender();
				$this->receiver=$contact->getReceiver();
				$this->anonymous=$contact->getAnonymous();
				$this->group_id=$contact->getGroupid();
				$this->idsubtable=$contact->getIdsubtable();
				$this->notification=$contact->getNotification();
			}
		}
		public static function getMaxId(){
			$maxid= ContactRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		public static function getFromId($id){
			$dataTmp = ContactRepository::find($id);
			$obj = new Contact;
			
			if($dataTmp!=NULL){
				$obj->setID($dataTmp->ID);
				$obj->setSender($dataTmp->sender);
				$obj->setReceiver($dataTmp->receiver);
				$obj->setAnonymous($dataTmp->anonymous);
				$obj->setGroupid($dataTmp->group_id);
				$obj->setIdsubtable($dataTmp->idsubtable);
				$obj->setNotification($dataTmp->notification);
				return $obj;
			}
			else{
				return NULL;
			}

		}
		/*public static function getFromSubtable($group_id,$idsubtable){
			$dataTmp = ContactRepository::where('group_id','=',$group_id)->where('id_subtable','=',$idsubtable)->get();
			$obj = new Contact;
			
			$students=array();
				$studentsTmp = SubjectStudentRelationshipRepository::where('id_subject','=',$dataTmp->ID)->where('status_del','=','0')->get();
				for($i=0;$i<count($studentsTmp);$i++){
					$students[$i]=Student::getFromID($studentsTmp[$i]->{'id_student'});
					//$students[$i]=$studentsTmp[$i]->{'id_student'};
				}
				$obj->setStudents($students);
			
			if($dataTmp!=NULL){
				for($i=0;$i<count($dataTmp);$i++){
					$obj->setID($dataTmp->ID);
					$sender=array();
					for($i=0;$i<count($studentsTmp);$i++){
						$sender[$i]=getFromID($studentsTmp[$i]->{'id_student'});
					}
					$obj->setStudents($students);
					$obj->setReceiver($dataTmp->receiver);
					$obj->setAnonymous($dataTmp->anonymous);
					$obj->setGroupid($dataTmp->group_id);
					$obj->setIdsubtable($dataTmp->idsubtable);
					return $obj;
				}
			}
			else{
				return NULL;
			}

		}*/
		public function update(){
			$dataTmp = ContactRepository::find($this->id);
			if($dataTmp!=NULL){
				DB::table('contact')->where('ID', '=',$this->id)->update(array('sender' => $this->sender
					,'receiver' => $this->receiver,'anonymous' => $this->anonymous,'group_id' => $this->group_id,'idsubtable' => $this->idsubtable,'notification' => $this->notification));
				return true;
			}
			else{
				return false;
			}

		}
		public function setID($data){
			$this->id = $data;
		}
		public function getID(){
			return $this->id;
		}
		public function setSender($data){
			$this->sender = $data;
		}
		public function getSender(){
			return $this->sender;
		}
		public function setReceiver($data){
			$this->receiver = $data;
		}
		public function getReceiver(){
			return $this->receiver;
		}
		public function setAnonymous($data){
			$this->anonymous = $data;
		}
		public function getAnonymous(){
			return $this->anonymous;
		}
		public function setGroupid($data){
			$this->group_id = $data;
		}
		public function getGroupid(){
			return $this->group_id;
		}
		public function setIdsubtable($data){
			$this->idsubtable = $data;
		}
		public function getIdsubtable(){
			return $this->idsubtable;
		}
		public function setNotification($data){
			$this->notification = $data;
		}
		public function getNotification(){
			return $this->notification;
		}
		public function toString(){
			return 'id = ' . $this->id.'<br>'.
			'sender = ' . $this->sender.'<br>'.
			'receiver = ' . $this->receiver.'<br>'.
			'anonymous = ' . $this->anonymous.'<br>'.
			'group_id = ' . $this->group_id.'<br>'.
			'idsubtable = ' . $this->idsubtable.'<br>'.
			'notification = ' . $this->notification.'<br>';
		}
		public function addContact(Contact $contact){
			$dataTmp = ContactRepository::where('ID','=',$contact->getID())->get();
			if(count($dataTmp)==0){
				$dataTmp = new ContactRepository;
				$dataTmp->ID = Contact::getMaxId()+1;
				$dataTmp->sender = $contact->getSender();
				$dataTmp->receiver = $contact->getReceiver();
				$dataTmp->anonymous = $contact->getAnonymous();
				$dataTmp->group_id = $contact->getGroupid();
				$dataTmp->idsubtable = $contact->getIdsubtable();
				$dataTmp->notification = $contact->getNotification();
				$dataTmp->save();	
			}						
		}
	}