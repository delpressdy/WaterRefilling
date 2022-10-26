<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>

<!-- Printable area start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	// document.body.style.marginTop="-45px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<!-- Printable area end -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('return_details') ?></h1>
            <small><?php echo display('return_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('return') ?></a></li>
                <li class="active"><?php echo display('return_details') ?></li>
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
        if($this->permission1->method('manufacturer_return_list','read')->access()){ ?>
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
	                                </address>
	                            </div>
	                            {/company_info}
	                            <div class="col-sm-4 text-left" style="display: inline-block;margin-left: 5px;">
	                                <h2 class="m-t-0"><?php echo display('return') ?></h2>
	                                <div><?php echo display('return_id') ?>: {invoice_no}</div>
	                                 <div><?php echo display('purchase_id') ?>: {purchase_id}</div>
	                                <div class="m-b-15"><?php echo display('billing_date') ?>: {final_date}</div>

	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>

	                                  <address style="margin-top:10px;width: 200px">  
	                                    <span><?php echo display('manufacturer')?></span> : <strong>{manufacturer_name} </strong><br>
	                                    <?php if ($address) { ?>
		                                <span><?php echo display('address')?></span> :  <b>{address}</b>
		                                <?php } ?>
	                                    <br>
	                                    <span><?php echo display('mobile')?></span> :  <abbr><b>{mobile}:</b></abbr>
	                                   
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

	                                        <th class="text-center"><?php echo display('purchase_price') ?></th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										{return_detail}
										<tr>
	                                    	<td class="text-center">{sl}</td>
	                                        <td class="text-center"><div><strong>{product_name} - ({product_model})</strong></div></td>
	                                        <td align="center">{ret_qty}</td>

	                                        <?php if ($discount_type == 1) { ?>
	                                        <td align="center">{deduction}</td>
	                                        <?php }else{ ?>
	                                        <td align="center"><?php echo (($position==0)?"$currency {deduction}":"{deduction} $currency") ?></td>
	                                        <?php } ?>
	                                        
	                                        <td align="center"><?php echo (($position==0)?"$currency {product_rate}":"{product_rate} $currency") ?></td>
	                                        <td align="center"><?php echo (($position==0)?"$currency {total_ret_amount}":"{total_ret_amount} $currency") ?></td>
	                                    </tr>
	                                    {/return_detail}
	                                </tbody>
	                                <tfoot>
	                                	<td align="center" colspan="1" style="border: 0px"><b><?php echo display('total')?>:</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td align="center"  style="border: 0px"><b>{subTotal_quantity}</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	
	                                	<td align="center"  style="border: 0px"><b><?php echo (($position==0)?"$currency {subTotal_ammount}":"{subTotal_ammount} $currency") ?></b></td>
	                                </tfoot>
	                            </table>
	                        </div>
	                        <div class="row">
		                        
		                        	<div class="col-xs-8" style="display: inline-block;width: 66%">
		                                <p><strong>Note : </strong>{note}</p>
		                               
		                                <div  style="float:left;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 110px;font-weight: bold;">
												<?php echo display('received_by') ?>
										</div>
		                            </div>
		                            <div class="col-xs-4" style="display: inline-block;">

				                        <table class="table">
				                            <?php
			                                	if ($return_detail[0]['total_deduct'] != 0) {
			                                ?>
				                            	<tr>
				                            		<th style="border-top: 0; border-bottom: 0;"><?php echo display('deduction') ?> : </th>
				                            		<td style="border-top: 0; border-bottom: 0;"><?php echo (($position==0)?"$currency {total_deduct}":"{total_deduct} $currency") ?> </td>
				                            	</tr>
				                            <?php } 
				                              	
			                                ?>
				                            	<tr>
				                            		<th class="grand_total"><?php echo display('grand_total') ?> :</th>
				                            		<td class="grand_total"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
				                            	</tr>

			                            </table>
		                                <div  style="float:left;width:90%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
												<?php echo display('authorised_by') ?>
										</div>
		                        </div>
	                        </div>
	                    </div>
	                </div>

                     <div class="panel-footer text-left">
                     	<a  class="btn btn-danger" href="<?php echo base_url('Cretrun_m');?>"><?php echo display('cancel') ?></a>
						<button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
						
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        else{
         ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



