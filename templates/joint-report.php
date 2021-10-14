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
   Estimated Joint Income Report
  </div>
</div> <!-- jumbotron -->

<?php
//let's get report data
$q = explode ('/',strtolower ($_GET ['query']));
$transactionId = $q[1];
$report = new IncomeEstimator ($transactionId);
if (empty ($transactionId))
{
	header ("location: /history");
}
if ($report->userId == $GLOBALS['user']->get_user_id())
{
?>
<!-- Content Below
    ================================================== -->
    
    <div class="container">
    	<h1>Estimated Joint Income Report on <?php echo $report->response->person1->name . " " . $report->response->person1->surname; ?> and <?php echo $report->response->person2->name . " " . $report->response->person2->surname; ?></h1>
        <div class="page-header">
          <h2>Details used to Perform Check</h2>
        </div>
        <table width="80%">
        	<tr>
            	<td colspan="2" align="center"><strong>Person 1</strong></td>
                <td colspan="2" align="center"><strong>Person 2</strong></td>
            </tr>
        	<tr>
            	<td width="20%"><strong>First Name(s):</strong></td>
                <td width="40%"><?php echo $report->response->person1->name; ?></td>
                <td width="20%"><strong>First Name(s):</strong></td>
                <td width="20%"><?php echo $report->response->person2->name; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Surname:</strong></td>
                <td width="40%"><?php echo $report->response->person1->surname; ?></td>
                <td width="20%"><strong>Surname:</strong></td>
                <td width="20%"><?php echo $report->response->person2->surname; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>ID Number:</strong></td>
                <td width="40%"><?php echo $report->response->person1->idNumber; ?></td>
                <td width="20%"><strong>ID Number:</strong></td>
                <td width="20%"><?php echo $report->response->person2->idNumber; ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Date of Birth:</strong></td>
                <td width="40%"><?php echo $report->response->person1->get_dob (); ?></td>
                <td width="20%"><strong>Date of Birth:</strong></td>
                <td width="40%"><?php echo $report->response->person2->get_dob (); ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Age:</strong></td>
                <td width="40%"><?php echo $report->response->person1->get_age(); ?></td>
                <td width="20%"><strong>Age:</strong></td>
                <td width="40%"><?php echo $report->response->person2->get_age(); ?></td>
            </tr>
            <tr>
            	<td width="20%"><strong>Gender:</strong></td>
                <td width="40%"><?php echo $report->response->person1->get_gender (); ?></td>
                <td width="20%"><strong>Gender:</strong></td>
                <td width="40%"><?php echo $report->response->person2->get_gender (); ?></td>
            </tr>
            <tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
            <tr>
            	<td width="20%"><strong>Transaction ID:</strong></td>
                <td width="40%"><?php echo $report->transactionId; ?></td>
            </tr>
        </table>
		<div class="page-header">
          <h2>Results from Check</h2>
          <p>&nbsp;</p>
          <table>
          	<tr>
          		<td>
          			<p>Estimated Income for <?php echo $report->response->person1->name . " " . $report->response->person1->surname; ?>:</p>
          		</td>
          		<td>
          			<p>R<?php echo number_format ($report->response->person1->estimatedIncome,0,"."," "); ?></p>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			<p>Estimated Income for <?php echo $report->response->person2->name . " " . $report->response->person2->surname; ?>:</p>
          		</td>
          		<td>
          			R<?php echo number_format ($report->response->person2->estimatedIncome,0,"."," "); ?></p>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			<h4>Joint Estimated Income:</h4>
          		</td>
          		<td>
          			<h4>R<?php echo number_format ($report->response->estimatedIncome,0,"."," "); ?></h4>
          		</td>
          	</tr>
          </table>
        </div>
    <!--<form method="post" action="pdf-joint-generate.php">
    <input type="hidden" name="transactionId" value="<?php echo $transactionId;?>" />
    <input type="submit" class="btn btn-success" value="Download PDF" />-->
    <?php
}
else
{
	echo "Error: You cannot view someone else's report.";
}
    ?>
    
    </div>
	<div class="space"></div><a href="#0" class="cd-top">Top</a>