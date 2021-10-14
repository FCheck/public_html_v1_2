<?php
$dbconn = new DatabaseConn ();
$redeemableCode = 0;
$referralheading = "";
$referalMessage = "";
if (!empty ($_POST) && $GLOBALS ['user']->is_business_account ())
{
	if ($_POST ['acc_type'] == 2)
	{
		$code = strtoupper (substr ($_POST ['companyName'],0,3));
		$code = $dbconn->generate_code ($GLOBALS ['user']->get_user_id(), $code);
	}
}
if (!empty ($q[1]) && $GLOBALS ['user']->is_business_account ())
{
	//user is attempting to purchase credits using their referral credit
	$credits = $q[1];
	switch ($credits)
	{
		case 9: $amountRequired = 99;
		break;

		case 30: $amountRequired = 299;
		break;

		case 100: $amountRequired = 899;
		break;
	}

	$holdingcreditArr = $dbconn->retrieve_holdingcredit_list ($_SESSION ['user_id']);
	$creditAmt = 0;
	foreach ($holdingcreditArr as $holdingcredit)
	{
		if ($holdingcredit ['status'] == 1 && $creditAmt < $amountRequired)
		{
			$available = $holdingcredit ['amount'] - $holdingcredit ['amountUsed'];
			if ($available + $creditAmt <= $amountRequired)
			{
				//redeem entire coupon
				$creditAmt += $available;
				$dbconn->update_holdingcredit ($holdingcredit ['codeuseId'], $_SESSION ['user_id'], 2, 1, $holdingcredit ['amount']);
			}
			else
			{
				//partially redeem coupon
				$availPortion = $available + $creditAmt - $amountRequired;
				//echo "$availPortion = $available + $creditAmt - $amountRequired<br>";
				$redeemPortion = $amountRequired - $creditAmt;
				//echo "$redeemPortion = $amountRequired - $creditAmt<br>";
				$totalRedeemed = $redeemPortion + $holdingcredit ['amountUsed'];
				//echo "$totalRedeemed = $redeemPortion + ".$holdingcredit ['amountUsed'];
				$creditAmt = $amountRequired;
				$dbconn->update_holdingcredit ($holdingcredit ['codeuseId'], $_SESSION ['user_id'], 1, 1, $totalRedeemed);
			}
			$possibleCodeuse = $dbconn->retrieve_codeuse ($_SESSION ['user_id']);
			if ($holdingcredit ['codeuseId'] == $possibleCodeuse ['codeuseId'])
			{
				//this user was referred by someone else - lets make that person's credit available
				$dbconn->update_holdingcredit ($possibleCodeuse ['codeuseId'], $possibleCodeuse ['refererId'], 1);
			}
		}
	}
	if ($creditAmt == $amountRequired)
	{
		$transactionId = $GLOBALS ['user']->create_purchase_reference();
		$check = $GLOBALS ['user']->confirm_transaction ($transactionId, $credits, $creditAmt, "Referral credit", 2);//status 2 = approved
		header ("location: /coupon-success");
	}

}

