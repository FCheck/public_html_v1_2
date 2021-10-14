<?php
include ("../functions/functions.php");
ajaxhead ();
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
	echo $jsonresponse;
	if ($response ['responseCode'] == 1)
	{
		$GLOBALS ['user'] = new User (-1);
		$GLOBALS ['user']->email = $_POST ['email'];
		$GLOBALS ['user']->set_password ($_POST ['password']);
		$GLOBALS ['user']->get_user_by_email ();
		$_SESSION ['login'] = true;
		$_SESSION ['user_id'] = $GLOBALS ['user']->get_user_id();
		//success
	}
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