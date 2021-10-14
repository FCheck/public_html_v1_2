<?php
include ("../functions/functions.php");
session_start();
ajaxhead ();
$cell = $_POST ['cellNo'];
$pin = $_POST ['pin'];
$otp = new OTP ();
$verify = 0;
$response = "";

if (strcmp ($_POST ['vc'], $cell) == 0)
	$verify = 1;

if ($verify == 0)
	$response = $otp->verify_otp ($cell, $pin);

if (is_object(json_decode($response)) || $verify == 1)
{
	if ($verify == 0)
		$responseArr = json_decode ($response, true);
	else 
	{
		$responseArr = array();
		$responseArr ['responseCode'] = 1;
	}
	if ($responseArr ['responseCode'] == 1)
	{
		//verify successful. Continue to register
		$type = $_POST ['acc_type'];
		if ($type == 1)
		{
			//individual
			$register = new RegisterIndividualDelta ($_POST);
		}
		else
		{
			//business
			$register = new RegisterBusinessDelta ($_POST);
		}
		$response = $register->submitRegistration();
		$jsonresponse = json_encode ($response);
		if (is_object(json_decode($jsonresponse)))
		{
			if (strcmp ($response ['status'], "SUCCESS") == 0)
			{
				$GLOBALS ['user'] = new User (-1);
				$GLOBALS ['user']->email = $_POST ['email'];
				$GLOBALS ['user']->set_password ($_POST ['password']);
				$GLOBALS ['user']->get_user_by_email ();
				$_SESSION ['login'] = true;
				$_SESSION ['user_id'] = $GLOBALS ['user']->get_user_id();
				//success
				$jsonArr = array ();
				$jsonArr ['message'] = "Registration Completed";
				$jsonArr ['responseCode'] = 1;
				$jsonArr['type'] = 2;
				$json = json_encode ($jsonArr);
				echo $json;
			}
			else
			{
				$jsonArr = array ();
				$jsonArr ['message'] = $response ['message'];
				$jsonArr ['responseCode'] = 0;
				$jsonArr['type'] = 2;
				$json = json_encode ($jsonArr);
				echo $json;
			}
		}
		else
		{
			$jsonArr = array ();
			$jsonArr ['message'] = "Temporary System Error. Please try again later";
			$jsonArr ['responseCode'] = 0;
			$jsonArr['type'] = 2;
			$json = json_encode ($jsonArr);
			echo $json;
		}
	}
	else
	{
		//OTP verify failed
		$responseArr ['type'] = 1;
		$response = json_encode ($responseArr);
		echo $response;
	}
}
else
{
	$jsonArr = array ();
	$jsonArr ['message'] = "Temporary System Error. Please try again later";
	$jsonArr ['responseCode'] = 0;
	$jsonArr['type'] = 1;
	$json = json_encode ($jsonArr);
	echo $json;
}
?>