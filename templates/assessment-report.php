<style>
table tr td
{
	padding:5px;
}
.badge-top
{
	position:absolute; 
	border-radius:3px; 
	width:22px; 
	height:22px; 
	color:#FFF; 
	font-size:10px; 
	padding-top:4px; 
	right:24px; 
	top:-40px;
	text-align:center;
}
.badge-green
{
	background-color:#1da236; 
}
.badge-orange
{
	background-color:#f6ac38
}
.badge-red
{
	background-color:#b41401; 
}
.badge-bottom
{
	background-color:#343434; 
	position:absolute; 
	border-radius:3px; 
	width:22px; 
	height:22px; 
	color:#FFF; 
	font-size:10px; 
	padding-top:4px; 
	text-align:center; 
	right:24px; 
	bottom:-40px;
}
.badge-rule
{
	position:absolute; 
	left:22px; 
	top:-43px;
}
.detail-badge
{
	position:relative;
	cursor:pointer;
}
.recommendation-key
{
	background-color:#EAEAEA; 
	border-radius:10px; 
	margin-top:20px;
}
</style>
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Person Check Recommendation
   <div class="try"><a href="register"><input type="button" class="btn btn-primary btn-nav" value="TRY NOW" /></a></div>
  </div>
</div> <!-- jumbotron -->

