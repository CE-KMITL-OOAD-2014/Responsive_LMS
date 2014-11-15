<?php
	require_once 'sdkazure\vendor\microsoft\windowsazure\WindowsAzure\WindowsAzure.php';
	require_once 'sdkazure\vendor\autoload.php';

	use WindowsAzure\Common\ServicesBuilder;
	use WindowsAzure\Common\ServiceException;
	use windowsAzure\blob\models\createcontaineroptions;
	use windowsAzure\blob\models\PublicAccessType;
class Absent extends Contact{
		private $date_at;
		private $detail;
		private $status;
		private $detail_delete;
		private $status_read;
		private $id_subject;
		private $id_doc;
		private $name_file;
		private $content_file;
		private $created_at;
		const ROWPERPAGE = 10;
		public function __construct() {
			$this->date_at=NULL;
			$this->detail=NULL;
			$this->status=NULL;
			$this->detail_delete=NULL;
			$this->status_read=NULL;
			$this->id_subject=NULL;
			$this->id_doc=NULL;
			$this->name_file=NULL;
			$this->content_file=NULL;
			$this->created_at=NULL;
	    }
	    public function copy(Absent $absentletter){
	    	if($absentletter!=NULL){
				$this->date_at=$absentletter->getDate_at();
				$this->detail=$absentletter->getDetail();
				$this->status=$absentletter->getStatus();
				$this->detail_delete=$absentletter->getDetail_delete();
				$this->status_read=$absentletter->getStatus_read();
				$this->id_subject=$absentletter->getId_subject();
				$this->id_doc=$absentletter->getId_doc();
				$this->name_file=$absentletter->getName_file();
				$this->content_file=$absentletter->getContent_file();
				$this->created_at=$absentletter->getCreated_at();
			}
	    }
		public static function cloneFromContact(Contact $contact){
			$obj = new Absent;
			$obj->cloneContact($contact);
			return $obj;
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
		public static function getLastpage($condition,$id_user,$id_subj){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
							->where('absentletter.id_subject','=',$id_subj)
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
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','1')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			
			return  max(ceil($table/Absent::ROWPERPAGE),1);
		}
		public static function getCount($condition,$id_user,$id_subj){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
							->where('absentletter.id_subject','=',$id_subj)
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
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->orWhere('absentletter.status','=','1')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			return  $table;
		}
		public static function search($condition,$currentPage,$id_user,$id_subj){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
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
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','1')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.receiver','=',$id_user)->get(array('absentletter.status','absentletter.detail'
            					,'contact.ID','absentletter.created_at','absentletter.date_at'));
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
		/*
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
		}*/
		public static function getFromId($id){
			$conTmp = Contact::getFromId($id);
			if($conTmp!=NULL){
				$dataTmp = AbsentLetterRepository::find($conTmp->getIdsubtable());
				$fileTmp = FileRepository::find($dataTmp->id_doc);
				$obj = new Absent;
				if($dataTmp!=NULL){
					$obj = Absent::cloneFromContact($conTmp);
					$obj->setDate_at($dataTmp->date_at);
					$obj->setDetail($dataTmp->detail);
					$obj->setStatus($dataTmp->status);
					$obj->setDetail_delete($dataTmp->detail_delete);
					$obj->setStatus_read($dataTmp->status_read);
					$obj->setId_subject($dataTmp->id_subject);
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
					
					$obj->setCreated_at($dataTmp->created_at);
					return $obj;
				}
			}
			return NULL;
			
		}
		public function downloadFile(){
			$file = $this->getContent_file();
			$contents = stream_get_contents($file);
			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=".$this->getName_file());
			echo  $contents;

		}
		public function update(){
			$dataTmp = AbsentLetterRepository::find($this->getIdsubtable());
			if($dataTmp!=NULL){
				DB::table('absentletter')->where('ID', '=',$this->getIdsubtable())->update(array('status' => $this->status,'status_read' => $this->status_read)); 
				return true;
			}
			else{
				return false;
			}

		}
		public static function getLastpage_s($condition,$id_user,$id_subj){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
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
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','1')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			
			return  max(ceil($table/Absent::ROWPERPAGE),1);
		}
		public static function getCount_s($condition,$id_user,$id_subj){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
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
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->orWhere('absentletter.status','=','1')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->count();
				}
				else{
						$table = 0;
				}				
			}
			return  $table;
		}
		public static function search_s($condition,$currentPage,$id_user,$id_subj){
			if($condition['approve'] =='1'){
				if($condition['Pending'] == '1' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
				}
				else if($condition['Pending'] == '1' && $condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','1');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
				}
				else if($condition['Pending'] == '0' && $condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where(function($query) {
               					 $query->where('absentletter.status','=','0')
								->orWhere('absentletter.status','=','2');
							})
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
				}
				else{
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','0')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
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
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
				}
				if($condition['unapprove'] == '0'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','1')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
				}
			}
			else{
				if($condition['unapprove'] == '1'){
						$table = DB::table('contact')
            				->join('absentletter', 'contact.idsubtable', '=', 'absentletter.ID')->where('contact.group_id','=','absentletter')
            				->where('absentletter.status','=','2')
							->where('absentletter.id_subject','=',$id_subj)
            				->where('contact.sender','=',$id_user)->get();
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
		public function getId_student(){
			$tmp = Student::getFromID($this->getSender());
			return $tmp->getId_student();
		}
		public function getName_student(){
			$tmp = Student::getFromID($this->getSender());
			return $tmp->getName();
		}
		public function getSurname_student(){
			$tmp = Student::getFromID($this->getSender());
			return $tmp->getSurname();
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
		public function setCreated_at($data){
			$this->created_at=$data;
		}
		public function getCreated_at(){
			return $this->created_at;
		}
		public function toString(){
			return parent::toString().
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
		