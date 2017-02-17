<?php

class SummaryExpensesacctController extends Controller{
	
	function get_summary_expenses()
    {
        $reimb = SummaryExpenses::getCreatedReimbursements();
        
        if (is_array($reimb))
        {
            return array('message' => "Operation successful!",
                         'data' => $reimb,
                         'success' => 1);
        }
        else
        {
            return array('message' => "Operation not successful!",
                         'data' => null,
                         'success' => 0);
        }
    }
	
	function get_summary_expenses_mgmt()
    {
        $reimb = SummaryExpenses::getCreatedReimbursements_mgmt();
        
        if (is_array($reimb))
        {
            return array('message' => "Operation successful!",
                         'data' => $reimb,
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