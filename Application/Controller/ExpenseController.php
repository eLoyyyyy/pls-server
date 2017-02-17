<?php


class ExpenseController extends Controller{
        
    function get_types()
    {        
        $types = Expense::getTypes();
        
        if (is_array($types))
        {
            return array('message' => "Operation successful!",
                         'data' => $types,
                         'success' => 1);
        }
        else
        {
            return array('message' => "Operation not successful!",
                         'data' => null,
                         'success' => 0);
        }
    }
}