<?php
//let's get report data
$q = explode ('/',strtolower ($_GET ['query']));
$transactionId = $q[1];
$report = new Report ($transactionId);
if (empty ($transactionId))
{
	header ("location: /history");
}
if ($report->accountId == $GLOBALS['user']->accountId)
{
?>
<!-- Content Below
    ================================================== -->
    
    <div class="container">
    	<h1>Full Person Check on <?php echo $report->firstName . " " . $report->lastName; ?></h1>
        <div class="page-header">
          <h2>Details used to Perform Check</h2>
        </div>
        <table width="80%">
        	<tr>
            	<td width="20%"><strong>First Name(s):</strong></td>
                <td width="40%"><?php echo $report->firstName; ?></td>
                <td width="20%"><strong>Phone Number:</strong></td>
                <td width="20%"><?php echo $report->mobileNumber; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Surname:</strong></td>
                <td width="40%"><?php echo $report->lastName; ?></td>
                <td width="20%"><strong>Email Adderss:</strong></td>
                <td width="20%"><?php echo $report->emailAddress; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>ID Number:</strong></td>
                <td width="40%"><?php echo $report->idNumber; ?></td>
                <td width="20%"><strong>Address:</strong></td>
                <td width="20%" rowspan="4"><?php echo $report->address->print_address (); ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Marital Status:</strong></td>
                <td width="40%"><?php echo $report->maritalStatus; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Date of Birth:</strong></td>
                <td width="40%"><?php echo $report->get_dob (); ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Age:</strong></td>
                <td width="40%"><?php echo $report->get_age(); ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Gender:</strong></td>
                <td width="40%"><?php echo $report->get_gender (); ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Transaction ID:</strong></td>
                <td width="40%"><?php echo $report->transactionId; ?></td>
            </tr>
        </table>
		<div class="page-header">
          <h2>Results from Check</h2>
        </div>
   		<table>
        <tr>
        	<?php
			switch ($report->screeningResult)
			{
				case "ACCEPT":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"15%\" style=\"padding:10px\"><img src=\"../images/accept.png\" /></td>"
        					."<td valign=\"top\" width=\"15%\" style=\"padding:10px; font-size:25px;\"><strong>Score</strong></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#85cb63;\"><strong>".$report->weighting."</strong></td>";
						$recommendation = "Proceed Without Concern";
						$recommendationText = "<strong>Low Risk</strong> - Our data providers confirmed that most of the details that you provided are valid and therefore presents a low risk. Before proceeding, make sure that you familiarise yourself with any mismatches that may have occurred and take the necessary due diligence to alleviate any concerns.";
				break;
				case "REVIEW":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"15%\" style=\"padding:10px\"><img src=\"../images/review.png\" /></td>"
        					."<td valign=\"top\" width=\"15%\" style=\"padding:10px; font-size:25px;\"><strong>Score</strong></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#f7c73f;\"><strong>".$report->weighting."</strong></td>";
							$recommendation = "Proceed With Caution";
						$recommendationText = "<strong>Moderate Risk</strong> - Our data providers reported a considerable number of mismatches between the data you provided and theirs and possibly other more serious issues, which presents a medium risk.<br />FraudCheck recommends that you take the following actions to reduce this risk:<ul><li>Perform your own due diligence process by requesting proof of identity, address or contact details to confirm the details that the person provided.</li><li>This process is recommended for all items that received a mismatch in the above report.</li></ul>";
				break;
				case "REJECT":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"15%\" style=\"padding:10px\"><img src=\"../images/reject.png\" /></td>"
        					."<td valign=\"top\" width=\"15%\" style=\"padding:10px; font-size:25px;\"><strong>Score</strong></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#d5031c;\"><strong>".$report->weighting."</strong></td>";
							$recommendation = "Do Not Proceed";
						$recommendationText = "<strong>High Risk</strong> - Our data providers reported an unacceptable number of mismatches between the data you provided and theirs on file and/or the person has received Debt Councelling, Debt Review, has Defaulted on one or more payments or has been issued with one or more Judgements or Notices.<br />Continuing against our recommendation of <span><q>Do not proceed</q></span> is putting yourself at high risk. You should evaluate all the risks carefully and complete due diligence to reduce this risk before proceeding.";
				break;
			}
			?>
			<td valign="top" width="20%" rowspan="3" style="padding:10px">
            	<table>
            		<tr>
						<td class="icon"><img src="../images/fraud-prevention-proceed.png" /></td>
						<td>0 and more</td>
					</tr>
					<tr>
						<td><img src="../images/fraud-prevention-caution.png" /></td>
						<td>-1 to -49</td>
					</tr>
					<tr>
						<td><img src="../images/fraud-prevention-reject.png" /></td>
						<td>-50 and less</td>
					</tr>
				</table>
            </td>
        </tr>
        <tr>
        	<td valign="top" style="padding:10px; vertical-align:baseline"><strong>Recommendation</strong></td>
        	<td valign="top" style="padding:10px; font-size:24px; vertical-align:baseline"><?php echo $recommendation; ?></td>
        </tr>
    	<tr>
        	<td valign="top" style="padding:10px"><strong>What this means</strong></td>
        	<td valign="top" style="padding:10px"><?php echo $recommendationText; ?></td>
        </tr>
        <tr>
        	<td></td>
        	<td valign="top" style="padding:10px"><strong>Check Performed On</strong></td>
            <td valign="top" style="padding:10px"><?php echo date ("d F Y, G:i",$report->transactionTimestamp/1000); ?></td>
            <td></td>
        </tr>
    </table>
    
    <div class="page-header">
          <h2>Employment History</h2>
        </div>
    <?php echo $report->print_employment_history () ?>
    
    <div class="page-header">
          <h2>Details of Check</h2>
        </div>
    <div class="row" id="assessment_overview">
    	<div class="col-md-6">
        	<?php echo assessment_icons (-1, $report); ?>
        </div>
        <div class="col-md-2">
    		<img src="../images/recommendation_outcome_key2.png" class="recommendation-key" />
    	</div>
    </div>
    <?php
	for ($i = 1; $i <= 10; $i++)
	{
		$cat_count = $report->category_count ($report->category_by_id ($i));
		if ($cat_count > 0)
		{
			echo "<div class=\"row assessment-category\" id=\"category".$i."\"> "
				. "<div class=\"col-md-1\"> " . assessment_icons ($i,$report,1) . " </div> "
				. "<div class=\"col-md-11\"> " . assessment_details ($i, $report) . " </div> "
				. "</div>";
		}
    }
	echo "<div class=\"row assessment-category\" id=\"category0\"> ";
	echo "<div class=\"col-md-1\"> " . assessment_icons (0,$report,0) . " </div> ";
	echo "<div class=\"col-md-11\"> ";
	for ($i = 1; $i <= 10; $i++)
	{
		$cat_count = $report->category_count ($report->category_by_id ($i));
		if ($cat_count > 0)
		{
			echo  assessment_details ($i, $report). "<br><br>";
		}
    }
	echo "</div>";
	echo "</div>";
	?>
    <form method="post" action="pdf-generate.php">
    <input type="hidden" name="transactionId" value="<?php echo $transactionId;?>" />
    <input type="submit" class="btn btn-success" value="Download PDF" />
    <?php
}
else
{
	echo "Error: You cannot view someone else's report.";
}
    ?>
    
    </div>
	<div class="space"></div><a href="#0" class="cd-top">Top</a>
