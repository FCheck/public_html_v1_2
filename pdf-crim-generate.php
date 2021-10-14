<?php
// Include the main TCPDF library (search for installation path).
include ("functions/functions.php");
session_start ();
$GLOBALS ['user'] = new User (0);
$transactionId = $_POST ['transactionId'];
require_once('pdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FraudCheck');
$pdf->SetTitle('Fraudcheck Report');
$pdf->SetSubject('Criminal Check');
$pdf->SetKeywords('TCPDF, PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "", "");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

ob_start ();
include ("templates/assessment-report-crim-pdf.php");
$html = ob_get_contents();
ob_end_clean();;

$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Fraudcheck Report - '.$report->firstName. ' '. $report->surname.'.pdf', 'I');