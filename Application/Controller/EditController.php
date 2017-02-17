<?php

class EditController extends Controller{
    
    function edit_reimbursement()
    {   
        $id = $this->getParams('id');
		
		if (!empty($id)) {
			foreach ($id as $key => $value) {
				$kv = "$key";
				$val = "$value";
				
				$update = Edit::editreimbursement($kv,$val);
			}
		}
            return array('message' => "Operation not successful!",
                         'data' => $update,
                         'success' => 1);
    }
    
}