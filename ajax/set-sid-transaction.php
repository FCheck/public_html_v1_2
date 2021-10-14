<?php
include ("../functions/functions.php");
session_start ();
$user = new User (0);

$credits = $_POST ['credits'];

$SID_MERCHANT = "FRAUDCHECK";
$SID_CURRENCY = "ZAR";
$SID_COUNTRY = "ZA";
$SID_REFERENCE = $user->create_purchase_reference();//transaction ID
$SID_AMOUNT = $_POST ['cost'].".00";
//$SID_DEFAULT_REFERENCE = "Fraudcheck Credits";
$SID_DEFAULT_REFERENCE = "";
$SID_SECRET_KEY = "gtbtNpkP7rr2O5lCmXXMHtucm2HiVQAs5uWCj3gSzaSKQk7zIDK3mOpw8";

$hash = $SID_MERCHANT . $SID_CURRENCY . $SID_COUNTRY . $SID_REFERENCE . $SID_AMOUNT . $SID_DEFAULT_REFERENCE . $SID_SECRET_KEY;
$hashEnc = strtoupper (openssl_digest($hash, 'sha512'));


echo $SID_REFERENCE."##".$hashEnc;
?>