<?php
class User extends Api
{
	private $id;
	public $email;
	private $password;
	public $visibilityType;
	public $transactionScope;
	public $firstName;
	public $surname;
	public $maidenName;
	public $maritalStatus;
	public $gender;
	public $dateOfBirth;
	public $idNumber;
	public $idType;
	public $emailAddress;
	public $passwordHash;
	public $passwordSalt;
	public $userAddresses = array ();
	public $userPhones = array ();
	public $userRoles = array ();
	public $userProfileVisibility;
	public $registrationDtm;
	public $lastLoginDtm;
	public $lastModifiedDtm;
	public $activationKey;
	public $activationCode;
	public $activatedDtm;
	public $accountId;
	public $purchaseScreened;
	public $referralSource;
	public $creditDiscount;
	public $consumerUser;
	public $backOfficeUser;
	public $status;
	private $credits;
	public $consent;
	public $transactions = array ();
	public $pendings = array ();
	public $criminals = array ();
	public $jointIncome = array ();
	
	public function __construct ($idOrData)
	{
		if (is_int ($idOrData))
		{
			if ($idOrData == -1)
			{
				//do nothing
			}
			else if ($idOrData == 0)
			{
				//get logged in user
				$this->get_logged_in_user ();
			}
			else
			{
				//call user data from database
				$this->id = $idOrData;
				$this->get_user_by_id();
			}
		}
		else if (!empty ($idOrData ['email']))
		{
			//data sent through - probably to register a new user
		}
	}
	
	private function get_logged_in_user ()
	{
		if (isset ($_SESSION ['user_id']))
		{
			$this->id = $_SESSION ['user_id'];
			$this->get_user_by_id ();		
			$this->get_account_credits ();
		}
	}
	
	public function get_credits ()
	{
		return $this->credits;
	}
	public function set_password ($pass)
	{
		$this->password = $pass;
	}
	
	private function add_user_details ($arr)
	{
		$this->id = $arr ['id'];
		$this->email = $arr ['emailAddress'];
		$this->visibilityType = $arr ['visibilityType'];
		$this->transactionScope = $arr ['transactionScope'];
		$this->firstName = $arr ['firstName'];
		$this->surname = $arr ['surname'];
		$this->maidenName = $arr ['maidenName'];
		$this->maritalStatus = $arr ['maritalStatus'];
		$this->gender = $arr ['gender'];
		$this->dateOfBirth = $arr ['dateOfBirth'];
		$this->idNumber = $arr ['idNumber'];
		$this->idType = $arr ['idType'];
		$this->emailAddress = $arr ['emailAddress'];
		$this->passwordHash = $arr ['passwordHash'];
		$this->passwordSalt = $arr ['passwordSalt'];
		foreach ($arr ['userAddresses'] as $arr2)
		{
			$userAddresses [] = new Address ($arr2);
		}
		foreach ($arr ['userPhones'] as $arr2)
		{
			$userPhones [] = new Phone ($arr2);
		}
		foreach ($arr ['userRoles'] as $arr2)
		{
			$this->userRoles [] = new Role ($arr2);
		}
		$this->userProfileVisibility = $arr ['userProfileVisibility'];
		$this->registrationDtm = $arr ['registrationDtm'];
		$this->lastLoginDtm = $arr ['lastLoginDtm'];
		$this->lastModifiedDtm = $arr ['lastModifiedDtm'];
		$this->activationKey = $arr ['activationKey'];
		$this->activationCode = $arr ['activationCode'];
		$this->activatedDtm = $arr ['activatedDtm'];
		$this->accountId = $arr ['accountId'];
		$this->purchaseScreened = $arr ['purchaseScreened'];
		$this->referralSource = $arr ['referralSource'];
		$this->creditDiscount = $arr ['creditDiscount'];
		$this->consumerUser = $arr ['consumerUser'];
		$this->backOfficeUser = $arr ['backOfficeUser'];
		$this->status = $arr ['status'];
	}
	
	public function is_business_account ()
	{
		foreach ($this->userRoles as $role)
		{
			if (strcmp ($role->role, "BUSINESS_ACCOUNT") == 0)
			{
				return true;
			}
		}
		
		$url = "userdata/businessaccount/list";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$businesses = json_decode ($return);
		foreach ($businesses as $business)
		{
			if (strcmp ($business->id, $this->accountId) == 0)
				return true;
		}
		
		return false;
	}
	
