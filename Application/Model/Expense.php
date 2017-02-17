<?php

class Expense extends Model {
        
    static function getTypes() {     
            
        $sql = "CALL get_expense_types();";
        $qry = self::getDb()->prepare($sql);
        $qry->execute();
        $rows = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC))
        {
            $rows[] = array('id' => $row['TypeCode'],
                            'desc' => $row['TypeDesc']);
        }
        
        return $rows;
    }
	
	
            
}



