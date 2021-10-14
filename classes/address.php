<?php
class Address
{
	private $id;
	public $addressType;
	public $buildingNumber;
	public $streetName;
	public $suburb;
	public $stateProvince;
	public $postalCode;
	public $buildingName;
	public $city;
	public $propertyType;
	
	public function __construct ($data)
	{
		$this->id = $data ['id'];
		$this->addressType = $data ['addressType'];
		$this->buildingNumber = $data ['buildingNumber'];
		$this->streetName = $data ['streetName'];
		$this->suburb = $data ['suburb'];
		$this->stateProvince = $data ['stateProvince'];
		$this->postalCode = $data ['postalCode'];
		$this->buildingName = $data ['buildingName'];
		$this->city = $data ['city'];
		$this->propertyType = $data ['propertyType'];
	}
	
	public function print_address ()
	{
		$return = $this->buildingNumber . " ";
		if (!empty ($this->buildingName))
			$return .= $this->buildingName . "<br>" . $this->streetName . "<br>";
		else
		 	$return .= $this->streetName . "<br>";
		$return .= $this->suburb . "<br>"
				. $this->city . "<br>"
				. $this->stateProvince;
		return $return;
	}
	
	public function is_address ()
	{
		if (empty ($city) && empty ($suburb))
			return false;
		else
			return true;
	}
}
?>