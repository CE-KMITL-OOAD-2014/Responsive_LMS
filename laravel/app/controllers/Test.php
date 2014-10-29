<?php

	class Test extends BaseController {
		public function userIsAdmin(){
			$str ='10 test<br>';
			$count = 0;
			for($i=0;$i<4;$i++){
				$user[$i]=new Admin;
			}
			for($i=4;$i<8;$i++){
				$user[$i]=new Teacher;
			}
			for($i=8;$i<10;$i++){
				$user[$i]=new Student;
			}
			for($i=0;$i<10;$i++){
				if($i<4){
					if(Admin::userIsAdmin($user[$i])){
						$count++;
					}
				}
				else{
					if(!Admin::userIsAdmin($user[$i])){
						$count++;
					}
				}
			}
			$str.='success '.$count.' test';
			return $str;
		}
		public function searchExcludeDelUser(){
			$str ='10 test<br>';
			$count = 0;
			for($i=0;$i<4;$i++){
				for($j=0;$j<10;$j++){
					$user[$i][$j]=array('ID'=>$i.''.$j,'status_del'=>'0');
				}
			}
			for($i=4;$i<8;$i++){
				for($j=0;$j<10;$j++){
					$user[$i][$j]=array('ID'=>$i.''.$j,'status_del'=>'1');
				}
			}
			for($i=8;$i<10;$i++){
				for($j=0;$j<10;$j++){
					$user[$i][$j]=array('ID'=>$i.''.$j,'status_del'=>'0');
				}
			}
			for($i=0;$i<10;$i++){
				if($i<4){
					$del=0;
					$tmp=Admin::searchExcludeDelUser($user[$i]);
					for($j=0;$j<count($tmp);$j++){
						if($tmp[$j]['status_del']=='1'){
							$del++;
						}
					}
					if($del==0){
						$count++;
					}
				}
				else if($i>=8){
					$del=0;
					$tmp=Admin::searchExcludeDelUser($user[$i]);
					for($j=0;$j<count($tmp);$j++){
						if($tmp[$j]['status_del']=='1'){
							$del++;
						}
					}
					if($del==0){
						$count++;
					}
				}
				else{
					$del=0;
					$tmp=Admin::searchExcludeDelUser($user[$i]);
					for($j=0;$j<count($tmp);$j++){
						if($tmp[$j]['status_del']=='1'){
							$del++;
						}
					}
					if($del==0){
						$count++;
					}
				}
			}
			$str.='success '.$count.' test';
			return $str;
		}
	}