	public function days_since_registration ()
	{
		$regdate = $this->registrationDtm/1000;
		$today = time ();
		$diff = $today - $regdate;
		$days = floor ($diff/86400);
		return ($days);
	}

	public function get_user_id ()
	{
		return ($this->id);
	}
	
	public function get_joint_income_estimator ()
	{
		$url = "userdata/incomeEstimator/get/user/".$this->id;
		$request = "";
		$return = $this->submit_api_request ($request, $url,1);
		$response = json_decode ($return, true);
		if (!empty ($response))
		{
			foreach ($response as $income)
			{
				$this->jointIncome [] = new IncomeEstimator ($income);
			}
			//print_r ($response);
		}
	}
	public function print_income_estimator_transactions ()
	{		
		$return = "";
		foreach ($this->jointIncome as $jointIncome)
		{
			if ($jointIncome->response->estimatedIncome > 0)
			{
				$return .= "<tr>"
						. "<td><strong>".$jointIncome->response->person1->name." ".$jointIncome->response->person1->surname."<br>"
							.$jointIncome->response->person2->name." ".$jointIncome->response->person2->surname."</strong></td>"
						. "<td>".$jointIncome->response->person1->idNumber."<br>".$jointIncome->response->person2->idNumber."</td>"
						. "<td>".$jointIncome->requestTimestamp."</td>"
						. "<td>R".number_format ($jointIncome->response->estimatedIncome,0,"."," ")."</td>"
						. "<td><button class=\"btn-primary btn-sm\" onclick=\"window.location.href='joint-report/".$jointIncome->transactionId."'\">View</button></td>"
						. "";
				
				$return .= "</tr>";
			}
		}
		return $return;
	}
	
	public function print_criminal_transactions ()
	{		
		$return = "";
		foreach ($this->criminals as $criminal)
		{
			$return .= "<tr>"
					. "<td><strong>".$criminal->firstName." ".$criminal->surname."</strong></td>"
					. "<td>".$criminal->identifier."</td>"
					. "<td>".$criminal->statusTimestamp."</td>"
					. "<td>";
			switch ($criminal->enquiryResult)
			{
				case 1:
						$return .= "<img src=\"images/fraud-prevention-caution.png\"/>";
				break;
				case 2:
						$return .= "<img src=\"images/fraud-prevention-proceed.png\"/>";
				break;
				default:
						$return .= "<img src=\"images/fraud-prevention-reject.png\"/>";
				break;
			}
			$return .= "</td><td>".$criminal->userFirstName." ".$criminal->userSurname."</td>"
					. "<td>"
					. "<form method=\"post\" action=\"pdf-crim-generate.php\">"
    				. "<input type=\"hidden\" name=\"transactionId\" value=\"".$criminal->transactionId."\" />"
    				. "<input type=\"submit\" class=\"btn-primary btn-sm\" value=\"Download Report\" />"
					. "</form>"
					. "</td>"
					. "</tr>";
		}
		return $return;
	}
	
	public function print_latest_transactions ()
	{
		$return = "";
		foreach ($this->transactions as $transaction)
		{
			$return .= "<tr>"
					. "<td><span class=\"table-green-txt\">".$transaction->firstName." ".$transaction->lastName."</span><br>"
					. "<strong>Mobile Number</strong> ".$transaction->mobileNumber."<br>"
					. date ("d F Y, G:i",$transaction->transactionTimestamp/1000)."</td>"
					. "<td>".$transaction->checkedBy."</td>"
					. "<td>";
			switch ($transaction->screeningResult)
			{
				case "ACCEPT":
						$return .= "<img src=\"images/fraud-prevention-proceed.png\"/>";
				break;
				case "REVIEW":
						$return .= "<img src=\"images/fraud-prevention-caution.png\"/>";
				break;
				case "REJECT":
						$return .= "<img src=\"images/fraud-prevention-reject.png\"/>";
				break;
			}
			$return .= "</td>"
					. "<td><button class=\"btn-primary btn-sm\" onclick=\"window.location.href='assessment-report/".$transaction->transactionId."'\">View</button></td>"
					. "</tr>";
		}
		return $return;
	}
	
