<?php
	class SubjectStudentRelationshipRepository extends Eloquent{
		public $table = 'subject_student_relationship';
		public static function getMaxId(){
			$maxid= SubjectRepository::orderBy('ID', 'DESC')->first();
			if(!isset($maxid)){
				return "0";
			}
			else{
				return $maxid->ID;
			}
		}
	}