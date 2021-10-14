<?php
include ("../functions/functions.php");
ajaxhead ();
session_start ();
$GLOBALS ['user'] = new User (0);

$response = $GLOBALS ['user']->resend_email_confirmation();

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