<?php

class Edit extends Model {
    
    static function editreimbursement($kv,$val) {
        
        $sql = "CALL for_acct_edit_reimbursement(:id,:val);";
		$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':id' => $kv,':val' => $val));
		
    }
    
}