<?php
class IncomeEstimator extends Api
{
	public $transactionId;
	public $requestTimestamp;
	public $requestString;
	public $response;
	public $userId;
	
	public function __construct ($idOrData)
	{
		if (is_array ($idOrData))
		{
			//search result
			$this->requestString = new IncomeEstimatorRequest ($idOrData ['requestString']);
			$this->response = new IncomeEstimatorResponse ($idOrData ['responseString']);
			$this->requestTimestamp = $idOrData ['requestTimestamp'];
			$this->userId = $idOrData ['userId'];
			$this->transactionId = $idOrData ['transactionId'];
		}
		else
		{
			//display report
			$this->transactionId = $idOrData;
			$request = "";
			$url = "userdata/incomeEstimator/get/transaction/".$this->transactionId;
			$return = $this->submit_api_request ($request, $url, 1);
			$response = json_decode ($return, true);
			$this->requestString = new IncomeEstimatorRequest ($response ['requestString']);
			$this->response = new IncomeEstimatorResponse ($response ['responseString']);
			$this->requestTimestamp = $response ['requestTimestamp'];
			$this->userId = $response ['userId'];
		}
	}
}

class IncomeEstimatorRequest
{
	public $name1;
	public $surname1;
	public $idnumber1;
	public $addressLine11;
	public $addressLine21;
	public $suburb1;
	public $city1;
	public $postalCode1;
	public $province1;
	
	public $name2;
	public $surname2;
	public $idnumber2;
	public $addressLine12;
	public $addressLine22;
	public $suburb2;
	public $city2;
	public $postalCode2;
	public $province2;
	
	public function __construct ($data)
	{
		$this->name1 = $data ['name1'];
		$this->surname1 = $data ['surname1'];
		$this->idnumber1 = $data ['idnumber1'];
		$this->addressLine11 = $data ['addressLine11'];
		$this->addressLine21 = $data ['addressLine21'];
		$this->suburb1 = $data ['suburb1'];
		$this->city1 = $data ['city1'];
		$this->postalCode1 = $data ['postalCode1'];
		$this->province1 = $data ['province1'];
		
		$this->name2 = $data ['name2'];
		$this->surname2 = $data ['surname2'];
		$this->idnumber2 = $data ['idnumber2'];
		$this->addressLine12 = $data ['addressLine12'];
		$this->addressLine22 = $data ['addressLine22'];
		$this->suburb2 = $data ['suburb2'];
		$this->city2 = $data ['city2'];
		$this->postalCode2 = $data ['postalCode2'];
		$this->province2 = $data ['province2'];
	}
}

class IncomeEstimatorResponse
{
	public $person1;
	public $person2;
	public $estimatedIncome;
	
	public function __construct ($data)
	{
		$this->person1 = new IncomeEstimatorPerson ($data ['person1']);
		$this->person2 = new IncomeEstimatorPerson ($data ['person2']);
		$this->estimatedIncome = $data ['estimatedIncome'];
	}
}

class IncomeEstimatorPerson
{
	public $name;
	public $surname;
	public $idNumber;
	public $estimatedIncome;
	
	public function __construct ($data)
	{
		$this->name = $data ['name'];
		$this->surname = $data ['surname'];
		$this->idNumber = $data ['idNumber'];
		$this->estimatedIncome = $data ['estimatedIncome'];
	}
	
	public function get_dob ()
	{
		$dob =  substr($this->idNumber,4,2) . "-" . substr($this->idNumber,2,2) . "-";
		if (substr($this->idNumber,0,2) > 15)
			$dob .= "19".substr($this->idNumber,0,2);
		else 
			$dob .= "20".substr($this->idNumber,0,2);
		return date ("d F Y",strtotime ($dob));
	}
	
	public function get_age ()
	{
		$dob = strtotime ($this->get_dob ());
		$diff = time () - $dob;
		$years = $diff / 3600 / 24 / 365;
		return floor ($years);
	}
	
	public function get_gender ()
	{
		$num = substr($this->idNumber,6,1);
		if ($num <= 4)
			return "Female";
		else
			return "Male";
	}
}