<?php
include ("../functions/functions.php");
session_start ();
if (isset ($_SESSION ['login']))
{
	//logged in
	$GLOBALS ['user'] = new User (0);
	ajaxhead ();
	
	//if ($GLOBALS ['user']->isLoggedIn() == true)
	//{
	$report = new ThreeSixtyReport ();
	$report->userId = $GLOBALS ['user']->accountId;
	$report->startDate = $_POST ['startDate']." 00:00:00";
	$report->endDate = $_POST ['endDate']." 23:59:59";
	if ($_POST ['cost_centre_code'] != -1)
		$report->cost_centre_code = $_POST ['cost_centre_code'];
	else
		$report->cost_centre_code = 'NULL';
	if ($_POST ['filter_type'] == 1)
	{	
		//basic filters
		if ($_POST ['filter_completed'] == 1)
		{
			//view only work in progress
			$report->filter_type = 1;
		}
		if ($_POST ['filter_incompleted'] == 1)
		{
			//view only completed
			$report->filter_type = 2;
		}
	}
	else if ($_POST ['filter_type'] == 2)
	{
		//advanced filters
		if (strcmp ($_POST ['filter_matric'],"0") != 0)
			$report->matric_status = $_POST ['filter_matric'];
			
		if (strcmp ($_POST ['filter_criminal'],"0") != 0)
			$report->criminal_status = $_POST ['filter_criminal'];
	}
	else
	{
		$report->id_number = $_POST ['idnumber'];
	}
	$report->call_report ($_POST ['page']);
	echo $report->display_results ($_POST ['page']);
	//}
}
?>