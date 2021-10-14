<style>
table tr td
{
	padding:5px;
}
</style>
<script>
$(document).ready (function ()
{
	//setDeedsType (1);
});
</script>
<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; background-size:cover;">
    <div class="container content-header">
        Deeds Lookup
    </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
<div id="collectdata">
    <div class="container">

        <div class="row space">

            <div class="col-md-7">
                <form class="form-horizontal" role="form" method="POST" onsubmit="return false;" action="run_deeds">
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom:10px">
                            <h2 class="green-heading" style="margin-top:6px;margin-left:5px;">Search Deeds by:</h2>
                        </div>
                        <div class="col-sm-3" style="margin-bottom:10px">
                            <input class="displaynone acc_type" type="radio" id="individual2" name="acc_type" value="2" onclick="setDeedsType (2)">
                            <label for="individual2" class="registerradio" style="float:right">Juristic Person</label>
                        </div>

                        <div class="col-sm-3" style="margin-bottom:10px">
                            <input class="displaynone acc_type" type="radio" id="individual1" name="acc_type" value="1" onclick="setDeedsType (1)">
                            <label for="individual1" class="registerradio">Natural Person</label>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div id="individualdeeds">
                        <div class="page-header green-heading">
                            <strong>Enter individual's information</strong>
                        </div>
                        <div class="space"></div>

                        <div class="form-group">
                            <label for="inputFirstName" class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputSurname" class="col-sm-2 control-label">Surname</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="surname" placeholder="Surname" name="surname">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputID" class="col-sm-2 control-label">ID Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control replace-bad-input" id="said" placeholder="ID Number" name="said">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputFirstName" class="col-sm-2 control-label">Physical Address</label>
                            <div class="col-sm-10" style="margin-bottom:10px">
                                <input type="text" class="form-control" id="streetNumber" name="streetNumber" placeholder="Street Number" maxlength="20" style="width:400px">
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" style="margin-bottom:10px">
                                <input type="text" class="form-control" id="streetName" name="streetName" placeholder="Street Name" style="width:400px">
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" style="margin-bottom:10px">
                                <input type="text" class="form-control" id="town" name="town" placeholder="Town" style="width:400px">
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" style="margin-bottom:10px">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City" style="width:400px">
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" style="margin-bottom:10px">
                                <input type="text" class="form-control replace-bad-input" id="postalCode" name="postalCode" placeholder="Postal Code" style="width:400px">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enquiryReason" class="col-sm-2 control-label">Reason</label>
                            <div class="col-sm-10">
                                <select name="enquiryReason" id="enquiryReason" class="form-control">
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
                    </div>
                    <div id="businessdeeds">
                        <div class="page-header green-heading">
                            <strong>Enter entity information</strong>
                        </div>
                        <div class="space"></div>

                        <div class="form-group">
                            <label for="inputFirstName" class="col-sm-4 control-label">Registered Entity Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputEntityName" placeholder="Entity Name" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputSurname" class="col-sm-4 control-label">Registration Number</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputRegNo" placeholder="Registration Number (if available)" name="regNo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enquiryReason" class="col-sm-4 control-label">Reason</label>
                            <div class="col-sm-8">
                                <select name="enquiryReason" id="enquiryBusReason" class="form-control">
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
                    </div>
                    <div class="space"></div>

                    <div class="form-group runbtn">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <?php
                            if (strcmp ($GLOBALS ['user']->status, "ACTIVE") == 0)
                            {
                                echo "<a href=\"#\"><button class=\"btn-primary btn-lg\" onclick=\"run_deeds()\">Run Check</button></a>";
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
                <div class="page-header green-heading" style="text-align:center;">
                    <strong>Cost of Lookup:</strong>
                </div>
                <br>
                <h2 class="text-center"><strong id="numcredits">10</strong> credits</h2>
                <div>
                    <p style="text-align:justify; margin-top:20px;">
                        <strong>What is a Juristic and Natural person?</strong><br />
                        A natural person is an individual such as yourself with a South African ID Number. A Juristic Person is a registered company, close corporation, trust etc which will have a registration number.
                   </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="runchecks" style="display:none;">
    <div align="center" class="container">
        <div class="space"></div>
        <div class="page-header green-heading">
            Please wait while we query the Deeds Registry.
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
<div id="displayresult" style="display:none;">
	<div class="container">
        <h1>Deeds Lookup on <span class="Rforename"></span>&nbsp;<span class="Rsurname"></span></h1>
        <div class="page-header">
          <h2>Details used to Perform Check</h2>
        </div>
        <table width="80%">
            <tr>
                <td width="20%"><strong>First Name(s):</strong></td>
                <td width="40%" class="Rforename"></td>
                <td width="20%"><strong>Address:</strong></td>
                <td width="20%" rowspan="4" valign="top" class="Raddress"></td>
            </tr>
            <tr>
                <td width="20%"><strong>Surname:</strong></td>
                <td width="40%" class="Rsurname"></td>
                <td colstan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="20%"><strong>ID Number:</strong></td>
                <td width="40%" class="Rsaid"></td>
                <td colstan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="20%"><strong>Transaction ID:</strong></td>
                <td width="40%" class="RtransactionId"></td>
                <td colstan="2">&nbsp;</td>
            </tr>
        </table>
        <div class="page-header">
        	<h2>Deeds Found</h2>
     	</div>
        <div id="deedsDisplay">

        </div>
    </div>
</div>
<div id="displaybusresult" style="display:none;">
	<div class="container">
        <h1>Deeds Lookup on <span class="Rbusname"></span></h1>
        <div class="page-header">
          <h2>Details used to Perform Check</h2>
        </div>
        <table width="80%">
            <tr>
                <td width="20%"><strong>Entity Name:</strong></td>
                <td width="40%" class="Rbusname"></td>
                <td width="20%"><strong>Address:</strong></td>
                <td width="20%" rowspan="3" valign="top" class="Raddress"></td>
            </tr>
            <tr>
                <td width="20%"><strong>Registration Number:</strong></td>
                <td width="40%" class="RregNo"></td>
                <td colstan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="20%"><strong>Transaction ID:</strong></td>
                <td width="40%" class="RtransactionId"></td>
                <td colstan="2">&nbsp;</td>
            </tr>
        </table>
        <div class="page-header">
        	<h2>Deeds Found</h2>
     	</div>
        <div id="deedsBusDisplay">

        </div>
    </div>
</div>
<div id="displayoptions" style="display:none;">
	<div class="container">
        <h2>Select Company to Proceed</h2>
    	<div id="companyDisplay">

    	</div>
    </div>
</div>

<a href="#0" class="cd-top">Top</a>
