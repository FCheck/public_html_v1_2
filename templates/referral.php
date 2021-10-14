<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
$dbconn = new DatabaseConn ();
$code = $dbconn->retrieve_code ($_SESSION ['user_id']);
?>

<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Refer a friend
   <div class="try"><a href="register"><input type="button" class="btn btn-primary btn-nav" value="TRY NOW" /></a></div>
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    
    <div class="container">

    	<div class="row space">
          <div class="col-md-12">
            <div class="page-header green-heading">
                <strong>Refer a business</strong>
             </div> 
             <br />  
           <p>Receive up to R900 in free Fraudcheck credit by refering other businesses to Fraudcheck! Simply give the referral code below to anyone you know who works at a business that can benefit from Fraudcheck&lsquo;s services and we will reward both of you with R90 credit. You may refer up to 10 friends using the same code, you will receive your free credit once your friend redeems their credit, it's that simple!</p>
           <div class="green-heading" style="font-size:1.5em;">Your Unique Referral Code: <strong><?php echo $code ['code']; ?></strong></div>
           <br />
           <p><strong>Click below to share your referral code on social media</strong></p>
           <div><a href="https://www.facebook.com/dialog/feed?app_id=184683071273&link=http%3A%2F%2Fwww.fraudcheck.co.za%2Fregister%2<?php echo $code ['code']; ?>&picture=http%3A%2F%2Fwww.fraudcheck.co.za%2Fimages%2Ffeature1.jpg&name=Fraudcheck%20background%20checks%2C%20credit%20checks%2C%20criminal%20checks%20%26%20more&caption=%20&description=Run%20credit%20checks%20and%20many%20other%20background%20checks%20instantly%20online.%20Register%20at%20Fraudcheck%20today%20with%20the%20code%20<?php echo $code ['code']; ?>%20to%20receive%20R90%20free%20credit!&redirect_uri=http%3A%2F%2Fwww.facebook.com%2F" target="_blank"><img src="images/sm-fb.png" /></a>&nbsp;&nbsp;
           <a href="https://twitter.com/home?status=Run%20credit%20%26%20background%20checks%20online.%20Register%20with%20the%20code%20<?php echo $code ['code']; ?>%20to%20receive%20R90%20free%20credit!%20http%3A//www.fraudcheck.co.za/register/<?php echo $code ['code']; ?>" target="_blank"><img src="images/sm-tw.png" /></a>&nbsp;&nbsp;
           <a href="https://www.linkedin.com/shareArticle?mini=true&url=http%3A//www.fraudcheck.co.za/register/<?php echo $code ['code']; ?>&title=Fraudcheck%20background%20checks,%20credit%20checks,%20criminal%20checks%20%26%20more&summary=Run%20credit%20checks%20and%20other%20background%20checks%20instantly%20online.%20Register%20at%20Fraudcheck%20today%20with%20the%20code%20<?php echo $code ['code']; ?>%20to%20receive%20R90%20free%20credit!&source=" target="_blank"><img src="images/sm-ln.png" /></a></div>
           <br /><br />
             
             
                	<?php
					$refers = $dbconn->retrieve_codeuse_list ($_SESSION ['user_id']);
					if (sizeof ($refers) > 0)
					{
						?>
                        <div class="page-header green-heading">
                            <strong>Your Referrals</strong>
                         </div> 
                         <br />
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
					}
					foreach ($refers as $refer)
					{
						$userId = $refer ['newuserId'];
						$status = $refer ['status'];
						$user = new User (intval ($userId));
						$name = $user->firstName . " " . $user->surname;
						echo "<tr><td>$name</td><td>";
						switch ($status)
						{
							case 0: echo "Awaiting first purchase";
							break;
							
							case 1: echo "R90 Credit Allocated";
							break;
						}
						echo "</td></tr>";
					}
					if (sizeof ($refers) > 0)
					{
						echo "</tbody></table>";
					}
					?>
          <br /><br />
        </div>
        </div>
</div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>

