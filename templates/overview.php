
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Overview
   
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    
    <div class="container">
		
        <div class="page-header green-heading">
          <strong>Checks run this month</strong>
        </div>
        <?php
		$overview = $GLOBALS['user']->get_overview ();
		?>
        <div class="table-responsive space">
                 
          <table class="table table-striped faq">
          <thead>
            <tr class="head">
              <th></th>
              <th>Pass</th>
              <th>Fail</th>
              <th>In Progress</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          <tr>
              <td><span class="table-green-txt">ID checks</span></td>
              <td><?php echo $overview ['BIDCHK_PASS']; ?></td>
              <td><?php echo $overview ['BIDCHK_FAIL']; ?></td>
              <td>0</td>
              <td><?php echo $overview ['BIDCHK_TOTAL']; ?></td>
            </tr>
            <tr>
              <td><span class="table-green-txt">Credit Checks</span></td>
              <td><?php echo $overview ['FULLCHK_PASS']; ?></td>
              <td><?php echo $overview ['FULLCHK_FAIL']; ?></td>
              <td>0</td>
              <td><?php echo $overview ['FULLCHK_TOTAL']; ?></td>
            </tr>
            <tr>
              <td><span class="table-green-txt">Criminal Checks</span></td>
              <td><?php echo $overview ['CRIM_PASS']; ?></td>
              <td><?php echo $overview ['CRIM_FAIL']; ?></td>
              <td><?php echo $overview ['CRIM_WIP']; ?></td>
              <td><?php echo $overview ['CRIM_TOTAL']; ?></td>
            </tr>
            <tr>
              <td><span class="table-green-txt">Matric Checks</span></td>
              <td><?php echo $overview ['MATRIC_PASS']; ?></td>
              <td><?php echo $overview ['MATRIC_FAIL']; ?></td>
              <td><?php echo $overview ['MATRIC_WIP']; ?></td>
              <td><?php echo $overview ['MATRIC_TOTAL']; ?></td>
            </tr>
            <tr>
              <td><span class="table-green-txt">Tertiary education verification</span></td>
              <td><?php echo $overview ['TERTIARY_PASS']; ?></td>
              <td><?php echo $overview ['TERTIARY_FAIL']; ?></td>
              <td><?php echo $overview ['TERTIARY_WIP']; ?></td>
              <td><?php echo $overview ['TERTIARY_TOTAL']; ?></td>
            </tr>
            <tr>
              <td><span class="table-green-txt">Association checks</span></td>
              <td>0</td>
              <td>0</td>
              <td>0</td>
              <td>0</td>
            </tr>
            <tr>
              <td><span class="table-green-txt"><strong>Total</strong></span></td>
              <td><strong><?php echo $overview ['PASS_TOTAL']; ?></strong></td>
              <td><strong><?php echo $overview ['FAIL_TOTAL']; ?></strong></td>
              <td><strong><?php echo $overview ['WIP_TOTAL']; ?></strong></td>
              <td><strong><?php echo $overview ['TOTAL']; ?></strong></td>
            </tr>
          </tbody>
        </table>
        
        
          
        </div>
    </div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>
