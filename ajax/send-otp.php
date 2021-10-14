<?php
include ("../functions/functions.php");
ajaxhead ();
$cell = $_POST ['cellNo'];
$otp = new OTP ();

$response = $otp->send_otp ($cell);

if (is_object(json_decode($response)))
{
	echo $response;
}
else
{
	$jsonArr = array ();
	$jsonArr ['message'] = "Temporary System Error. Please try again later";
	$jsonArr ['responseCode'] = 0;
	$json = json_encode ($jsonArr);
	echo $json;
}
?>