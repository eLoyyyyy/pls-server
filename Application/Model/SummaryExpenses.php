<?php

class SummaryExpenses extends Model {

	static function getCreatedReimbursements() {     
            
        $sql = "CALL `for_acct_get_created_reimbursement`();";
        $qry = self::getDb()->prepare($sql);
        $qry->execute();
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('reimbid' => $row['ReimbID'],
                            'date' => $row['DateSubmitted'],
                            'project' => $row['ProjectTitle'],
                            'status' => $row['Status']);
        }
        
        return $rows;
    }
	
	static function getCreatedReimbursements_mgmt() {     
            
        $sql = "CALL `for_mgmt_get_created_reimbursement`();";
        $qry = self::getDb()->prepare($sql);
        $qry->execute();
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('reimbid' => $row['ReimbID'],
                            'date' => $row['DateSubmitted'],
                            'project' => $row['ProjectTitle'],
                            'status' => $row['Status']);
        }
        
        return $rows;
    }
}