	public function print_pending_consent ()
	{
		$this->get_pending_consent_by_user_id ();
		$return = "";
		foreach ($this->pendings as $pending)
		{
			$return .= "<tr>"
					. "<td><strong>".$pending->firstName." ".$pending->surname."</strong></td>"
					. "<td>".$pending->mobileNumber."<br>"
					. "<td>".$pending->requestDtm."</td>";

			//$return .= "<td><button class=\"btn-primary btn-sm\" onclick=\"window.location.href='pending-consent/".$pending->permissionRequestId."'\">Cancel</button></td>";
			$return .= "</tr>";
		}
		return $return;
	}
	
	public function print_pending_criminal ()
	{
		$this->get_pending_criminal_by_user_id ();
		return $this->print_criminal_list ();
	}
	
	public function print_criminal_list ()
	{
		$return = "";
		foreach ($this->criminals as $criminal)
		{
			$return .= "<tr>"
					. "<td><strong>".$criminal->firstName." ".$criminal->surname."</strong></td>"
					. "<td>".$criminal->identifier."</td>"
					. "<td>".$criminal->statusTimestamp."</td>"
					. "<td>".$criminal->userFirstName." ".$criminal->userSurname."<br>";
			$return .= "<td><button class=\"btn-primary btn-sm\" onclick=\"window.location.href='criminal-list/release/".$criminal->transactionId."'\">Release</button></td>";
			$return .= "<td><button class=\"btn-primary btn-sm\" onclick=\"window.location.href='criminal-list/cancel/".$criminal->transactionId."'\">Cancel</button></td>"
					. "</tr>";
		}
		return $return;
	}
	
	public function print_pending_criminal_id_search ($id)
	{
		$this->get_pending_criminal_by_id_number ($id);
		return $this->print_criminal_list ();
	}
	
	
	////////// API CALLS //////////
	
	public function get_pending_consent_by_user_id ()
	{
		$url = "userdata/consent/list?userId=".$this->id."&status=PENDING";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		if (!empty ($response))
		{
			foreach ($response as $pending)
			{
				$this->pendings [] = new Pending ($pending);
			}
		}
	}
	
	public function cancel_pending_consent ($consentId)
	{
		$url = "userdata/consent/cancel/".$consentId;
		$request = "";
		$return = $this->submit_api_request ($request, $url, 1);
		
	}
	
	public function get_pending_criminal_by_user_id ()
	{
		$url = "userdata/criminalChecks/getByUserId?userId=".$this->id."&status=PENDING_APPROVAL&firstRecord=0&recordCount=100";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		if (!empty ($response))
		{
			foreach ($response['criminalChecks'] as $criminal)
			{
				$this->criminals [] = new Criminal ($criminal);
			}
		}
	}
	
	public function get_pending_criminal_by_id_number ($id_number)
	{
		$end = time() * 1000;
		$from = strtotime ("1 January 2010");
		$url = "userdata/criminalChecks/getByUserId?userId=".$this->id."&status=PENDING_APPROVAL&firstRecord=0&recordCount=100&idNumber=$id_number";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		foreach ($response['criminalChecks'] as $criminal)
		{
			$criminal ['identifier'] = $id_number;
			$this->criminals [] = new Criminal ($criminal);
		}
	}
	
	public function get_processed_criminal_by_user_id ()
	{
		$url = "userdata/criminalChecks/getByUserId?userId=".$this->id."&status=PROCESSED&firstRecord=0&recordCount=15";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		if (!empty ($response))
		{
			foreach ($response['criminalChecks'] as $criminal)
			{
				$this->criminals [] = new Criminal ($criminal);
			}
		}
	}
	
	public function get_processed_criminal_by_id_number ($id_number)
	{
		$end = time() * 1000;
		$from = strtotime ("1 January 2010");
		$url = "userdata/criminalChecks/getByUserId?userId=".$this->id."&status=PROCESSED&firstRecord=0&recordCount=20&idNumber=$id_number";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
                if (!empty ($response))
		{
			foreach ($response['criminalChecks'] as $criminal)
			{
				$criminal ['identifier'] = $id_number;
				$this->criminals [] = new Criminal ($criminal);
			}
		}
	}
	
	public function release_pending_criminal ($transactionId)
	{
		$url = "userdata/criminalCheck/$transactionId/release";
		$request = "";
		$return = $this->submit_api_request ($request, $url, 1);
	}
	
	public function cancel_pending_criminal ($transactionId)
	{
		$url = "userdata/criminalCheck/$transactionId/delete";
		$request = "";
		$return = $this->submit_api_request ($request, $url, 1);
	}
	
