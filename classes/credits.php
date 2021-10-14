<?php
class Credits
{
	public $idcheck = 0;
	public $creditcheck = 0;
	public $paymentcheck = 0;
	public $criminalcheck = 0;
	public $driverscheck = 0;
	public $matriccheck = 0;
	public $tertiarycheck = 0;
	public $associationcheck = 0;
	public $bankcheck = 0;
	public $deedscheck = 0;

	public function __construct ()
	{
		//$values = $this->submit_api_request ("", "creditvalues", 0);
		$this->idcheck = 1;
		$this->creditcheck = 3;
		$this->paymentcheck = 6;
		$this->criminalcheck = 10;
		$this->driverscheck = 6;
		$this->matriccheck = 6;
		$this->tertiarycheck = 6;
		$this->associationcheck = 6;
		$this->bankcheck = 1;
		$this->deedscheck = 10;
	}

	public function credits_with_text ($var)
	{
		$temp;
		switch ($var)
		{
			case 'id':
			$temp = $this->idcheck;
			break;
			case 'credit':
			$temp = $this->creditcheck;
			break;
			case 'criminal':
			$temp = $this->criminalcheck;
			break;
			case 'drivers':
			$temp = $this->driverscheck;
			break;
			case 'matric':
			$temp = $this->matriccheck;
			break;
			case 'tertiary':
			$temp = $this->tertiarycheck;
			break;
			case 'association':
			$temp = $this->associationcheck;
			break;
			case 'bank':
			$temp = $this->bankcheck;
			break;
			case 'deeds':
			$temp = $this->deedscheck;
			break;
			case 'payment':
			$temp = $this->paymentcheck;
			break;
		}
		if ($temp == 1)
			$string = "Credit";
		else
			$string = "Credits";
		return $temp . " " . $string;
	}

	public function credits_in_rands ($var)
	{
		$temp;
		switch ($var)
		{
			case 'id':
			$temp = $this->idcheck;
			break;
			case 'credit':
			$temp = $this->creditcheck;
			break;
			case 'criminal':
			//$temp = $this->criminalcheck;
			return 114;
			break;
			case 'drivers':
			$temp = $this->driverscheck;
			break;
			case 'matric':
			$temp = $this->matriccheck;
			break;
			case 'tertiary':
			$temp = $this->tertiarycheck;
			break;
			case 'association':
			$temp = $this->associationcheck;
			break;
			case 'bank':
			$temp = $this->bankcheck;
			break;
			case 'deeds':
			$temp = $this->bankcheck;
			break;
			case 'payment':
			$temp = $this->paymentcheck;
			break;
		}
		return $temp * 10;
	}

	private function submit_api_request ($request, $url, $type = 0)
	{
		$url = "http://fc-php-api-svr:8181/fraudcheck3-php-portal-api/rest/".$url;
		$ch = curl_init($url);
		if ($type == 1)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
}
?>
