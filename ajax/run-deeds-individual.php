<?php
include ("../functions/functions.php");
ajaxhead ();
session_start ();
$GLOBALS ['user'] = new User (0);
$_POST ['cost'] = 10;
$_POST ['userId'] = $GLOBALS ['user']->get_user_id();
$_POST ['accountId'] = $GLOBALS ['user']->accountId;

if (empty ($_POST ['enquiryReason']))
	$_POST ['enquiryReason'] = "OTHER";

$deeds = new DeedsRequest ($_POST);
$response = $deeds->runLookup ($_POST);

//$response = '{ "transactionId" : "ca4116102d6a4c679c5973ffc5d79760", "deeds" : [ { "date" : "20121026", "comment" : "", "purchasePrice" : "0030504007", "purchaseDate" : "", "propertySize" : "991.0SQM", "bondNumber" : "", "bondHolder" : "", "bondAmount" : "0000000000", "bondDate" : "20120831", "multipleOwners" : "No", "share" : "", "dateOfBirthOrIDNumber" : "6501270069082", "erf" : "188", "propertyType" : "Erf (Full-title)", "farm" : "", "propertyName" : "NOCHUMSOHN MOIRA", "schemeName" : "", "schemeNumber" : "", "portion" : "", "title" : "T32596/2012", "township" : "DOWERGLEN", "deedsOffice" : "JOHANNESBURG", "street" : "MILFORD", "province" : "GAUTENG", "streetNumber" : "47", "bond" : { "actionDate" : "", "comment" : "No active bond detail", "bondNumber" : "", "bondHolder" : "", "bondAmount" : "0000000000", "bondDate" : "", "bondBuyerID" : "", "bondBuyerName" : "" } } ], "bondsFull" : [ { "actionDate" : "", "comment" : "No active bond detail", "bondNumber" : "", "bondHolder" : "", "bondAmount" : "0000000000", "bondDate" : "", "bondBuyerID" : "", "bondBuyerName" : "" } ] }';

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