if ($GLOBALS ['user']->is_business_account ())
{
	$codeuse = $dbconn->retrieve_codeuse ($_SESSION ['user_id']);
	if (empty ($codeuse))
	{
		if ($GLOBALS ['user']->days_since_registration() <= 7)
		{
			$referralheading = "Redeem a referral code";
			$referalMessage = "Did a friend refer you to Fraudcheck? Enter their referral code here and you'll each receive free Fraudcheck credit!";
			$redeemableCode = 1;
		}
	}
}
if (!empty ($_POST ['referralCode']) && $GLOBALS ['user']->is_business_account ())
{
	//user registered with a referral code
	$referrer = $dbconn->retrieve_user_by_code ($_POST ['referralCode']);
	if (!empty ($referrer))
	{
		if ($referrer ['count'] < 10)
		{
			//check that user hasn't already entered a referral code
			$check = $dbconn->retrieve_codeuse ($_SESSION ['user_id']);
			if ($check == 0)
			{
				//lets make sure the user isn't using their own referral code!
				$check2 = $dbconn->retrieve_user_by_code ($_POST ['referralCode']);
				if ($check2 ['userId'] != $_SESSION ['user_id'])
				{
					//lastly, lets do an IP address check as an attempt to stop users from registering multiple accounts
					if ($dbconn->check_ip() <= 1)
					{
						$codeuseId = $dbconn->insert_codeuse ($referrer ['userId'], $_SESSION ['user_id'], 0);
						$dbconn->increment_code ($_POST ['referralCode']);
						$dbconn->send_friend_code_ac ($_POST ['referralCode']);
						$holdingcredit = $dbconn->insert_holdingcredit ($codeuseId, $_SESSION ['user_id'], 90, 1);
						$holdingcredit = $dbconn->insert_holdingcredit ($codeuseId, $referrer ['userId'], 90, 0);
						$referralheading = "Our gift to you";
						$referalMessage = "Your referral code was redeemed successfully and we have allocated R90 toward your next purchase on Fraudcheck. Please see details below :)";
						$redeemableCode = 0;
					}
					else
					{
						$referralheading = "Referral redeem error";
						$referalMessage = "Unfortunately your IP address has already been used to redeem 2 codes - please note that only 1 code may be redeemed per user. If you believe this to be in error please contact our support team for further assistance.";
						$redeemableCode = 1;
					}
				}
				else
				{
					$referralheading = "Referral redeem error";
					$referalMessage = "We like the way you think, but unfortunately you can't use your own referral code. If you have another referral code, please enter it below. Alternatively, if you believe this to be in error please contact our support team for further assistance.";
					$redeemableCode = 1;
				}
			}
			else
			{
				$referralheading = "Referral redeem error";
			$referalMessage = "Our system indicates that you have already redeemed a referral code, and this one was therefore not applied. If you believe this to be in error please contact our support team for further assistance.";
			$redeemableCode = 0;
			}
		}
		else
		{
			//referral code has been used too many times
			$referralheading = "Referral redeem error";
			$referalMessage = "Please note that the referral code used was invalid as it has exceeded the maximum number of referrals. If you have another referral code, please enter it below. Alternatively, if you believe this to be in error please contact our support team for further assistance.";
			$redeemableCode = 1;
		}
	}
	else
	{
		//referral code not found
		$referralheading = "Referral redeem error";
		$referalMessage = "Please note that the referral code used was invalid and could not be applied. Please try again or enter another referral code below. Alternatively, if you believe this to be in error please contact our support team for further assistance.";
		$redeemableCode = 1;
	}
}
//TODO: add to active campaign


$holdingcreditArr = $dbconn->retrieve_holdingcredit_list ($_SESSION ['user_id']);
$creditAmt = 0;
foreach ($holdingcreditArr as $holdingcredit)
{
	if ($holdingcredit ['status'] == 1)
		$creditAmt += $holdingcredit ['amount'] - $holdingcredit ['amountUsed'];
}
if ($creditAmt > 0 && $GLOBALS ['user']->is_business_account ())
{
	if (!empty ($referalMessage))
		$referalMessage .= "<br><br>";

	$referalMessage .= "You have <strong>R".$creditAmt.".00</strong> of referral credit available. This amount will be used toward your next purchase of Fraudcheck credits and the prices below reflect only the pay-in amount required.";

	if (empty ($referralheading))
		$referralheading = "Referral credit available";
}


