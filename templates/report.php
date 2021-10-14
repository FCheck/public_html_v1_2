<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/DateRange.js"></script>
<script type="text/javascript" src="js/base.js"></script>
<script type="text/javascript" src="sj/sha1.js"></script>
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/base.css" />
<link rel="stylesheet" href="css/clean.css" />
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   360&deg; Report
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    
<div class="container">
<?php
		$startDate = strtotime ("-30 days");
		$minDate = strtotime ("14 November 2014");
		if ($startDate < $minDate)
		{
			$startDate = $minDate;
		}
		$report = new ThreeSixtyReport ();
		$report->userId = $GLOBALS ['user']->accountId;
		$report->startDate = date ("Y-m-d", $startDate)." 00:00:00";
		$report->endDate = date ("Y-m-d")." 23:59:59";
		$report->call_report(1);
		$costcentre = $report->cost_centre_arr ();
		echo "<input type=\"hidden\" id=\"minDate\" value=\"".date ("Y-m-d",$minDate)."\">";
		echo "<div id=\"displayfilters\">";
		echo "<h2 style=\"color:#124216\">Filters</h2>";
		 echo "<div id=\"date-range\">
				<div id=\"date-range-field\">
					<span>Click to Modify Dates</span>
					<div id=\"dateend\">&#9660;</div>
				</div>
				<div id=\"datepicker-calendar\"></div>
			</div>";
	
		echo "Cost Centre: <select id=\"cost_centre\">";
		echo "<option value=\"-1\">All</option>";
		foreach ($costcentre as $code=>$name)
		{
			echo "<option value=\"$code\">$name</option>";
		}
		echo "</select>";
		echo "<div id=\"filter_container\">";
		
			echo "<div id=\"basic_filter_btn\" class=\"select_btn select_btn_selected\" onclick=\"toggle_filters (1)\" >Basic Filters</div>";
			echo "<div id=\"advanced_filter_btn\" class=\"select_btn\" onclick=\"toggle_filters (2)\">Advanced Filters</div>";
			echo "<div id=\"search_filter_btn\" class=\"select_btn\" onclick=\"toggle_filters (3)\">Search</div>";
		
			//basic filters
			echo "<div id=\"basic_filter\">";
				echo "<input type=\"checkbox\" id=\"complete_checkbox\" onchange=\"update_checkboxes ('complete_checkbox','incomplete_checkbox')\"> <label for=\"complete_checkbox\">View Completed Checks</label>&nbsp;&nbsp;";
				echo "<input type=\"checkbox\" id=\"incomplete_checkbox\" onchange=\"update_checkboxes ('incomplete_checkbox','complete_checkbox')\"> <label for=\"incomplete_checkbox\">View Work in Progress</label>";
			echo "</div>";
			
			//search
			echo "<div id=\"search_filter\">";
				echo "<input type=\"text\" class=\"dropdown\" placeholder=\"Candidate ID Number\" id=\"idnumber\" />";
			echo "</div>";
			
			//advanced filters
			echo "<div id=\"advanced_filter\">";
				
				echo "<select id=\"matric_check_status\" name='filter_matric' class=\"dropdown\" onchange=\"check_time_filter ()\">";
					/*$remotedb = dbconn_remote ();
					$result = $remotedb->query ("SELECT status, description FROM matriculation_logs_status ORDER BY list_order ASC");
					echo "<option value=\"0\">Filter by Matric Status</option>";
					while ($row = $result->fetch_assoc ())
					{
						echo "<option value=\"".$row ['status']."\">".$row ['description']."</option>";
					}*/
					echo "<option value=\"0\">Filter by Matric Status</option>";
					echo "<option value=\"YES\">Verified</option>";
					echo "<option value=\"NO\">Not Verified</option>";
					echo "<option value=\"WIP\">Work in Progress</option>";
				echo "</select>";
				
				echo "<select id=\"criminal_check_status\" name='filter_matric' class=\"dropdown\">";
					echo "<option value=\"0\">Filter by Criminal Status</option>";
					echo "<option value=\"PROCESSED\">Processed</option>";
					echo "<option value=\"PENDING_APPROVAL\">Pending Approval</option>";
					echo "<option value=\"PENDING_RESULT\">Pending Result</option>";
					echo "<option value=\"PENDING_UPLOAD\">Pending Upload</option>";
				echo "</select>";
				
			echo "</div>";
			echo "<input type=\"button\" style=\"position:relative; top:70px;\" value=\"Update Report\" onclick=\"update_results (1)\" />";
			//echo "<input type=\"button\" style=\"position:relative; top:70px; left:10px;\" value=\"Export to CSV\" onclick=\"get_csv ()\" />";
			
		echo "</div>";
		echo "</div></div>";
		echo "<div class=\"space\"></div>";
		echo "<div id=\"displayresults\">";
			echo $report->display_results (1);
		echo "</div>";
		?>	       

	<div class="space"></div>
    


