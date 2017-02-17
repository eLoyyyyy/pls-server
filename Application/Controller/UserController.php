<?php

class UserController extends Controller {
    
    function login()
    {
        $gotun = $this->getParams('username');
        $gotpw = $this->getParams('password');
        //$gotpc = $this->getParams('pincode');
        
        if ($gotun == "" && $gotpw == "")
        {
            throw new Exception('Invalid credentials. Please try again.');
        }
        
        $success = User::checkCredentials($gotun, $gotpw); //, $gotpc
        
        if ($success) 
        {
            return array( 'message' => "Login Successful!!",
                          'data' => array('employee_id' => User::getLoginID($gotun, $gotpw)),
                          'success' => true);
        }
        else
        {
            return array( 'message' => "Login Unsuccessful!",
                          'success' => false);
        }
    }
    
    function userlvl()
    {
        $gotun = $this->getParams('username');
        $gotpw = $this->getParams('password');
       // $gotpc = $this->getParams('pincode');
        
        if ($gotun == "" && $gotpw == "")
        {
            throw new Exception('Invalid credentials. Please try again.');
        }
        
        $success = User::checkCredentials($gotun, $gotpw); //, $gotpc
        
        if ($success) 
        {
            return array( 'message' => "Login Successful!!",
                          'data' => array('userlvl' => User::getUsrLvl($gotun, $gotpw)),
                          'success' => true);
        }
        else
        {
            return array( 'message' => "Login Unsuccessful!",
                          'success' => false);
        }
    }
	
	    function change_password()
    {
        $gotid = $this->getParams('emp_id');
        $goto_pw = $this->getParams('old_pass');
        $gotn_pw = $this->getParams('new_pass');
        $pin = $this->getParams('pincode');
        
        if ($pin !== COMPANY_PINCODE)
        {
            throw new Exception('Invalid credentials. Please try again.');
        }
        
        $success = User::changePassword($gotid, $goto_pw, $gotn_pw);
        
        if ($success) 
        {
            return array( 'message' => "Change Password Successful!!",
                          'data' => array('successful' => $success['successful']),
                          'success' => true);
        }
        else
        {
            return array( 'message' => "Change Password Unsuccessful!",
                          'success' => false);
        }
    }
	
	function add_account()
	{
		$lname = $this->getParams('lname');
        $fname = $this->getParams('fname');
        $mname = $this->getParams('mname');
        $suffix = $this->getParams('suffix');
		$position = $this->getParams('position');
        $username = $this->getParams('username');
        $email = $this->getParams('email');
		
		$success = User::addAccount($lname, $fname, $mname, $suffix, $position, $username, $email);
		
		return array( 'message' => "Added 1 user Successfully!!",
                          'data' => array('successful' => $success['successful']),
                          'success' => true);
	}
	
	
	function edit_account()
	{
		$lname = $this->getParams('lname');
        $fname = $this->getParams('fname');
        $mname = $this->getParams('mname');
        $suffix = $this->getParams('suffix');
		$position = $this->getParams('position');
        $username = $this->getParams('username');
        $email = $this->getParams('email');
		$id = $this->getParams('id');
		
		$success = User::editAccount($id, $lname, $fname, $mname, $suffix, $position, $username, $email);
		
		return array( 'message' => "Account has been Successfully edited!!",
                          'data' => array('successful' => $success['successful']),
                          'success' => 1);
	}
	

       function forgot_password()
    {
        $gotid = $this->getParams('emp_id');
        //$goto_pw = $this->getParams('old_pass');
        $gotn_pw = $this->getParams('new_pass');
        $pin = $this->getParams('pincode');
        
        if ($pin !== COMPANY_PINCODE)
        {
            throw new Exception('Invalid credentials. Please try again.');
        }
        
        $success = User::forgotPassword($gotid, $gotn_pw);  // $goto_pw,
        
        if ($success) 
        {
            return array( 'message' => "Change Password Successful!!",
                          'data' => array('successful' => $success['successful']),
                          'success' => true);
        }
        else
        {
            return array( 'message' => "Change Password Unsuccessful!",
                          'success' => false);
        }
    }
	
}
