<?php
	require_once 'sdkazure\vendor\microsoft\windowsazure\WindowsAzure\WindowsAzure.php';
	require_once 'sdkazure\vendor\autoload.php';

	use WindowsAzure\Common\ServicesBuilder;
	use WindowsAzure\Common\ServiceException;
	use windowsAzure\blob\models\createcontaineroptions;
	use windowsAzure\blob\models\PublicAccessType;
class SubmitAssignment extends Contact{
		private $id_assignment;
		private $detail;
		private $id_doc;
		private $name_file;
		private $content_file;
		private $status;
		private $created_at;
		private $id_subject;
		private $score;
		private $detail_score;
		private $status_score;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->id_assignment=NULL;
			$this->detail=NULL;
			$this->id_doc=NULL;
			$this->name_file=NULL;
			$this->content_file=NULL;
			$this->status=NULL;
			$this->created_at=NULL;
			$this->id_subject=NULL;
			$this->score=NULL;
			$this->detail_score=NULL;
			$this->status_score=NULL;
					
	    }
	    public function copy(SubmitAssignment $assign){
	    	if($assign!=NULL){
				$this->id_assignment=$assign->getId_assignment();
				$this->detail=$assign->getDetail();
				$this->id_doc=$assign->getId_doc();
				$this->name_file=$assign->getName_file();;
				$this->content_file=$assign->getContent_file();
				$this->status=$assign->getStatus();
				$this->created_at=$assign->getCreated_at();
				$this->id_subject=$assign->getId_subject();
				$this->score=$assign->getScore();
				$this->detail_score=$assign->getDetail_score();
				$this->status_score=$assign->getStatus_score();
				
			}
	    }
	    public static function cloneFromContact(Contact $contact){
			$obj = new SubmitAssignment;
			$obj->cloneContact($contact);
			return $obj;
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
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->where('submit_assignment.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$condition['idass'])
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
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->where('submit_assignment.status','=','1')
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['uncheck'] == '1'){
						$table = DB::table('contact')
            				->join('submit_assignment', 'contact.idsubtable', '=', 'submit_assignment.ID')->where('contact.group_id','=','submit_assignment')
							->where('submit_assignment.id_assignment','=',$condition['idass'])
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
						$table = DB::table('submit_assignment')
            				->join('assignment', 'submit_assignment.id_assignment','=','assignment.ID' )
            				->join('contact', 'contact.idsubtable','=','submit_assignment.ID' )
            				->join('user_student','user_student.id_user','=','contact.sender')
            				->join('file','file.ID','=','submit_assignment.id_doc')
            				->where('contact.group_id','=','submit_assignment')
            				->where('contact.receiver','=',$id_user)
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->get(array('submit_assignment.status','contact.ID','submit_assignment.created_at','user_student.id_student',
            					'submit_assignment.detail','submit_assignment.id_doc','submit_assignment.score','submit_assignment.detail_score','file.name'));
				}
				else{
						$table = DB::table('submit_assignment')
            				->join('assignment', 'submit_assignment.id_assignment','=','assignment.ID' )
            				->join('contact', 'contact.idsubtable','=','submit_assignment.ID' )
            				->join('user_student','user_student.id_user','=','contact.sender')
            				->join('file','file.ID','=','submit_assignment.id_doc')
            				->where('contact.group_id','=','submit_assignment')
            				->where('submit_assignment.status','=','1')
            				->where('contact.receiver','=',$id_user)
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->get(array('submit_assignment.status','contact.ID','submit_assignment.created_at','user_student.id_student',
            					'submit_assignment.detail','submit_assignment.id_doc','submit_assignment.score','submit_assignment.detail_score','file.name'));
				}
			}
			else{
				if($condition['uncheck'] == '1'){
						$table = DB::table('submit_assignment')
            				->join('assignment', 'submit_assignment.id_assignment','=','assignment.ID' )
            				->join('contact', 'contact.idsubtable','=','submit_assignment.ID' )
            				->join('user_student','user_student.id_user','=','contact.sender')
            				->join('file','file.ID','=','submit_assignment.id_doc')
            				->where('contact.group_id','=','submit_assignment')
            				->where('submit_assignment.status','=','0')
            				->where('contact.receiver','=',$id_user)
							->where('submit_assignment.id_assignment','=',$condition['idass'])
            				->get(array('submit_assignment.status','contact.ID','submit_assignment.created_at','user_student.id_student',
            					'submit_assignment.detail','submit_assignment.id_doc','submit_assignment.score','submit_assignment.detail_score','file.name'));
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
				$dataTmp = SubmitAssignmentRepository::find($conTmp->getIdsubtable());
				$fileTmp = FileRepository::find($dataTmp->id_doc);
				$obj = new SubmitAssignment;
				if($dataTmp!=NULL){
					$obj = SubmitAssignment::cloneFromContact($conTmp);
					$obj->setId_assignment($dataTmp->id_assignment);				
					$obj->setDetail($dataTmp->detail);
					$obj->setId_doc($dataTmp->id_doc);
					$obj->setName_file($fileTmp->name);
					if($dataTmp->id_doc!='0'){
						$connectionString = "DefaultEndpointsProtocol=http;AccountName=rpslmssr;AccountKey=NJ7zmjCLPbw6n7ySPWZRQ0EgR48jjzolffMpMApBVPl2yYfOqgfz0To4C57/lAACSrGL/1AElzeIuwbc6lJNTA==";
						$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
						$blob_list = $blobRestProxy->listBlobs("docs");
						$blobs = $blob_list->getBlobs();
						$urlTmp = NULL; 
						foreach($blobs as $blob)
						{
							if($blob->getName()==$fileTmp->name){
								$urlTmp = $blob->getUrl();
							}
							
						}
						$urlTmp=str_replace(" ","%20",$urlTmp);
						//echo $urlTmp;
						
						//
						//fopen("https://rpslmssr.blob.core.windows.net/docs/2014-11-13%2017:27:123%20Numerical%20Methods.pdf", "r");
						$file = fopen($urlTmp,"r");
						$obj->setContent_file($file);

					}
					else{
						$obj->setContent_file(NULL);
					}
					
					$obj->setStatus($dataTmp->status);
					$obj->setCreated_at($dataTmp->created_at);
					$obj->setId_subject($dataTmp->id_subject);
					$obj->setScore($dataTmp->score);
					$obj->setDetail_score($dataTmp->detail_score);
					$obj->setStatus_score($dataTmp->status_score);
					return $obj;
				}
			}
			return NULL;
			
		}
		public static function getscore($id_student,$id_subj){
					$table = DB::table('submit_assignment')
            				->join('contact', 'contact.idsubtable','=','submit_assignment.ID' )
            				->where('contact.group_id','=','submit_assignment')
            				->where('submit_assignment.status_score','=','0')
            				->where('contact.receiver','=',$id_student)
							->where('submit_assignment.id_subject','=',$id_subj)
            				->get();
				
			return $table;
			
		}
		public function downloadFile(){
			$file = $this->getContent_file();
			$contents = stream_get_contents($file);
			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=".$this->getName_file());
			echo  $contents;

		}
		public function update(){
				$dataTmp = SubmitAssignmentRepository::where('ID','=',$this->getIdsubtable())->get();

				if(count($dataTmp)==1){
					DB::table('submit_assignment')->where('ID', '=',$this->getIdsubtable())->
					update(array(
					 'status' => $this->getStatus() 
					 ,'score' => $this->getScore() 
					 ,'detail_score' => $this->getDetail_score() 	
					 ,'status_score' => $this->getStatus_score() 					 
					 
					));
					return true;
				}
			return false;
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
		public function setCreated_at($data){
			$this->created_at=$data;
		}
		public function getCreated_at(){
			return $this->created_at;
		}
		public function setId_subject($data){
			$this->id_subject=$data;
		}
		public function getId_subject(){
			return $this->id_subject;
		}
		public function setScore($data){
			$this->score=$data;
		}
		public function getScore(){
			return $this->score;
		}
		public function setDetail_score($data){
			$this->detail_score=$data;
		}
		public function getDetail_score(){
			return $this->detail_score;
		}
		public function setStatus_score($data){
			$this->status_score=$data;
		}
		public function getStatus_score(){
			return $this->status_score;
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
		public function getId_student(){
			$tmp = Student::getFromID($this->getSender());
			return $tmp->getId_student();
		}
		public function toString(){
			return parent::toString().
					'id = '.$this->id.'<br>'.
					'id_assignment = '.$this->id_assignment.'<br>'.
					'detail = '.$this->detail.'<br>'.
					'id_doc = '.$this->id_doc.'<br>'.
					'status = '.$this->status.'<br>'.
					'created_at = '.$this->created_at.'<br>'.
					'id_subject = '.$this->id_subject.'<br>'.
					'score = '.$this->score.'<br>'.
					'detail_score = '.$this->detail_score.'<br>'.
					'status_score = '.$this->status_score.'<br>';
		}
	}
		
?>