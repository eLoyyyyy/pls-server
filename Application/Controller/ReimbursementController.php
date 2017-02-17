<?php

class ReimbursementController extends Controller{
        
    function get_reimbursements()
    {   
        $employee_id = $this->getParams('employee_id');
        $project_id = $this->getParams('project_id');
        
        $reimbursements = Reimbursement::getReimbursements($employee_id, $project_id);
        
        if (is_array($reimbursements))
        {
            return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
        }
        else
        {
            return array('message' => "Operation not successful!",
                         'data' => -1,
                         'success' => 0);
        }
    }
    
    function insert_reimbursement()
    {
        $employee_id = $this->getParams('emp_id');
        $project_id = $this->getParams('proj_id');
        $date_prepared = $this->getParams('dateprepd');
        $description = $this->getParams('desc');
        $amount = $this->getParams('amount');
        $type = $this->getParams('type');
        $reimbursement_id = $this->getParams('reimb_id');
        
        Reimbursement::insertReimbursement($employee_id, $project_id, $date_prepared, $description, $amount, $type, $reimbursement_id);
        
	$reimbursements = array($employee_id, $project_id, $date_prepared, $description, $amount, $type, $reimbursement_id);
		
        return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
    }
    
    function create_reimbursement()
    {
        $u_reimb_id = $this->getParams('u_reimb_id');
        $reimb_id = $this->getParams('reimb_id');
        $proj_id = $this->getParams('proj_id');
        $date = $this->getParams('i_date');
                
        Reimbursement::createReimbursement($u_reimb_id,$reimb_id,$proj_id,$date);
        
        $reimbursements = array($u_reimb_id,$reimb_id,$u_reimb_id,$reimb_id,$proj_id,$date);
        
        return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
    }
    
    function getcreated_reimbursements()
    {
        
        $emp_id = $this->getParams('emp_id');
        
        $reimbursements = Reimbursement::getcreatedReimbursement($emp_id);
        
        return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
    }
    
    function get_reimbursementform_details(){
        
         $employee_id = $this->getParams('employee_id');
         $reimb_id = $this->getParams('reimb_id');
         
         $reimbursements = Reimbursement::getreimbursementformdetails($employee_id,$reimb_id);
         
         return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
    }
    
    function get_reimbursementform_expenses(){
        
         $employee_id = $this->getParams('employee_id');
         $reimb_id = $this->getParams('reimb_id');
         
         $reimbursements = Reimbursement::getreimbursementformexpense($employee_id,$reimb_id);
         
         return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
        
    }
    
    
    //for acct userlvl
    
    function get_reimbursementformdetails_acct(){
        
         $reimb_id = $this->getParams('reimb_id');
         
         $reimbursements = Reimbursement::getreimbursementdetailsacct($reimb_id);
         
         return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
    }
    
    function get_reimbursementformexpense_acct(){
        
         $reimb_id = $this->getParams('reimb_id');
         
         $reimbursements = Reimbursement::getreimbursementexpensesacct($reimb_id);
         
         return array('message' => "Operation successful!",
                         'data' => $reimbursements,
                         'success' => 1);
    }
}
