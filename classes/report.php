<?php
class Report extends Api
{
	public $transactionId;
	public $transactionTimestamp;
	public $reviewResult;
	public $mobileNumber;
	public $lastName;
	public $firstName;
	public $weighting;
	public $screenResult;
	public $checkReason;
	public $productName;
	public $checkedBy;
	public $productKey;
	public $disputed;
	
	public $triggeredRulesCount;
	public $executedRulesCount;
	public $reviewWeighting;
	public $rules = array ();
	public $employmentHistory = array ();
	public $maritalStatus;
	public $emailAddress;
	public $idNumber;
	public $address;
	public $accountId;
	public $gender;
	public $age;
	public $date_of_birth;
	
	public function __construct ($idOrData)
	{
		if (is_array ($idOrData))
		{
			if (isset ($idOrData ['idChkTxnId']))
			{
				$this->transactionId = $idOrData ['idChkTxnId'];
				$this->transactionTimestamp = strtotime ($idOrData ['idChkCompletedDate'])*1000;
				//$this->reviewResult = $idOrData ['screeningResult'];
				$this->mobileNumber = "Not set";
				$this->lastName = $idOrData ['candidateLastName'];
				$this->firstName = $idOrData ['candidateFirstName'];
				//$this->weighting = $idOrData ['weighting'];
				$this->screeningResult = $idOrData ['screeningResult'];
				//$this->checkReason = $idOrData ['checkReason'];
				//$this->productName = $idOrData ['productName'];
				$this->checkedBy = "";
				//$this->productKey = $idOrData ['productKey'];
				//$this->disputed = $idOrData ['disputed'];
			}
			else
			{
				$this->transactionId = $idOrData ['transactionId'];
				$this->transactionTimestamp = $idOrData ['transactionTimestamp'];
				$this->reviewResult = $idOrData ['reviewResult'];
				$this->mobileNumber = $idOrData ['mobileNumber'];
				$this->lastName = $idOrData ['lastName'];
				$this->firstName = $idOrData ['firstName'];
				$this->weighting = $idOrData ['weighting'];
				$this->screeningResult = $idOrData ['screeningResult'];
				$this->checkReason = $idOrData ['checkReason'];
				$this->productName = $idOrData ['productName'];
				$this->checkedBy = $idOrData ['checkedBy'];
				$this->productKey = $idOrData ['productKey'];
				$this->disputed = $idOrData ['disputed'];
			}
		}
		else
		{
			$this->transactionId = $idOrData;
			$this->get_data();
		}
	}
	
	private function get_data ()
	{
		$url = "userdata/transaction/".$this->transactionId;
		$request = "";
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		$this->transactionId = $response ['transactionId'];
		$this->transactionTimestamp = $response ['transactionTimestamp'];
		$this->reviewResult = $response ['reviewResult'];
		$this->mobileNumber = $response ['phoneNumber'];
		$this->lastName = $response ['lastName'];
		$this->firstName = $response ['firstName'];
		$this->weighting = $response ['weighting'];
		$this->screeningResult = $response ['screeningResult'];
		$this->productName = $response ['serviceType'];
		$this->disputed = $response ['disputed'];
		$this->triggeredRulesCount = $response ['triggeredRulesCount'];
		$this->executedRulesCount = $response ['executedRulesCount'];
		$this->reviewWeighting = $response ['reviewWeighting'];
		$this->maritalStatus = $response ['maritalStatus'];
		$this->emailAddress = $response ['emailAddress'];
		$this->idNumber = $response ['idNumber'];
		$this->address = new Address ($response ['address']);
		$this->accountId = $response ['accountId'];
		foreach ($response ['triggeredRules'] as $rule)
		{
			if (strcmp ($rule ['category'], "Affordability") == 0)
				$rule ['category'] = "Credit";
			$this->rules [] = new Rule ($rule);
		}
		if (!empty ($response ['employmentHistory']))
		{
			foreach ($response ['employmentHistory'] as $employmentHistory)
			{
				$this->employmentHistory [] = new Employment ($employmentHistory);
			}
		}
	}
	
	public function print_rules ($category)
	{
		$return = "<table width=\"100%\" style=\"margin-left:60px\">";
		foreach ($this->rules as $rule)
		{
			if (strcmp ($rule->category, $category) == 0)
			{
				$return .= $rule->print_rule ();
			}
		}
		$return .= "</table>";
		return $return;
	}
	
	public function print_rules_pdf ($category)
	{
		$return = "<table width=\"620\" cellpadding=\"5\" style=\"margin:0px;\">";
		foreach ($this->rules as $rule)
		{
			if (strcmp ($rule->category, $category) == 0)
			{
				$return .= $rule->print_rule_pdf ();
			}
		}
		$return .= "</table>";
		return $return;
	}
	
