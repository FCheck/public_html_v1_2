<!DOCTYPE html>
<html lang="en" ng-app="app" ng-controller="OuterCtrl"><head>
  <script type="text/javascript">
     document.write ('<base href="'+window.location.protocol+'//www.fraudchecksupport.co.za" />');

  </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="CsKVL6s2amMyXXe-88yx7ASTc4KsN5cn4kspSCiRDXs" />
	<title>Identity verification service | Fingerprinting background check - Fraud Check</title>
    <meta name="description" content=" We are experts in id verification, education verification and other fingerprint services. We also offer a comprehensive credit check and prepare reports at affordable rates.">
    <!-- Google Analytics -->
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60306733-1', 'auto');
  ga('send', 'pageview');

</script>
	<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/global.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link href='css/font.css' rel='stylesheet' type='text/css'>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.mask.js"></script>
        <script src="js/validate.js"></script>
        <script src="js/numeral.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/bootbox.min.js"></script>
    <!--<script src="js/app.js"></script>-->
    <!--<script src="js/pro.js"></script>-->
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/filter.js"></script> <!-- Resource jQuery -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!--<script src="js/main.js"></script>--> <!-- Gem jQuery -->
    <!-- Stats counter animation -->
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/bxslider/jquery.bxslider.min.js"></script>
    <link href="js/bxslider/jquery.bxslider.css" rel="stylesheet" />


    <script src="js/app.js"></script>
    <script src="js/main.js"></script> <!-- Gem jQuery -->


    <!-- Stats counter animation -->
    <script>
	var login = 0;
	var mandatory_drivers = 0;
	var mandatory_matric = 0;
	var mandatory_tertiary = 0;
	var mandatory_association = 0;
	var mandatory_deeds = 0;
	var mandatory_payment = 0;
     var mandatory_bank = 0;
	function togglelogin ()
	{
		if (login == 0)
		{
			$("html, body").animate({ scrollTop: 0 }, "fast");
			$('#loginbox').html ('<h1>Login</h1><form method="post" action="processlogin.php"><div><input type="text" name="email" class="form-control" placeholder="Email Address" /></div><div><input type="password" name="password" class="form-control" placeholder="Password" /></div><div><input type="submit" class="btn btn-success" value="Login" /></div><div><a href="reset-password">Forgot Password</a><br><a href="register">Register</a></div></form>');
			$('#loginbox').fadeIn (0);
			login = 1;

		}
		else
		{
			$('#loginbox').fadeOut (0);
			$('#loginbox').html ('');
			login = 0;
		}
	}

    jQuery(document).ready(function( $ ) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

		var loginshow = 0;
		var regshow = 0;
		var profilepage = 0;
		$(document).ready (function ()
		{
			$('#userPhones').focus ( function ()
			{
				$('#userPhones').mask ("9999999999");
			});
			$('#tel-otp').focus ( function ()
			{
				$('#tel-otp').mask ("9999999999");
			});
			$(".replace-bad-input").on('keyup',PreventNonDigitInput);
			$(".replace-bad-input-letters").on('keyup',PreventDigitInput);
			$(document).on('click', ".remove" , function()
			{
				$(this).parent().remove ();
			});//remove agents from list
			$("body").click(function() {
    			$("#loginbox").hide();
				$('#loginbox').html ('');
				$(".registerpanel").hide();
				loginshow = 0;
				regshow = 0;
			});

			$("#loginbox").click(function(e) {
    			e.stopPropagation();
				loginshow = 1;
			});
			$("#openlogin").click(function(e) {
    			e.stopPropagation();
				loginshow = 1;
			});
			$(".registerpanel").click(function(e) {
    			e.stopPropagation();
				regshow = 1;
			});
			/*$(document).on('keyup', function(e) {
    			if (e.which == 13 && loginshow == 1)
        			login();
				if (e.which == 13 && regshow == 1)
        			register();
			});*/
		});
		$(document).click (function ()
		{
			var proceed = 1;

			if (login == 1 && proceed == 1)
			{
				$('#loginbox').fadeOut (0);
				$('#loginbox').html ('');
				login = 2;
			}
			else if (login == 2 && proceed == 1)
			{
				login = 0;
			}
		});
    });
	var regType = 0;
	function setRegType (type)
	{
		regType = type;
		if (type == 2)
			$('.businessdata').fadeIn (0);
		else
			$('.businessdata').fadeOut (0);
	}

	function step2 ()
	{
		$('#step1').fadeOut (0);
		$('#step2').fadeIn (0);
		return false;
	}
	function step1 ()
	{
		$('#step2').fadeOut (0);
		$('#step1').fadeIn (0);
		return false;
	}
	var credits = 1;

	function add_credits (num, id)
	{
		if (id == "IDCheck")
		{
			$('#'+id).prop ("checked", true);
		}
		else
		{
			if ($('#'+id).is (":checked"))
			{
				credits += num;
				switch (id)
				{
					case "DriversCheck":
						$('#drivers_step').fadeIn (0);
						mandatory_drivers = 1;
					break;

					case "MatricCheck":
						$('#matric_step').fadeIn (0);
						mandatory_matric = 1;
					break;

					case "TertiaryCheck":
						$('#tertiary_step').fadeIn (0);
						mandatory_tertiary = 1;
					break;

					case "AssociationCheck":
						$('#association_step').fadeIn (0);
						mandatory_association = 1;
					break;

					case "BankCheck":
						$('#bank_step').fadeIn (0);
						mandatory_bank = 1;
					break;

					case "DeedsCheck":
						$('#deeds_step').fadeIn (0);
						mandatory_deeds = 1;
					break;

					case "CreditCheck":
						if ($('#PaymentCheck').is (":checked"))
						{
							$('#PaymentCheck').prop ("checked", false);
							credits -= 6;
							mandatory_payment = 0;
						}
					break;

					case "PaymentCheck":
						if ($('#CreditCheck').is (":checked"))
						{
							$('#CreditCheck').prop ("checked", false);
							credits -= 3;
						}
						//bootbox.alert ("<div align='center'><h2 class='green-heading'>NB: You may only run this check on yourself</h2><br>If you are NCR registered, please email support@fraudcheck.co.za to have this facility activated for all checks.</div>");
						mandatory_payment = 1;
					break;
				}
			}
			else
			{
				credits -= num;
				switch (id)
				{
					case "DriversCheck":
						$('#drivers_step').fadeOut (0);
						mandatory_drivers = 0;
					break;

					case "MatricCheck":
						$('#matric_step').fadeOut (0);
						mandatory_matric = 0;
					break;

					case "TertiaryCheck":
						$('#tertiary_step').fadeOut (0);
						mandatory_tertiary = 0;
					break;

					case "AssociationCheck":
						$('#association_step').fadeOut (0);
						mandatory_association = 0;
					break;

					case "BankCheck":
						$('#bank_step').fadeOut (0);
						mandatory_bank = 0;
					break;

					case "DeedsCheck":
						$('#deeds_step').fadeOut (0);
						mandatory_deeds = 0;
					break;

					case "PaymentCheck":
						mandatory_payment = 0;
					break;
				}
			}
			$('#numcredits').html (credits);
			$('#numcredits2').val (credits);

			/*if (mandatory_payment == 1)
			{
							}
			else
			{
				$('#inputFirstName').prop ('readonly','');
				$('#inputSurname').prop ('readonly','');
				$('#inputEmail').prop ('readonly','');
				$('#inputID').prop ('readonly','');
				$('#consentNotRequired').prop("checked",false);
				$('#consentTick').prop("checked",false);
			}*/
		}
	}
	function run_check1 ()
	{
		$('.btn-primary').attr('disabled', "true");
		if (verify_id_number ($("#inputID").val ()))
		{
			if (consent_option == 1)
				retn =  run_check_consent ();
			else
				retn = run_check_no_consent ();

			if (!retn)
			{
				$('.btn-primary').prop('disabled', false);
			}
			return retn;
		}
		else
		{
			bootbox.alert ("Invalid ID Number entered. Please try again.");
			$('.btn-primary').prop('disabled', false);
			return false;
		}
	}

	function activate_box (id)
	{
		if (id == 0)
		{
			$('#no-consent-box').fadeIn (0);
			$('#consent-box').fadeOut (0);
			consent_option = 0;
		}
		else
		{
			$('#no-consent-box').fadeOut (0);
			$('#consent-box').fadeIn (0);
			consent_option = 1;
		}
	}

	function process_credits (credits)
	{
		//allocate credits and reduce referral credit balance
		//this should be fun...
	}

	function run_check_consent ()
	{
		var t1 = parseInt($('#num_credits2').val ());
		var t2 = parseInt($('#numcredits').text ());
		if (t1 >= t2)
		{
			//credit check success. Now check validation
			if ($('#inputFirstName').val () != "" && $('#inputSurname').val () != "" && $('#inputID').val () != "")
			{
				if ($('#inputID').val ().length == 13)
				{
					if ($('#inputCell').val ().length >= 10 && $('#inputCell').val ().length <= 12)
					{
						if ($('#inputReason').val () != "")
						{
							if (check_vas_fields ())
							{
								$('#collectdata').fadeOut (0);
								$('#runchecks').fadeIn (0);
								$('.btn-primary').prop('disabled', true);
								return true;
							}
							else
								return false;
						}
						else
						{
							bootbox.alert ("Please enter a reason for running the check - the candidate will be sent this reason when asked to confirm permission.");
							return false;
						}
					}
					else
					{
						bootbox.alert ("Please check Mobile Number and re-submit");
						return false;
					}
				}
				else
				{
					bootbox.alert ("Please check the ID Number and re-submit");
					return false;
				}
			}
			else
			{
				bootbox.alert ("Please ensure you have entered the full name of the candidate before proceeding.");
				return false;
			}
		}
		else
		{
			//no credits
			bootbox.alert ("Unfortuantely you do not have enough credits to continue. Please top up your account and try again.");
			return false;
		}
	}
	function run_check_no_consent ()
	{
		var t1 = parseInt($('#num_credits2').val ());
		var t2 = parseInt($('#numcredits').text ());
		if (t1 >= t2)
		{
			//credit check success. Now check validation
			if ($('#inputFirstName').val () != "" && $('#inputSurname').val () != "" && $('#inputID').val () != "")
			{
				if ($('#inputID').val ().length == 13)
				{
					if ($('#consentTick').is(':checked') || consent_option == -1)
					{
						if (check_vas_fields ())
						{
							$('#collectdata').fadeOut (0);
							$('#runchecks').fadeIn (0);
							$('.btn-primary').prop('disabled', true);
							return true;
						}
						else
							return false;
					}
					else
					{
						bootbox.alert ("Please tick the disclaimer that you have the relevant consent to run this check.");
						return false;
					}
				}
				else
				{
					bootbox.alert ("Please check the ID Number and re-submit");
					return false;
				}
			}
			else
			{
				bootbox.alert ("Please ensure you have entered the full name of the candidate before proceeding.");
				return false;
			}
		}
		else
		{
			//no credits
			bootbox.alert ("Unfortuantely you do not have enough credits to continue. Please top up your account and try again.");
			return false;
		}
	}

	function check_vas_fields ()
	{
		var returnval = 0;
		if (mandatory_drivers == 1)
		{
			if ($('#inputDrivers').val () == "")
			{
				bootbox.alert ("Please enter drivers license information to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
		if (mandatory_matric == 1)
		{
			if ($('#inputSchool').val () == "" || $('#inputSchoolYear').val () == "")
			{
				bootbox.alert ("Please enter Matric information to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
		if (mandatory_tertiary == 1)
		{
			if ($('#inputInstitute').val () == "" || $('#inputTertiaryYear').val () == "" || $('#inputTertiaryQualification').val () == "")
			{
				bootbox.alert ("Please enter tertiary education information to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
		if (mandatory_association == 1)
		{
			if ($('#inputAssociation').val () == "")
			{
				bootbox.alert ("Please enter association information to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
		if (mandatory_bank == 1)
		{
			if ($('#accountNumber1').val () == "")
			{
				bootbox.alert ("Please enter the bank account number to continue");
				return false;
			}
			else if ($('#branchCode1').val () == "")
			{
				bootbox.alert ("Please enter the branch code number to continue");
				return false;
			}
			else if ($('#enquiryReason').val () == "")
			{
				bootbox.alert ("Please provide a reason for the bank account verification to continue");
				return false;
			}
			else if ($('#streetName').val () == "" || $('#suburb').val () == "" || $('#city').val () == "")
			{
				bootbox.alert ("Please provide the candidate's phyical address to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
		if (mandatory_deeds == 1)
		{
			if ($('#deedsEnquiryReason').val () == "")
			{
				bootbox.alert ("Please provide a reason for the deeds check to continue");
				return false;
			}
			else if ($('#streetName').val () == "" || $('#suburb').val () == "" || $('#city').val () == "")
			{
				bootbox.alert ("Please provide the candidate's phyical address to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
          if (mandatory_payment == 1)
		{
			if ($('#streetName').val () == "" || $('#suburb').val () == "" || $('#city').val () == "")
			{
				bootbox.alert ("Please provide the candidate's phyical address to continue");
				return false;
			}
			else
			{
				returnval++;
			}
		}
		return true;
	}

	function run_check ()
	{
		$('#collectdata').fadeOut (0);
		$('#runchecks').fadeIn (0);

	}
	function reg_run_check ()
	{
		if (verify_id_number ($("#idNumber").val ()))
		{
			if ($('#firstName').val() != "" && $('#surname').val() != "" && $('#idNumber').val() != "" && $('#emailAddress').val() != "" && $('#userPhones').val() != "")
			{
				$('#collectdata').fadeOut (0);
				$('#runchecks').fadeIn (0);
				return true;
			}
			else
			{
				bootbox.alert ("Please enter all fields and try again");
				return false;
			}
		}
		else
		{
			bootbox.alert ("Invalid ID Number. Please try again.");
			return false;
		}
	}
	function check_pass ()
	{
		if ($('#password').val () == $('#passwordconf').val())
		{
			if ($('#password').val () != "")
			{
				if ($('#password').val ().length >= 4)
				{
					if (regType == 1)
						return true;
					else if (regType == 0)
					{
						bootbox.alert ("Please select your account type by clicking on Business or Individual");
					}
					else
					{
						//confirm company fields
						if ($('#companyName').val ().length > 0)
						{
							return true;
						}
						else
						{
							bootbox.alert ("Please enter a company name and try again.");
							return false;
						}
					}
				}
				else
				{
					bootbox.alert ("Please select a password longer than 4 characters.");
					return false;
				}
			}
			else
			{
				bootbox.alert ("Please choose a password for your account.");
				return false;
			}
		}
		else
		{
			bootbox.alert ("Please check that passwords match.");
			return false;
		}
	}



	function open_category (cat)
	{
		//if (cat == 0)
		//	$('.assessment-category').slideToggle ("fast");
		//else
		//	$('#category'+cat).slideToggle ("fast");
		$('.assessment-category').fadeOut (0);
		$('#assessment_overview').fadeOut ("normal",function () {$('#category'+cat).fadeIn ("normal")});
	}

	function update_purchase_credits ()
	{
		var credits = $('#select_credits').val ();
		var creditcost = credits * 10;
		var vat = creditcost * 14/100;
		var total = creditcost + vat;
		error_log("Credits being purchased: " . credits);
		error_log("Credits being purchased cost: " . creditcost);
		error_log("Credits being purchased VAT: " . vat);
		error_log("Credits being purchased total cost: " . total);
		$('.numcredits').text (credits);
		$('#creditcost').text (creditcost);
		$('#vat').text (vat);
		$('#totalcost').text (total);
	}

	function submit_transaction ()
	{

		var credits = $('#numcredits').val ();
		var cost = $('#select_credits').val ();
		$('#transaction_amount').val (cost);
		$('#proceed_btn_area').html ("<input type=\"button\" value=\"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\" class=\"btn-primary btn-lg\" style=\"background-image: url('images/loader.gif'); background-size:30%; background-repeat:no-repeat; background-position:bottom center; width:300px;\">");
		$('#proceed_btn_area_2').html ("");
		$.ajax
		({
			type: "POST",
			url: "ajax/set-transaction.php",
			data: "credits="+credits
		})
		.done(function(response)
		{
			var data = response.split ('##');
			$('#transaction_ref').val (data[0]);
			$('#transaction_hash').val (data[1]);
			document.creditsform.submit();
		});
	}

	function submit_sid_transaction ()
	{
		var credits = $('#numcredits').val ();
		var cost = $('#select_credits').val ();
		$('#sid_amount').val (cost+".00");
		$('#proceed_btn_area').html ("<input type=\"button\" value=\"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\" class=\"btn-primary btn-lg\" style=\"background-image: url('images/loader.gif'); background-size:30%; background-repeat:no-repeat; background-position:bottom center; width:300px;\">");
		$('#proceed_btn_area_2').html ("");
		$.ajax
		({
			type: "POST",
			url: "ajax/set-sid-transaction.php",
			data: "credits="+credits+"&cost="+cost
		})
		.done(function(response)
		{
			var data = response.split ('##');
			$('#sid_reference').val (data[0]);
			$('#sid_consistent').val (data[1]);
			document.creditsform_sid.submit();
		});
	}

	function validateEmail(email) {
	  var regex = /(?!^[.+&'_-]*@.*$)(^[_\w\d+&'-]+(\.[_\w\d+&'-]*)*@[\w\d-]+(\.[\w\d-]+)*\.(([\d]{1,3})|([\w]{2,}))$)/;
	  return regex.test(email);
	}

	function validateCell(cell) {
	  var regex = /^(\d{10})$/;
	  return regex.test(cell);
	}

	function verify_id_number (id)
	{
		var i, c,
			even = '',
			sum = 0,
			check = id.slice(-1);

		if (id.length != 13 || id.match(/\D/)) {
			return false;
		}
		id = id.substr(0, id.length - 1);
		for (i = 0; c = id.charAt(i); i += 2) {
			sum += +c;
			even += id.charAt(i + 1);
		}
		even = '' + even * 2;
		for (i = 0; c = even.charAt(i); i++) {
			sum += +c;
		}
		sum = 10 - ('' + sum).charAt(1);
		return ('' + sum).slice(-1) == check;
	}
	var cellNumber = "";
	var cellVerify = "";

	function change_step (num)
	{
		if(validateEmail($('#emailAddress').val()))
		{
			if (validateCell($('#userPhones').val()))
			{
				if (verify_id_number ($("#idNumber").val ()))
				{
					if ($('#firstName').val() != "" && $('#surname').val() != "")
					{
						if (check_pass ())
						{
							$('#collectdata').fadeTo("fast",0.1);
							$('#runchecks').fadeIn("fast");
							//send OTP
							$.ajax
							({
								type: "POST",
								url: "ajax/send-otp.php",
								data: "cellNo="+$('#userPhones').val()
							})
							.done(function(response)
							{
								$('#collectdata').fadeTo("fast",1);
								$('#runchecks').fadeOut("fast");
								data = JSON.parse(response);
								var temp = $('#userPhones').val();
								if (data.responseCode == 1)
								{
									//send OTP
									cellNumber = temp;
									$('#step1').fadeOut (0);
									$('#step2').fadeIn (0);
									$('.textstep1').removeClass ('activetext');
									$('.textstep1').addClass ('inactivetext');
									$('.textstep2').removeClass ('inactivetext');
									$('.textstep2').addClass ('activetext');
									$('#point1').attr ("src","images/bullet-1-inactive.png");
									$('#point2').attr ("src","images/bullet-2.png");
									$(".steptext").html ("We're now sending an SMS to your cellphone with a One Time Pin");
									$('#tel-otp').val ($('#userPhones').val());
								}
								else if (data.responseCode == 0)
								{
									cellNumber = temp;
									cellVerify = cellNumber;
									verify_otp ();
								}
								else
								{
									bootbox.alert (data.message);
								}
							});

						}
					}
					else
					{
						bootbox.alert ("Please enter your first and last names and try again");
					}
				}
				else
				{
					bootbox.alert ("ID Number invalid. Please ensure you type a valid ID Number and try again.");
				}
			}
			else
			{
				bootbox.alert("Cellphone number invalid. Please ensure you type a valid cellphone number and try again.");
			}
		}
		else
		{
			bootbox.alert ("Email address invalid. Please ensure you type a valid email address and try again.");
		}
	}

	function resend_otp ()
	{
		$('#collectdata').fadeTo("fast",0.1);
		$('#runchecks').fadeIn("fast");

		$.ajax
		({
			type: "POST",
			url: "ajax/send-otp.php",
			data: "cellNo="+$('#tel-otp').val()
		})
		.done(function(response)
		{
			$('#collectdata').fadeTo("fast",1);
			$('#runchecks').fadeOut("fast");
			data = JSON.parse(response);
			var temp = $('#tel-otp').val();
			if (data.responseCode == 1)
			{
				$('.resend').fadeOut (0);
				cellNumber = temp;
				bootbox.alert ("A new OTP has been sent");
			}
			else
			{
				bootbox.alert (data.message);
			}
		});
	}

	function resend_confmail ()
	{

		$('#warntxt').html ("Sending Email...");
		$.ajax
		({
			type: "POST",
			url: "ajax/send-confmail.php"
		})
		.done(function(response)
		{
			data = JSON.parse(response);
			$('#warntxt').html (data.message);
		});
	}

	function update_email ()
	{

		bootbox.prompt ("Please enter your new email address and press Ok", function (result) {
			$('#warntxt').html ("Updating email address...");
			$.ajax
			({
				type: "POST",
				url: "ajax/update-email.php",
				data: "newemail="+result
			})
			.done(function(response)
			{
				data = JSON.parse(response);
				$('#warntxt').html (data.message);
			});
		});
	}

	function verify_otp ()
	{
		//verify OTP
		$('#collectdata').fadeTo("fast",0.1);
		$('#runchecks').fadeIn("fast");
		$.ajax
		({
			type: "POST",
			url: "ajax/verify-otp.php",
			data: "cellNo="+cellNumber+"&pin="+$('#OTP').val()+"&vc="+cellVerify+"&firstName="+$('#firstName').val()+"&surname="+$('#surname').val()+"&email="+$('#emailAddress').val()+"&idNumber="+$('#idNumber').val()+"&password="+$('#password').val()+"&acc_type="+$('input[name=acc_type]:checked').val()+"&companyName="+$('#companyName').val()+"&companyPhoneNo="+$('#companyPhoneNo').val()+"&referralCode="+$('#referralCode').val()
		})
		.done(function(response)
		{

			var dataResponse = JSON.parse(response);
			if (dataResponse.responseCode == 1)
			{
				//regisered successfully
				var acctype = $('input[name=acc_type]:checked').val();
				var action = "Individual"
				if (acctype == 2)
					action = "Business";
				ga('send', 'event', 'Registration', action);
				//_trackEvent("Registration", action)
				document.getElementById("regform").submit();
				//document.location.href = 'buy-credits';
			}
			else
			{
				$('#collectdata').fadeTo("fast",1);
				$('#runchecks').fadeOut("fast");
				bootbox.alert (dataResponse.message);
				if (dataResponse.type == 1)
				{
					//otp error

				}
				else
				{
					//register error
					$('#step2').fadeOut (0);
					$('#step1').fadeIn (0);
					$('.textstep2').removeClass ('activetext');
					$('.textstep2').addClass ('inactivetext');
					$('.textstep1').removeClass ('inactivetext');
					$('.textstep1').addClass ('activetext');
					$('#point2').attr ("src","images/bullet-1-inactive.png");
					$('#point1').attr ("src","images/bullet-2.png");
					$(".steptext").html (dataResponse.message);
					cellVerify = cellNumber;
				}
			}
		});
	}

	function open_resend ()
	{
		$('.resend').fadeIn (0);
	}

	function please_confirm ()
	{
		bootbox.alert ("We hate to be a pain, but it's really important that you confirm your email address before you can run your first check. Please click the link in the email we sent to you and try again.");

	}
	var deedsType = 0;
	function setDeedsType (type)
	{
		if (type == 1)
		{
			deedsType = 1;
			$('#individualdeeds').fadeIn (0);
			$('#businessdeeds').fadeOut (0);
			$('.runbtn').fadeIn (0);
		}
		else
		{
			deedsType = 2;
			$('#businessdeeds').fadeIn (0);
			$('#individualdeeds').fadeOut (0);
			$('.runbtn').fadeIn (0);
		}
	}

	function run_deeds ()
	{
		if (deedsType == 1)
		{
			//individual
			var forename = $('#firstName').val();
			var surname = $('#surname').val();
			var said = $('#said').val();
			var streetnumber = $('#streetNumber').val();
			var streetname = $('#streetName').val();
			var town = $('#town').val();
			var city = $('#city').val();
			var postalCode = $('#postalCode').val();
			var enquiryReason = $('#enquiryReason').val();
			var request = "forename="+forename+"&surname="+surname+"&said="+said+"&streetnumber="+streetnumber+"&streetname="+streetname+"&town="+town+"&city="+city+"&postalCode="+postalCode+"&enquiryReason="+enquiryReason;
			$('#collectdata').fadeOut (0);
			$('#runchecks').fadeIn (0);
			$.ajax
			({
				type: "POST",
				url: "ajax/run-deeds-individual.php",
				data: request
			})
			.done(function(response)
			{
				data = JSON.parse(response);

				$('.Rforename').html (forename);
				$('.Rsurname').html (surname);
				$('.Rsaid').html (said);
				$('.Raddress').html (streetnumber + " " + streetname + "<br>" + town + "<br>" + city + "<br>" + postalCode);
				$('.RtransactionId').html (data.transactionId);

				if (data.deeds == null)
					displayDeeds = "<p>No Deeds Found</p>";
				else
				{
					var numDeeds = data.deeds.length;
					var displayDeeds = "";

					for (var i = 0; i < numDeeds; i++)
					{
						var deed = "<h3>"+data.deeds[i].streetNumber + " " + data.deeds[i].street + ", " + data.deeds[i].township + "</h3>";
						if (data.deeds[i].date != "" && data.deeds[i].date != null);
							deed += "<table><tr><td><strong>Date Registered:</strong></td><td>"+data.deeds[i].date+"</td></tr>";
						if (data.deeds[i].purchasePrice != "" && data.deeds[i].purchasePrice != null)
							deed += "<tr><td><strong>Purchase Price:</strong></td><td>R"+numeral (data.deeds[i].purchasePrice).format ('0,0')+"</td></tr>";
						if (data.deeds[i].purchaseDate != "" && data.deeds[i].purchaseDate != null)
							deed += "<tr><td><strong>Date Purchased:</strong></td><td>"+data.deeds[i].purchaseDate+"</td></tr>";
						if (data.deeds[i].propertySize != "" && data.deeds[i].propertySize != null)
							deed += "<tr><td><strong>Property Size:</strong></td><td>"+data.deeds[i].propertySize+"</td></tr>";
						if (data.deeds[i].multipleOwners != "" && data.deeds[i].multipleOwners != null)
							deed += "<tr><td><strong>Multiple Owners:</strong></td><td>"+data.deeds[i].multipleOwners+"</td></tr>";
						if (data.deeds[i].share != "" && data.deeds[i].share != null)
							deed += "<tr><td><strong>Share (if multiple owners):</strong></td><td>"+data.deeds[i].share+"</td></tr>";
						if (data.deeds[i].erf != "" && data.deeds[i].erf != null)
							deed += "<tr><td><strong>Erf Number:</strong></td><td>"+data.deeds[i].erf+"</td></tr>";
						if (data.deeds[i].propertyType != "" && data.deeds[i].propertyType != null)
							deed += "<tr><td><strong>Property Type:</strong></td><td>"+data.deeds[i].propertyType+"</td></tr>";
						if (data.deeds[i].farm != "" && data.deeds[i].farm != null)
							deed += "<tr><td><strong>Farm:</strong></td><td>"+data.deeds[i].farm+"</td></tr>";
						if (data.deeds[i].propertyName != "" && data.deeds[i].propertyName != null)
							deed += "<tr><td><strong>Name:</strong></td><td>"+data.deeds[i].propertyName+"</td></tr>";
						if (data.deeds[i].schemeName != "" && data.deeds[i].schemeName != null)
							deed += "<tr><td><strong>Scheme Name:</strong></td><td>"+data.deeds[i].schemeName+"</td></tr>";
						if (data.deeds[i].schemeNumber != "" && data.deeds[i].schemeNumber != null)
							deed += "<tr><td><strong>Scheme Number:</strong></td><td>"+data.deeds[i].schemeNumber+"</td></tr>";
						if (data.deeds[i].portion != "" && data.deeds[i].portion != null)
							deed += "<tr><td><strong>Portion:</strong></td><td>"+data.deeds[i].portion+"</td></tr>";
						if (data.deeds[i].title != "" && data.deeds[i].title != null)
							deed += "<tr><td><strong>Title:</strong></td><td>"+data.deeds[i].title+"</td></tr>";
						if (data.deeds[i].deedsOffice != "" && data.deeds[i].deedsOffice != null)
							deed += "<tr><td><strong>Deeds Office:</strong></td><td>"+data.deeds[i].deedsOffice+"</td></tr>";

						deed += "</table>"

						deed += "<br><h4 style='padding:5px;font-size:1.6em'>Bonds</h4><table>";
						if (data.deeds[i].bond == null)
						{
							deed += "<tr><td>No Bonds</td></tr></table>";
						}
						else
						{
							if (data.deeds[i].bond.actionDate != "" && data.deeds[i].bond.actionDate != null)
								deed += "<tr><td><strong>Action Date:</strong></td><td>"+data.deeds[i].bond.actionDate+"</td></tr>";
							if (data.deeds[i].bond.comment != "" && data.deeds[i].bond.comment != null)
								deed += "<tr><td><strong>Comment:</strong></td><td>"+data.deeds[i].bond.comment+"</td></tr>";
							if (data.deeds[i].bond.bondNumber != "" && data.deeds[i].bond.bondNumber != null)
								deed += "<tr><td><strong>Bond Number:</strong></td><td>"+data.deeds[i].bond.bondNumber+"</td></tr>";
							if (data.deeds[i].bond.bondHolder != "" && data.deeds[i].bond.bondHolder != null)
								deed += "<tr><td><strong>Bond Holder:</strong></td><td>"+data.deeds[i].bond.bondHolder+"</td></tr>";
							if (data.deeds[i].bond.bondAmount != "" && data.deeds[i].bond.bondAmount != null)
								deed += "<tr><td><strong>Bond Amount:</strong></td><td>R"+numeral (data.deeds[i].bond.bondAmount).format ('0,0')+"</td></tr>";
							if (data.deeds[i].bond.bondDate != "" && data.deeds[i].bond.bondDate != null)
								deed += "<tr><td><strong>Bond Date:</strong></td><td>"+data.deeds[i].bond.bondDate+"</td></tr>";
							if (data.deeds[i].bond.bondBuyerName != "" && data.deeds[i].bond.bondBuyerName != null)
								deed += "<tr><td><strong>Buyer Name:</strong></td><td>"+data.deeds[i].bond.bondBuyerName+"</td></tr>";
							deed += "</table>"
						}
						displayDeeds += deed + "<br><br>";
					}
				}
				$('#deedsDisplay').html (displayDeeds);
				$('#runchecks').fadeOut (0);
				$('#displayresult').fadeIn (0);

			});

		}
		else
		{
			//business
			var name = $('#inputEntityName').val();
			var regNo = $('#inputRegNo').val();
			var request = "name="+name+"&regNo="+regNo;
			$('#collectdata').fadeOut (0);
			$('#runchecks').fadeIn (0);
			$.ajax
			({
				type: "POST",
				url: "ajax/run-business-lookup.php",
				data: request
			})
			.done(function(response)
			{
				data = JSON.parse(response);
				$('#runchecks').fadeOut (0);


				//format result
				if (data.results == null)
				{
					displayCompany = "<p>Entity Not Found</p>";
					$('#companyDisplay').html (displayCompany);
					$('#displayoptions').fadeIn (0);
				}
				else if (data.results == 1)
				{
					//process lookup
					run_bus_deeds (data.results[0].itNumber, data.results[0].name, data.results[0].physicalAddress, data.results[0].regNo);
				}
				else
				{
					var numCompanies = data.results.length;
					var displayCompany = "<br><Br>";

					for (var i = 0; i < numCompanies; i++)
					{
						var company = "<h3>"+data.results[i].name+"</h3>";
						company += "<table>";
						if (data.results[i].physicalAddress.length != 0);
							company += "<tr><td><strong>Physical Address:</strong></td><td>"+data.results[i].physicalAddress+"</td></tr>";
						if (data.results[i].town.length != 0);
							company += "<tr><td><strong>Town:</strong></td><td>"+data.results[i].town+"</td></tr>";
						if (data.results[i].regNo.length != 0);
							company += "<tr><td><strong>Registration Number:</strong></td><td>"+data.results[i].regNo+"</td></tr>";
						company += "<tr><td colspan='2'><input type='button' class='btn-primary btn-lg' value='Run Lookup' onclick=\"run_bus_deeds ('"+data.results[i].itNumber+"','"+data.results[i].name+"','"+data.results[i].physicalAddress+"','"+data.results[i].regNo+"')\" /></td></tr>";
						company += "</table><br><br>";
						displayCompany += company;
					}
					$('#companyDisplay').html (displayCompany);
					$('#displayoptions').fadeIn (0);
				}

			});
		}
	}

	function run_bus_deeds (itNumber, name, address, regNo)
	{
		var request = "itNumber="+itNumber+"&enquiryReason="+$('#enquiryBusReason').val();
		$('#collectdata').fadeOut (0);
		$('#displayoptions').fadeOut (0);
		$('#runchecks').fadeIn (0);
		$.ajax
		({
			type: "POST",
			url: "ajax/run-deeds-business.php",
			data: request
		})
		.done(function(response)
		{
			data = JSON.parse(response);

			$('.Rbusname').html (name);
			$('.Raddress').html (address);
			$('.RregNo').html (regNo);
			$('.RtransactionId').html (data.transactionId);

			if (data.deeds.deeds == null)
				displayDeeds = "<p>No Deeds Found</p>";
			else
			{
				deeds = data.deeds.deeds;
				bonds = data.deeds.bonds;
				var numDeeds = deeds.businessDeedsComprehensivePW.length;
				var numBonds = bonds.deedsMultipleBond.length;
				var displayDeeds = "";

				for (var i = 0; i < numDeeds; i++)
				{
					var deed = "<h3>"+deeds.businessDeedsComprehensivePW[i].streetNumber + " " + deeds.businessDeedsComprehensivePW[i].street + ", " + deeds.businessDeedsComprehensivePW[i].township + "</h3>";
					if (deeds.businessDeedsComprehensivePW[i].date.length != 0);
						deed += "<table><tr><td><strong>Date Registered:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].date+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].purchasePrice.length != 0)
						deed += "<tr><td><strong>Purchase Price:</strong></td><td>R"+numeral (deeds.businessDeedsComprehensivePW[i].purchasePrice).format ('0,0')+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].purchaseDate.length != 0)
						deed += "<tr><td><strong>Date Purchased:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].purchaseDate+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].propertySize.length != 0)
						deed += "<tr><td><strong>Property Size:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].propertySize+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].multiple.length != 0)
						deed += "<tr><td><strong>Multiple Owners:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].multiple+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].share.length != 0)
						deed += "<tr><td><strong>Share (if multiple owners):</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].share+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].erf.length != 0)
						deed += "<tr><td><strong>Erf Number:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].erf+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].propertyType.length != 0)
						deed += "<tr><td><strong>Property Type:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].propertyType+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].farm.length != 0)
						deed += "<tr><td><strong>Farm:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].farm+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].buyerName.length != 0)
						deed += "<tr><td><strong>Name:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].buyerName+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].schemeName.length != 0)
						deed += "<tr><td><strong>Scheme Name:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].schemeName+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].schemeNumber.length != 0)
						deed += "<tr><td><strong>Scheme Number:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].schemeNumber+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].portion.length != 0)
						deed += "<tr><td><strong>Portion:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].portion+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].title.length != 0)
						deed += "<tr><td><strong>Title:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].title+"</td></tr>";
					if (deeds.businessDeedsComprehensivePW[i].deedsOffice.length != 0)
						deed += "<tr><td><strong>Deeds Office:</strong></td><td>"+deeds.businessDeedsComprehensivePW[i].deedsOffice+"</td></tr>";

					deed += "</table>"
				}
				for (var i = 0; i < numBonds; i++)
				{
					deed += "<br><h4 style='padding:5px;font-size:1.6em'>Bonds</h4><table>";
					if (bonds.deedsMultipleBond[i].actionDate.length != 0)
						deed += "<tr><td><strong>Action Date:</strong></td><td>"+bonds.deedsMultipleBond[i].actionDate+"</td></tr>";
					if (bonds.deedsMultipleBond[i].comment.length != 0)
						deed += "<tr><td><strong>Comment:</strong></td><td>"+bonds.deedsMultipleBond[i].comment+"</td></tr>";
					if (bonds.deedsMultipleBond[i].bondNumber.length != 0)
						deed += "<tr><td><strong>Bond Number:</strong></td><td>"+bonds.deedsMultipleBond[i].bondNumber+"</td></tr>";
					if (bonds.deedsMultipleBond[i].bondHolder.length != 0)
						deed += "<tr><td><strong>Bond Holder:</strong></td><td>"+bonds.deedsMultipleBond[i].bondHolder+"</td></tr>";
					if (bonds.deedsMultipleBond[i].bondAmount.length != 0)
						deed += "<tr><td><strong>Bond Amount:</strong></td><td>R"+numeral (bonds.deedsMultipleBond[i].bondAmount).format ('0,0')+"</td></tr>";
					if (bonds.deedsMultipleBond[i].bondDate.length != 0)
						deed += "<tr><td><strong>Bond Date:</strong></td><td>"+bonds.deedsMultipleBond[i].bondDate+"</td></tr>";
					if (bonds.deedsMultipleBond[i].bondBuyerName.length != 0)
						deed += "<tr><td><strong>Buyer Name:</strong></td><td>"+bonds.deedsMultipleBond[i].bondBuyerName+"</td></tr>";
					deed += "</table>"
					displayDeeds += deed;
				}
			}
			$('#deedsBusDisplay').html (displayDeeds);
			$('#runchecks').fadeOut (0);
			$('#displaybusresult').fadeIn (0);

		});
	}

     function view_video ()
     {
          bootbox.dialog({
            title: "Fraudcheck Video",
            message: '<iframe width="560" height="315" src="https://www.youtube.com/embed/quZn_MKv2Zg" frameborder="0" allowfullscreen></iframe>'
          });
     }

  </script>

  <script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-34905464-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl'
					: 'http://www')
					+ '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>
    <script type="text/javascript">
var _ss = _ss || [];
_ss.push(['_setDomain', 'https://koi-9IDAHGXA.sharpspring.com/net']);
_ss.push(['_setAccount', 'KOI-E15GRR3I']);
_ss.push(['_trackPageView']);
(function() {
    var ss = document.createElement('script');
    ss.type = 'text/javascript'; ss.async = true;

    ss.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'koi-9IDAHGXA.sharpspring.com/client/ss.js?ver=1.1.1';
    var scr = document.getElementsByTagName('script')[0];
    scr.parentNode.insertBefore(ss, scr);
})();
</script>

<script type="text/javascript">
	var trackcmp_email = '';
	var trackcmp = document.createElement("script");
	trackcmp.async = true;
	trackcmp.type = 'text/javascript';
	trackcmp.src = '//trackcmp.net/visit?actid=223237523&e='+encodeURIComponent(trackcmp_email)+'&r='+encodeURIComponent(document.referrer)+'&u='+encodeURIComponent(window.location.href);
	var trackcmp_s = document.getElementsByTagName("script");
	if (trackcmp_s.length) {
		trackcmp_s[0].parentNode.appendChild(trackcmp);
	} else {
		var trackcmp_h = document.getElementsByTagName("head");
		trackcmp_h.length && trackcmp_h[0].appendChild(trackcmp);
	}
</script>
</head>
<body>
<!--<div class="alert alert-warning" style="margin-bottom:0px">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Alert!</strong> <span id="warntxt">Please note that we are currently experiencing network issues and Fraudcheck services may not be fully operational. We are working to resolve this problem as soon as possible.</span>-->
</div>

	<div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="topbar-menu">
                        	<li><a class='btn-login' href="javascript:togglelogin()">Login</a></li>
                            <li><a href="faq">FAQ's</a></li>
                            <li><a href="contact">Contact</a></li>
                            <!--<li><a href="thought-leadership">Thought Leadership</a></li>-->
                            <li><a href="https://help.fraudchecksupport.co.za/">Knowledge Centre</a></li>
                            <!--<li><a href="resources">Resources</a></li>-->
                                                    </ul>
                        <div id="loginbox">
               			</div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->
	    <nav class="navbar navbar-default navbar-default-top">
    	<div class="container">
<div class="try-mobi"><a href="register"><input type="button" class="btn btn-success btn-nav regbutton-mobi" value="TRY NOW" /></a></div>
            <div class="navbar-header">

              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="brand img-responsive logomain" href="/">
        		Fraud Check
              </a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="/">Home</a></li>

                <li >
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">About <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    	<li><a href="what-we-do">About FraudCheck</a></li>
                        <!--<li><a href="for-you">Get my Own Credit Score</a></li>-->
                        <li><a href="business">Business Services</a></li>
                        <li><a href="agents">Fraudcheck Accredited Agents</a></li>
                        <li><a href="business">Business SAAS</a></li>
                    </ul>
                </li>

                <li class="dropdown ">
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Services <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="services/id-check">ID Checks</a></li>
                        <!--<li><a href="services/credit-check">Credit Checks</a></li>-->
                        <li><a href="services/criminal-check">Criminal Checks</a></li>
                        <li><a href="services/drivers-license-check">Drivers License Checks</a></li>
                        <li><a href="services/matric-verification">Matric Verification</a></li>
                        <li><a href="services/tertiary-verification">Tertiary Education Verification</a></li>
                        <li><a href="services/association-check">Association Checks</a></li>
                        <!--<li><a href="services/bank-account-verification">Bank Account Verification</a></li>-->
                        <!--<li><a href="services/bulk-data-purification">Bulk Data Purification</a></li>-->
                        <li><a href="services/deeds">Deeds</a></li>
			<li><a href="services/fica">FICA Validation</a></li>
			<li><a href="services/social-media-background-screening">Social Media Background Screening</a></li>
			<li><a href="services/other">Criminal Record Expungement & Other</a></li>
                      </ul>
                </li>


                <li >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reporting <span class="caret"></span></a>
                	<ul class="dropdown-menu" role="menu">
                        <li><a href="scorecard">The FraudCheck Score Card</a></li>
                        <li><a href="360-report">360&deg; Report</a></li>
                    </ul>
                </li>
                <li ><a href="purchase-credits">Pricing</a></li>
                <li class="register"><a href="register"><input type="button" class="btn btn-success btn-nav regbutton" value="TRY NOW" /></a></li>
              </ul>
            </div>


        </div>
    </nav>
    
<script>
$(window).load (function ()
{
     $('.bxslider').fadeIn(0);
     $('.bxslider').bxSlider({
          minSlides: 1,
          maxSlides: 5,
          moveSlides: 5,
          slideWidth: 320,
          slideMargin: 100
     });
});
</script>
<style>
.bxslider li img
{
     height:160px;
     text-align: center;
}
.bx-wrapper .bx-viewport
{
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
}
</style>

<!--<div class="alert alert-warning" style="margin-bottom:0px">-->
    <!--<strong>Please note:</strong> <span id="warntxt">Our portal services are currently offline. We apologise for the inconvenience and promise to return the website back to normal as soon as possible.</span>-->
<!--</div>-->


<!-- Carousel
    ================================================== -->

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" ></li>
        <li data-target="#myCarousel" data-slide-to="2" ></li>
        <li data-target="#myCarousel" data-slide-to="3" ></li>
	<li data-target="#myCarousel" data-slide-to="4" ></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <div style="background:url(/resources/img/feature1.jpg) center left;
          background-size:cover;" class="slider-size">

          <div class="container content-header">



  </div>
          <div class="carousel-menu">
                <div class="row mobile-hide">
                    <div class="col-lg-12" style="position:absolute;top:30px; width:35%;">
                      <h1 style="text-align:left;">Fraudcheck Services</h1>
                      <br />
                      <!--<h2 style="text-align:left;color:#030;">New Services:</h2>-->
                      <a href="services/deeds"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Deeds Search</button></a>
                      <!--<a href="services/bulk-data-purification"><button type="button" class="btn btn-primary btn-lg btn-block">Bulk Data Purification</button></a>-->
                      <!--<a href="services/bank-account-verification"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Bank Account Verification</button></a>-->
                      <!--<h2 style="text-align:left;color:#030;">Most Popular:</h2>-->
                      <a href="services/id-check"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">ID checks</button></a>
                      <!--<a href="services/credit-check"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Credit checks</button></a>-->
                      <a href="services/criminal-check"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Criminal checks</button></a>
                      <a href="services/drivers-license-check"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Drivers License checks</button></a>
                      <a href="services/matric-verification"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Matric verification</button></a>
                      <a href="services/tertiary-verification"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Tertiary education verification</button></a>
                      <a href="services/association-check"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Association checks</button></a>
			<a href="services/social-media-background-screening"><button type="button" class="btn btn-primary btn-lg btn-block" style="text-align:left">Background Screening</button></a>
                    </div>
                </div>
                <div class="row mobile-display">
                    <div class="carousel-caption">
                      <h1>Credit Check</h1>
                      <p>Sign up now to Run an instant credit check</p>

                      <a href="register"><button type="button" class="btn btn-primary btn-lg btn-block">Sign Up</button></a>
                    </div>
                </div>
            </div>


          </div>
        </div>

        <div class="item">
          <div style="background:url(/resources/img/feature1.jpg) center left;; background-size:cover;" class="slider-size">
              <div class="container content-header">


  </div>
            <div class="container">
                <div class="carousel-caption">
                  <h1>Protect</h1>
		  <h1>Inform</h1>
		  <h1>Educate</h1>
                  <p class="mobile-hide">FraudCheck protects its users against the losses incurred as a result of identity fraud by providing background screening information and educating clients on how to identify and avoid becoming victims of fraud.</p>
                  <p><a class="btn btn-lg btn-primary" href="register" role="button">Sign up today</a></p>
                  <p></p>
                </div>
			</div>
          </div>
        </div>

        <div class="item">
          <div style="background:url(/resources/img/featurev2-3.png) center center; background-size:cover;" class="slider-size">
              <div class="container content-header">


  </div>
            <div class="container">
                <div class="carousel-caption">
                  <h1>Individual</h1>
		  <h1>Business</h1>
		  <h1>Enterprise</h1>
                  <p class="mobile-hide">FraudCheck works for YOU! No client is too big or too small; individuals, businesses and enterprises are equally at risk of being defrauded and we have a solution for everyone.</p>
                  <p><a class="btn btn-lg btn-primary" href="register" role="button">Sign up today</a></p>
                </div>
			</div>
          </div>
        </div>

<div class="item">
          <div style="background:url(/resources/img/feature1.jpg) center left;; background-size:cover;" class="slider-size">
              <div class="container content-header">


  </div>
            <div class="container">
                <div class="carousel-caption">
                  <h1>Fraudcheck's new &</h1>
                  <h1>Easy to use</h1>
                  <p class="mobile-hide">Combat fraud wherever you are!</p>
                  <p><a class="btn btn-lg btn-primary" href="register" role="button">Register</a> <a class="btn btn-lg btn-primary" href="https://fraudcheck.co.za/register" role="button">Get it now</a></p>
                </div>
                        </div>
          </div>
        </div>

        <div class="item">
          <div style="background:url(/resources/img/feature1.jpg) center left;r; background-size:cover;" class="slider-size">
              <div class="container content-header">

  </div>
            <div class="container">
                <div class="carousel-caption">
                  <h1>Real-time</h1>
		  <h1>Online</h1>
		  <h1>Easy to Use</h1>
                  <p class="mobile-hide">FraudCheck provides real-time, online feedback, interpreted in a simple scorecard to save you time, money and anxiety when making crucial people decisions.</p>
                  <p><a class="btn btn-lg btn-primary" href="register" role="button">Sign up today</a> <a class="btn btn-lg btn-primary" href="javascript: view_video();" role="button"></a></p>
                </div>
			</div>
          </div>
        </div>

      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->



    <!-- Modal
    ================================================== -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <embed width="100%" height="489" name="player_uid_769035701_1" id="player_uid_769035701_1" tabindex="0" type="application/x-shockwave-flash" src="https://s.ytimg.com/yts/swfbin/player-vflb_ree1/watch_as3.swf" allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" wmode="opaque" flashvars="loaderUrl=https%3A%2F%2Fwww.fraudcheck.co.za%2Ffraudcheck-portal%2F&amp;modestbranding=1&amp;ldpj=-11&amp;title=FraudCheck%20take%20version%201&amp;length_seconds=126&amp;iurlhq=https%3A%2F%2Fi.ytimg.com%2Fvi%2FMJtPMrGvCkE%2Fhqdefault.jpg&amp;hl=en_GB&amp;host_language=en-GB&amp;iurlmaxres=https%3A%2F%2Fi.ytimg.com%2Fvi%2FMJtPMrGvCkE%2Fmaxresdefault.jpg&amp;watch_xlb=https%3A%2F%2Fs.ytimg.com%2Fyts%2Fxlbbin%2Fwatch-strings-en_GB-vflS0WsT9.xlb&amp;sw=0.1&amp;cr=ZA&amp;allow_ratings=1&amp;iurlsd=https%3A%2F%2Fi.ytimg.com%2Fvi%2FMJtPMrGvCkE%2Fsddefault.jpg&amp;view_count=925&amp;video_id=MJtPMrGvCkE&amp;iurlmq=https%3A%2F%2Fi.ytimg.com%2Fvi%2FMJtPMrGvCkE%2Fmqdefault.jpg&amp;index=0&amp;allow_embed=1&amp;enablejsapi=1&amp;iurl=https%3A%2F%2Fi.ytimg.com%2Fvi%2FMJtPMrGvCkE%2Fhqdefault.jpg&amp;ssl=1&amp;controls=1&amp;idpj=0&amp;rel=0&amp;is_html5_mobile_device=false&amp;fexp=900718%2C927622%2C932404%2C943917%2C947209%2C947218%2C948124%2C948703%2C952302%2C952605%2C952901%2C955301%2C957103%2C957105%2C957201&amp;avg_rating=0&amp;el=embedded&amp;eurl=https%3A%2F%2Fwww.fraudcheck.co.za%2Ffraudcheck-portal%2F&amp;playerapiid=player_uid_769035701_1&amp;framer=https%3A%2F%2Fwww.fraudcheck.co.za%2Ffraudcheck-portal%2F">
            </div>

        </div>
      </div>
    </div><!-- /modal -->



<!-- Spliter Bar
    ================================================== -->
    <!--<div class="default-bg space grey">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                	<h2 class="text-center">How can you increase staff retention and reduce employment costs? How can you save time and money on training?</h2>
                    <h1 class="text-center">Fraudcheck can answer both of these for you.
                    </h1>
                </div>
            </div>
        </div>
    </div>-->
    <!-- <div class="default-bg space grey">
         <div class="row">
            <div class="col-md-10 col-md-offset-1" style="text-align:center;">
                 <h2 class="text-center" style="font-size:2em">About Fraudcheck</h2>
             <iframe width="560" height="315" src="https://fraudcheckai.co.za/wp-content/uploads/2021/08/FC-logo-b.png" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
   </div> -->
    <div class="default-bg space">
        <div >
            <!--<div class="row">
                <div class="col-md-10 col-md-offset-1">
                	<h2 class="text-center" style="font-size:2em">Where Did All The People Go? - Free E-Book Download</h2>
                    <p class="text-center" style="font-size:1.6em">Tips and Tricks to Finding the Right People to Interview</p>
                    <p style="text-align:center; margin-top:15px;"><a href='resources/where-did-all-the-people-go' class="btn btn-primary btn-lg ">Free E-Book Download</a></p>
                </div>
          
<!-- Key Benefits
    ================================================== -->

    <div class="default-bg space dark-grey">
        <div class="container keyBenefits">
            <div class="row text-center"><h2>KEY BENEFITS:</h2><br/></div>
        	<div class="row">
            	<div class="col-md-6">
                	<div class="row">
                        <div class="col-md-3"><img src="https://fraudchecksupport.co.za/resources/img/home_icon1.png"/></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-8 space"><h3>Automated Risk Management</h3>
							Fraudcheck is an automated risk management services company.

                        </div>
                    </div>
                    <div class="row space">
                        <div class="col-md-3"><img src="https://fraudchecksupport.co.za/resources/img/home_icon2.png"/></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-8 space"><h3>Digital Recruitment Solutions</h3>
							Fraudcheck provide digital solutions for HR departments and recruitment companies to help you to ensure that job applicants are being honest about their personal details, qualifications, financial background and criminal records.
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                	<div class="row">
                        <div class="col-md-3"><img src="https://fraudchecksupport.co.za/resources/img/home_icon3.png"/></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-8 space"><h3>Real-time Results</h3>
							Fraudcheck provide real-time, automated feedback, presented in a consistent interpreted scorecard to give you peace of mind about the job applicants that you are considering.
                        </div>
                    </div>
                    <div class="row space">
                        <div class="col-md-3"><img src="https://fraudchecksupport.co.za/resources/img/home_icon4.png"/></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-8 space"><h3>360 Degree Reporting</h3>
							On demand reports available anywhere and anytime.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Stats messaging
    ================================================== -->

    <div class="container statsHome">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <h2><span class="counter">6</span>%</h2>
          <p>of South African job applicants would fail financial background screening.</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <h2><span class="counter">6</span>%</h2>
          <p>have criminal records.</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <h2><span class="counter">20</span>%</h2>
          <p>lie about their education.</p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

      </div>


	<div class="container">
    	<div class="row">
        	<div class="col-md-2 text-center"><img src=(https://site.fraudcheckai.co.za/img/bg/client-bg.png) ></div>
        	</div>

          <div class="row">
               <div class="col-md-10 col-md-offset-1">
                   <h2 class="text-center" style="font-size:2em">FRAUDCHECK </h2>
                   <br /><br />
              </div>
         </div>
      </div>

          <div class="row">
               <div class="col-md-10 col-md-offset-1">
                   <h2 class="text-center" style="font-size:2em">Fraud committed by criminals can cause your company reputational damage and cost you the earth in recruitment charges as you hire and rehire, and address the fall-out caused by dishonest and underqualified staff</h2>
                   <br /><br />
              </div>
         </div>	
      <div class="row">
               <div class="col-md-10 col-md-offset-1">
                   <h2 class="text-center" style="font-size:2em">Fraudcheck lets you conduct pre-employment and background screening on potential employees to verify their personal details before you employ them </h2>
                   <br /><br />
              </div>
         </div>
      </div>< 	

        </div>
    </div>

          <div class="row">
               <div class="col-md-10 col-md-offset-1">
                   <h2 class="text-center" style="font-size:2em">Our Clients</h2>
                   <br /><br />
              </div>
         </div>
               <ul class="bxslider" style="display:auto;">
                 <li><img src="https://fraudchecksupport.co.za/resources/img/FClogo1.png" /></li>
                 <li><img src="https://fraudcheck.co.za/images/logos/10x.jpg" /></li>
                 <li><img src="https://fraudcheck.co.za/images/logos/5minutes.png" /></li>
                 <li><p style="font-size:15px"><span style="font-style:italic">“Our company has been using Fraudcheck for a few months and we couldn’t be any happier with the service we have received. We require a quick turn around with the criminal checks and Fraudcheck delivers that and more.”</span> - <strong>Stuart Smith, Director, 5 Minutes 2 Town </strong></p></li>
                 <li><img src="https://fraudcheck.co.za/images/logos/fabrizi.png" /></li>
                 <li><img src="https://fraudcheck.co.za/images/logos/sienna.jpg" /></li>
                 <li><img src="https://fraudcheck.co.za/images/logos/imvusa.jpg" /></li>
                 <li><p style="font-size:15px"><span style="font-style:italic">“Fraudcheck has given us the ability to provide a one stop service for people hiring any level of employee with a 48-hour turnaround.  Thank you for all your support and we look forward to continuing a long and professional association.”</span> - <strong>Imvusa Retail Solutions</strong></p></li>
                 <li><img src="images/logos/incred.png" /></li>
                <li><img src="https://fraudchecksupport.co.za/resources/img/FC-Outline.png" /></li>
                 <li><p style="font-size:15px"><span style="font-style:italic">“Fraud check always goes above and beyond to assist. Nosi is always willing and able to cater for our checks with a smile. The website is also very user- friendly. I am pleased with the service to date.”</span> - <strong>Capcorp </strong></p></li>
                 <li><img src="https://fraudchecksupport.co.za/resources/img/FC-Outline.png" /></li>
                 <li><img src="https://fraudchecksupport.co.za/resources/img/FC-Outline.png" /></li>
                 
               </ul>
        </div>
    </div>

<!-- Spliter Bar
    ================================================== -->
<div id="video-anchor" class="item">
          <div style="background:url(https://site.fraudcheckai.co.za/img/bg/client-bg.png) center center; background-size:cover;" class="slider-size">
        <div class="container">
                 <div class="row text-center"><h1>-</h1><br/></div>
                        <div class="row text-center"><h3>FraudCheck saves you time and money, gives you peace of mind and puts control firmly back in your hands by taking the risk out of decisions about the people with whom you interact and transact.</h3><br/>
							<h2>Fraudcheck is an automated risk management services company.</h2>
                        </div>
                        
                <div class="row text-center"><h1></h1><br/></div>
                  
                 <section class="video-area pt-80 pb-100 p-relative">
                <div class="video-img2">

                    <img src="img/bg/video-img.gif" alt="mobile">

                    <a href="http://web.fraudcheck.live/wp-content/uploads/2021/06/Fraudcheck_HUD-.mp4 class="popup-video"><img src="https://fraudchecksupport.co.za/resources/img/FC-Outline.png" alt="Fraudcheck"></a>
                </div>
                <div class="row text-center"><h1>FRAUDCHECK</h1><br/></div>
            </div>
        </div>
    </div>


    <a href="#0" class="cd-top">Top</a>

		<script>
			$("document").ready(function() {
				$(".scroll").click(function(event) {
					event.preventDefault();
					$('html,body').animate({
						scrollTop: $(this.hash).offset().top
					}, 500);
				});

				$("#back-top").hide();

				$(function() {
					$(window).scroll(function() {
						if ($(this).scrollTop() > 255) {
							$('#back-top').fadeIn();
						} else {
							$('#back-top').fadeOut();
						}
					});

					$('#back-top a').click(function() {
						$('body,html').animate({
							scrollTop: 0
						}, 800);
						return false;
					});
				});
			});
		</script>


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '2417525548285056'); 
fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" 
src="https://www.facebook.com/tr?id=2417525548285056&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->


<!-- Footer
    ================================================== -->
    <footer class="footer">
     <div class="container">
     	<div class="row">
        	<div class="col-sm-2">
            <h6>For You</h6>
            <ul class="list-unstyled">
            	<!--<li><a href="for-you#getownscore">Get My Own Credit Score</a></li>-->
                <li><a href="for-you#check">Check Someone</a></li>
                <li><a href="register">Get Started</a></li>
                
            </ul>
            </div>
            <div class="col-sm-2">
            <h6>For Your Business</h6>
            <ul class="list-unstyled">
            	<li><a href="business">Our Services</a></li>
                <li><a href="register">Get Started</a></li>                
            </ul>
            </div>
        	<div class="col-sm-2">
            <h6>Services</h6>
            <ul class="list-unstyled">
            	<li><a href="services/id-check">ID Check</a></li>
                <!--<li><a href="services/credit-check">Credit Check</a></li>-->
                <li><a href="services/criminal-check">Criminal Check</a></li>
                <li><a href="services/drivers-license-check">Drivers License Check</a></li>
                <li><a href="services/matric-verification">Matric Verification</a></li>
                <li><a href="services/tertiary-verification">Tertiary Education Verification</a></li>
                <li><a href="services/association-check">Association Check</a></li>
                <!--<li><a href="services/bank-account-verification">Bank Account Verification</a></li>-->
                <!--<li><a href="services/bulk-data-purification">Bulk Data Purification</a></li>-->
                <li><a href="services/deeds">Deeds</a></li>
            </ul>
            </div>
            <div class="col-sm-2">
            <h6>About FraudCheck</h6>
            <ul class="list-unstyled">
            	<li><a href="what-we-do">What We Do</a></li>
                <li><a href="scorecard">Score Card</a></li>
                <li><a href="360-report">360 Report</a></li>
            	<li><a href="contact">Contact Us</a></li>
                <li><a href="faq">FAQ's</a></li>
                <li><a href="disagree">Disputes</a></li>
                <li><a href="purchase-credits">Purchase Credits</a></li>
            </ul>
            </div>
            <div class="col-sm-3">
            <a target="blank" href="https://twitter.com/FraudCheckSA"><img alt="Follow us on Twitter" src="images/iconbot1.png"></a><a target="blank" href="http://www.facebook.com/FraudCheckSA"><img alt="Follow us on Facebook" src="images/iconbot2.png"></a><a href="skype:fraudcheck?chat" name="skype" id="skype"><img alt="Skype us" src="images/iconbot4.png"></a>
                    <div class="whitehead20px">Email Support</div>
                        <div id="bottomnav2"><a href="mailto:support@fraudcheck.co.za">support@fraudcheck.co.za</a>
                        </div>
	<br/>
            <!--Small seal script. Can only be placed on -->
        <!--<script type="text/javascript" src="https://intellicred.intellicred.com/TrustSeals/GetSeal?sealType=1&memberId=kOn0/zYJp+ctslBc32V3Cg==&sealId=4"></script>-->
	<!--<script type="text/javascript" src="https://intellicred.intellicred.com/TrustSeals/GetSeal?sealType=2&memberId=kOn0/zYJp+ctslBc32V3Cg==&sealId=3"></script>-->
	<br/>
	<img src="https://fraudcheckai.co.za/wp-content/uploads/2021/08/FC-logo-b.png"/>
		</div>
        </div>
        <div class="row space text-center">
        &copy; Copyright  FRAUDCHECK  (Pty) Ltd - 2021 - All rights reserved. <a href="ts-and-cs">Terms and Conditions</a>
        </div>
        <div class="row space text-center">
        <img src="img/creditcards.png" height="50" />
        </div>
     </div>
    
    </footer>
    <script type="text/javascript">

                var trackcmp_email = '';

                var trackcmp = document.createElement("script");

                trackcmp.async = true;

                trackcmp.type = 'text/javascript';

                trackcmp.src = '//trackcmp.net/visit?actid=648954545&e='+encodeURIComponent(trackcmp_email)+'&r='+encodeURIComponent(document.referrer)+'&u='+encodeURIComponent(window.location.href);

                var trackcmp_s = document.getElementsByTagName("script");

                if (trackcmp_s.length) {

                                trackcmp_s[0].parentNode.appendChild(trackcmp);

                } else {

                                var trackcmp_h = document.getElementsByTagName("head");

                                trackcmp_h.length && trackcmp_h[0].appendChild(trackcmp);

                }

</script>

<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('9311-741-10-6691');/*]]>*/</script><noscript><a href="https://www.olark.com/site/9311-741-10-6691/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->

<script language="JavaScript" type="text/javascript">
TrustLogo("https://www.fraudcheck.co.za/images/comodo_secure_seal_76x26_transp.png", "CL1", "none");
</script>
<script type="text/javascript"> //<![CDATA[
  var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
  document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]></script>
<script language="JavaScript" type="text/javascript">
  TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_md_167x42.png", "POSDV", "none");
</script>
<!--<a  href="https://ssl.comodo.com" id="comodoTL">SSL Certificates</a>-->

</body>
</html>
