
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Check Someone
   
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    <div id="collectdata">
    <div class="container">

    	<div class="row space">
            <div class="col-md-7">
                       
            <form class="form-horizontal" role="form" method="POST" onsubmit="return run_check1()" action="run-check">
             
             <div class="page-header green-heading">
                <strong>Step 1</strong> - Select check(s)
             </div>
             
             <div class="space"></div>
              
              <?php
			  
			  $consent = $GLOBALS ['user']->get_mandatory_consent ();
			  if ($consent == 0)
			  {
				  echo "<script type=\"text/javascript\"> var consent_option = -1; </script>";
			  }
			  else
			  {
				  echo "<script type=\"text/javascript\"> var consent_option = 1; </script>";
			  }
			  
			  /*1 = ID
			2 = Credit
			3 = Drivers
			4 = Matric
			5 = Tertiary
			6 = Association
			7 = Bank
			8 = Deeds*/
			  $credits = new Credits ();
			  ?>
              <table>
              <tr>
              <td valign="baseline" class="checkbox">
                  <label>
                  	<input type="checkbox" id="IDCheck" checked="checked" name="check1" value="1" onclick="add_credits (<?php echo $credits->idcheck; ?>, 'IDCheck')"> ID Check
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('id') ?> - mandatory for all checks)</td>
              </tr>
              <tr>
              
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="CreditCheck" value="1" name="check2" onclick="add_credits (<?php echo $credits->creditcheck; ?>, 'CreditCheck')"> Credit Check
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('credit') ?>)</td>
              </tr>
              <tr>
              
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="PaymentCheck" value="1" name="check0" onclick="add_credits (<?php echo $credits->paymentcheck; ?>, 'PaymentCheck')"> Credit Check with Payment Profile
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('payment') ?>)</td>
              </tr>
              <tr>
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="DriversCheck" value="1" name="check3" onclick="add_credits (<?php echo $credits->driverscheck; ?>, 'DriversCheck')"> Drivers License Check 
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('drivers') ?>)*</td>
              </tr>
              <tr>
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="MatricCheck" value="1" name="check4" onclick="add_credits (<?php echo $credits->matriccheck; ?>, 'MatricCheck')"> Matric Verification 
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('matric') ?>)*</td>
              </tr>
              <tr>
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="TertiaryCheck" value="1" name="check5" onclick="add_credits (<?php echo $credits->tertiarycheck; ?>, 'TertiaryCheck')"> Tertiary Verification 
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('tertiary') ?>)*</td>
              </tr>
              <tr>
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="AssociationCheck" value="1" name="check6" onclick="add_credits (<?php echo $credits->associationcheck; ?>, 'AssociationCheck')"> Association Check 
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('association') ?>)*</td>
              </tr>
              <tr>
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="BankCheck" value="1" name="check7" onclick="add_credits (<?php echo $credits->bankcheck; ?>, 'BankCheck')"> Bank Account Verification 
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('bank') ?>) <span style="font-weight:bold; color:#43a447;">NEW</span></td>
              </tr>
               <tr>
              <td class="checkbox">
                  <label>
                  	<input type="checkbox" id="DeedsCheck" value="1" name="check8" onclick="add_credits (<?php echo $credits->deedscheck; ?>, 'DeedsCheck')"> Deeds Verification 
                  </label>
              </td>
              <td valign="baseline">&nbsp;&nbsp;&nbsp;(<?php echo $credits->credits_with_text ('deeds') ?>) <span style="font-weight:bold; color:#43a447;">NEW</span></td>
              </tr>
              </table>
              <div class="checkbox"><a href="criminal-check-details" target="_blank">Looking for a criminal check? Click here for info</a></div>
              <div>* Checks marked with an asterisk may take up to 48 hours to return results</div>
              <div>(all other checks return results in under 30 seconds)</div>
              <div class="space"></div>
              
              <div class="page-header green-heading">
                <strong>Step 2</strong> - enter individual's information
             </div>
             
             <div class="space"></div>
              
              <div class="form-group">
                <label for="inputFirstName" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name="firstName">
                </div>
              </div>
              
              <!--<div class="form-group">
                <label for="inputFirstName" class="col-sm-2 control-label">Middle Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputFirstName" placeholder="Middle Name" name="middleName">
                </div>
              </div>-->
              <input type="hidden" class="form-control" id="inputFirstName" name="middleName" value="">
              <div class="form-group">
                <label for="inputSurname" class="col-sm-2 control-label">Surname</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputSurname" placeholder="Surname" name="surname">
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputEmail" placeholder="Email" name="emailAddress">
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputID" class="col-sm-2 control-label">ID Number</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control replace-bad-input" id="inputID" placeholder="ID Number" name="idNumber">
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputCell" class="col-sm-2 control-label">Cellphone Number</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control replace-bad-input" id="inputCell" placeholder="Cellphone Number" name="tel">
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputCell" class="col-sm-2 control-label">Marital Status</label>
                <div class="col-sm-10">
                  <select class="form-control" id="maritalStatus" style="width:400px" name="maritalStatus">
                  	<option value="SINGLE">Single</option>
                    <option value="MARRIED">Married</option>
                    <option value="DIVORCED_WIDOWED">Divorced</option>
                    <option value="DIVORCED_WIDOWED">Widowed</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
        	<label for="inputFirstName" class="col-sm-2 control-label">Physical Address</label>
            <div class="col-sm-10" style="margin-bottom:10px">
            	<select class="form-control" id="propertyType" style="width:400px" name="propertyType">
                	<option value="OWNED">Property is owned by Individual</option>
                    <option value="NOT_OWNED">Property is Not owned by Individual</option>
                </select>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
            	<input type="text" class="form-control" id="buildingName" name="buildingName" placeholder="Building / Complex Name" style="width:400px">
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
                <input type="text" class="form-control" id="buildingNumber" name="buildingNumber" placeholder="Building / Complex Number" maxlength="10" style="width:400px">
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
                <input type="text" class="form-control" id="streetName" name="streetName" placeholder="Street Name" style="width:400px">
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
                <input type="text" class="form-control" id="suburb" name="suburb" placeholder="Suburb" style="width:400px">
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
                <input type="text" class="form-control" id="city" name="city" placeholder="City" style="width:400px">
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
                <select class="form-control" id="stateProvince" name="province" style="width:400px">
                	<option value="Gauteng">Gauteng</option>
                    <option value="Western Cape">Western Cape</option>
                    <option value="Eastern Cape">Eastern Cape</option>
                    <option value="Northern Cape">Northern Cape</option>
                    <option value="Mpumalanga">Mpumalanga</option>
                    <option value="Kwazulu Natal">Kwazulu Natal</option>
                    <option value="North West">North West</option>
                    <option value="Limpopo">Limpopo</option>
                    <option value="Free State">Free State</option>
                </select>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom:10px">
                <input type="text" class="form-control replace-bad-input" id="postalCode" name="postalCode" placeholder="Postal Code" style="width:400px">
            </div>

        </div>
        
        
        	<div class="space"></div>
              <div style="display:none;" id="matric_step">
              <div class="page-header green-heading">
                Enter matric information
             </div>
             
             <div class="space"></div>
              
              <div class="form-group">
                <label for="inputSchool" class="col-sm-2 control-label">School</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputSchool" onkeyup="PreventDigitInput('inputSchool')" name="matric_school" placeholder="School">
                </div>
              </div>  
              <div class="form-group">
                <label for="inputSchoolYear" class="col-sm-2 control-label">Year</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control replace-bad-input" id="inputSchoolYear" name="matric_year" placeholder="Year">
                </div>
              </div>  
              </div>  
              <div style="display:none;" id="tertiary_step">
              <div class="space"></div>
              <div class="page-header green-heading">
                Enter tertiary education information
             </div>
             
             <div class="space"></div>
              
              <div class="form-group">
                <label for="inputInstitute" class="col-sm-2 control-label">Tertiary Institute</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputInstitute" name="tertiary_institute" placeholder="Tertiary Institute">
                </div>
              </div>  
              <div class="form-group">
                <label for="inputTertiaryYear" class="col-sm-2 control-label">Year</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control replace-bad-input" id="inputTertiaryYear" name="tertiary_year" placeholder="Year">
                </div>
              </div>    
              <div class="form-group">
                <label for="inputTertiaryQualification" class="col-sm-2 control-label">Qualification</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputTertiaryQualification" name="tertiary_qualification" placeholder="Qualification">
                </div>
              </div> 
              </div>
              <div style="display:none;" id="drivers_step">
              <div class="space"></div>
              <div class="page-header green-heading">
                Enter drivers license information
             </div>
             
             <div class="space"></div>
              
              <div class="form-group">
                <label for="inputDrivers" class="col-sm-2 control-label">Drivers License Number</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputDrivers" name="drivers_code" placeholder="Drivers License Number">
                </div>
              </div> 
              </div>
              <div style="display:none;" id="association_step">
              <div class="space"></div>
              <div class="page-header green-heading">
                Enter association information
             </div>
             
             <div class="space"></div>
              
              <div class="form-group">
                <label for="inputAssociation" class="col-sm-2 control-label">Association</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputAssociation" name="association" placeholder="Association">
                </div>
              </div> 
              </div>
              <div style="display:none;" id="bank_step">
              <div class="space"></div>
              <div class="page-header green-heading">
                Enter bank account information
             </div>
			<div class="space"></div>
              
              <div class="form-group">
                <label for="accountNumber1" class="col-sm-2 control-label">Bank Account</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="accountNumber1" name="accountNumber1" placeholder="Account Number">
                </div>
              </div>
              <div class="form-group">
                <label for="branchCode1" class="col-sm-2 control-label">Branch Code</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="branchCode1" name="branchCode1" placeholder="Branch Code">
                </div>
              </div>
              <div class="form-group">
                <label for="accountType1" class="col-sm-2 control-label">Account Type</label>
                <div class="col-sm-10">
                  <select name="accountType1"  class="form-control">
                  	<option value="Current">Current Account</option>
                    <option value="Savings">Savings Account</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="enquiryReason" class="col-sm-2 control-label">Reason</label>
                <div class="col-sm-10">
                  <select name="enquiryReason" class="form-control">
                  	<option value="">Reason for Enquiry</option>
                    <option value="EMPLOYMENT_CHECK">Employment Check</option>
                    <option value="CREDIT_APPLICATION">Credit Application</option>
                    <option value="INSURANCE_APPLICATION">Insurance Application</option>
                    <option value="INSURANCE_CLAIM">Insurance Claim</option>
                    <option value="AFFORDABILITY_ASSESSMENT">Affordability Assessment</option>
                    <option value="DEBT_COUNSELING">Debt Counseling</option>
                    <option value="SUPPLIER">Supplier Verification</option>
                    <option value="REFERANCE_CHECK">Reference Check</option>
                    <option value="LEASE">Lease</option>
                    <option value="SURETY">Surety</option>
                    <option value="OTHER">Other</option>
                  </select>
                </div>
              </div> 
              <div class="space"></div>
              </div> 
              
              <div style="display:none;" id="deeds_step">
              <div class="space"></div>
              <div class="page-header green-heading">
                Enter Deeds Registry Information
             </div>
			<div class="space"></div>
            
              <div class="form-group">
                <label for="enquiryReason" class="col-sm-2 control-label">Reason for Deeds Check</label>
                <div class="col-sm-10">
                  <select name="deedsEnquiryReason" id="deedsEnquiryReason" class="form-control">
                  	<option value="">Reason for Enquiry</option>
                    <option value="EMPLOYMENT_CHECK">Employment Check</option>
                    <option value="CREDIT_APPLICATION">Credit Application</option>
                    <option value="INSURANCE_APPLICATION">Insurance Application</option>
                    <option value="INSURANCE_CLAIM">Insurance Claim</option>
                    <option value="AFFORDABILITY_ASSESSMENT">Affordability Assessment</option>
                    <option value="DEBT_COUNSELING">Debt Counseling</option>
                    <option value="SUPPLIER">Supplier Verification</option>
                    <option value="REFERANCE_CHECK">Reference Check</option>
                    <option value="LEASE">Lease</option>
                    <option value="SURETY">Surety</option>
                    <option value="OTHER">Other</option>
                  </select>
                </div>
              </div> 
              <div class="space"></div>
              </div> 
              
			  <div class="form-group">
                <label for="inputReason" class="col-sm-2 control-label">Consent for Check (<a href="http://www.fraudcheck.co.za/for-you#getownscore" target="_blank">more info</a>)</label>
                <div class="col-sm-10">
                  <input type="radio" id="consentNotRequired" name="consent" value="0" onclick="activate_box (0)"> I have already obtained consent from this individual to run a check<br />
                  <input type="radio" id="consentRequired" name="consent" value="1" onclick="activate_box (1)"> I have not obtained consent and would like FraudCheck to request consent by SMS
                </div>
              </div> 
              
              <div class="form-group" id="no-consent-box" style="display:none;">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                  <input type="checkbox" id="consentTick" name="consentTick" value="0"> <strong>NB: I acknowledge that it is a legal requirement to obtain consent from an individual before running any checks on them and certify that he/she is aware of these checks and have given the relevant consent.</strong>
                </div>
              </div> 
              
              <div class="form-group" id="consent-box" style="display:none;">
                <label for="inputReason" class="col-sm-2 control-label">Reason for Check</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputReason" name="checkReason" placeholder="Reason for Check" maxlength="40">
                </div>
              </div> 

              <div class="space"></div>
              <div class="form-group">
              	<div class="col-sm-2"></div>
              	<div class="col-sm-10">
                <?php
				if (strcmp ($GLOBALS ['user']->status, "ACTIVE") == 0)
				{
	                echo "<a href=\"#\"><button class=\"btn-primary btn-lg\">Run Check</button></a>";
				}
				else
				{
					echo "<a href=\"javascript:please_confirm()\" class=\"btn-primary btn-lg\">Run Check</a>";
				}
				?>
                </div>
              </div>
              <input type="hidden" id="numcredits2" name="creditCost" value="1" />
            </form>

          </div>
          <div class="col-md-1"></div>
          <div class="col-md-3">
          	<div class="page-header green-heading">
				<strong>Total Cost of Check:</strong>
			</div>
            <br>
          	<h2 class="text-center"><strong id="numcredits">1</strong> credit(s)</h2>
            <div>
            <p style="text-align:justify; margin-top:20px;"><strong>Why is an ID check mandatory?</strong><br />
            In order to run any checks on an individual, we must first ensure that they are who they claim to be. For this reason, all checks must be coupled with an ID check</p>
            </div>
            <div>
            <p style="text-align:justify; margin-top:20px;"><strong>Looking for a criminal check?</strong><br />
            Before you can run a criminal check against an individual, you need to capture their fingerprints. Please <a href="criminal-check-details" target="_blank">click here</a> for details.</p>
            </div>
          </div>
          
        </div>
    </div>
    </div>
    <div id="runchecks" style="display:none;">
	<div align="center" class="container">
    <div class="space"></div>
    <div class="page-header green-heading">
                Please wait while we process your checks.
             </div>
             <div class="space"></div>
    	<img src="images/runcheck.gif" /><br /><br />
		
    </div>

	<div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
	<div class="space"></div>
    </div>
    
   <a href="#0" class="cd-top">Top</a>

