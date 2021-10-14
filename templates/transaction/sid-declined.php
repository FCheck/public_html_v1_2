<!-- Header Image
    ================================================== -->
<div class="jumbotron" style="background:url(images/content_header1.jpg) center center; 
          background-size:cover;">
  <div class="container content-header">
   Buy Credits
   <div class="try"><a href="register"><input type="button" class="btn btn-primary btn-nav" value="TRY NOW" /></a></div>
  </div>
</div> <!-- jumbotron -->


<!-- Content Below
    ================================================== -->
    
    <div class="container">

    	<div class="row space">
          <div class="col-md-9">
            <div class="page-header green-heading">
                <strong>Transaction Declined</strong>
             </div> 
             <br />  
           Unfortunately there has been an error processing your purchase.<br /><br />
            To re-try the transaction, please click proceed below<br /><br />
              
              <table>
                <tr>
                    <td colspan="2"><strong>Purchase <span class="numcredits" id="numcredits"><?php echo $credits; ?></span> Credits</strong></td>
                </tr>
                <tr>
                    <td width="200"><span class="numcredits"><?php echo round($credits); ?></span> Credits</td>
                    <td align="right">R<span><?php echo round($exclvat); ?></span>.00</td>
                </tr>
                <tr> 
                    <td>VAT</td>
                    <td align="right">R<span id="vat"><?php echo round($vat); ?></span>.00</td> 
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td><strong>Total Cost</strong></td>
                    <td align="right"><strong>R<span><?php echo $totalamt; ?></span></strong></td>
                </tr> 
                
              </table>
        
        		<input type="hidden" id="numcredits" value="<?php echo round($credits); ?>" />
                <input type="hidden" id="select_credits" value="<?php echo round($totalamt); ?>" />
              
              <form class="form-horizontal" role="form" name="creditsform_sid" onsubmit="submit_sid_transaction (); return false" action="https://www.sidpayment.com/paySID/" method="post">  
              	<input type="hidden" name="SID_MERCHANT" id="sid_merchant" value="FRAUDCHECK">
              	<input type="hidden" name="SID_REFERENCE" id="sid_reference" value="">
              	
              	<input type="hidden" name="SID_AMOUNT" id="sid_amount" value="">
              	<input type="hidden" name="SID_CURRENCY" id="sid_currency" value="ZAR">
                <input type="hidden" name="SID_COUNTRY" id="sid_country" value="ZA">
              	<input type="hidden" name="SID_CONSISTENT" id="sid_consistent" value="">         
                <div class="form-group">
              	<div class="col-sm-4"></div>
              	<div class="col-sm-6" id="proceed_btn_area">
                <input type="submit" class="btn-primary btn-lg" value="Pay by Internet Banking - SID" style="width:300px;">        
                </div>
              </div>
              	      
            </form>

        </div>
        </div>
</div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>

