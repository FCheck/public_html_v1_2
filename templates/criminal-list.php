
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Criminal Checks
   
  </div>
  
</div> <!-- jumbotron -->
<?php
if (!empty ($q[2]))
{
	if (strcmp ($q[1], "release") == 0)
	{
		$GLOBALS ['user']->release_pending_criminal ($q[2]);
		echo "<div class=\"container\" style='margin-bottom:25px;'><div class=\"green-heading\" style='font-size:1.6em'>Criminal Check Released Successfully. Please check back in 48 hours for results.</div></div>";
	}
	else if (strcmp ($q[1], "cancel") == 0)
	{
		$GLOBALS ['user']->cancel_pending_criminal ($q[2]);
	}
}

			if (isset ($_POST ['id_search']))
			{
				$content =  $GLOBALS ['user']->print_pending_criminal_id_Search ($_POST ['id_search']); 
			}
			else
			{
				$content = $GLOBALS ['user']->print_pending_criminal (); 
			}
			?>

<!-- Content Below
    ================================================== -->
    <div class="container">
		<div class="page-header green-heading">
                Releasing Criminal Checks
             </div>
             <?php
			 if (!empty ($content))
			 {
			 ?>
              <p>The following criminal checks have been captured, but not yet released. To run the check on the relevant candidate, please release the check below:</p>
             <div class="row">
    <form method="post" name="search"  action="">
    <div class="col-sm-3">
    	&nbsp;
    </div>
    <div class="col-sm-5">
		<input type="text" class="form-control" id="id_search" placeholder="ID Number" name="id_search" /> 
    </div>
    <div class="col-sm-1" style="margin-bottom:10px">
    <input type="submit" class="btn-primary btn-lg" style="padding: 5px 16px; position:relative; top:-2px;" value="Search" />
    </div>
    <div class="col-sm-4">
    	&nbsp;
    </div>
    </form>
    </div>
        
        <div class="table-responsive">
          <table class="table table-striped faq">
          <thead>
            <tr class="head">
              <th>Name</th>
              <th>ID Number</th>
              <th>Date Submitted</th>
              <th>Uploaded By</th>
              <th>Release</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php 
			echo $content;
			?>
          </tbody>
        </table>
          
        </div>
        <?php
			 }
			 else
			 {
				 
		?>
        <p>You do not currently have any criminal checks captured on in progress.</p>
        <div class="page-header green-heading" style="font-size:1.5em">
                How do I run a criminal check
             </div>
             
             
          <p style="text-align:justify">In order to run a criminal check, the candidate has to have their fingerprints captured by a trained Fraudcheck representative. This can either be done by sending the candidate to our offices in Sandton (please <a href="contact">contact us</a> to arrange a suitable time), or alternatively we can come to your offices within the Johannesburg or Cape Town regions with the relevant equipment to take fingerprints on site. Once fingerprints have been captured, you will be able to view the status of your criminal checks on this page.</p>
          <p style="text-align:justify">To book an appointment to capture fingerprints, please contact our support desk:<br /><br />
          <strong>Call:</strong> 011 262 5252
            <br>
            <strong>Email:</strong> <a href="mailto:support@fraudcheck.co.za">support@fraudcheck.co.za</a>
            <div class="page-header green-heading" style="font-size:1.5em">
                Why do I need to capture fingerprints?
             </div>
             
             
          <p style="text-align:justify">In South Africa, it is a legal requirement to capture an individual&acute;s fingerprints before one can legally run a criminal check against them. This requirement is set by government and is in place to prevent fraud and unauthorised checks against individuals.</p>

          </div>
          <?php
			 }
		  ?>
    </div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>
