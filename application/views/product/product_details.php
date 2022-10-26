<!-- Product details page start -->
<div class="content-wrapper">
	<section class="content-header">
	    <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo 'Gallons Report' ?></li>
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

                  <a href="<?php echo base_url('Cproduct')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo 'Add Item'?> </a>


                  <a href="<?php echo base_url('Cproduct/manage_product')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo 'Manage Gallons'?> </a>

                </div>
            </div>
        </div>


        <?php
        if($this->permission1->method('manage_medicine','read')->access() ) { ?>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo 'Details'?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<h2> <span style="font-weight:normal;"><?php echo 'Item Name' ?>: </span><span style="color:#005580;">{product_name}</span></h2>
						<h4> <span style="font-weight:normal;"><?php echo 'Model' ?>:</span> <span style="color:#005580;">{product_model}</span></h4>
						<h4> <span style="font-weight:normal;"><?php echo display('price') ?>:</span> <span style="color:#005580;">
						<?php echo (($position==0)?"$currency {price}":"{price} $currency") ?></span></h4>
						<table class="table">
							
						</table>
		            </div>
		        </div>
		    </div>
		 </div>



        <?php
        }else{
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
<!-- Product details page end -->