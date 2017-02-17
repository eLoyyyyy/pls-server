<?php

class AdminController extends Controller {
    
    function get_area_executive()
    {
        $success = Admin::getareaexecutive();
        
        if (is_array($success))
        {
            return array('message' => "Operation successful!",
                         'data' => $success,
                         'success' => 1);
        }
        else
        {
            return array('message' => "Operation not successful!",
                         'data' => null,
                         'success' => 0);
        }
    }
    
    function get_unassigned_project()
    {
        $success = Admin::getunassignedproject();
        
        if (is_array($success))
        {
            return array('message' => "Operation successful!",
                         'data' => $success,
                         'success' => 1);
        }
        else
        {
            return array('message' => "Operation not successful!",
                         'data' => null,
                         'success' => 0);
        }
    }
	
	function get_all_user_account()
    {
        $success = Admin::getalluseraccount();
        
        if (is_array($success))
        {
            return array('message' => "Operation successful!",
                         'data' => $success,
                         'success' => 1);
        }
        else
        {
            return array('message' => "Operation not successful!",
                         'data' => null,
                         'success' => 0);
        }
    }
	
	
	function assign_project_employee()
    {   
		$empid = $this->getParams('empid');
		$projid = $this->getParams('projid');
		
		if (!empty($empid) AND !empty($projid)) {
			
			$update = Admin::assignprojectemployee($empid,$projid);
			
			return array('message' => "Operation successful!",
                         'data' => $update,
                         'success' => 1);
			
		}else{
			return array('message' => "Operation not successful!",
                         'data' => $update,
                         'success' => 0);
		}
            
    }
	
	function get_employee_details()
    {   
		$empid = $this->getParams('empid');
		
		if (!empty($empid)) {
			
			$get = Admin::get_account_details($empid);
			
			return array('message' => "Operation successful!",
                         'data' => $get,
                         'success' => 1);
			
		}else{
			return array('message' => "Operation not successful!",
                         'data' => $get,
                         'success' => 0);
		}
            
    }
	
}