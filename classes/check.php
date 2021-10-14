<?php
class Check extends Api
{
	public $checksRun = array ();
	public $person;
	public $mode = "LIVE";
	public $clientReference = "idontknowwhatthisis";
	public $transactionType;
	public $currentEmploymentDetail;
	public $affordability;
	public $authentication;
	public $vasRequest;
	public $creditCost;
	public $userId;
	
	public function __construct ($data)
	{
		$this->person = new Person ($data);
		$this->currentEmploymentDetail = new CurrentEmploymentDetail ($data);
		$this->affordability = new Affordability ();
		$this->authentication = new Authentication ($data);
		$this->creditCost = $data ['creditCost'];
		$this->userId = $data ['userId'];
		if (isset ($data ['check0']))
			$this->checksRun[] = 0;
		if (isset ($data ['check1']))
			$this->checksRun[] = 1;
		if (isset ($data ['check2']))
			$this->checksRun[] = 2;
		if (isset ($data ['check3']))
			$this->checksRun[] = 3;
		if (isset ($data ['check4']))
			$this->checksRun[] = 4;
		if (isset ($data ['check5']))
			$this->checksRun[] = 5;
		if (isset ($data ['check6']))
			$this->checksRun[] = 6;
		if (isset ($data ['check7']))
			$this->checksRun[] = 7;
		if (isset ($data ['check8']))
			$this->checksRun[] = 8;
		$this->setVasAndTransaction ($data);
	}
	
	private function setVasAndTransaction ($data)
	{
		$transactionType = "BIDCHK";
		$this->vasRequest = new VAS ();
		foreach ($this->checksRun as $check)
		{
			/*
			0 = Payment
			1 = ID
			2 = Credit
			3 = Drivers
			4 = Matric
			5 = Tertiary
			6 = Association
			7 = Bank
			8 - Deeds
			*/
			if ($check == 1)
			{
				//do nothing
			}
			else if ($check == 2)
			{
				$transactionType = "FULLCHK";
			}
			else if ($check == 0)
			{
				$transactionType = "BUSFULLCHK";
			}
			else
			{
				$this->vasRequest->addVAS ($check, $data);
			}
		}
		$this->transactionType = $transactionType;
	}
	
	public function compileArray ()
	{
		$arr = array ();
		
		$arr ['screenRequest']['requestDetails']['person'] = (array) $this->person;
		$arr ['screenRequest']['requestDetails']['mode'] = $this->mode;
		$arr ['screenRequest']['requestDetails']['clientReference'] = $this->clientReference;
		$arr ['screenRequest']['requestDetails']['transactionType'] = $this->transactionType;
		$arr ['screenRequest']['requestDetails']['currentEmploymentDetail'] = $this->currentEmploymentDetail;
		$arr ['screenRequest']['requestDetails']['affordability'] = $this->affordability;
		$arr ['screenRequest']['authentication'] = $this->authentication;
		$temp = $this->vasRequest->getVasArr ();
		if (!empty ($temp))
			$arr ['vasRequest'] = $temp;
		return $arr;
	}
	
	private function compileJSON ()
	{
		$arr = $this->compileArray ();
		$request = json_encode ($arr);
		
		return $request;
		
	}
	
	public function submitCheck ()
	{
		$request = $this->compileJSON();
		$url = "userdata/screenWithVas/".$this->creditCost."/".$this->userId;
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		if (empty ($response ['screenResponse']))
		{
			//echo "Return = ".$return;
			header ("location: check-error");
		}
		else
		{
			header ("location: assessment-report/".$response ['screenResponse']);
		}
	}
}

class ConsentCheck extends Api
{
	public $screenRequest;
	public $userId;
	public $checkReason;
	public $creditCost;
	
	public function __construct ($data)
	{
		$this->screenRequest = new Check ($data);
		$this->userId = $data ['userId'];
		$this->checkReason = $data ['checkReason'];
		$this->creditCost = $data ['creditCost'];
		$this->submitCheck ();
	}
	
	public function compileJSON ()
	{
		$arr = array ();
		$arr ['screenRequest'] = $this->screenRequest->compileArray ();
		$arr ['consentRequest']['userId'] = $this->userId;
		$arr ['consentRequest']['checkReason'] = $this->checkReason;
		$arr ['consentRequest']['creditCost'] = intval ($this->creditCost);
		$request = json_encode ($arr);
		return $request;
	}
	