//temporary script - NB: DO NOT UNCOMMENT UNLESS YOU KNOW WHAT YOU ARE DOING!!!
/*$api = new Api ();
$url = "userdata/businessaccount/list";
$request = "";
$return = $api->submit_api_request ($request, $url);
$businesses = json_decode ($return);

for ($i = 301; $i <= 408; $i++)
{
	$accountId = $businesses[$i]->id;
	$accUrl = "userdata/get/account/$accountId";
	$accReturn = $api->submit_api_request ($request, $accUrl);
	$account = json_decode ($accReturn, true);

	if (json_last_error() === JSON_ERROR_NONE)
	{
		// JSON is valid
		if (is_array ($account))
		{
			$userId = intval ($account['id']);
			$user = new User ($userId);
			$email = $user->email;
			$code = strtoupper (substr ($businesses[$i]->name,0,3));
			$code = $dbconn->generate_code ($userId, $code, $email);
			echo $account['id'] . " - " . $businesses[$i]->name . "<br>";
		}
	}
}*/
//end temp script
?>

  <!-- Header Image
    ================================================== -->
  <div class="jumbotron" style="background:url(images/content_header1.jpg) center center;
          background-size:cover;">
    <div class="container content-header">
      <?php
			if (!empty ($_POST))
			{
				echo "Welcome";
			}
			else
			{
                echo "Buy Credits";
			}
			?>

    </div>
  </div>
  <!-- jumbotron -->


  <!-- Content Below
    ================================================== -->

  <div class="container" ng-init="plant=400;power=0.70;target=0.96;cost=40.00">

    <div class="row space">
      <div class="col-md-12">

        <div class="pricelist" ng-show="pricelist">

          <?php
			 if (!empty ($referralheading))
			 {

			 ?>
            <div class="page-header green-heading">
              <strong><?php echo $referralheading ?></strong>
            </div>
            <div>
              <br />
              <p style="font-size:19px">
                <?php echo $referalMessage; ?>
              </p>
              <br />
              <?php
					if ($redeemableCode == 1)
					{
					?>
                <form method="post" action="buy-credits">
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" class="form-control" id="referralCode" placeholder="Referral Code" name="referralCode" style="height:45px">
                    </div>
                    <div class="col-md-2">
                      <input type="hidden" class="form-control" id="acc_type" name="acc_type" value="3">
                      <input type="submit" class="btn-primary btn-lg" value="Redeem" />
                    </div>
                    <div class="col-md-6"></div>
                  </div>
                </form>
                <?php
					}
					?>
                  <br />
                  <br />
            </div>
            <?php
			 }
			 ?>
              <div class="page-header green-heading">
                <strong>Purchase Credits</strong>
              </div>
              <br />
              <p style="font-size:19px">Get started with Fraudcheck quickly and easily by selecting a bundle of credits below. Not sure what this means? <a class="scroll" href="#credits">Click here</a></p>
              <br />
              <br />
              <div class="col-md-12">
                <div class="row clearfix">
                  <!-- Pricelist block one -->
                  <div class="col-md-3   column">
                    <div class="top_div">
                      Micro
                    </div>
                    <div class="mid_div">
                      9 credits
                      <hr> Valid for 60 days
                      <hr>
                      <span class="price">
                            <?php
							if ($creditAmt > 0)
								echo "<del>";
							?>
                            	R99.00 <small>incl. VAT</small>
                            <?php
							if ($creditAmt > 0)
							{
								echo "</span></del>"; $amt1 = 99 - $creditAmt; if ($amt1
                      < 0) $amt1=0 ; echo "<br><span style='color:#96d651; font-weight:bold;'>R".$amt1. ".00</span>"; } else { echo "<br> "; } ?>
                        </span>
                        <br>
                        <br>

                        <div class="padding2"></div>
                        <?php
							if ($creditAmt > 0)
							{
								$amt1 = 99 - $creditAmt;
								if ($amt1 <= 0)
								{
									echo "<div class='button'><a id='link-1' href='buy-credits/9' >Get Now</a></div>";
								}
								else
								{
									echo "<div class='button'><a id='link-1' href ng-click='showAlert();value = 9' >Buy Now</a></div>";
								}
							}
							else
							{
								echo "<div class='button'><a id='link-1' href ng-click='showAlert();value = 9' >Buy Now</a></div>";
							}
							?>

                    </div>
                    <div class="bot_div">
                      <br> Real time checks
                      <hr> Full reporting
                      <hr> Email support
                      <hr> No Monthly Retainer
                      <br/>
                      <br>
                    </div>

                  </div>
                  <!-- End Pricelist block one -->

                  <!-- Pricelist block two -->
                  <div class="col-md-3 top   column">
                    <div class="top_div">
                      Basic
                    </div>
                    <div class="mid_div">
                      30 credits
                      <hr> Valid for 360 days
                      <hr>
                      <span class="price">
                            <?php
							if ($creditAmt > 0)
								echo "<del>";
							?>
                            	R299.00 <small>incl. VAT</small>
                            <?php
							if ($creditAmt > 0)
							{
								echo "</span></del>"; $amt2 = 299 - $creditAmt; if ($amt2
                      < 0) $amt2=0 ; echo "<br><span style='color:#96d651; font-weight:bold;'>R".$amt2. ".00</span>"; } else { echo "<br> <small>10 % savings</small>"; } ?>

                        </span>
                        <br>
                        <br>
                        <?php
							if ($creditAmt > 0)
							{
								$amt2 = 299 - $creditAmt;
								if ($amt2 <= 0)
								{
									echo "<div class='button'><a id='link-2' href='buy-credits/30' >Get Now</a></div>";
								}
								else
								{
									echo "<div class='button'><a id='link-2' href ng-click='showAlert();value = 30' >Buy Now</a></div>";
								}
							}
							else
							{
								echo "<div class='button'><a id='link-2' href ng-click='showAlert();value = 30' >Buy Now</a></div>";
							}
							?>
                    </div>
                    <div class="bot_div">
                      <br> Real time checks
                      <hr> Full reporting
                      <hr> Email &amp; Telephone support
                      <hr> No Monthly Retainer
                      <br/>
                      <br>
                    </div>
                  </div>
                  <!-- End Pricelist block two -->
                  <!-- Pricelist block three -->
                  <div class="col-md-3   column">
                    <div class="top_div">
                      Pro
                    </div>
                    <div class="mid_div">
                      100 credits
                      <hr> Does not expire
                      <hr>
                      <span class="price">
                            <?php
							if ($creditAmt > 0)
								echo "<del>";
							?>
                            	R899.00 <small>incl. VAT</small>
                            <?php
							if ($creditAmt > 0)
							{
								echo "</span></del>"; $amt3 = 899 - $creditAmt; if ($amt3
                      < 0) $amt3=0 ; echo "<br><span style='color:#96d651; font-weight:bold;'>R".$amt3. ".00</span>"; } else { echo "<br> <small>20 % savings</small>"; } ?>
                        </span>
                        <br>
                        <br>
                        <?php
							if ($creditAmt > 0)
							{
								$amt3 = 899 - $creditAmt;
								if ($amt3 <= 0)
								{
									echo "<div class='button'><a id='link-4' href='buy-credits/100' >Get Now</a></div>";
								}
								else
								{
									echo "<div class='button'><a id='link-4' href ng-click='showAlert();value = 100' >Buy Now</a></div>";
								}
							}
							else
							{
								echo "<div class='button'><a id='link-4' href ng-click='showAlert();value = 100' >Buy Now</a></div>";
							}
							?>
                    </div>
                    <div class="bot_div">
                      <br> Real time checks
                      <hr> Full reporting
                      <hr> Email &amp; Telephone support
                      <hr> No Monthly Retainer
                      <br/>
                      <br>
                    </div>
                  </div>
                  <div class="col-md-3 top  column">
                    <div class="top_div">
                      Enterprise
                    </div>
                    <div class="mid_div">
                      Our enterprise solutions are tailor made for companies looking to do large volume.

                      <div class="padding3"></div>
                      <div class="button"><a href="/contact">Contact Us</a></div>
                    </div>
                    <div class="bot_div">
                      <br> API integration – integrate Fraud Check services into your internal or client facing systems
                      <hr> Customised pricing based on volume
                      <hr> Billing in arrears
                      <hr> White-labelled solutions
                      <br/>
                      <br>
                    </div>
                  </div>
                  <!-- End Pricelist block one -->
                </div>
              </div>

              <div class="col-md-11">
                <div class="heading">Questions about pricing? Call us at 011 262 5252 </div>
                <br>
              </div>
              <div class="col-md-12">
                <div class="line">&nbsp;</div>
                <br />
                <!--<p style="font-size:20px">No credit card? No problem! Contact support today for an invoice to pay by EFT</p>-->
                <ul>
                  <li>Proof of payment must be e-mailed to Support@fraudcheck.co.za</li>
                  <li>Credits will only be allocated Monday to Friday, 8:00 - 17:00</li>
                </ul>
                <br>
                <div class="sub_heading">
                  <a id="credits"></a>What are credits and how do I use them?</div>
                <br>
              </div>

              <div class="col-md-11">
                <div class="text">All Fraud Check services are managed through a pre-paid credit system. Think of it like getting a data bundle for your cell phone – first you buy a bundle of data, and then as you use the internet your data balance goes down. Similarly, once you purchase a credit bundle from Fraud Check, you will have a balance of credits which can be used to run the various checks offered. Once your bundle runs out, you may top it up with a new bundle. Each check requires the following number of credits:</div>
                <div class="space"></div>
                <?php
	$credits = new Credits ();
