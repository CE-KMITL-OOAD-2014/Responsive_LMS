<?php
	class ClassAssess{
		private $id_study;
		private $id_student;
		private $score;
		private $text_assess;
		public function __construct() {
   			$this->id_study=NULL;
			$this->id_student=NULL;
			$this->score=NULL;
			$this->text_assess=NULL;
    	}
    	public function cloneClassAssess(ClassAssess $classAssess){	
			if($classAssess!=NULL){
				$this->id_study=$classAssess->getId_study();
				$this->id_student=$classAssess->getId_student();
				$this->score=$classAssess->getScore();
				$this->text_assess=$classAssess->getText_assess();
			}
		}
		public static function getMaxId(){
			$maxid= ClassAssessRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
		public static function getFromIDStudy($id){
			$dataTmp = ClassAssessRepository::where('id_study','=',$id)->get();
			$txtTmp = ClassAssessTextRepository::all();
			$obj = new ClassAssess;
			
			if(count($dataTmp)>0){
				$obj->setId_study($dataTmp[0]->id_study);
				$id_studentTmp=array();
				for($i=0;$i<count($dataTmp);$i++){
					$id_studentTmp[$i]=	$dataTmp[$i]->id_student;				
				}
				$obj->setId_student(array_values(array_unique($id_studentTmp)));
				$studentFromObj=$obj->getId_student();
				$scoreTmp=array();
				for($i=0;$i<count($studentFromObj);$i++){
					$scoreTmp[$i] = ClassAssessRepository::where('id_study','=',''.$id)
							->where('id_student','=',''.$studentFromObj[$i])->get();
					for($j=0;$j<count($scoreTmp[$i]);$j++){
						$score[$i][$j] = $scoreTmp[$i][$j]->{'score'};
					}
				}
				$obj->setScore($score);
				$text_assessTmp=array();
				for($i=0;$i<count($txtTmp);$i++){
					$text_assessTmp[$txtTmp[$i]->{'number'}] =  $txtTmp[$i]->{'text'};
				}
				$obj->setText_assess($text_assessTmp);
				return $obj;
			}
			else{
				return NULL;
			}

		}

		public function calculateResult(){
			$tmpScore=$this->getScore();
			$tmpText=$this->getText_assess();
			$result=array();
			for($i=0;$i<count($tmpText);$i++){
				$result[$tmpText[$i]] = 0;
				for($j=0;$j<count($tmpScore);$j++){
					$result[$tmpText[$i]] += $tmpScore[$j][$i];
				}
				$result[$tmpText[$i]] /= count($tmpScore);
			}
			return $result;
			
		}
		public static function makeEmptyResult(){
			$txtTmp = ClassAssessTextRepository::all();
			$result=array();
			for($i=0;$i<count($txtTmp);$i++){
					$text_statusTmp[$i]=$txtTmp[$i]->{'text'};
					$result[$text_statusTmp[$i]]=0;
			}
			return $result;
		}
		public function update(){
			var_dump($this->getScore());
			var_dump($this->getId_student());
			
		 	 for($i=0;$i<count($this->getId_student());$i++){
				$n=ClassAssessRepository::where('id_study','=',$this->getId_study())
					->where('id_student','=',$this->getId_student()[$i])->count();
					echo($n);
				if($n>0){
					for($j=0;$j<count($this->getScore()[$i]);$j++){
						DB::table('class_assess')->where('id_study', '=',$this->getId_study())
							->where('id_student','=',$this->getId_student()[$i])
							->where('id_assess','=',$j)->
						update(array(
							'score' => $this->getScore()[$i][$j]
						));
					}
				}
				else{
					for($j=0;$j<count($this->getScore()[$i]);$j++){
						$tmp = new ClassAssessRepository;
						$tmp->ID = ClassAssess::getMaxId()+1;
						$tmp->id_study = $this->getId_study();
						$tmp->score = $this->getScore()[$i][$j];
						$tmp->id_assess= $j;
						$tmp->id_student = $this->getId_student()[$i];
						$tmp->save();
					}
				}
			}	
			
			
		}
		public function setId_study($data){
			$this->id_study = $data;
		}
		public function getId_study(){
			return $this->id_study;
		}
		public function setId_student($data){
			$this->id_student = $data;
		}
		public function getId_student(){
			return $this->id_student;
		}
		public function setScore($data){
			$this->score = $data;
		}
		public function getScore(){
			return $this->score;
		}
		public function setText_assess($data){
			$this->text_assess = $data;
		}
		public function getText_assess(){
			return $this->text_assess;
		}
	}