	public function get_user_by_id ()
	{
		//api call to retrieve user details from ID
		$request = "";
		$url = "userdata/".$this->id;
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		$this->add_user_details ($response);
	}
	
	public function get_user_by_email ()
	{
		//api call to retrieve user details from email
		$request = "";
		$url = "userdata/get/".$this->email;
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		$this->add_user_details ($response);
	}
	
	public function authenticate_user ()
	{
		//api call to authenticate user
		$variables ['username'] = $this->email;
		$variables ['password'] = $this->password;
		$request = json_encode ($variables);
		$url = "userdata/authenticate";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);

		if ($response ['authResponse'] == 1)
		{
			//$this->id = 1;
			//authentication successful
			$this->get_user_by_email ();
			return true;
		}
		else
		{
			error_log($return);
			//unsuccessful
			return false;
		}
	}
	
	public function submit_contact_form ()
	{
		$url = "userdata/contact?firstName=".$_POST ['contactName']."&companyName=".$_POST ['companyName']."&emailAddress=".$_POST ['email']."&requestType=".$_POST ['requestType']."&subject=".$_POST ['subject']."&message=".$_POST ['message'];
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function password_reset ()
	{
		//api call to request password reset
		$url = "userdata/requestPasswordReset/".$this->email;
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function create_purchase_reference ()
	{
		//api call to retrieve number of credits available
		$url = "userdata/credits/generateUid";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		return $response ['uniqueIdentifier'];
	}
	
	public function get_mandatory_consent ()
	{
		//api call to retrieve number of credits available
		$url = "userdata/".$this->accountId."/mandatoryConsent";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		$this->consent = $response ['mandatoryConsent'];
		return $this->consent;
	}
	
	public function get_account_credits ()
	{
		//api call to retrieve number of credits available
		$url = "userdata/".$this->accountId."/credits";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		$this->credits = $response ['credits'];
	}
	
	public function fund_account_credits ()
	{
		//api call to (i'm guessing) add credits to account
		$url = "userdata/".$this->accountId."/credits/fund";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function deduct_account_credits ()
	{
		//api call to add credits to account
		$url = "userdata/".$this->accountId."/transactions";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function search_transactions_by_id_number ($id_number)
	{
		//api call to get list of transactions
		$end = time() * 1000;
		$from = strtotime ("1 January 2010");
		$url = "statusreport/get/data2?accountId=".$this->accountId."&from=$from&to=$end&idNumber=$id_number&firstRecord=0&recordCount=20";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		foreach ($response as $transaction)
		{
			$this->transactions [] = new Report ($transaction);
		}
	}
	
	public function get_latest_transactions_by_account ($limit = 20)
	{
		//api call to get list of transactions
		$url = "userdata/".$this->accountId."/transactions?limit=$limit";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		foreach ($response as $transaction)
		{
			$this->transactions [] = new Report ($transaction);
		}
	}
	
	public function get_latest_transactions_by_user ($limit = 10)
	{
		//api call to get list of transactions
		$url = "userdata/".$this->accountId."/transactions?limit=$limit";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		foreach ($response as $transaction)
		{
			$this->transactions [] = new Report ($transaction);
		}
	}
	
	public function get_transaction_list_by_date ()
	{
		//api call to get list of transactions
		$url = "userdata/".$this->accountId."/transactions/date";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function log_dispute ()
	{
		//api call to log a dispute
		$url = "userdata/dispute";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function screen_purchase ()
	{
		//api call to (I'm guessing) run a screen report
		$url = "userdata/screen/purchase";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
	}
	
	public function get_overview ()
	{
		$month = date ("M");
		$fromDate = date ("Y-m")."-00";
		$toDate = date ("Y-m-d");
		$from = strtotime ($fromDate) * 1000;
		$to = strtotime ($toDate) * 1000;
		$url = "statusreport/get/overview?accountId=".$this->accountId."&from=$from&to=$to";
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		$counters = array ();
		foreach ($response ['counts'] as $count)
		{
			$counters [$count ['dataKey']] = $count ['dataCount'];
		}
		
		$counters ['BIDCHK_TOTAL'] = $counters ['BIDCHK_PASS'] + $counters ['BIDCHK_FAIL'];
		$counters ['FULLCHK_TOTAL'] = $counters ['FULLCHK_PASS'] + $counters ['FULLCHK_FAIL'];
		$counters ['CRIM_TOTAL'] = $counters ['CRIM_PASS'] + $counters ['CRIM_FAIL'] + $counters ['CRIM_WIP'];
		$counters ['MATRIC_TOTAL'] = $counters ['MATRIC_PASS'] + $counters ['MATRIC_FAIL'] + $counters ['MATRIC_WIP'];
		$counters ['TERTIARY_TOTAL'] = $counters ['TERTIARY_PASS'] + $counters ['TERTIARY_FAIL'] + $counters ['TERTIARY_WIP']; 
		$counters ['PASS_TOTAL'] = $counters ['BIDCHK_PASS'] + $counters ['FULLCHK_PASS'] + $counters ['CRIM_PASS'] + $counters ['MATRIC_PASS'] + $counters ['TERTIARY_PASS'];
		$counters ['FAIL_TOTAL'] = $counters ['BIDCHK_FAIL'] + $counters ['FULLCHK_FAIL'] + $counters ['CRIM_FAIL'] + $counters ['MATRIC_FAIL'] + $counters ['TERTIARY_FAIL'];
		$counters ['WIP_TOTAL'] = $counters ['CRIM_WIP'] + $counters ['MATRIC_WIP'] + $counters ['TERTIARY_WIP'];
		$counters ['TOTAL'] = $counters ['PASS_TOTAL'] + $counters ['FAIL_TOTAL'] + $counters ['WIP_TOTAL'];
		
		return $counters;
	}
	
	public function confirm_transaction ($referenceId, $credits, $cost, $response, $status)
	{
		$variables = array ();
		$variables ['userCreditPurchase'] = array ();
		$variables ['userCreditPurchase']['userId'] = $this->id;
		$variables ['userCreditPurchase']['referenceId'] = $referenceId;
		$variables ['userCreditPurchase']['requestDtm'] = time () * 1000;
		$variables ['userCreditPurchase']['credits'] = $credits;
		$variables ['userCreditPurchase']['cost'] = intval ($cost);
		$variables ['userCreditPurchase']['discount'] = 0;
		$variables ['userCreditPurchase']['response'] = $response;
		$variables ['userCreditPurchase']['responseDtm'] = time () * 1000;
		$variables ['userCreditPurchase']['status'] = $status;
		$variables ['accountId'] = $this->accountId;
		$request = json_encode ($variables);
		$url = "userdata/saveAndFundCreditPurchase";
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		if ($response ['creditsChanged'] == true)
		{
			$this->credits = $response ['accountCreditResponse']['credits'];
			return true;
		}
		else
		{
			//unsuccessful
			return false;
		}
	}
	
	public function increment_purchase_sharpspring ()
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
																									 
	   	$data = json_encode($data);                                                                   
	   	$ch = curl_init($url);                                                                        
	   	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                              
	   	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                  
	   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                               
	   	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                   
		   'Content-Type: application/json',                                                         
		   'Content-Length: ' . strlen($data)                                                        
	   	));                                                                                           
																									 
	   	$result = curl_exec($ch);                                                                     
	   	curl_close($ch);                                                                              
				
		$response = json_decode ($result, true);                                                                        
	
		$id = $response['result']['lead'][0]['id'];
		$purchase = $response['result']['lead'][0]['purchased_55cb944630c28'];
		if (empty ($purchase))
			$purchase = 1;
		else
			$purchase ++;
		$updates = array ();
		$updates [0] = array ();
		$updates [0] ['id'] = $id;
		$updates [0] ['purchased_55cb944630c28'] = $purchase;
																							  
	   	$method = 'updateLeads';
	   	$params = array('objects' => $updates);
	
	   	$data = array(
		   'method' => $method,
		   'params' => $params,
		   'id' => $requestID,
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";                             
																									 
	   	$data = json_encode($data);                                                                   
	   	$ch = curl_init($url);                                                                        
	   	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                              
	   	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                  
	   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                               
	   	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                   
		   'Content-Type: application/json',                                                         
		   'Content-Length: ' . strlen($data)                                                        
	   	));                                                                                           
																									 
	   $result = curl_exec($ch);                                                                     
	   curl_close($ch);
	}
	
	public function increment_checks_sharpspring ()
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
																									 
	   	$result = $this->submit_sharpspring_request ($url, $data);                                                                               
				
		$response = json_decode ($result, true);                                                                        
	
		$id = $response['result']['lead'][0]['id'];
		$checks = $response['result']['lead'][0]['checks_run_55cb9b6b72f36'];
		if (empty ($checks))
			$checks = 1;
		else
			$checks ++;
		$updates = array ();
		$updates [0] = array ();
		$updates [0] ['id'] = $id;
		$updates [0] ['checks_run_55cb9b6b72f36'] = $checks;
																							  
	   	$method = 'updateLeads';
	   	$params = array('objects' => $updates);
	
	   	$data = array(
		   'method' => $method,
		   'params' => $params,
		   'id' => $requestID,
	   	);                                                                                            
																									 
	   	$queryString = http_build_query(array('accountID' => $accountID, 'secretKey' => $secretKey)); 
	   	$url = "http://api.sharpspring.com/pubapi/v1/?$queryString";                             
																									 
	   	$result = $this->submit_sharpspring_request ($url, $data);                                                      
	}
	
	private function get_activation_link ()
	{
		$url = "userdata/get/emailcode/".$this->email;
		$return = $this->submit_api_request ("", $url);
		$response = json_decode ($return, true);
		return "http://www.fraudcheck.co.za/confirm/".$this->email."/".$response ['message'];
	}
	
	public function resend_email_confirmation ()
	{
		$url = "userdata/emailverify/sendlink/".$this->email;
		$return = $this->submit_api_request ("", $url, 1);
		return $return;
	}
	
	public function update_email ($newemail)
	{
		$url = "userdata/emailverify/emailchange/".$this->id."/".$this->email."/".$newemail;
		$return = $this->submit_api_request ("", $url, 1);
		$response = json_decode ($return, true);
		if ($response ['responseCode'] == 1)
			$this->email = $newemail;
		return $return;
	}
	
	public function send_activation_link_sharpspring ()
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
	
}

