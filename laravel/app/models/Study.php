<?php
	class Study{
		private $id;
		private $id_subject;
		private $date_at;
		private $detail;
		private $notification;
		const ROWPERPAGE = 10;	
		public function __construct() {
   			$this->id=NULL;
			$this->id_subject=NULL;
			$this->date_at=NULL;
			$this->detail=NULL;
			$this->notification=NULL;
    	}
    	//copy constructor
    	public function cloneStudy(Study $study){	
			if($study!=NULL){
				$this->id=$study->getID();
				$this->id_subject=$study->getId_subject();
				$this->date_at=$study->getDate_at();
				$this->detail=$study->getDetail();
				$this->notification=$study->getNotification();
			}
		}
		public static function getMaxId(){
			$maxid= StudyRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		//รับค่าข้อมูลห้องเรียนจากฐานข้อมูลโดยระบุ id
		public static function getFromId($id){
			$dataTmp = StudyRepository::find($id);
			$obj = new Study;
			
			if($dataTmp!=NULL){
				$obj->setID($dataTmp->ID);
				$obj->setId_subject($dataTmp->id_subject);
				$obj->setDate_at($dataTmp->date_at);
				$obj->setDetail($dataTmp->detail);
				$obj->setNotification($dataTmp->notification);
				return $obj;
			}
			else{
				return NULL;
			}

		}
		//อ่านค่าจำนวนหน้าทั้งหมดสำหรับหน้าแสดงผล
		public static function getLastpage($id_subj){
			$table = DB::table('study')->where('id_subject','=',$id_subj)->count();
			return  max(ceil($table/Study::ROWPERPAGE),1);
		}
		//อ่านค่าจำนวนข้อมูลทั้งหมดสำหรับหน้าแสดงผล
		public static function getCount($id_subj){
			$table = DB::table('study')->where('id_subject','=',$id_subj)->count();
			return  $table;
		}
		//ค้นหาข้อมูลทั้งหมดสำหรับหน้าแสดงผล
		public static function search($currentPage,$id_subj){
			$table = DB::table('study')->where('id_subject','=',$id_subj)->orderBy('ID', 'DESC')->get();
           	$i = ($currentPage-1)* Study::ROWPERPAGE;
            $j = $i+min(Study::ROWPERPAGE,count($table)-$i);
            $output=array();
            for($k=0;$i<$j;$i++,$k++){
            	$output[$k]=$table[$i];
            }
            return $output;

		}
		public function update(){
			$dataTmp = StudyRepository::find($this->id);
			if($dataTmp!=NULL){
				DB::table('study')->where('ID', '=',$this->id)->update(array('id_subject' => $this->id_subject
					,'date_at' => $this->date_at,'detail' => $this->detail,'notification' => $this->notification
					));
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
		public function setId_subject($data){
			$this->id_subject = $data;
		}
		public function getId_subject(){
			return $this->id_subject;
		}
		public function setDate_at($data){
			$this->date_at = $data;
		}
		public function getDate_at(){
			return $this->date_at;
		}
		public function setDetail($data){
			$this->detail = $data;
		}
		public function getDetail(){
			return $this->detail;
		}	
		public function setNotification($data){
			$this->notification = $data;
		}
		public function getNotification(){
			return $this->notification;
		}		
		public function toString(){
			return 'id = ' . $this->id.'<br>'.
			'id_subject = ' . $this->id_subject.'<br>'.
			'date_at = ' . $this->date_at.'<br>'.
			'detail = ' . $this->detail.'<br>'.
			'notification = ' . $this->notification.'<br>';
		}	

	}