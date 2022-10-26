<!-- Stock report start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<!-- Product Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('sales_report_product_wise') ?></h1>
	        <small><?php echo display('sales_report_product_wise') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('sales_report_product_wise') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <?php
                    if($this->permission1->method('todays_report','read')->access()){ ?>
                        <a href="<?php echo base_url('Admin_dashboard/all_report')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('todays_report')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('sales_report','read')->access()){ ?>
                        <a href="<?php echo base_url('Admin_dashboard/todays_purchase_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('purchase_report')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('sales_report_medicine_wise','read')->access()){ ?>
                        <a href="<?php echo base_url('Admin_dashboard/product_sales_reports_date_wise')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report_product_wise')?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>

        <?php
        if($this->permission1->method('sales_report_medicine_wise','read')->access()){ ?>
		<!-- Product report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('Admin_dashboard/product_sales_search_reports',array('class' => 'form-inline','method' => 'get'))?>
		                <?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('start_date') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" value="<?php echo $start ;?>">
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('end_date') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $end ;?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>

		               <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('sales_report_product_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		            	<div id="purchase_div" style="margin-left:2px;">
			            	<div class="text-center">
								{company_info}
								<h3> {company_name} </h3>
								<h4 >{address} </h4>
								{/company_info}
								<h4> <?php echo display('print_date') ?>: <?php echo $start ;?>  To  <?php echo $end ;?></h4>
							</div>

			                <div class="table-responsive">
			                    <table class="table table-bordered table-striped table-hover">
			                       <thead>
										<tr>
											<th><?php echo display('sales_date') ?></th>
											<th><?php echo display('product_name') ?></th>
											<th><?php echo display('product_model') ?></th>
											<th><?php echo display('customer_name') ?></th>
											<th><?php echo display('rate') ?></th>
											<th><?php echo display('total_ammount') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($product_report) {
									?>
									<?php
                                       $sub_totalp = 0;
									 foreach($product_report as $rep){
                                        $sub_totalp +=$rep['total_price'];
										?>
                                        
										<tr>
											<td><?php echo $rep['sales_date'] ?></td>
											<td><?php echo $rep['product_name'] ?></td>
											<td><?php echo $rep['product_model'] ?></td>
											<td><?php echo $rep['customer_name'] ?></td>
											<td style="text-align: right;"><?php echo (($position==0)?"$currency":"$currency");echo $rep['rate'] ?></td>
											<td style="text-align: right;"><?php echo (($position==0)?"$currency":"$currency");echo $rep['total_price'] ?></td>
										</tr>
									<?php
										}
									?>
									<?php
										}
									?>
									</tbody>
									<tfoot>
									<td colspan="5" align="right" style="text-align:right;font-size:14px !Important">&nbsp; <b><?php echo display('total_ammount') ?></b></td>
											<td style="text-align: right;"><b><?php echo (($position==0)?"$currency":"$currency");echo $sub_totalp; ?></b></td>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		                <div class="text-right"><?php echo $links?></div>
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
	</section>
</div>
 <!-- Product Report End -->
