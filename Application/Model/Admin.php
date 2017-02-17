<?php

class Admin extends Model {
        
    static function getareaexecutive() {     
            
        $sql = "Call get_area_executive()";
        $qry = self::getDb()->prepare($sql);
        $qry->execute();
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['EmployeeID'],
                            'lastname' => $row['LastName'],
                            'firstname' => $row['FirstName'],
                            'middlename' => $row['MiddleName'],
                            'suffix' => $row['Suffix'],
                            'position' => $row['Position'],
                            'email' => $row['Email'],
                            'acctuser' => $row['AccountUser']
                );
        }
        
        return $rows;
    }
    
    static function getunassignedproject() {     
            
        $sql = "Call get_project_no_assigned()";
        $qry = self::getDb()->prepare($sql);
        $qry->execute();
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['ProjectID'],
                            'projtitle' => $row['ProjectTitle'],
                            'projdescription' => $row['ProjectDescription']
                );
        }
        
        return $rows;
    }
    
    static function getalluseraccount() {     
            
        $sql = "Call get_employee()";
        $qry = self::getDb()->prepare($sql);
        $qry->execute();
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['EmployeeID'],
                            'lastname' => $row['LastName'],
                            'firstname' => $row['FirstName'],
                            'middlename' => $row['MiddleName'],
                            'suffix' => $row['Suffix'],
                            'position' => $row['Position'],
                            'email' => $row['Email'],
                            'acctuser' => $row['AccountUser']
                );
        }
        
        return $rows;
    }
	
	static function assignprojectemployee($empid,$projid) {     
        
        $sql = "Call assign_project_to_employee(:i_empid,:i_projid)";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':i_empid' => $empid,':i_projid' => $projid));
		
    }
	
	static function get_account_details($empid) {     
            
        $sql = "Call edit_employee_get_details(:empid)";
        $qry = self::getDb()->prepare($sql);
        $qry->execute(array(':empid' => $empid));
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['EmployeeID'],
                            'lastname' => $row['LastName'],
                            'firstname' => $row['FirstName'],
                            'middlename' => $row['MiddleName'],
                            'suffix' => $row['Suffix'],
                            'position' => $row['Position'],
                            'acctuser' => $row['AccountUser'],
                            'email' => $row['Email'],
							'usrlvl' => $row['usrlvl']
                );
        }
        
        return $rows;
    }
	
}
