?>

                  <table class="grey">
                    <tr>
                      <td class="td1"><a href="services/id-check">ID Check</a>

                        <div class="line1"></div>

                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('id'); ?> (R10)

                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/credit-check">Credit Check</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('credit'); ?> (R30)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/credit-check">Credit Check With Payment Profile</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('payment'); ?> (R60)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/criminal-check">Criminal Check</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">R114.00
                        <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/drivers-license-check">Drivers License Check</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('drivers'); ?> (R60)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/matric-verification">Matric Check</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('matric'); ?> (R60)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/tertiary-verification">Tertiary Education Check</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('tertiary'); ?> (R60)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/association-check">Association Check</a>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('association'); ?> (R60)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><a href="services/association-check">Bank Account Verification</a>

                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('bank'); ?> (R10)</td>
                    </tr>
                  </table>
                  <div class="space"></div>
                  <div class="sub_heading">Example</div>
                  As an example, if you wanted to perform an ID check, Credit check and Matric check on a single individual, the check would require the following number of credits:
                  <br />
                  <br />
              </div>

              <div class="col-md-4" style="margin-top:10px">
                <?php
	$credits = new Credits ();
?>
                  <table class="grey">
                    <tr>
                      <td class="td1"><span class="a">ID Check</span>
                        <div class="line1"></div>

                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('id'); ?> (R10)

                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><span class="a">Credit Check</span>
                        <div class="line1"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('credit'); ?> (R30)
                          <div class="line2"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><span class="a">Matric Check</span>
                        <div class="line1"></div>
                        <div class="line3"></div>
                      </td>
                      <td class="td2">
                        <?php echo $credits->credits_with_text ('matric'); ?> (R60)
                          <div class="line2"></div>
                          <div class="line4"></div>
                      </td>
                    </tr>
                    <tr>
                      <td class="td1"><span class="a">Total Credits required</span>

                      </td>
                      <td class="td2"><span class="b">11 Credits (R110)</span>

                      </td>
                    </tr>
                  </table>
              </div>

        </div>
      </div>
      <div class="space"></div>

    </div>
    <input ng-model="value" type="hidden" id="amt" />
    <br />

    <!--<div class="form-group">
                <label for="inputcredits">Number of Credits</label>
                <select class="form-control" id="select_credits" onchange="update_purchase_credits ()">
                  <option value="10">10 Credits</option>
                  <option value="20">20 Credits</option>
                  <option value="50">50 Credits</option>
                  <option value="70">70 Credits</option>
                  <option value="100">100 Credits</option>
                  <option value="150">150 Credits</option>
                  <option value="250">250 Credits</option>
                  <option value="500">500 Credits</option>
                </select>
              </div>-->


    <!-- Calculation Table -->
    <div class="calculation" ng-show="calculation">
      <div class="page-header green-heading">
        <strong>Purchase Credits</strong>
      </div>
      <table class="grey" width="100%">
        <tr>
          <td class="td1 a" colspan="2"><strong>Confirm Purchase <span class="numcredits" name="amt" ng-model="amt">{{value}}</span> Credits</strong>
            <div class="line1"></div>
          </td>
        </tr>
        <tr>
          <td class="td1 a">Number of credits
            <div class="line1"></div>
          </td>
          <td align="right" class="b td2"><span class="numcredits">{{value}}</span>
            <div class="line2"></div>
          </td>
        </tr>
        <tr>
          <td class="a td1"><strong>Total cost (incl vat)</strong>
            <div class="line1"></div>
          </td>
          <td class="b td2" align="right">
            <!-- show discount values -->
            R<span id="creditcost">
                        <span ng-switch on="value">
                        	<span ng-switch-when="9">99
                            </span>
            <span ng-switch-when="30">299
                            </span>
            <span ng-switch-when="100">899
                            </span>
            </span>.00</strong>
            </span>
            </span>
            <div class="line2"></div>
          </td>
        </tr>
        <?php
				if ($creditAmt > 0)
				{
				?>
          <tr>
            <td class="a td1">LESS: Referral Credit
              <div class="line1"></div>
              <div class="line3"></div>
            </td>

            <td align="right" class="b td2">
              <span ng-switch on="value">
                        	<span ng-switch-when="9">- R<?php if ($creditAmt < 99) echo $creditAmt; else echo "99"; ?>
                            </span>
              <span ng-switch-when="30">- R<?php if ($creditAmt < 299) echo $creditAmt; else echo "299"; ?>
                            </span>
              <span ng-switch-when="100">- R<?php if ($creditAmt < 899) echo $creditAmt; else echo "899"; ?>
                            </span>
              </span>.00</strong>
              </span>
              <div class="line2"></div>
              <div class="line4"></div>

            </td>
          </tr>

          <tr>
            <td class="a td1"><strong>Total Cost</strong></td>
            <td class="b td2" align="right">
              <strong>R<span id="totalcost">
                    	<span ng-switch on="value">
                        	<span ng-switch-when="9"><?php echo $amt1; ?>
                            </span>
                            <span ng-switch-when="30"><?php echo $amt2; ?>
                            </span>
                            <span ng-switch-when="100"><?php echo $amt3; ?>
                            </span>
                           </span>.00</strong>
              </span>
            </td>
          </tr>
          <?php
				}
				?>

      </table>

      <!-- calculations for checkout -->
      <div ng-switch on="value">
        <span ng-switch-when="9"><input  type="hidden" id="select_credits" value="<?php if ($creditAmt > 0) echo $amt1; else echo "99"; ?>" /><br /></span>
        <span ng-switch-when="30"><input  type="hidden" id="select_credits" value="<?php if ($creditAmt > 0) echo $amt2; else echo "299"; ?>" /></span>
        <span ng-switch-when="100"><input  type="hidden" id="select_credits" value="<?php if ($creditAmt > 0) echo $amt3; else echo "899"; ?>" /></span>
        <span ng-switch-default></span>
      </div>
      <!-- end calculations for checkout -->

      <form class="form-horizontal" role="form" name="creditsform" onsubmit="submit_transaction (); return false" action="https://www.vcs.co.za/vvonline/vcspay.aspx" method="post">
        <input type="hidden" name="p1" value="6307">
        <input type="hidden" name="p2" id="transaction_ref" value="">
        <input type="hidden" name="p3" value="Fraudcheck Credits">
        <input type="hidden" name="p4" id="transaction_amount" value="">
        <input type="hidden" name="p5" value="ZAR">
        <input type="hidden" name="p10" value="http://<?php echo $_SERVER ['HTTP_HOST']; ?>/buy-credits">
        <input type="hidden" name="CardholderEmail" value="<?php echo $GLOBALS ['user']->email; ?>">
        <input type="hidden" name="CardholderName" value="<?php echo $GLOBALS ['user']->firstName . " " . $GLOBALS ['user']->surname; ?>">
        <input type="hidden" name="Mobile" id="transaction_mobile" value="N">
        <input type="hidden" name="UrlsProvided" value="Y">
        <input type="hidden" name="ApprovedUrl" value="http://<?php echo $_SERVER ['HTTP_HOST']; ?>/transaction/approved">
        <input type="hidden" name="DeclinedUrl" value="http://<?php echo $_SERVER ['HTTP_HOST']; ?>/transaction/declined">
        <input type="hidden" name="hash" id="transaction_hash" value="">
        <br />
        <br />
        <!--<p style="font-size:20px">No credit card? No problem! Click the Pay by Internet Banking button below or contact support on 011 262 5252 today for an invoice to pay by EFT</p>-->
        <br />
        <br />
        <div class="col-md-11">
          <div class="text"><ul><li>a) Proof of payment must be e-mailed to Support@fraudcheck.co.za</li>
            <li>b) Credits will only be allocated Monday to Friday, 8:00 - 17:00</li></ul></div>
          <div class="space"></div>
        <div class="form-group">
          <div class="col-sm-4"></div>
          <div class="col-sm-6" id="proceed_btn_area">
            <input type="submit" class="btn-primary btn-lg" value="Pay by Credit Card" style="width:300px;">
          </div>
        </div>
      </form>
      <form class="form-horizontal" role="form" name="creditsform_sid" onsubmit="submit_sid_transaction (); return false" action="https://www.sidpayment.com/paySID/" method="post">
        <input type="hidden" name="SID_MERCHANT" id="sid_merchant" value="FRAUDCHECK">
        <input type="hidden" name="SID_REFERENCE" id="sid_reference" value="">

        <input type="hidden" name="SID_AMOUNT" id="sid_amount" value="">
        <input type="hidden" name="SID_CURRENCY" id="sid_currency" value="ZAR">
        <input type="hidden" name="SID_COUNTRY" id="sid_country" value="ZA">
        <input type="hidden" name="SID_CONSISTENT" id="sid_consistent" value="">
        <!--<div class="form-group">-->
          <!--<div class="col-sm-4"></div>-->
          <!--<div class="col-sm-6" id="proceed_btn_area_2">-->
            <!--<input type="submit" class="btn-primary btn-lg" value="Pay by Internet Banking - SID" style="width:300px;">-->
          <!--</div>-->
        <!--</div>-->

      </form>






    </div>
    <?php
	$credits = new Credits ();
