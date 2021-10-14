
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Pending Consent
   
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    <?php
	if (isset ($q[1]))
	{
		$GLOBALS ['user']->cancel_pending_consent ($q[1]);
	}
	?>
    <div class="container">
		<div class="page-header green-heading">
                Request in Progress
             </div>
         <p>Your checks have been submitted successfully and are pending consent from the person being checked. Once consent is approved, you will receive an email with the result.</p>
        <div class="table-responsive">
          <table class="table table-striped faq">
          <thead>
            <tr class="head">
              <th>Name</th>
              <th>Contact Number</th>
              <th>Date Submitted</th>
              <!--<th>Cancel</th>-->
            </tr>
          </thead>
          <tbody>
            <?php echo $GLOBALS ['user']->print_pending_consent (); ?>
          </tbody>
        </table>
          
        </div>
    </div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>
