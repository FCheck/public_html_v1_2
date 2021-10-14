<?php
class DeedsRequest extends Api
{
	public $surname;
	public $forename1;
	public $said;
	public $streetnumber;
	public $streetname;
	public $town;
	public $city;
	public $postalCode;
	public $enquiryReason;
	
	public function __construct ($data)
	{
		$this->surname = $data ['surname'];
		$this->forename1 = $data ['forename'];
		$this->said = $data ['said'];
		$this->streetnumber = $data ['streetnumber'];
		$this->streetname = $data ['streetname'];
		$this->town = $data ['town'];
		$this->city = $data ['city'];
		$this->postalCode = $data ['postalCode'];
		$this->enquiryReason = $data ['enquiryReason'];
	}
	
	public function runLookup ($data)
	{
		$request = json_encode ($this);
		$url = "userdata/deedscheck/run/".$data ['cost']."/".$data ['accountId']."/".$data ['userId'];
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		//echo $return;
		return $return;
		if (empty ($response ['deeds']))
		{
			//display error
		}
		else
		{
			//display report
		}
	}
}

class BusinessDeedsRequest extends Api
{
	public $itNumber;
	public $enquiryReason;
	public $accountId;
	public $userId;
	public $credits;
	
	public function __construct ($data)
	{
		$this->itNumber = $data ['itNumber'];
		$this->enquiryReason = $data ['enquiryReason'];
		$this->accountId = $data ['accountId'];
		$this->userId = $data ['userId'];
		$this->credits = $data ['cost'];
	}
	
	public function runLookup ()
	{//businessdata/deedscheck/run/{itcCode}/{enquiryReason}/{creditCost}/{accountId}/{userId}{userId}
		$request = "";
		$url = "businessdata/deedscheck/run/".$this->itNumber."/".$this->enquiryReason."/".$this->credits."/".$this->accountId."/".$this->userId;
		$return = $this->submit_api_request ($request, $url, 1);
		$response = json_decode ($return, true);
		//echo $return;
		return $return;
		if (empty ($response ['deeds']))
		{
			//display error
		}
		else
		{
			//display report
		}
	}
}

class DeedsReport extends Api
{
	public $transactionId;
	public $request;
	public $requestTimestamp;
	public $deeds = array ();
	
	public function __construct ($transactionId)
	{
		$url = "userdata/deedscheck/get/transaction/$transactionId";
		$return = $this->submit_api_request ("", $url, 1);
		$response = json_decode ($return, true);
		$this->transactionId = $transactionId;
		$this->request = new DeedsRequest ($response ['requestString']);
		foreach ($response ['responseString']['deeds'] as $deeds)
		{
			$this->deeds[] = new DeedsResponse ($deeds);
		}
	}
}

class DeedsResponse
{
	public $date;
	public $comment;
	public $purchasePrice;
	public $purchaseDate;
	public $propertySize;
	public $multipleOwners;
	public $share;
	public $dateOfBirthOrIDNumber;
	public $erf;
	public $propertyType;
	public $farm;
	public $propertyName;
	public $schemeName;
	public $schemeNumber;
	public $portion;
	public $title;
	public $township;
	public $deedsOffice;
	public $street;
	public $province;
	public $streetNumber;
	public $bond = array();
	
	public function __construct ($response)
	{
		/*
		multipleOwners = multiple
		propertyName = buyerName
		
		////because fuck consistency, apparently////
		
		*/
		$this->transactionId = $response ['transactionId'];
		$this->date = $response ['date'];
		$this->comment = $response ['comment'];
		$this->purchasePrice = $response ['purchasePrice'];
		$this->purchaseDate = $response ['purchaseDate'];
		$this->propertySize = $response ['propertySize'];
		if (isset ($response ['multipleOwners']))//individual
			$this->multipleOwners = $response ['multipleOwners'];
		else if (isset ($response ['multiple']))//business
			$this->multipleOwners = $response ['multiple'];
		$this->share = $response ['share'];
		$this->dateOfBirthOrIDNumber = $response ['dateOfBirthOrIDNumber'];
		$this->erf = $response ['erf'];
		$this->propertyType = $response ['propertyType'];
		$this->farm = $response ['farm'];
		if (isset ($response ['propertyName']))//individual
			$this->propertyName = $response ['propertyName'];
		else if (isset ($response ['buyerName']))//business
			$this->propertyName = $response ['buyerName'];
		$this->schemeName = $response ['schemeName'];
		$this->schemeNumber = $response ['schemeNumber'];
		$this->portion = $response ['portion'];
		$this->title = $response ['title'];
		$this->township = $response ['township'];
		$this->deedsOffice = $response ['deedsOffice'];
		$this->street = $response ['street'];
		$this->province = $response ['province'];
		$this->streetNumber = $response ['streetNumber'];
	}
}

class Bond
{
	public $actionDate;
	public $comment;
	public $bondNumer;
	public $bondHolder;
	public $bondAmount;
	public $bondDate;
	public $bondBuyerID;
	public $bondBuyerName;
}
?>