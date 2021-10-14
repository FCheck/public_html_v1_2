<?php
//let's get report data

$postvar = $_GET["trans_id"];
if (empty($postvar)) {
	$request = "";
} else {
	$transactionId = $postvar;
}

$api = new Api ();
$url = "userdata/transaction/criminal/$transactionId";
$request = "";
$return = $api->submit_api_request ($request, $url);
$response = json_decode ($return, true);
$report = new Criminal ($response);
//if ($report->accountId == $GLOBALS['user']->accountId)
//{
	/*
	public $firstName;
	public $lastName;
	public $userFirstName;
	public $userSurname;
	public $statusTimestamp;
	public $transactionId;
	public $identifier;
	public $enquiryResult;
	*/
?>
<!-- Content Below
    ================================================== -->
    
    <div class="container">
    	<h1 style="font-weight:normal; font-size: 2.5em; margin: 0 0 0.1em;">Criminal Check on <?php echo $report->firstName . " " . $report->surname; ?></h1>
        <div class="page-header">
          <h2 style="font-size: 1.8em; margin: 0 0 0.07em; font-weight:normal; color:#333;">Details used to Perform the Check</h2>
        </div>
        <table width="100%" cellpadding="5">
        	<tr>
            	<td width="20%"><strong>First Name(s):</strong></td>
                <td width="30%"><?php echo $report->firstName; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Surname:</strong></td>
                <td width="30%"><?php echo $report->surname; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>ID Number:</strong></td>
                <td width="30%"><?php echo $report->identifier; ?></td>
            </tr>
            <tr>
            	<td><strong>Date of Birth:</strong></td>
                <td><?php echo $report->dateOfBirth; ?></td>
            </tr>
            <tr>
            	<td><strong>Age:</strong></td>
                <td><?php echo $report->get_age(); ?></td>
            </tr>
            <tr>
            	<td><strong>Gender:</strong></td>
                <td><?php echo $report->gender; ?></td>
            </tr>
        </table>
          <h2 style="font-size: 1.8em; margin: 0 0 0.07em; font-weight:normal; color:#333;">Results from Check</h2>
   		<table cellpadding="5">
        <tr>
        	<?php
			switch ($report->enquiryResult)
			{
				case 1:
						echo "<td valign=\"top\" rowspan=\"3\" width=\"25%\" style=\"padding:10px\"><img src=\"images/review.png\" /></td>"
        					."<td valign=\"top\" width=\"25%\" style=\"padding:10px; font-size:25px;\"></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#85cb63;\"></td>";
						$recommendation = "Proceed With Caution";
						$recommendationText = "<strong>No Match</strong> - We could not find a match for this user with our data providers.";
				break;
				case 2:
						echo "<td valign=\"top\" rowspan=\"3\" width=\"25%\" style=\"padding:10px\"><img src=\"images/accept.png\" /></td>"
        					."<td valign=\"top\" width=\"25%\" style=\"padding:10px; font-size:25px;\"></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#85cb63;\"></td>";
						$recommendation = "Proceed Without Concern";
						$recommendationText = "<strong>No illicit activity found</strong> - The individual does not have a criminal record.";
				break;
				case 3:
						echo "<td valign=\"top\" rowspan=\"3\" width=\"25%\" style=\"padding:10px\"><img src=\"images/reject.png\" /></td>"
        					."<td valign=\"top\" width=\"25%\" style=\"padding:10px; font-size:25px;\"></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#d5031c;\"></td>";
							$recommendation = "Do Not Proceed";
						$recommendationText = "<strong>Illicit activity found</strong> - The individual has a criminal record.";
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
            <td valign="top" style=""><?php echo $report->statusTimestamp; ?></td>
            <td></td>
        </tr>
    </table>
    <?php
/*}
else
{
	echo "Error: You cannot view someone else's report.";
}*/
?>
