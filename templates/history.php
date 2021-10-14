
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   History
   
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    
    <div class="container">
    <div class="row">
    <form method="post" action="">
    <div class="col-sm-3">
    	&nbsp;
    </div>
    <div class="col-sm-5">
		<input type="text" class="form-control" id="id_search" placeholder="ID Number" name="id_search"> 
    </div>
    <div class="col-sm-1" style="margin-bottom:10px">
    <input type="submit" class="btn-primary btn-lg" style="padding: 5px 16px; position:relative; top:-2px;" value="Search" />
    </div>
    <div class="col-sm-4">
    	&nbsp;
    </div>
    </form>
    </div>
    <?php
		  if (isset ($_POST ['id_search']))
		  {
				$content =  $GLOBALS ['user']->get_processed_criminal_by_id_number ($_POST ['id_search']); 
		  }
		  else
		  {
		   	   $GLOBALS ['user']->get_processed_criminal_by_user_id (); 
		  }
		  $GLOBALS ['user']->get_joint_income_estimator ();
		  
        if (sizeof ($GLOBALS ['user']->jointIncome) > 0)
	 	{
		?>
    <div class="green-heading" style="font-size:1.5em">Joint Income Estimator Reports</div>
    	<div class="table-responsive">
          
          
          <table class="table table-striped faq">
          <thead>
            <tr class="head">
              <th>Full Names</th>
              <th>ID Numbers</th>
              <th>Date Processed</th>
              <th>Result</th>
              <th>View</th>
            </tr>
          </thead>
          <tbody>
            <?php echo $GLOBALS ['user']->print_income_estimator_transactions (); ?>
          </tbody>
        </table>
          
        </div>
        <?php
		}
        if (sizeof ($GLOBALS ['user']->criminals) > 0)
	 	{
		?>
    <div class="green-heading" style="font-size:1.5em">Criminal Reports</div>
    	<div class="table-responsive">
          
          
          <table class="table table-striped faq">
          <thead>
            <tr class="head">
              <th>Full Name</th>
              <th>ID Number</th>
              <th>Date Processed</th>
              <th>Result</th>
              <th>Submitted By</th>
              <th>Download</th>
            </tr>
          </thead>
          <tbody>
            <?php echo $GLOBALS ['user']->print_criminal_transactions (); ?>
          </tbody>
        </table>
          
        </div>
    <div class="green-heading" style="font-size:1.5em">All Other Reports</div>
    <?php
		  }
	?>
        <div class="table-responsive">
          <?php
		  if (isset ($_POST ['id_search']))
		  {
			$GLOBALS ['user']->search_transactions_by_id_number ($_POST ['id_search']);
		  }
		  else
		  {
		  	$GLOBALS ['user']->get_latest_transactions_by_account ();
		  }
		  ?> 
     <table class="table table-striped faq">
          <thead>
            <tr class="head">
              <th>Name Contact Date</th>
              <th>Checked By</th>
              <th>Results</th>
              <th>View Details</th>
            </tr>
          </thead>
          <tbody>
            <?php echo $GLOBALS ['user']->print_latest_transactions (); ?>
          </tbody>
        </table>
          
        </div>
    </div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>
