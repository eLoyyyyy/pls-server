<?php

class Application {
    
    /** @var null The controller */
    private $url_controller = null;

    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;

    /** @var array URL parameters */
    private $params = array();
    
    private $result = array(); 
    
    private $registry;
    
    function __construct()
    {
    }
    
    private function processRequest()
    { 
	//get the encrypted request 
	$request = $_REQUEST['request'];
	
	//get the provided app id
	$app_id = $_REQUEST['app_id'];
        
       
	//check first if the app id exists in the list of applications
	if( $app_id !== _APP_ID ) {
            throw new Exception('Application does not exist!');
	}
	
	//decrypt the request
	$params = json_decode($request,true);
        
        
	//check if the request is valid by checking if it's an array and looking for the controller and action
	if( !isset($params['controller']) || !isset($params['action']) ) {
            throw new Exception('Request is not valid.');
	}
	
	//cast it into an array
	$this->params = (array)$params;
        //$this->params = stripSlashesDeep($params); 
        
        //$this->params = $_REQUEST;
        
    }
    
    function load()
    {
        try
        {
            self::processRequest();

            $controller = ucfirst(strtolower($this->params['controller'])) . "Controller";
            //$controller = stripSlashesDeep($controller);
            
            $action = strtolower($this->params['action']);
            //$action = stripSlashesDeep($action);

            //create a new instance of the controller, and pass
            //it the parameters from the request
            $findme = ROOT . "Application\\Controller\\" . $controller . ".php";
            if (file_exists( $findme )) {
                $controller = new $controller();
                $controller->setParams($this->params);
            } else {
                throw new Exception("Controller is Invalid: {$findme}");
            }
            

            //check if the action exists in the controller. if not, throw an exception.
            if( method_exists($controller, $action) === false ) {
                throw new Exception('Action is invalid.');
            }

            /*execute the action
            $this->result['data'] = $controller->$action();
            $this->result['success'] = true; */
            
            $pre_result = $controller->{$action}();
            $this->result = array( 'message' => $pre_result['message'],
                                   'data' => $pre_result['data'],
                                   'success' => $pre_result['success']
                                );
        
        } catch( Exception $e ) {
            /*catch any exceptions and report the problem
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage(); */
            $this->result = array( 'message' => $e->getMessage(),
                                   'data' => "-1",
                                   'success' => false) ;
        }

        //echo the result of the API call
        if (is_array($this->result))
        {
            echo json_encode($this->result);
        }
        else 
        {
            $tobe = array( 'success' => 0,
                           'data' => '-1',
                           'message' => var_dump($this->result)
                         );
            echo json_encode($tobe);
        }
        exit();
    }
}
