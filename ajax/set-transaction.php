<?php
include ("../functions/functions.php");
session_start ();
$user = new User (0);

$credits = $_POST ['credits'];
$amount = $credits * 10 * 1.14;

$p1 = "6307";
$p2 = $user->create_purchase_reference();//transaction ID
$p3 = "Fraudcheck Credits";
$p4 = $amount;
$p5 = "ZAR";
$p10 = "http://".$_SERVER ['HTTP_HOST']."/transaction/declined";
$CardholderEmail = $user->email;
$CardholderName = $GLOBALS ['user']->firstName . " " . $GLOBALS ['user']->surname;
$Mobile = 'N';
$UrlsProvided = 'Y';
$ApprovedUrl = "http://".$_SERVER ['HTTP_HOST']."/transaction/approved";
$DeclinedUrl = "http://".$_SERVER ['HTTP_HOST']."/transaction/declined";
$secretKey = "PdC01dYn08@m09!";
//$hash = md5 ($p1.$p2.$p3.$p4.$p5.$p10.$CardholderEmail.$secretKey);
$hash = md5 ($p1.$p2.$p3.$p4.$p5.$p10.$CardholderEmail.$CardholderName.$Mobile.$UrlsProvided.$ApprovedUrl.$DeclinedUrl.$secretKey);
echo $p2."##".$hash;
?>