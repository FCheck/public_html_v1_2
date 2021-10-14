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

$deeds = new BusinessDeedsRequest ($_POST);
$response = $deeds->runLookup ();

//$response = '{"transactionId" : "9b0805ca3db3465596950e6909f34edb","deeds" : {"deeds" : {"businessDeedsComprehensivePW" : [ {"majorProduct" : "5429","date" : "20131112","comment" : "","purchasePrice" : "0004470000","purchaseDate" : "20060607","propertySize" : "1154.0SQM","bondNumber" : "B75319/2006","mortgagee" : "FIRSTRAND BANK LTD","bondAmount" : "0007000000","bondDate" : "20060906","multiple" : "No","share" : "","dateOfBirthID" : "200601646207","erf" : "647","propertyType" : "Erf (Full-title)", "farm" : "","buyerName" : "TEPNOC PTY LTD","schemeName" : "","schemeNumber" : "","portion" : "","title" : "T53511/2006","street" : "OXFORD","township" : "PARKWOOD","province" : "GAUTENG","deedsOffice" : "JOHANNESBURG","rowID" : "1","streetNumber" : "145"} ]},"bonds" : {"deedsMultipleBond" : [ {"majorProduct" : "5429","actionDate" : "20131112","comment" : "","bondNumber" : "B75319/2006","bondHolder" : "FIRSTRAND","bondAmount" : "0007000000","bondDate" : "20060906","bondBuyerID" : "200601646207","bondBuyerName" : "TEPNOC PTY LTD","rowID" : "1"} ]},"firstResponse" : {"ticketNumber" : "0899618714","dunsNumber" : "00538838866","registrationNumber" : "200601646207","businessName" : "TEPNOC (PTY) LTD","itnumber" : "619673197"}}}';

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
