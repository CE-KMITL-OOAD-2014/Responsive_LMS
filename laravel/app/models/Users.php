<?php
	class Users{
		private $id;
		private $username;
		private $password;
		private $title;
		private $name;
		private $surname;
		private $email;
		private $status;
		public function __construct() {
   			$this->id=NULL;
			$this->username=NULL;
			$this->password=NULL;
			$this->title=NULL;
			$this->name=NULL;
			$this->surname=NULL;
			$this->email=NULL;
			$this->status=NULL;
    	}
    	//copy constructor
    	public function cloneUser(Users $user){	
			if($user!=NULL){
				$this->id=$user->getID();
				$this->username=$user->getUsername();
				$this->password=$user->getPassword();
				$this->title=$user->getTitle();
				$this->name=$user->getName();
				$this->surname=$user->getSurname();
				$this->email=$user->getEmail();
				$this->status=$user->getStatus();
			}
		}
		//get maximum column 'id'
		public static function getMaxId(){
			$maxid= UsersRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		//get this object by specify id
		public static function getFromId($id){
			$dataTmp = UsersRepository::find($id);
			$obj = new Users;
			
			if($dataTmp!=NULL){
				$obj->setId($dataTmp->ID);
				$obj->setUsername($dataTmp->username);
				$obj->setPassword($dataTmp->password);
				$obj->setTitle($dataTmp->title);
				$obj->setName($dataTmp->name);
				$obj->setSurname($dataTmp->surname);
				$obj->setEmail($dataTmp->email);
				$obj->setStatus($dataTmp->status);
				return $obj;
			}
			else{
				return NULL;
			}

		}
		//get data record from userane password
		protected static function  importFromUserPass($user,$pass){
			return UsersRepository::where('username','=',$user)->where('password','=',$pass)->get();
		}
		//get this object by specify username password
		public static function getFromUserPass($user,$pass){
			$dataTmp = Users::importFromUserPass($user,$pass);
			if(count($dataTmp)==1){
				return Users::getFromId($dataTmp[0]->ID);
			}
			else{
				return NULL;
			}
		} 
		public function update(){
			$dataTmp = UsersRepository::find($this->id);
			if($dataTmp!=NULL){
				DB::table('user')->where('ID', '=',$this->id)->update(array('username' => $this->username
					,'password' => $this->password,'title' => $this->title,'name' => $this->name
					,'surname' => $this->surname,'email' => $this->email,'status' => $this->status));
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
		public function setUsername($data){
			$this->username = $data;

		}
		public function getUsername(){
			return $this->username;
		}
		public function setPassword($data){
			$this->password = $data;
		}
		public function getPassword(){
			return $this->password;
		}
		public function setTitle($data){
			$this->title = $data;
		}
		public function getTitle(){
			return $this->title;
		}
		public function setName($data){
			$this->name = $data;
		}
		public function getName(){
			return $this->name;
		}
		public function setSurname($data){
			$this->surname = $data;
		}
		public function getSurname(){
			return $this->surname;
		}
		public function setStatus($data){
			$this->status = $data;
		}
		public function getStatus(){
			return $this->status;
		}
		public function setEmail($data){
			$this->email = $data;
		}
		public function getEmail(){
			return $this->email;
		}

		public function toString(){
			return 'id = ' . $this->id.'<br>'.
			'username = ' . $this->username.'<br>'.
			'password = ' . $this->password.'<br>'.
			'title = ' . $this->title.'<br>'.
			'name = ' . $this->name.'<br>'.
			'surname = ' . $this->surname.'<br>'.
			'email = ' . $this->email.'<br>'.
			'status = ' . $this->status.'<br>';
		}
	}