<?php
function assessment_icons ($num, $report, $linesperrow = 3)
{
	$return = "";
	$badges = array ();
	$badges [0] = $report->print_badge_data (0)
            	. "<img src=\"../images/rules_total.png\" style=\"padding:10px;\" />";
	$badges [1] = $report->print_badge_data ($report->category_by_id(1))
            	. "<img src=\"../images/rules_address.png\" style=\"padding:10px;\" />";
	$badges [2] = $report->print_badge_data ($report->category_by_id(2))
           		. "<img src=\"../images/rules_affordability.png\" style=\"padding:10px;\" />";
	$badges [3] = $report->print_badge_data ($report->category_by_id(3))
           		. "<img src=\"../images/rules_business.png\" style=\"padding:10px;\" />";
	$badges [4] = $report->print_badge_data ($report->category_by_id(4))
           		. "<img src=\"../images/rules_contact.png\" style=\"padding:10px;\" />";
	$badges [5] = $report->print_badge_data ($report->category_by_id(5))
           		. "<img src=\"../images/rules_criminal.png\" style=\"padding:10px;\" />";
	$badges [6] = $report->print_badge_data ($report->category_by_id(6))
           		. "<img src=\"../images/rules_employment.png\" style=\"padding:10px;\" />";
	$badges [7] = $report->print_badge_data ($report->category_by_id(7))
           		. "<img src=\"../images/rules_identification.png\" style=\"padding:10px;\" />";
	$badges [8] = $report->print_badge_data ($report->category_by_id(8))
           		. "<img src=\"../images/rules_law.png\" style=\"padding:10px;\" />";
	$badges [9] = $report->print_badge_data ($report->category_by_id(9))
           		. "<img src=\"../images/rules_bank.png\" style=\"padding:10px;\" />";
	$badges [10] = $report->print_badge_data ($report->category_by_id(10))
           		. "<img src=\"../images/rules_deeds.png\" style=\"padding:10px;\" />";
	
	$return .= "<div class=\"row\">";
	if ($num == -1)
		$num2 = 0;
	else
		$num2 = $num;
	$return .= "<span class=\"detail-badge\" onclick=\"open_category ($num2)\">".$badges [$num2]."</span>";
    $rowcount = 1;
	for ($i = 0; $i <= 10; $i++)
	{
		if ($i == 0)
			$cat_count = 1;
		else
			$cat_count = $report->category_count ($report->category_by_id ($i));
		if ($cat_count > 0)
		{
			if ($i != $num2)
			{
				if ($rowcount == $linesperrow)
				{
					$return .= "</div><div class=\"row\">";
					$rowcount = 1;
				}
				else
					$rowcount ++;
				$return .= "<span class=\"detail-badge\" onclick=\"open_category ($i)\"";
				if ($num != -1)
					$return .= " style=\"opacity:0.4\"";
				$return .= ">".$badges [$i]."</span>";
				
			}
		}
	}
	$return .= "</div>";
	return $return;
}

function assessment_details ($num, $report)
{
	$return = "";
	$details = array ();
	$details [1] = $report->print_rules ("Address");
	$details [2] = $report->print_rules ("Credit");
	$details [3] = $report->print_rules ("Business");
	$details [4] = $report->print_rules ("Contact");
	$details [5] = $report->print_rules ("Criminal");
	$details [6] = $report->print_rules ("Employment");
	$details [7] = $report->print_rules ("Identification");
	$details [8] = $report->print_rules ("Law");
	$details [9] = $report->print_rules ("Banking");
	$details [10] = $report->print_rules ("Deeds");
	$return .= "<h3 style=\"margin-left:60px\">".$report->category_by_id ($num)."</h3>";
	$return .= $details [$num];
	return $return;
}
?>