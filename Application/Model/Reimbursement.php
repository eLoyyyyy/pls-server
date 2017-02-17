<?php

class Reimbursement extends Model {
        
    static function getReimbursements($emp_id, $proj_id) {     
            
        $sql = "CALL get_reimbursements(:emp_id, :proj_id);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':emp_id' => $emp_id, ':proj_id' => $proj_id) );
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['ExpenseID'],
                            'desc' => $row['ExpenseDesc'],
                            'type' => $row['ExpenseType'],
                            'amount' => $row['ExpenseAmount']);
        }
        
        return $rows;
    }
    
    static function insertReimbursement($emp_id, $proj_id, $dateprepd, $desc, $amount, $type, $reimb_id) {     
            
        $sql = "CALL insert_reimbursement(:emp_id, :proj_id, :dateprepd, :desc, :amount, :type, :reimb_id);";
	$qry = self::getDb()->prepare($sql);
        $qry->execute( array(':emp_id' => $emp_id, 
                             ':proj_id' => $proj_id,
                             ':dateprepd' => $dateprepd,
                             ':desc' => $desc,
                             ':amount' => $amount,
                             ':type' => $type,
                             ':reimb_id' => $reimb_id) );
    }
    
    static function createReimbursement($u_reimb_id,$reimb_id,$proj_id,$date){
        
        $sql = "CALL create_reimbursement(:u_reimb_id,:reimb_id,:proj_id,:i_date);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':u_reimb_id' => $u_reimb_id,':reimb_id' => $reimb_id,':proj_id' => $proj_id,':i_date' => $date) );
        
    }
	
    static function getcreatedReimbursement($emp_id){
        
        $sql = "CALL get_created_reimbursement(:emp_id);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute(array(':emp_id' => $emp_id));

        $rows = array();
        
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('reimbid' => $row['ReimbID'],
                            'datesubmitted' => $row['DateSubmitted'],
                            'projecttitle' => $row['ProjectTitle'],
                            'status' => $row['Status']);
        }
        return $rows;
    }
    
    static function getreimbursementformdetails($employee_id,$reimb_id){
        
        $sql = "CALL reimbursementform_details(:emp_id,:reimb_id);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute(array(':emp_id' => $employee_id,':reimb_id' => $reimb_id));

        $rows = array();
        
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('reimbid' => $row['ReimbID'],
                            'datesubmitted' => $row['DateSubmitted'],
                            'projecttitle' => $row['ProjectTitle'],
                            'status' => $row['Status'],
                            'approvedacctg' => $row['ApprovedAcctg'],
                            'approvedmgmt' => $row['ApprovedMgmt'],
                            'lastname' => $row['LastName'],
                            'firstname' => $row['FirstName'],
                            'middlename' => $row['MiddleName'],
                            'suffix' => $row['Suffix']
                    );
        }
        return $rows;
        
    }
    
    static function getreimbursementformexpense($employee_id,$reimb_id){
        
        $sql = "CALL reimbursementform_expenses(:emp_id,:reimb_id);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute(array(':emp_id' => $employee_id,':reimb_id' => $reimb_id));

        $rows = array();
        
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('expensedesc' => $row['ExpenseDesc'],
                            'expenseamount' => $row['ExpenseAmount'],
                            'typedesc' => $row['TypeDesc']
                    );
        }
        return $rows;
        
    }
    
    
    
    // for acct userlvl
    
    static function getreimbursementdetailsacct($reimb_id){
        
        $sql = "CALL for_acct_reimbursementform_details(:reimb_id);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute(array(':reimb_id' => $reimb_id));

        $rows = array();
        
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
                    $rows[] = array('reimbid' => $row['ReimbID'],
                            'datesubmitted' => $row['DateSubmitted'],
                            'projecttitle' => $row['ProjectTitle'],
                            'status' => $row['Status'],
                            'approvedacctg' => $row['ApprovedAcctg'],
                            'approvedmgmt' => $row['ApprovedMgmt'],
                            'lastname' => $row['LastName'],
                            'firstname' => $row['FirstName'],
                            'middlename' => $row['MiddleName'],
                            'suffix' => $row['Suffix']
                    );
        }
        return $rows;
    }
    
    
    static function getreimbursementexpensesacct($reimb_id){
        
        $sql = "CALL for_acct_reimbursementform_expenses(:reimb_id);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute(array(':reimb_id' => $reimb_id));

        $rows = array();
        
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('expenseid' => $row['ExpenseID'],
                            'expensedesc' => $row['ExpenseDesc'],
                            'expenseamount' => $row['ExpenseAmount'],
                            'typedesc' => $row['TypeDesc']
                    );
        }
        return $rows;
        
    }
            
}