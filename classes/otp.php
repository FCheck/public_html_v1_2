<?php
class OTP extends Api
{
	public $cellNumber;
	
	/*
	Send OTP Possible responses:
		-2	The mobile number must consist of ten (10) characters and must start with a 0.	
		-1	This phone number is already resgistered on the FraudCheck system.
		0	Unable to send verification SMS.
		1	Verification SMS sent.
		
	Verify OTP Possible resopnses:
		-1	OTP Has expired
		0	OTP Not Verified
		1	OTP Verified
	*/
	
	public function send_otp ($number)
	{
		if ($number != 0)
		{
			$this->cellNumber = $number;
		}
		$request = "";
		$url = "userdata/otpverify/sendotp/".$this->cellNumber;
		$return = $this->submit_api_request ($request, $url, 1);
		return $return;
	}
	
	public function verify_otp ($number, $otp)
	{
		$request = "";
		$url = "userdata/otpverify/verifyotp/$number/$otp";
		$return = $this->submit_api_request ($request, $url, 1);
		return $return;
	}
}
?>