	public function print_employment_history ()
	{
		$count = 0;
		$return = "<table width=\"80%\">";
		$return .= "<tr><th>Company Name</th><th>First Seen Date</th><th>Last Updated Date</th></tr>";
		foreach ($this->employmentHistory as $employment)
		{
			$count ++;
			$return .= "<tr><td style=\"margin:5px;\">".$employment->employer."</td><td style=\"margin:5px;\">".$employment->firstReportedDate."</td><td style=\"margin:5px;\">".$employment->lastUpdatedDate."</td></tr>";
		}
		$return .= "</table>";
		if ($count > 0)
			return $return;
		else
			return "No Employment History Found";
	}
	
	public function category_count ($category)
	{
		$count = 0;
		foreach ($this->rules as $rule)
		{
			if (strcmp ($rule->category, $category) == 0)
			{
				$count ++;
			}
		}
		return $count;
	}
	
	public function category_by_id ($categoryId)
	{
		switch ($categoryId)
		{
			case 1: $category = "Address";
			break;
			case 2: $category = "Credit";
			break;
			case 3: $category = "Business";
			break;
			case 4: $category = "Contact";
			break;
			case 5: $category = "Criminal";
			break;
			case 6: $category = "Employment";
			break;
			case 7: $category = "Identification";
			break;
			case 8: $category = "Law";
			break;
			case 9: $category = "Banking";
			break;
			case 10: $category = "Deeds";
			break;
		}
		return $category;
	}
	
	public function category_weighting ($category)
	{
		$count = 0;
		foreach ($this->rules as $rule)
		{
			if (strcmp ($rule->category, $category) == 0)
			{
				$count += $rule->weighting;
			}
		}
		return $count;
	}
	
	public function print_badge_data ($category)
	{
		if ($category === 0)
		{
			$weighting = $this->weighting;
			$rulecount = sizeof ($this->rules);
		}
		else
		{
			$weighting = $this->category_weighting($category);
			$rulecount = $this->category_count($category);
		}
		$return = "";
		if ($weighting >=0)
		{
			$return .= "<img src=\"../images/rule_accept.png\" class=\"badge-rule\" />";
			$return .= "<div class=\"badge-top badge-green\">".$weighting."</div>";
		}
		else if ($weighting > -10)
		{
			$return .= "<img src=\"../images/rule_caution.png\" class=\"badge-rule\" />";
			$return .= "<div class=\"badge-top badge-orange\">".$weighting."</div>";
		}
		else
		{
			$return .= "<img src=\"../images/rule_reject.png\" class=\"badge-rule\" />";
			$return .= "<div class=\"badge-top badge-red\">".$weighting."</div>";
		}
		$return .= "<div class=\"badge-bottom\">".$rulecount."</div>";
		return $return;
	}
	
	public function print_badge_data_pdf ($category)
	{
		if ($category === 0)
		{
			$weighting = $this->weighting;
			$rulecount = sizeof ($this->rules);
		}
		else
		{
			$weighting = $this->category_weighting($category);
			$rulecount = $this->category_count($category);
		}
		$return = "";
		if ($weighting >=0)
		{
			$return .= "<img src=\"images/rule_accept.png\" style=\"position:absolute; left:22px; top:-43px;\" />";
			$return .= "<div style=\"position:absolute; border-radius:3px; width:22px; height:22px; color:#FFF; font-size:10px; padding-top:4px; right:24px; top:-40px; text-align:center; background-color:#1da236;\">".$weighting."</div>";
		}
		else if ($weighting > -10)
		{
			$return .= "<img src=\"images/rule_caution.png\" style=\"position:absolute; left:22px; top:-43px;\" />";
			$return .= "<div style=\"position:absolute; border-radius:3px; width:22px; height:22px; color:#FFF; font-size:10px; padding-top:4px; right:24px; top:-40px; text-align:center; background-color:#f6ac38;\">".$weighting."</div>";
		}
		else
		{
			$return .= "<img src=\"images/rule_reject.png\" style=\"position:absolute; left:22px; top:-43px;\" />";
			$return .= "<div style=\"position:absolute; border-radius:3px; width:22px; height:22px; color:#FFF; font-size:10px; padding-top:4px; right:24px; top:-40px; text-align:center; background-color:#b41401;\">".$weighting."</div>";
		}
		$return .= "<div style=\"background-color:#343434; position:absolute; border-radius:3px; width:22px; height:22px; color:#FFF; font-size:10px; padding-top:4px; text-align:center; right:24px; bottom:-40px;\">".$rulecount."</div>";
		return $return;
	}
	
	public function get_dob ()
	{
		$serviceTypes = 'CRIMINALCHK';
		if (strcmp ($this->productName, $serviceTypes) == 0)
			return $this->date_of_birth;
		else
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
		$serviceTypes = 'CRIMINALCHK';
		if (strcmp ($this->productName, $serviceTypes) == 0)
			return $this->gender;
		else
		$num = substr($this->idNumber,6,1);
		if ($num <= 4)
			return "Female";
		else
			return "Male";
	}
}
?>
