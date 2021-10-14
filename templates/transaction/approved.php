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
                <strong>Transaction Successful</strong>
             </div> 
             <br />  
           Thank you for your business, your credits have successfully been added to your account. Please see your payment summary below:<br /><br />
              
              <table>
                <tr>
                    <td colspan="2"><strong>Purchase <span class="numcredits"><?php echo $credits; ?></span> Credits</strong></td>
                </tr>
                <tr>
                    <td width="200"><span class="numcredits"><?php echo $credits; ?></span> Credits</td>
                    <td align="right">R<span id="creditcost"><?php echo round ($exclvat); ?></span>.00</td>
                </tr>
                <tr> 
                    <td>VAT</td>
                    <td align="right">R<span id="vat"><?php echo round ($vat); ?></span>.00</td> 
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td><strong>Total Cost</strong></td>
                    <td align="right"><strong>R<span id="totalcost"><?php echo $totalamt; ?></span></strong></td>
                </tr> 
                
              </table>
          
        </div>
        </div>
</div>

	<div class="space"></div>
    
    
   <a href="#0" class="cd-top">Top</a>

