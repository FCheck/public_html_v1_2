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
    	<h1>Criminal Check on <?php echo $report->firstName . " " . $report->lastName; ?></h1>
        <div class="page-header">
          <h2>Details used to Perform Check</h2>
        </div>
        <table width="80%">
        	<tr>
            	<td width="20%"><strong>First Name(s):</strong></td>
                <td width="40%"><?php echo $report->firstName; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Surname:</strong></td>
                <td width="40%"><?php echo $report->lastName; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>ID Number:</strong></td>
                <td width="40%"><?php echo $report->idNumber; ?></td>
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
			$report->screeningResult = "ACCEPT";
			switch ($report->screeningResult)
			{
				case "ACCEPT":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"15%\" style=\"padding:10px\"><img src=\"../images/accept.png\" /></td>"
        					."<td valign=\"top\" width=\"15%\" style=\"padding:10px; font-size:25px;\"></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#85cb63;\"></td>";
						$recommendation = "Proceed Without Concern";
						$recommendationText = "<strong>No Criminal Record</strong> - The individual does not have a criminal record.";
				break;
				case "REJECT":
						echo "<td valign=\"top\" rowspan=\"3\" width=\"15%\" style=\"padding:10px\"><img src=\"../images/reject.png\" /></td>"
        					."<td valign=\"top\" width=\"15%\" style=\"padding:10px; font-size:25px;\"></td>"
            				."<td valign=\"top\" width=\"50%\" style=\"padding:10px; font-size:25px; color:#d5031c;\"></td>";
							$recommendation = "Do Not Proceed";
						$recommendationText = "<strong>Criminal Record Found</strong> - The individual has a criminal record.";
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
    
   
    <form method="post" action="pdf-generate.php">
    <input type="hidden" name="transactionId" value="<?php echo $transactionId;?>" />
    <input type="submit" onclick="document.location.href='for-you-get-started'" class="btn btn-success" value="Download PDF" />
    <?php
}
else
{
	echo "Error: You cannot view someone else's report.";
}
    ?>
    
    </div>
	<div class="space"></div><a href="#0" class="cd-top">Top</a>

?>
