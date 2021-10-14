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
   Deeds Lookup
  </div>
</div> <!-- jumbotron -->

<?php
//let's get report data
$q = explode ('/',strtolower ($_GET ['query']));
$transactionId = $q[1];
$report = new DeedsReport ($transactionId);
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
    	<h1>Deeds Lookup on <?php echo $report->firstName . " " . $report->lastName; ?></h1>
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