<?php
include ("../functions/functions.php");
ajaxhead ();
session_start ();
$GLOBALS ['user'] = new User (0);

$_POST ['userId'] = $GLOBALS ['user']->get_user_id();
$_POST ['accountId'] = $GLOBALS ['user']->accountId;
$_POST ['regNo'] = str_replace ('/','',$_POST ['regNo']);

$businessLookup = new BusinessLookup ($_POST);
$return = $businessLookup->runLookup ();

//$return = $businessLookup->business;
$numReturn = sizeof ($return);

if ($numReturn == 0 && !empty ($_POST ['regNo']))
{
	//in case user entered an incorrect registration number - run again against the name
	$_POST ['regNo'] = "";
	$businessLookup2 = new BusinessLookup ($_POST);
	$return = $businessLookup2->runLookup ();
	//$return = $businessLookup2->business;
}

$jsonReturn = json_encode ($return);

//$jsonReturn = '{"results": [{"itNumber": "619673197","name": "TEPNOC PTY LTD","nameType": "B","bsuinessName": "","physicalAddress": "N B S BLDG CHURCH STR","suburb": "","town": "PIETERMARITZBURG","country": "SA","postalAddress": "7 ARMSTRONG DRIVE","postalSuburb": "","postalCountry": "SA","postalPostCode": "3201","phoneNo": "0331   946757","faxNo": "","regNo": "198600187423","regStatus": "AR Final Deregi","regStatusCode": "29","tradingNumber": ""},{"itNumber": "573063252","name": "GROVEST C C","nameType": "A","bsuinessName": "GROVEST CC","physicalAddress": "N B S BLDG CHURCH STR","suburb": "","town": "PIETERMARITZBURG","country": "SA","postalAddress": "7 ARMSTRONG DRIVE","postalSuburb": "","postalCountry": "SA","postalPostCode": "3201","phoneNo": "0331   946757","faxNo": "","regNo": "198600187423","regStatus": "AR Final Deregi","regStatusCode": "29","tradingNumber": ""}]}';

if (is_object(json_decode($jsonReturn)))
{
	echo $jsonReturn;
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