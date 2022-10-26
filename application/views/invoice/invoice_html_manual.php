<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>

<!-- Printable area start -->

<!-- Printable area end -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('invoice_details') ?></h1>
            <small><?php echo display('invoice_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('invoice_details') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
    	<!-- Alert Message -->
	    <?php
	        $message = $this->session->userdata('message');
	        if (isset($message)) {
	    ?>
	    <div class="alert alert-info alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        <?php echo $message ?>
	    </div>
	    <?php
	        $this->session->unset_userdata('message');
	        }
	        $error_message = $this->session->userdata('error_message');
	        if (isset($error_message)) {
	    ?>
	    <div class="alert alert-danger alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        <?php echo $error_message ?>
	    </div>
	    <?php
	        $this->session->unset_userdata('error_message');
	        }
	    ?>
        <?php
        if($this->permission1->method('manage_invoice','read')->access() ){ ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
	                <div id="printableArea">
	                    <div class="panel-body">
	                        <div class="row">
	                        	{company_info}
	                            <div class="col-sm-8" style="display: inline-block;width: 64%">
	                                 <img src="<?php if (isset($Web_settings[0]['invoice_logo'])) {echo $Web_settings[0]['invoice_logo']; }?>" class="" alt="" style="margin-bottom:20px">
	                                <br>
	                                <span class="label label-success-outline m-r-15 p-10" ><?php echo display('billing_from') ?></span>
	                                <address style="margin-top:10px">
	                                    <strong>{company_name}</strong><br>
	                                    {address}<br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
	                                    {email}<br>
	                                    <abbr><b><?php echo display('website') ?>:</b></abbr>
	                                    {website}
	                                    {/company_info}<br>
	                                     <abbr>{tax_regno}</abbr>
	                                </address>
	                            </div>
	                            
	                            
	                            <div class="col-sm-4 text-left" style="display: inline-block;margin-left: 5px;">
	                                <h2 class="m-t-0"><?php echo display('invoice') ?></h2>
	                                <div><?php echo display('invoice_no') ?>: {invoice_no}</div>
	                                <div class="m-b-15"><?php echo display('billing_date') ?>: {final_date}</div>

	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>

	                                  <address style="margin-top:10px;width: 200px">
	                                    <strong>{customer_name} </strong><br>
	                                    <?php if ($customer_address) { ?>
		                                {customer_address}
		                                <?php } ?>
	                                    <br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr>
	                                    <?php if ($customer_mobile) { ?>
	                                    {customer_mobile}
	                                    <?php }if ($customer_email) {
	                                    ?>
	                                    <br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
	                                    {customer_email}
	                                   	<?php } ?>
	                                </address>
	                            </div>
	                        </div> <hr>

	                        <div class="table-responsive m-b-20">
	                            <table class="table table-striped table-bordered">
	                                <thead>
	                                    <tr>
	                                        <th class="text-center"><?php echo display('sl') ?></th>
	                                        <th class="text-center"><?php echo display('product_name') ?></th>
	                                        <th class="text-center"><?php echo display('quantity') ?></th>

	                                        <?php if ($discount_type == 1) { ?>
	                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
	                                        <?php }elseif($discount_type == 2){ ?>
	                                        <th class="text-center"><?php echo display('discount') ?> </th>
	                                        <?php }elseif($discount_type == 3) { ?>
	                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
	                                        <?php } ?>

	                                        <th class="text-center"><?php echo display('rate') ?></th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										{invoice_all_data}
										<tr>
	                                    	<td class="text-center">{sl}</td>
	                                        <td class="text-center"><div><strong>{product_name} - ({product_model})</strong></div></td>
	                                        <td align="center">{quantity}</td>

	                                        <?php if ($discount_type == 1) { ?>
	                                        <td align="center">{discount}</td>
	                                        <?php }else{ ?>
	                                        <td align="center"><?php echo (($position==0)?"$currency {discount}":"{discount} $currency") ?></td>
	                                        <?php } ?>

	                                        <td align="center"><?php echo (($position==0)?"$currency {rate}":"{rate} $currency") ?></td>
	                                        <td align="right"><?php echo (($position==0)?"$currency {total_price}":"{total_price} $currency") ?></td>
	                                    </tr>
	                                    {/invoice_all_data}
	                                </tbody>
	                                <tfoot>
	                                	<td align="center" colspan="1" style="border: 0px"><b><?php echo display('sub_total')?>:</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td align="center"  style="border: 0px"><b>{subTotal_quantity}</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>

	                                	<td class="text-right" align="center"  style="border: 0px"><b><?php echo (($position==0)?"$currency {subTotal_ammount}":"{subTotal_ammount} $currency") ?></b></td>
	                                </tfoot>
	                            </table>
	                        </div>
	                        <div class="row">

		                        	<div class="col-xs-8" style="display: inline-block;width: 66%">

		                                <p></p>
		                                <p><strong>{invoice_details}</strong></p>
		                               
		                            </div>
		                            <div class="col-xs-4" style="display: inline-block;">

				                        <table class="table">
                                        <?php
                                        if ($invoice_all_data[0]['total_discount'] != 0) {
                                            ?>
                                            <tr>
                                                <th style="border-top: 0; border-bottom: 0;"><?php echo display('total_discount') ?> : </th>
                                                <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {total_discount}" : "{total_discount} $currency") ?> </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($invoice_all_data[0]['total_tax'] != 0) {
                                            ?>
                                            <tr>
                                                <th class="text-left" style="border-top: 0; border-bottom: 0;"><?php echo display('tax') ?> : </th>
                                                <td  class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {total_tax}" : "{total_tax} $currency") ?> </td>
                                            </tr>
                                        <?php } ?>
                                       
                                        <tr>
                                            <th class="text-left grand_total"><?php echo display('previous'); ?> :</th>
                                            <td class="text-right grand_total"><?php echo (($position == 0) ? "$currency {previous}" : "{previous} $currency") ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left grand_total"><?php echo display('grand_total') ?> :</th>
                                            <td class="text-right grand_total"><?php echo (($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left grand_total" style="border-top: 0; border-bottom: 0;"><?php echo display('paid_ammount') ?> : </th>
                                            <td class="text-right grand_total" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {paid_amount}" : "{paid_amount} $currency") ?></td>
                                        </tr>				 
                                        <?php
                                        if ($invoice_all_data[0]['due_amount'] != 0) {
                                            ?>
                                            <tr>
                                                <th class="text-left grand_total"><?php echo display('due') ?> : </th>
                                                <td  class="text-right grand_total"><?php echo (($position == 0) ? "$currency {due_amount}" : "{due_amount} $currency") ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>

		                              

		                        </div>
		                        <div class="row">
		                        	<div class="col-sm-4">
		                        		 <div  style="float:left;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
												<?php echo display('received_by') ?>
												 <input type="hidden" name="" id="url" value="<?php echo base_url('Cinvoice');?>">
										</div>
		                        	</div>
		                        	<div class="col-sm-4"></div>
		                        	<div class="col-sm-4">  <div  style="float:right;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
												<?php echo display('authorised_by') ?>
										</div></div>
		                        </div>
	                        </div>
	                    </div>
	                </div>

                     <div class="panel-footer text-left">
                     	<a  class="btn btn-danger" href="<?php echo base_url('Cinvoice');?>"><?php echo display('cancel') ?></a>
						<button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>

                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        else{
        ?>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script type="text/javascript">

$(window).load(function() {
      var url=document.getElementById("url").value; 
      var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.getElementById('printableArea').innerHTML;
        document.getElementById('printableArea').innerHTML = printContents;
        // document.body.style.marginTop="-45px";
      
        window.print();
        document.body.innerHTML = originalContents;
          setInterval(function(){

          document.location.href = url;
           }, 3000);

       
});
</script>

