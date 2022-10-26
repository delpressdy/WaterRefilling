<div class="content-wrapper">
	<section class="content-header">
	    <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('manufacturer') ?></a></li>
                <li class="active"><?php echo display('manage_suppiler') ?></li>
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

                    <?php
                    if($this->permission1->method('manage_manufacturer','create')->access()) { ?>
                        <a href="<?php echo base_url('Cmanufacturer')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_manufacturer')?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>

        <?php
        if($this->permission1->method('manage_manufacturer','read')->access()){ ?>
            <!-- Manage manufacturer -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('manage_suppiler') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="dataTableExample4" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo display('manufacturer_id') ?></th>
                                        <th><?php echo display('manufacturer_name') ?></th>
                                        <th><?php echo display('address') ?></th>
                                        <th><?php echo display('mobile') ?></th>
                                        <th><?php echo display('details') ?></th>
                                        <?php
                                        if($this->permission1->method('manage_manufacturer','update')->access() || $this->permission1->method('manage_manufacturer','delete')->access()) { ?>
                                            <th><?php echo display('action') ?></th>
                                        <?php } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($manufacturers_list) {
                                        ?>
                                        {manufacturers_list}
                                        <tr>
                                            <td>{manufacturer_id}</td>
                                            <td>
                                                <a href="<?php echo base_url() . 'Cmanufacturer/manufacturer_ledger_info/{manufacturer_id}'; ?>">
                                                    {manufacturer_name}
                                                </a>
                                            </td>
                                            <td>{address}</td>
                                            <td>{mobile}</td>
                                            <td>{details}</td>
                                            <?php
                                            if($this->permission1->method('manage_manufacturer','update')->access() || $this->permission1->method('manage_manufacturer','delete')->access()) { ?>
                                                <td>
                                                    <center>
                                                        <?php
                                                        if($this->permission1->method('manage_manufacturer','update')->access()) { ?>
                                                            <a href="<?php echo base_url() . 'Cmanufacturer/manufacturer_update_form/{manufacturer_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <?php } ?>

                                                        <?php
                                                        if($this->permission1->method('manage_manufacturer','delete')->access()) { ?>
                                                            <a href="" class="deletemanufacturer btn btn-danger btn-sm" name="{manufacturer_id}" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </center>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        {/manufacturers_list}
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div class="text-right"><?php echo $links ?></div>
                            </div>
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
<!-- Manage Product End -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Delete Product ajax code -->
<script type="text/javascript">
	//Delete manufacturer
	$(".deletemanufacturer").click(function()
	{
		var manufacturer_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm("<?php echo display('are_you_sure_to_delete');?>");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: '<?php echo base_url('Cmanufacturer/manufacturer_delete')?>',
			data: {manufacturer_id:manufacturer_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{

			}
		});
		}
	});

	$(document).ready(function(){
        //Datatable
	    $("#dataTableExample4").DataTable( {
	        dom:"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp", lengthMenu:[[10, 25, 50, -1], [10, 25, 50, "All"]], buttons:[ {
	            extend: "copy", className: "btn-sm"
	        }
	        , {
	            extend: "csv", title: "ManufacturerList", className: "btn-sm"
	        }
	        , {
	            extend: "excel", title: "ManufacturerList", className: "btn-sm"
	        }
	        , {
	            extend: "pdf", title: "ManufacturerList", className: "btn-sm"
	        }
	        , {
	            extend: "print", className: "btn-sm"
	        }
	        ],
	        paging: false,
	    });
    });
</script>