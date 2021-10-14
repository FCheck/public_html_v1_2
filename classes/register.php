<?php
class Register extends Api
{
	public $register;
	public $response;
	
	public function __construct ($data)
	{
		$this->register = new RegisterData ($data);
		$this->submitRegistration ();
	}
	
	private function compileJSON ()
	{
		$arr = (array)$this->register;
		$request = json_encode ($arr);
		return $request;
	}
	
	public function submitRegistration ()
	{
		$request = $this->compileJSON();
		$url = "userdata/register";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		$this->response = $response;
		//echo $request . "<br><br>" . $return;
	}
}

class RegisterStep1 extends Api
{
	public $register;
	public $response;
	
	public function __construct ($data)
	{
		$this->register = new Step1RegisterData ($data);
		$this->submitRegistration ();
	}
	
	private function compileJSON ()
	{
		$arr = (array)$this->register;
		$request = json_encode ($arr);
		return $request;
	}
	
	public function submitRegistration ()
	{
		$request = $this->compileJSON();
		$url = "userdata/register/step1";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		$this->response = $response;
		//echo $request . "<br><br>" . $return;
		$this->send_activation_link_sharpspring ();
	}
	
	private function get_activation_link ()
	{
		$url = "userdata/get/emailcode/".$this->register->emailAddress;
		$return = $this->submit_api_request ("", $url);
		$response = json_decode ($return, true);
		return "http://www.fraudcheck.co.za/activate/".$this->register->emailAddress."/".$response ['message'];
	}
	
