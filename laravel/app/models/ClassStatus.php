<?php
	class ClassStatus{
		private $id_study;
		private $status;
		private $id_student;
		private $text_status;
		public function __construct() {
   			$this->id_study=NULL;
			$this->status=NULL;
			$this->id_student=NULL;
			$this->text_status=NULL;
    	}
    	public function cloneClassStatus(ClassStatus $classStatus){	
			if($classStatus!=NULL){
				$this->id_study=$classStatus->getId_study();
				$this->status=$classStatus->getStatus();
				$this->id_student=$classStatus->getId_student();
				$this->text_status=$classStatus->getText_status();
			}
		}
		public static function getMaxId(){
			$maxid= ClassStatusRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		public static function getFromIDStudy($id){
			$dataTmp = ClassStatusRepository::where('id_study','=',$id)->get();
			$txtTmp = ClassStatusTextRepository::all();
			$obj = new ClassStatus;
			
			if(count($dataTmp)>0){
				$obj->setId_study($dataTmp[0]->id_study);
				$statusTmp=array();
				$id_studentTmp=array();
				for($i=0;$i<count($dataTmp);$i++){
					$statusTmp[$i]=	$dataTmp[$i]->status;	
					$id_studentTmp[$i]=	$dataTmp[$i]->id_student;				
				}
				$obj->setStatus($statusTmp);
				$obj->setId_student($id_studentTmp);
				for($i=0;$i<count($txtTmp);$i++){
					$text_statusTmp[$txtTmp[$i]->{'number'}] =  $txtTmp[$i]->{'text'};
				}
				$obj->setText_status($text_statusTmp);
				return $obj;
			}
			else{
				return NULL;
			}

		}
		public function calculateStatus(){
			$tmp=$this->getStatus();
			$txtTmp = $this->getText_status();
			$result=array();
			for($i=0;$i<count($txtTmp);$i++){
					$text_statusTmp[$i]=$txtTmp[$i];
					$result[$text_statusTmp[$i]]=0;
			}
			if($tmp!=NULL){
				sort($tmp);
				for($i=0;$i<count($tmp);$i++){
						$result[$text_statusTmp[$tmp[$i]]]=$result[$text_statusTmp[$tmp[$i]]]+1;
				}
			}
			return $result;
		}
		public static function makeEmptyStatus(){
			$txtTmp = ClassStatusTextRepository::all();
			$result=array();
			for($i=0;$i<count($txtTmp);$i++){
					$text_statusTmp[$i]=$txtTmp[$i]->{'text'};
					$result[$text_statusTmp[$i]]=0;
			}
			return $result;
		}
		public function setId_study($data){
			$this->id_study = $data;
		}
		public function getId_study(){
			return $this->id_study;
		}
		public function setStatus($data){
			$this->status = $data;
		}
		public function getStatus(){
			return $this->status;
		}
		public function setId_student($data){
			$this->id_student = $data;
		}
		public function getId_student(){
			return $this->id_student;
		}
		public function setText_status($data){
			$this->text_status = $data;
		}
		public function getText_status(){
			return $this->text_status;
		}
	}