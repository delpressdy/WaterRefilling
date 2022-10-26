
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
<style type="text/css">
	.prints{
		background-color: #31B404;
		color:#fff;
	}
</style>
<!-- Stock List Start -->
<div class="content-wrapper">
	<section class="content-header">
	     <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo 'Stockage' ?></a></li>
	            <li class="active"><?php echo 'View' ?></li>
	        </ol>
	</section>

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
		<div class="row">
            <div class="col-sm-12">
                <div class="column">

                   <!--  <?php
                    if($this->permission1->method('stock_report_manufacturer_wise','read')->access()){ ?>
                        <a href="<?php echo base_url('Creport/stock_report_manufacturer_wise')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_manufacturer_wise')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('stock_report_product_wise','read')->access()){ ?>
                        <a href="<?php echo base_url('Creport/stock_report_product_wise')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_product_wise')?> </a>
                    <?php } ?> -->

                </div>
            </div>
        </div>
        
		

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		                <div class="panel-title text-right">
		                    <?php echo form_open_multipart('Creport/index',array('class' => 'form-inline', 'id' => 'stock_reports'))?>

							<?php  $today = date('d-m-Y'); ?>
							
						
							<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
		                	
			            <?php echo form_close()?>

		                </div>
		           
		            <div class="panel-body">
						<div id="printableArea" style="margin-left:2px;">
							<!-- <div class="text-center">
								{company_info}
								<h3> {company_name} </h3>
								<h4 >{address} </h4>
								{/company_info}
								<h4> <?php echo display('stock_date') ?> : {date} </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div> -->
							
			                <div class="table-responsive" style="margin-top: 10px;" >
			                   <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="checkList">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo '#' ?></th>
											<th class="text-center"><?php echo 'Product' ?></th>
											<th class="text-center"><?php echo 'Manufacturer' ?></th>
											<th class="text-center"><?php echo 'Model'?></th>
											<th class="text-center"><?php echo display('sell_price') ?></th>
											<th class="text-center"><?php echo 'Gallon/Bottle'?></th>
											<th class="text-center"><?php echo 'Total Item' ?></th>
											<th class="text-center"><?php echo 'Sold' ?></th>
											<th class="text-center"><?php echo 'Item Left' ?></th>
											<th class="text-center"><?php echo 'Profits'?></th>
											<th class="text-center"><?php echo 'Profits(Containers)'?></th>
										</tr>
									</thead>
									<tbody>
										 <tfoot>
											<tr>
                <th colspan="8" style="text-align:right">Total:</th>
                <th id="stockqty"></th>
                  <th></th>  <th></th> 
            </tr>
											
										</tfoot> 
								
			                    </table>
			                </div>
			            </div>
		                
		            </div>
		        </div>
		    </div>
		</div>
       
	</section>
</div>

<script type="text/javascript">
$(document).ready(function() { 

    $('#checkList').DataTable({ 
             responsive: true,

             "aaSorting": [[ 1, "asc" ]],
             "columnDefs": [
                { "bSortable": false, "aTargets": [0,2,3,4,5,6,7,8,9,10] },

            ],
		   'processing': true,
           'serverSide': true,

		  
           'lengthMenu':[[10, 25, 50,100,250,500, "<?php echo $totalnumber;?>"], [10, 25, 50,100,250,500, "All"]],

             dom:"'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip", buttons:[ {
	            extend: "copy", className: "btn-sm prints"
	        }
	        , {
	            extend: "csv", title: "StockList", className: "btn-sm prints"
	        }
	        , {
	            extend: "excel", title: "StockList", className: "btn-sm prints"
	        }
	        , {
	            extend: "pdf", title: "StockList", className: "btn-sm prints"
	        }
	        , {
	            extend: "print", className: "btn-sm prints"
	        }
	        ],
	        
            'serverMethod': 'post',
            'ajax': {
               'url':'<?=base_url()?>Creport/CheckList'
            },
          'columns': [
             { data: 'sl' },
             { data: 'product_name' },
             { data: 'manufacturer_name' },
             { data: 'product_model'},
             { data: 'sales_price' },
             { data: 'purchase_p' },
             { data: 'totalPurchaseQnty' },
             { data: 'totalSalesQnty' },
             { data: 'stok_quantity',class:"stock" },
             { data: 'total_sale_price',class:"total_sale" },
             { data: 'purchase_total' ,class:"total_purchase"},
          ],

  "footerCallback": function(row, data, start, end, display) {
  var api = this.api();
 
  api.columns('.stock', {
    page: 'current'
  }).every(function() {
    var sum = this
      .data()
      .reduce(function(a, b) {
        var x = parseFloat(a) || 0;
        var y = parseFloat(b) || 0;
        return x + y;
      }, 0);
    $(this.footer()).html(sum);
  });

   api.columns('.total_sale', {
    page: 'current'
  }).every(function() {
    var sum = this
      .data()
      .reduce(function(a, b) {
        var x = parseFloat(a) || 0;
        var y = parseFloat(b) || 0;
        return x + y;
      }, 0);
    $(this.footer()).html(sum);
  });

     api.columns('.total_purchase', {
    page: 'current'
  }).every(function() {
    var sum = this
      .data()
      .reduce(function(a, b) {
        var x = parseFloat(a) || 0;
        var y = parseFloat(b) || 0;
        return x + y;
      }, 0);
    $(this.footer()).html(sum);
  });
}



    });




});




</script>