?>
  </div>
  <div class="col-md-1"></div>
  <!--<div class="col-md-12">
          	<div class="page-header green-heading">
				<strong>How many credits do you need?</strong>
			</div>
            <br>
          	Credit's used last month:
            <strong class="table-green-txt">100</strong>
            <br><br>
            1 Credit = R10 (excl vat)
            <br /><br />
            <strong>Cost of Checks:</strong>
            <table>
                <tr>
                    <td style="padding:4px"><a href="services/id-check">ID Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('id'); ?><?php */?></td>
                </tr>
                <tr>
                    <td style="padding:4px"><a href="services/credit-check">Credit Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('credit'); ?><?php */?></td>
                </tr>
                <tr>
                    <td style="padding:4px"><a href="services/criminal-check">Criminal Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('criminal'); ?><?php */?></td>
                </tr>
                <tr>
                    <td style="padding:4px"><a href="services/drivers-license-check">Drivers License Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('drivers'); ?><?php */?></td>
                </tr>
                <tr>
                    <td style="padding:4px"><a href="services/matric-verification">Matric Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('matric'); ?><?php */?></td>
                </tr>
                <tr>
                    <td style="padding:4px"><a href="services/tertiary-verification">Tertiary Eduction Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('tertiary'); ?><?php */?></td>
                </tr>
                <tr>
                    <td style="padding:4px"><a href="services/association-check">Association Check</a></td>
                    <td style="padding:4px"><?php /*?><?php echo $credits->credits_with_text ('association'); ?><?php */?></td>
                </tr>
            </table>
          </div>-->



  </div>
  </div>

  <div class="space"></div>


  <a href="#0" class="cd-top">Top</a>
