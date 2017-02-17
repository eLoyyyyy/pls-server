<?php

class User extends Model {
        
    static function checkCredentials($username, $passwd) {     //, $pincode
            
        $sql = "SELECT AccountPass, EmployeeID FROM pls_empaccount WHERE AccountUser = :usrnme;";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':usrnme' => $username) );
        $row = $qry->fetch();
        if ($qry->rowCount() == 1){
            $gotPasswd = $row['AccountPass'];
            
            if (Passhash::check_password($gotPasswd, $passwd)) { // && $pincode == COMPANY_PINCODE
                return true;
            }
            else {
                return false;
            }
        }
    }
	
	static function getLoginID($username, $passwd) {
	
            $sql = "SELECT login(:usrname, :pword) AS `login`;";
            $qry = self::getDb()->prepare($sql);
            $qry->execute( array(':usrname' => $username, ':pword' => $passwd) );
            $row = $qry->fetch();
            if ($qry->rowCount() == 1){
                $gotId = $row['login'];

                return $gotId;
            }
	}
        
        
    static function getUsrLvl($username, $passwd){
            
        $sql = "SELECT usrlvl(:usrname, :pword) AS `userlvl`;";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':usrname' => $username, ':pword' => $passwd) );
        
		$row = $qry->fetch();
            if ($qry->rowCount() == 1){
                $gotId = $row['userlvl'];

                return $gotId;
            }
    }
		
	static function changePassword($employee_id, $old_password, $new_password)
    {
        $sql = "SELECT change_password(:empid, :old_pass, :new_pass) as change_password;";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':empid' => $employee_id, 
                             ':old_pass' => PassHash::hash($old_password),
                             ':new_pass' => PassHash::hash($new_password)) );
        $row = $qry->fetch();
        if ($qry->rowCount() == 1){
            $got = array('successful' => $row['change_password']);

            return $got;
        }
    }
	
	static function addAccount($lname, $fname, $mname, $suffix, $position, $username, $email)
    {
		$password = "Welcome01!";
		$password = PassHash::hash($password);
		if($position == '1'){
			$lvl = $position;
			$position = "Area Executive";
		}elseif($position == '2'){
			$lvl = $position;
			$position = "Accountant";
		}elseif($position == '3'){
			$lvl = $position;
			$position = "Top Management";
		}elseif($position == '4'){
			$lvl = $position;
			$position = "Administrator";
		}else{
			
		}
		
        $sql = "Call insert_employee(:i_last,:i_first,:i_mid,:i_suffix,:i_position,:i_username,:i_password,:i_lvl,:i_email)";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':i_last' => $lname, 
                             ':i_first' => $fname,
                             ':i_mid' => $mname,
							 ':i_suffix' => $suffix,
							 ':i_position' => $position,
							 ':i_username' => $username,
							 ':i_password' => $password,
							 ':i_lvl' => $lvl,
							 ':i_email' => $email)
							 );
							 
    }
	
	
	
	static function editAccount($id, $lname, $fname, $mname, $suffix, $position, $username, $email)
    {
		//$password = "Welcome01!";
		//$password = PassHash::hash($password);
		if($position == '1'){
			$lvl = $position;
			$position = "Area Executive";
		}elseif($position == '2'){
			$lvl = $position;
			$position = "Accountant";
		}elseif($position == '3'){
			$lvl = $position;
			$position = "Top Management";
		}elseif($position == '4'){
			$lvl = $position;
			$position = "Administrator";
		}else{
			
		}
		
        $sql = "Call edit_employee(:id,:i_last,:i_first,:i_mid,:i_suffix,:i_position,:i_username,:i_lvl,:i_email)";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':id' => $id,
							 ':i_last' => $lname, 
                             ':i_first' => $fname,
                             ':i_mid' => $mname,
							 ':i_suffix' => $suffix,
							 ':i_position' => $position,
							 ':i_username' => $username,
                             ':i_email' => $email,
							 ':i_lvl' => $lvl)
							 );
							 
    }

    static function forgotPassword($employee_id, $new_password) // $old_password, 
    {
        $sql = "SELECT forgot_password(:empid, :new_pass) as forgot_password;"; //:old_pass, 
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':empid' => $employee_id, 
                             //':old_pass' => PassHash::hash($old_password),
                             ':new_pass' => PassHash::hash($new_password)) );
        $row = $qry->fetch();
        if ($qry->rowCount() == 1){
            $got = array('successful' => $row['forgot_password']);

            return $got;
        }
    }
            
}


