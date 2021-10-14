<?php
class BusinessLookup extends Api
{
	public $business = array ();
	public $name;
	public $regNo;
	public $type;
	public $data;
	public $userId;
	public $accountId;
	
	public function __construct ($data)
	{
		$this->name = $data ['name'];
		$this->regNo = $data ['regNo'];
		$this->userId = $data ['userId'];
		$this->accountId = $data ['accountId'];
		
		if (empty ($this->regNo))
		{
			$this->type = "name";
			$this->data = $this->name;
		}
		else
		{
			$this->type = "registrationNumber";
			$this->data = $this->regNo;
		}
	}
	
	public function runLookup ()
	{
		$request = "";
		$data = urlencode ($this->data);
		$url = "businessdata/search/".$this->type."/".$data."/".$this->userId."/".$this->accountId;
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		return $response;
		foreach ($response as $business)
		{
			//$this->business [] = new Business ($business);
		}
	}
}

class Business
{
	public $itNumber;
	public $name;
	public $physicalAddress;
	public $postalAddress;
	public $regNo;
	public $regStatus;
	
	public function __construct ($data)
	{
		$this->itNumber = $data ['itNumber'];
		$this->name = $data ['name'];
		$this->physicalAddress = $data ['physicalAddress'];
		$this->postalAddress = $data ['postalAddress'];
		$this->regNo = $data ['regNo'];
		$this->regStatus = $data ['regStatus'];
	}
}
?>