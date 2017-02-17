<?php

class ApprovalController extends Controller{
    
    function approve_reimbursement()
    {   
        $reimb_id = $this->getParams('reimb_id');
        
        $update = Approval::approve($reimb_id);
		$done = Approval::done($reimb_id);
        
            return array('message' => "Operation not successful!",
                         'data' => $update,
                         'success' => 1);
        
        
    }
	
	function disapprove_reimbursement()
    {   
        $reimb_id = $this->getParams('reimb_id');
        
        $update = Approval::disapprove($reimb_id);
		$done = Approval::done($reimb_id);
        
            return array('message' => "Operation not successful!",
                         'data' => $update,
                         'success' => 1);
        
        
    }
	
	function approve_reimbursement1()
    {   
        $reimb_id = $this->getParams('reimb_id');
        
        $update = Approval::approve1($reimb_id);
		$done = Approval::done($reimb_id);
        
            return array('message' => "Operation not successful!",
                         'data' => $update,
                         'success' => 1);
        
        
    }
	
	function disapprove_reimbursement1()
    {   
        $reimb_id = $this->getParams('reimb_id');
        
        $update = Approval::disapprove1($reimb_id);
		$done = Approval::done($reimb_id);
        
            return array('message' => "Operation not successful!",
                         'data' => $update,
                         'success' => 1);
        
        
    }
    
}
