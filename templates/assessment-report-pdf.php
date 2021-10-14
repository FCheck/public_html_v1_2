<?php
//let's get report data
$report = new Report ($transactionId);
if ($report->accountId == $GLOBALS['user']->accountId)
{
?>
<!-- Content Below
    ================================================== -->
    
    <div class="container">
    	<h1 style="font-weight:normal; font-size: 2.5em; margin: 0 0 0.1em;">Check for <?php echo $report->firstName . " " . $report->lastName; ?></h1>
        <div class="page-header">
          <h2 style="font-size: 1.8em; margin: 0 0 0.07em; font-weight:normal; color:#333;">Details used to Perform Check</h2>
        </div>
        <table width="100%" cellpadding="5">
        	<tr>
            	<td width="20%"><strong>First Name(s):</strong></td>
                <td width="30%"><?php echo $report->firstName; ?></td>
                <?php
				if (isset ($report->mobileNumber))
				{
					?>
                <td width="20%"><strong>Phone Number:</strong></td>
                <td width="30%"><?php echo $report->mobileNumber; ?></td>
                 <?php
				}
				else
					echo "<td colspan='2'>&nbsp;</td>";
				?>
            </tr>
            <tr>
            	<td width="20%"><strong>Surname:</strong></td>
                <td width="30%"><?php echo $report->lastName; ?></td>
                <?php
				if (isset ($report->emailAddress))
				{
					?>
                <td width="20%"><strong>Email Address:</strong></td>
                <td width="30%"><?php echo $report->emailAddress; ?></td>
                <?php
				}
				else
					echo "<td colspan='2'>&nbsp;</td>";
				?>
            </tr>
            <tr>
            	<td width="20%"><strong>ID Number:</strong></td>
                <td width="30%"><?php echo $report->idNumber; ?></td>
                <?php
				if ($report->address->is_address())
				{
					?>
                <td width="20%"><strong>Address:</strong></td>
                <td width="30%" rowspan="4"><?php echo $report->address->print_address (); ?></td>
                	<?php
				}
				else
					echo "<td colspan='2'>&nbsp;</td>";
					?>
            </tr>
            <tr>
            	<td><strong>Marital Status:</strong></td>
                <td><?php echo $report->maritalStatus; ?></td>
            </tr>
            <tr>
            	<td><strong>Date of Birth:</strong></td>
                <td><?php echo $report->get_dob (); ?></td>
            </tr>
            <tr>
            	<td><strong>Age:</strong></td>
                <td><?php echo $report->get_age(); ?></td>
            </tr>
            <tr>
            	<td><strong>Gender:</strong></td>
                <td><?php echo $report->get_gender (); ?></td>
            </tr>
            <tr>
            	<td><strong>Transaction ID:</strong></td>
                <td><?php echo $report->transactionId; ?></td>
            </tr>
        </table>
          <h2 style="font-size: 1.8em; margin: 0 0 0.07em; font-weight:normal; color:#333;">Results from Check</h2>
   		<table cellpadding="5">
        <tr>
        	<?php
			switch ($report->screeningResult)
			{
				case "ACCEPT":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"25%\" style=\"padding:10px\"><img src=\"images/accept.png\" /></td>"
        					."<td valign=\"top\" width=\"25%\" style=\"padding:10px; font-size:25px;\"><strong>Score</strong></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#85cb63;\"><strong>".$report->weighting."</strong></td>";
						$recommendation = "Proceed Without Concern";
						$recommendationText = "<strong>Low Risk</strong> - Our data providers confirmed that most of the details that you provided are valid and therefore presents a low risk. Before proceeding, make sure that you familiarise yourself with any mismatches that may have occurred and take the necessary due diligence to alleviate any concerns.";
				break;
				case "REVIEW":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"25%\" style=\"padding:10px\"><img src=\"images/review.png\" /></td>"
        					."<td valign=\"top\" width=\"25%\" style=\"padding:10px; font-size:25px;\"><strong>Score</strong></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#f7c73f;\"><strong>".$report->weighting."</strong></td>";
							$recommendation = "Proceed With Caution";
						$recommendationText = "<strong>Moderate Risk</strong> - Our data providers reported a considerable number of mismatches between the data you provided and theirs and possibly other more serious issues, which presents a medium risk.<br />FraudCheck recommends that you take the following actions to reduce this risk:<ul><li>Perform your own due diligence process by requesting proof of identity, address or contact details to confirm the details that the person provided.</li><li>This process is recommended for all items that received a mismatch in the above report.</li></ul>";
				break;
				case "REJECT":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"25%\" style=\"padding:10px\"><img src=\"images/reject.png\" /></td>"
        					."<td valign=\"top\" width=\"25%\" style=\"padding:10px; font-size:25px;\"><strong>Score</strong></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#d5031c;\"><strong>".$report->weighting."</strong></td>";
							$recommendation = "Do Not Proceed";
						$recommendationText = "<strong>High Risk</strong> - Our data providers reported an unacceptable number of mismatches between the data you provided and theirs on file and/or the person has received Debt Councelling, Debt Review, has Defaulted on one or more payments or has been issued with one or more Judgements or Notices.<br />Continuing against our recommendation of <span><q>Do not proceed</q></span> is putting yourself at high risk. You should evaluate all the risks carefully and complete due diligence to reduce this risk before proceeding.";
				break;
			}
			?>
			
        </tr>
        <tr>
        	<td valign="top" style="vertical-align:baseline"><strong>Recommendation</strong></td>
        	<td valign="top" style="font-size:24px; vertical-align:baseline"><?php echo $recommendation; ?></td>
        </tr>
    	<tr>
        	<td valign="top" style=""><strong>What this means</strong></td>
        	<td valign="top" style=""><?php echo $recommendationText; ?></td>
        </tr>
        <tr>
        	<td></td>
        	<td valign="top" style=""><strong>Check Performed On</strong></td>
            <td valign="top" style=""><?php echo date ("d F Y, G:i",$report->transactionTimestamp/1000); ?></td>
            <td></td>
        </tr>
    </table>
    <div class="page-header">
          <h2 style="font-size: 1.8em; margin: 0 0 0.07em; font-weight:normal; color:#333;">Employment History</h2>
        </div>
    <?php echo $report->print_employment_history () ?>
    
    <div class="page-header">
          <h2 style="font-size: 1.8em; margin: 0em; font-weight:normal; color:#333;">Details of Check</h2>
        </div>
    
    <?php
	for ($i = 1; $i <= 10; $i++)
	{
		$cat_count = $report->category_count ($report->category_by_id ($i));
		if ($cat_count > 0)
		{
			echo "<div> " . assessment_details ($i, $report) . "</div>";
		}
    }
}
else
{
	echo "Error: You cannot view someone else's report.";
}
    ?>
