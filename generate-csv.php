<?php
//generate CSV
include ("functions/functions.php");

	
	$report = new ThreeSixtyReport ();
	$report->userId = $_GET ['userId'];
	$report->startDate = $_GET ['startDate']." 00:00:00";
	$report->endDate = $_GET ['endDate']." 23:59:59";
	if ($_GET ['cost_centre_code'] != -1)
		$report->cost_centre_code = $_GET ['cost_centre_code'];
	else
		$report->cost_centre_code = 'NULL';
	if ($_GET ['filter_type'] == 1)
	{	
		//basic filters
		if ($_GET ['filter_completed'] == 1)
		{
			//view only work in progress
			$report->filter_type = 1;
		}
		if ($_GET ['filter_incompleted'] == 1)
		{
			//view only completed
			$report->filter_type = 2;
		}
	}
	else if ($_GET ['filter_type'] == 2)
	{
		//advanced filters
		if (strcmp ($_GET ['filter_matric'],"0") != 0)
			$report->matric_status = $_GET ['filter_matric'];
			
		if (strcmp ($_GET ['filter_criminal'],"0") != 0)
			$report->criminal_status = $_GET ['filter_criminal'];
	}
	else
	{
		$report->id_number = $_GET ['idnumber'];
	}
	global $results;
	$report->call_report (0);
	
	$report->generate_csv ();
?>
