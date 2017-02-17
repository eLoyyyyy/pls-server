<?php

class Approval extends Model {
    
    static function approve($reimb_id) {
        
        $sql = "CALL for_acct_approve(:reimb);";
		$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':reimb' => $reimb_id));
    } 
	
	static function disapprove($reimb_id) {
        
        $sql = "CALL for_acct_disapprove(:reimb);";
		$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':reimb' => $reimb_id));
    } 
    
	static function approve1($reimb_id) {
        
        $sql = "CALL for_mgmt_approve(:reimb);";
		$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':reimb' => $reimb_id));
    } 
	
	static function disapprove1($reimb_id) {
        
        $sql = "CALL for_mgmt_disapprove(:reimb);";
		$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':reimb' => $reimb_id));
    } 
	
	
	//if done
	static function done($reimb_id) {
        
        $sql = "CALL done(:reimb);";
		$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':reimb' => $reimb_id));
    } 
	
}
