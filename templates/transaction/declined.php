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
           Unfortunately there has been an error processing your purchase, the error provided is: <?php echo $getvars ['p3']; ?><br /><br />
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
              <input type="hidden" id="select_credits" value="<?php echo $getvars ['p6']; ?>">
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
              <br /><br />
              <div class="form-group">
              	<div class="col-sm-4"></div>
              	<div class="col-sm-3" id="proceed_btn_area">
                <input type="submit" class="btn-primary btn-lg" value="Proceed">
                </div>
              </div>
              
            </form>
        </div>
        </div>
</div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>