	public function submitCheck ()
	{
		$request = $this->compileJSON();
		$url = "userdata/screenConsentWithVas";
		$return = $this->submit_api_request ($request, $url, 1);
		//$response = json_decode ($return, true);
		//header ("location: assessment-report/".$response ['screenResponse']);
		//echo $return;
		header ("location: pending-consent");
	}
}

class VAS
{
	public $matriculationLog;
	public $tertiaryQualificationLogs = array ();
	public $driversLicenseLog;
	public $professionalAssociationLogs = array ();
	public $bankVerificationLogs;
	public $deedsLogs;
	public $bank = 0;
	public $matric = 0;
	public $tertiary = 0;
	public $drivers = 0;
	public $association = 0;
	public $deeds = 0;
	
	public function __construct ()
	{
		
	}
	
	public function addVAS ($type, $data)
	{
		switch ($type)
		{
			case 3:
				$this->driversLicenseLog = new Drivers ($data);
				$this->drivers = 1;
			break;
			case 4:
				$this->matriculationLog = new Matric ($data);
				$this->matric = 1;
			break;
			case 5:
				$this->tertiaryQualificationLogs [0] = new Tertiary ($data);
				$this->tertiary = 1;
			break;
			case 6:
				$this->professionalAssociationLogs [0] = new Association ($data);
				$this->association = 1;
			break;
			case 7:
				$this->bankVerificationLogs = new BankVerification ($data);
				$this->bank = 1;
			break;
			case 8:
				$this->deedsLogs = new DeedsCheck ($data);
				$this->deeds = 1;
			break;
		}
	}
	
	public function getVasArr ()
	{
		$return = array ();
		if ($this->drivers == 1)
			$return ['driversLicenseLog'] = (array) $this->driversLicenseLog;
		if ($this->matric == 1)
			$return ['matriculationLog'] = (array) $this->matriculationLog;
		if ($this->tertiary == 1)
			$return ['tertiaryQualificationLogs'] = (array) $this->tertiaryQualificationLogs;
		if ($this->association == 1)
			$return ['professionalAssociationLogs'] = (array) $this->professionalAssociationLogs;
		if ($this->bank == 1)
			$return ['consumerAvsRequest'] = (array) $this->bankVerificationLogs;
		if ($this->deeds == 1)
			$return ['deedRequest'] = (array) $this->deedsLogs;
		return $return;
	}
}

class Matric
{
	public $school;
	public $year;
	
	public function __construct ($data)
	{
		$this->school = $data ['matric_school'];
		$this->year = $data ['matric_year'];
	}
}

class Tertiary
{
	public $institute;
	public $year;
	public $qualification;
	
	public function __construct ($data)
	{
		$this->institute = $data ['tertiary_institute'];
		$this->year = $data ['tertiary_year'];
		$this->qualification = $data ['tertiary_qualification'];
	}
}

class Drivers
{
	public $code;
	
	public function __construct ($data)
	{
		$this->code = $data ['drivers_code'];
	}
}

class Association
{
	public $association;
	
	public function __construct ($data)
	{
		$this->association = $data ['association'];
	}
}

class BankVerification
{
	public $accountType1;
	public $branchCode1;
	public $accountNumber1;
	public $enquiryReason;
	
	public function __construct ($data)
	{
		$this->accountType1 = $data ['accountType1'];
		$this->branchCode1 = $data ['branchCode1'];
		$this->accountNumber1 = $data ['accountNumber1'];
		$this->enquiryReason = $data ['enquiryReason'];
	}
}

class DeedsCheck
{
	public $enquiryReason;
	
	public function __construct ($data)
	{
		$this->enquiryReason = $data ['deedsEnquiryReason'];
	}
}

class Person
{
	public $dateOfBirth;
	public $emailAddress;
	public $idNumber;
	public $firstName;
	public $addresses = array ();
	public $surname;
	public $ipAddress = "IP ADDRESS";
	public $telephoneNumbers = array ();
	public $type = "INDIVIDUAL";
	public $maidenName = "";
	public $maritalStatus;
	public $middleName;
	public $alias = "alias";
	public $gender;
	
