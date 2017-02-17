<?php

class Project extends Model {
        
    static function getProjects($employee_id) {     
            
        $sql = "CALL `get_projects`(:employee);";
        $qry = self::getDb()->prepare($sql);
        $qry->execute( array(':employee' => $employee_id) );
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['ProjectID'],
                            'title' => $row['ProjectTitle']);
        }
        
        return $rows;
    }
	
	
            
}