class Pending
{
	public $firstName;
	public $lastName;
	public $mobileNumber;
	public $requestDtm;
	public $permissionRequestId;
	
	public function __construct ($data)
	{
		$this->firstName = $data ['firstName'];
		$this->surname = $data ['surname'];
		$this->mobileNumber = $data ['mobileNumber'];
		$this->requestDtm = $data ['requestDtm'];
		$this->permissionRequestId = $data ['permissionRequestId'];
	}
}

class Criminal
{
	public $firstName;
	public $lastName;
	public $userFirstName;
	public $userSurname;
	public $statusTimestamp;
	public $transactionId;
	public $identifier;
	public $enquiryResult;
	public $dateOfBirth;
	public $gender;
	
	public function __construct ($data)
	{
		if (isset ($data ['crimChkTxnId']))
		{
			$this->firstName = $data ['candidateFirstName'];
			$this->surname = $data ['candidateFirstName'];
			$this->userFirstName = "";
			$this->userSurname = "";
			$this->statusTimestamp = $data ['idChkCompletedDate'];
			$this->transactionId = $data ['crimChkTxnId'];
			$this->identifier = $data ['idNumber'];
			$this->enquiryResult = $data ['enquiryResult'];
			$this->dateOfBirth = $data ['dateOfBirth'];
			$this->gender = $data ['gender'];
		}
		else
		{
			$this->firstName = $data ['firstName'];
			$this->surname = $data ['surname'];
			$this->userFirstName = $data ['userFirstName'];
			$this->userSurname = $data ['userSurname'];
			$this->statusTimestamp = $data ['statusTimestamp'];
			$this->transactionId = $data ['transactionId'];
			$this->identifier = $data ['identifier'];
			$this->enquiryResult = $data ['enquiryResult'];
			$this->dateOfBirth = $data ['dateOfBirth'];
			$this->gender = $data ['gender'];
		}
	}
	
	public function get_dob ()
	{
		$dob =  substr($this->identifier,4,2) . "-" . substr($this->identifier,2,2) . "-";
		if (substr($this->identifier,0,2) > 15)
			$dob .= "19".substr($this->identifier,0,2);
		else 
			$dob .= "20".substr($this->identifier,0,2);
		return date ("d F Y",strtotime ($dob));
	}
	
	public function get_age ()
	{
		$dob = strtotime ($this->dateOfBirth);
		$diff = time () - $dob;
		$years = $diff / 3600 / 24 / 365;
		return floor ($years);
	}
	
	public function get_gender ()
	{
		$num = substr($this->identifier,6,1);
		if ($num <= 4)
			return "Female";
		else
			return "Male";
	}
}
?>
