<?php


class ProjectController extends Controller{
        
    function get_projects()
    {
        $employee = $this->getParams('employee_id');
        
        $projects = Project::getProjects($employee);
        
        if (is_array($projects))
        {
            return array('message' => "Operation successful!",
                         'data' => $projects,
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