<?php
function assessment_icons ($num, $report, $linesperrow = 3)
{
	$return = "";
	$badges = array ();
	$badges [0] = $report->print_badge_data_pdf (0)
            	. "<img src=\"images/rules_total.png\" style=\"padding:10px;\" />";
	$badges [1] = $report->print_badge_data_pdf ($report->category_by_id(1))
            	. "<img src=\"images/rules_address.png\" style=\"padding:10px;\" />";
	$badges [2] = $report->print_badge_data_pdf ($report->category_by_id(2))
           		. "<img src=\"images/rules_affordability.png\" style=\"padding:10px;\" />";
	$badges [3] = $report->print_badge_data_pdf ($report->category_by_id(3))
           		. "<img src=\"images/rules_business.png\" style=\"padding:10px;\" />";
	$badges [4] = $report->print_badge_data_pdf ($report->category_by_id(4))
           		. "<img src=\"images/rules_contact.png\" style=\"padding:10px;\" />";
	$badges [5] = $report->print_badge_data_pdf ($report->category_by_id(5))
           		. "<img src=\"images/rules_criminal.png\" style=\"padding:10px;\" />";
	$badges [6] = $report->print_badge_data_pdf ($report->category_by_id(6))
           		. "<img src=\"images/rules_employment.png\" style=\"padding:10px;\" />";
	$badges [7] = $report->print_badge_data_pdf ($report->category_by_id(7))
           		. "<img src=\"images/rules_identification.png\" style=\"padding:10px;\" />";
	$badges [8] = $report->print_badge_data_pdf ($report->category_by_id(8))
           		. "<img src=\"images/rules_law.png\" style=\"padding:10px;\" />";
	$badges [9] = $report->print_badge_data_pdf ($report->category_by_id(9))
           		. "<img src=\"images/rules_business.png\" style=\"padding:10px;\" />";
	$badges [10] = $report->print_badge_data_pdf ($report->category_by_id(10))
           		. "<img src=\"images/rules_deeds.png\" style=\"padding:10px;\" />";
	
	$return .= "<div class=\"row\">";
	if ($num == -1)
		$num2 = 0;
	else
		$num2 = $num;
	$return .= "<span style=\"position:relative; cursor:pointer;\" onclick=\"open_category ($num2)\">".$badges [$num2]."</span>";
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
				$return .= "<span style=\"position:relative; cursor:pointer;\" onclick=\"open_category ($i)\"";
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
	$details [1] = $report->print_rules_pdf ("Address");
	$details [2] = $report->print_rules_pdf ("Credit");
	$details [3] = $report->print_rules_pdf ("Business");
	$details [4] = $report->print_rules_pdf ("Contact");
	$details [5] = $report->print_rules_pdf ("Criminal");
	$details [6] = $report->print_rules_pdf ("Employment");
	$details [7] = $report->print_rules_pdf ("Identification");
	$details [8] = $report->print_rules_pdf ("Law");
	$details [9] = $report->print_rules_pdf ("Banking");
	$details [10] = $report->print_rules_pdf ("Deeds");
	$return .= "<div style=\" margin: 0em !important; margin-top:0px !important; margin-bottom:0px;font-size: 1.8em; font-weight: bold; color:#c3d181; padding:0px;\">".$report->category_by_id ($num)."</div>";
	$return .= $details [$num]."";
	return $return;
}
?>