	public function __construct ($data)
	{
		$this->emailAddress = $data ['emailAddress'];
		$this->idNumber = new IDNumber ($data);
		$this->firstName = $data ['firstName'];
		$this->addresses [] = new ScreenAddress ($data);
		$this->surname = $data ['surname'];
		$this->telephoneNumbers [] = new Telephone ($data);
		$this->maritalStatus = $data ['maritalStatus'];
		$this->middleName = $data ['middleName'];
		$this->gender = $this->get_gender ();
		$this->dateOfBirth = $this->get_dob ();
	}
	
	public function get_gender ()
	{
		$num = substr($this->idNumber->value,6,1);
		if ($num <= 4)
			return "FEMALE";
		else
			return "MALE";
	}
	
	public function get_dob ()
	{
		$dob =  substr($this->idNumber->value,4,2) . "-" . substr($this->idNumber->value,2,2) . "-";
		if (substr($this->idNumber->value,0,2) > 15)
			$dob .= "19".substr($this->idNumber->value,0,2);
		else 
			$dob .= "20".substr($this->idNumber->value,0,2);
		return strtotime ($dob)*1000;
	}
}

class IDNumber
{
	public $value;
	public $type = "IDENTITY_DOCUMENT";
	
	public function __construct ($data)
	{
		$this->value = $data ['idNumber'];
	}
}

class ScreenAddress
{
	public $propertyType;
	public $city;
	public $country;
	public $postalCode;
	public $streetName;
	public $suburb;
	public $buildingName;
	public $stateProvince;
	public $type;
	public $buildingNumber;
	
	public function __construct ($data)
	{
		$this->propertyType = $data ['propertyType'];
		$this->city = $data ['city'];
		$this->country = "South Africa";
		$this->postalCode = $data ['postalCode'];
		$this->streetName = $data ['streetName'];
		$this->suburb = $data ['suburb'];
		$this->buildingName = $data ['buildingName'];
		$this->stateProvince = $data ['province'];
		$this->type = "PHYSICAL";
		$this->buildingNumber = $data ['buildingNumber'];
	}
}

class Telephone
{
	public $countryCode = 27;
	public $value;
	public $type = "MOBILE";
	
	public function __construct ($data)
	{
		$this->value = $data ['tel'];
	}
}

class CurrentEmploymentDetail
{
	public $position;
	public $startDate;
	public $spouseEmployer = "";
	public $spousePosition = "";
	public $spouseStartDate = 0;
	public $employmentType = "PERMANENT";
	public $spouseEmploymentType = "PERMANENT";
	public $employer;
	
	public function __construct ($data)
	{
		/*$this->position = $data ['employmentPosition'];
		$this->startDate = $data ['employmentStartDate'];
		$this->employmentType = $data ['employmentType'];
		$this->employer = $data ['employer'];*/
		$this->position = "";
		$this->startDate = 0;
		$this->employmentType = "PERMANENT";
		$this->employer = "";
	}
}

class Affordability
{
	public $loanDetail;
	public $incomeDetail;
	public $expenseDetail;
	
	public function __construct ()
	{
		$this->loanDetail = new LoanDetail ();
		$this->incomeDetail = new IncomeDetail ();
		$this->expenseDetail = new ExpenseDetail ();
	}
}

class LoanDetail
{
	public $term;
	public $amount = 123;
	public $productCode = "PRODCODE";
	public $installment = 345;
	public $productDescription = "ABCDEF";
	
	public function __construct ()
	{
		$this->term = new Term ();
	}
}

class Term
{
	public $termFrequency = "MONTH";
	public $value = 123;
	
	public function __construct ()
	{
		
	}
}

class IncomeDetail
{
	public $spouseNet = 123;
	public $gross = 123;
	public $spouseGross = 123;
	public $net = 123;
	
	public function __construct ()
	{
		
	}
}

class ExpenseDetail
{
	public $vehicleRepayment = 12;
	public $transportation = 12;
	public $rentBond = 12;
	public $insurance = 12;
	public $other = 12;
	public $household = 12;
	public $medical = 12;
	
	public function __construct ()
	{
		
	}
}

class Authentication
{
	public $accountId;
	
	public function __construct ($data)
	{
		$this->accountId = $data ['accountId'];
	}
}
?>