	private function send_activation_link_sharpspring ()
	{
		$limit = 500;                                                                         
	   	$offset = 0;                                                                          
																							  
	   	$method = 'getLeads';                                                                 
	   	$params = array('where' => array('emailAddress'=>$this->register->emailAddress), 'limit' => $limit, 'offset' => $offset);          
	   	$requestID = session_id();       
	   	$accountID = '06FCF81DA461BCAEEEE894DEF3B597F4';
	   	$secretKey = '93972DE3C34AB25EDB4234B2FF721742';                                                     
	
	   	$data = array(                                                                                
		   'method' => $method,                                                                      
		   'params' => $params,                                                                      
		   'id' => $requestID,                                                                       
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";  
		
		$response = submit_sharpspring_request ($url, $data);                                                                     
	
		$id = $response['result']['lead'][0]['id'];
		$updates = array ();
		$updates [0] = array ();
		$updates [0] ['id'] = $id;
		$updates [0] ['activation_link_557ff36128b08'] = $this->get_activation_link ();
																							  
	   	$method = 'updateLeads';
	   	$params = array('objects' => $updates);
	
	   	$data = array(
		   'method' => $method,
		   'params' => $params,
		   'id' => $requestID,
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";  
		
		$response = submit_sharpspring_request ($url, $data);
	}
}

class RegisterStep2Consumer extends Api
{
	public $register;
	public $response;
	
	public function __construct ($data)
	{
		$this->register = new Step2RegisterData ($data);
		$this->submitRegistration ();
	}
	
	private function compileJSON ()
	{
		$arr = (array)$this->register;
		$request = json_encode ($arr);
		return $request;
	}
	
	public function submitRegistration ()
	{
		$request = $this->compileJSON();
		$url = "userdata/register/step2/consumer";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		$this->response = $response;
		//echo $request . "<br><br>" . $return;
	}
}

class RegisterStep2Business extends Api
{
	public $user;
	public $business;
	public $response;
	
	public function __construct ($data)
	{
		$this->user = new Step2RegisterData ($data);
		$this->business = new RegisterBusinessData ($data);
		$this->submitRegistration ();
	}
	
	private function compileJSON ()
	{
		$arr ['user'] = (array)$this->user;
		$arr ['business'] = (array)$this->business;
		$request = json_encode ($arr);
		return $request;
	}
	
	public function submitRegistration ()
	{
		$request = $this->compileJSON();
		$url = "userdata/register/step2/business";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		$this->response = $response;
		//echo $request . "<br><br>" . $return;
	}
}

class CompanyRegister extends Api
{
	public $user;
	public $business;
	public $response;
	
	public function __construct ($data)
	{
		$this->user = new RegisterData ($data);
		$this->business = new RegisterBusinessData ($data);
		$this->submitRegistration ();
	}
	
	private function compileJSON ()
	{
		$arr ['user'] = (array)$this->user;
		$arr ['business'] = (array)$this->business;
		$request = json_encode ($arr);
		return $request;
	}
	
	public function submitRegistration ()
	{
		$request = $this->compileJSON();
		$url = "userdata/registerBusiness";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		$this->response = $response;
		//echo $request . "<br><br>" . $return;
	}
}

class RegisterBusinessData
{
	public $companyName;
	public $phoneNumber;
	public $vatNumber;
	public $registrationNumber;
	public $address;
	
	public function __construct ($data)
	{
		$this->companyName = $data ['companyName'];
		$this->phoneNumber = $data ['telno'];
		$this->vatNumber = $data ['vatNumber'];
		$this->registrationNumber = $data ['regNumber'];
		$this->address = new RegisterBusinessAddress ($data);
	}
}

class RegisterTelephone
{
	public $code = 27;
	public $number;
	public $type = "MOBILE";
	
	public function __construct ($data)
	{
		$this->number = $data ['tel'];
	}
}

class RegisterData
{
	public $userPhones = array ();
	public $dateOfBirth;
	public $transactionScope = "USER";
	public $maritalStatus;
	public $idType = "RSA";
	public $emailAddress;
	public $visibilityType = "PRIVATE";
	public $gender;
	public $idNumber;
	public $firstName;
	public $surname;
	public $userAddresses = array ();
	
	public function __construct ($data)
	{
		$data ['maritalStatus'] = "";
		$data ['propertyType'] = "";
		$data ['city'] = "";
		$data ['postalCode'] = "";
		$data ['streetName'] = "";
		$data ['suburb'] = "";
		$data ['buildingName'] = "";
		$data ['province'] = "";
		$data ['addressType'] = "";
		$data ['buildingNumber'] = "";

		$this->userPhones [0] = new RegisterTelephone ($data);
		$this->idNumber = $data ['idNumber'];
		$this->dateOfBirth = $this->get_dob();
		$this->maritalStatus = $data ['maritalStatus'];
		$this->emailAddress = $data ['emailAddress'];
		$this->gender = $this->get_gender();
		$this->firstName = $data ['firstName'];
		$this->surname = $data ['surname'];
		$this->userAddresses [0] = new RegisterAddress ($data);
	}
	
	public function get_gender ()
	{
		$num = substr($this->idNumber,6,1);
		if ($num <= 4)
			return "FEMALE";
		else
			return "MALE";
	}
	
	public function get_dob ()
	{
		$dob =  substr($this->idNumber,4,2) . "-" . substr($this->idNumber,2,2) . "-";
		if (substr($this->idNumber,0,2) > 15)
			$dob .= "19".substr($this->idNumber,0,2);
		else 
			$dob .= "20".substr($this->idNumber,0,2);
		return strtotime ($dob)*1000;
	}
}

class Step2RegisterData
{
	public $maritalStatus;
	public $emailAddress;
	public $userAddresses = array ();
	
	public function __construct ($data)
	{
		//$this->maritalStatus = $data ['maritalStatus'];
		$this->emailAddress = $data ['emailAddress'];
		//$this->userAddresses [0] = new RegisterAddress ($data);
	}
}

class Step1RegisterData
{
	public $userPhones = array ();
	public $emailAddress;
	public $idNumber;
	public $firstName;
	public $surname;
	public $gender;
	public $dateOfBirth;
	
	public function __construct ($data)
	{
		$this->userPhones [0] = new RegisterTelephone ($data);
		$this->idNumber = $data ['idNumber'];
		$this->emailAddress = $data ['emailAddress'];
		$this->firstName = $data ['firstName'];
		$this->surname = $data ['surname'];
		$this->gender = $this->get_gender();
		$this->dateOfBirth = $this->get_dob();
	}
	
	public function get_gender ()
	{
		$num = substr($this->idNumber,6,1);
		if ($num <= 4)
			return "FEMALE";
		else
			return "MALE";
	}
	
	public function get_dob ()
	{
		$dob =  substr($this->idNumber,4,2) . "-" . substr($this->idNumber,2,2) . "-";
		if (substr($this->idNumber,0,2) > 15)
			$dob .= "19".substr($this->idNumber,0,2);
		else 
			$dob .= "20".substr($this->idNumber,0,2);
		return strtotime ($dob)*1000;
	}
}

class RegisterAddress
{
	public $propertyType;
	public $city;
	public $postalCode;
	public $streetName;
	public $suburb;
	public $buildingName;
	public $stateProvince;
	public $addressType;
	public $buildingNumber;
	
	public function __construct ($data)
	{
		$this->propertyType = $data ['propertyType'];
		$this->city = $data ['city'];
		$this->postalCode = $data ['postalCode'];
		$this->streetName = $data ['streetName'];
		$this->suburb = $data ['suburb'];
		$this->buildingName = $data ['buildingName'];
		$this->stateProvince = $data ['province'];
		$this->addressType = $data ['addressType'];
		$this->buildingNumber = $data ['buildingNumber'];
	}
}

class RegisterBusinessAddress
{
	public $city;
	public $postalCode;
	public $streetName;
	public $suburb;
	public $buildingName;
	public $stateProvince;
	public $buildingNumber;
	
	public function __construct ($data)
	{
		$this->city = $data ['companycity'];
		$this->postalCode = $data ['companypostalCode'];
		$this->streetName = $data ['companystreetName'];
		$this->suburb = $data ['companysuburb'];
		$this->buildingName = $data ['companybuildingName'];
		$this->stateProvince = $data ['companystateProvince'];
		$this->buildingNumber = $data ['companybuildingNumber'];
	}
}

class RegisterIndividualDelta extends Api
{
	public $idNumber;
	public $firstname;
	public $surname;
	public $email;
	public $cellNo;
	public $password;
	
	public function __construct ($data)
	{
		$this->idNumber = $data ['idNumber'];
		$this->firstname = $data ['firstName'];
		$this->surname = $data ['surname'];
		$this->email = $data ['email'];
		$this->cellNo = $data ['cellNo'];
		$this->password = $data ['password'];
	}
	
	public function submitRegistration ()
	{
		$request = json_encode ($this);;
		$url = "userdata/register/individual";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		if (strcmp ($response ['status'], "SUCCESS") == 0)
			$this->add_activecampaign_user ();
		return $response;
	}
	
	private function get_activation_link ()
	{
		$url = "userdata/get/emailcode/".$this->email;
		$return = $this->submit_api_request ("", $url);
		$response = json_decode ($return, true);
		return "http://www.fraudcheck.co.za/confirm/".$this->email."/".$response ['message'];
	}
	
	private function send_activation_link_sharpspring ()
	{
		$limit = 500;                                                                         
	   	$offset = 0;                                                                          
																							  
	   	$method = 'getLeads';                                                                 
	   	$params = array('where' => array('emailAddress'=>$this->email), 'limit' => $limit, 'offset' => $offset);          
	   	$requestID = session_id();       
	   	$accountID = '06FCF81DA461BCAEEEE894DEF3B597F4';
	   	$secretKey = '93972DE3C34AB25EDB4234B2FF721742';                                                     
	
	   	$data = array(                                                                                
		   'method' => $method,                                                                      
		   'params' => $params,                                                                      
		   'id' => $requestID,                                                                       
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";  
		
		$response = $this->submit_sharpspring_request ($url, $data);                                                                     
	
		$id = $response['result']['lead'][0]['id'];
		$updates = array ();
		$updates [0] = array ();
		$updates [0] ['id'] = $id;
		$updates [0] ['activation_link_557ff36128b08'] = $this->get_activation_link ();
																							  
	   	$method = 'updateLeads';
	   	$params = array('objects' => $updates);
	
	   	$data = array(
		   'method' => $method,
		   'params' => $params,
		   'id' => $requestID,
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";  
		
		$response = $this->submit_sharpspring_request ($url, $data);
	}
	
	public function add_activecampaign_user ()
	{
		$url = 'https://fraudcheck.api-us1.com';


		$params = array(
			'api_key'      => '8b528cafb603631b6e2aeb9750adf874132498c691506f45601cbc59adf4d27e7e2f945a',
			'api_action'   => 'contact_add',
			'api_output'   => 'json',
		);
		
		$post = array(
			'email'                    => $this->email,
			'first_name'               => $this->firstname,
			'last_name'                => $this->surname,
		
			// add custom fields
			'field[%CELL_PHONE_NUMBER%,0]'      => $this->cellNo,
			'field[%ID_NUMBER_1%,0]'      => $this->idNumber,
		
			// assign to lists:
			'p[6]'                   => 6, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
			'status[6]'              => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
			'instantresponders[3]' => 1, // set to 0 to if you don't want to sent instant autoresponders
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// This section takes the input data and converts it to the proper format
		$data = "";
		foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
		$data = rtrim($data, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// This sample code uses the CURL library for php to establish a connection,
		// submit your request, and show (print out) the response.
		if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
		
		// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		
		// define a final API request - GET
		$api = $url . '/admin/api.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
		//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = (string)curl_exec($request); // execute curl post and store results in $response
		curl_close($request); // close curl object
	}
}

class RegisterBusinessDelta extends Api
{
	public $idNumber;
	public $firstname;
	public $surname;
	public $email;
	public $cellNo;
	public $password;
	public $companyName;
	public $companyPhoneNo;
	
	
	public function __construct ($data)
	{
		$this->idNumber = $data ['idNumber'];
		$this->firstname = $data ['firstName'];
		$this->surname = $data ['surname'];
		$this->email = $data ['email'];
		$this->cellNo = $data ['cellNo'];
		$this->password = $data ['password'];
		$this->companyName = $data ['companyName'];
		$this->companyPhoneNo = $data ['companyPhoneNo'];
	}
	
	public function submitRegistration ()
	{
		$request = json_encode ($this);
		$url = "userdata/register/business";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		if (strcmp ($response ['status'], "SUCCESS") == 0)
			$this->add_activecampaign_user ();
		//	$this->send_activation_link_sharpspring ();
		return $response;
	}
	
	private function get_activation_link ()
	{
		$url = "userdata/get/emailcode/".$this->email;
		$return = $this->submit_api_request ("", $url);
		$response = json_decode ($return, true);
		return "http://www.fraudcheck.co.za/confirm/".$this->email."/".$response ['message'];
	}
	
	private function send_activation_link_sharpspring ()
	{
		$limit = 500;                                                                         
	   	$offset = 0;                                                                          
																							  
	   	$method = 'getLeads';                                                                 
	   	$params = array('where' => array('emailAddress'=>$this->email), 'limit' => $limit, 'offset' => $offset);          
	   	$requestID = session_id();       
	   	$accountID = '06FCF81DA461BCAEEEE894DEF3B597F4';
	   	$secretKey = '93972DE3C34AB25EDB4234B2FF721742';                                                     
	
	   	$data = array(                                                                                
		   'method' => $method,                                                                      
		   'params' => $params,                                                                      
		   'id' => $requestID,                                                                       
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";  
		
		$response = $this->submit_sharpspring_request ($url, $data);                                                                     
	
		$id = $response['result']['lead'][0]['id'];
		$updates = array ();
		$updates [0] = array ();
		$updates [0] ['id'] = $id;
		$updates [0] ['activation_link_557ff36128b08'] = $this->get_activation_link ();
																							  
	   	$method = 'updateLeads';
	   	$params = array('objects' => $updates);
	
	   	$data = array(
		   'method' => $method,
		   'params' => $params,
		   'id' => $requestID,
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";  
		
		$response = $this->submit_sharpspring_request ($url, $data);
	}
	
	public function add_activecampaign_user ()
	{
		$url = 'https://fraudcheck.api-us1.com';


		$params = array(
			'api_key'      => '8b528cafb603631b6e2aeb9750adf874132498c691506f45601cbc59adf4d27e7e2f945a',
			'api_action'   => 'contact_add',
			'api_output'   => 'json',
		);
		
		$post = array(
			'email'                    => $this->email,
			'first_name'               => $this->firstname,
			'last_name'                => $this->surname,
		
			// add custom fields
			'field[%BUSINESS_NAME%,0]'      => $this->companyName , // using the personalization tag instead (make sure to encode the key)
			'field[%BUSINESS_TELEPHONE_NUMBER%,0]'      => $this->companyPhoneNo,
			'field[%CELLPHONE_NUMBER%,0]'      => $this->cellNo,
			'field[%ID_NUMBER%,0]'      => $this->idNumber,
		
			// assign to lists:
			'p[3]'                   => 3, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
			'status[3]'              => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
			'instantresponders[3]' => 1, // set to 0 to if you don't want to sent instant autoresponders
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// This section takes the input data and converts it to the proper format
		$data = "";
		foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
		$data = rtrim($data, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// This sample code uses the CURL library for php to establish a connection,
		// submit your request, and show (print out) the response.
		if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
		
		// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		
		// define a final API request - GET
		$api = $url . '/admin/api.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
		//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = (string)curl_exec($request); // execute curl post and store results in $response
		curl_close($request); // close curl object
	}
}
?>