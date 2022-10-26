<!-- Add new customer start -->
<div class="content-wrapper">
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

        
        <!-- New customer -->
        <?php
        if ($this->permission1->method('add_category', 'create')->access()) {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_category') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open('Ccategory/insert_category', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="category_name" class="col-sm-3 col-form-label"><?php echo display('category_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="category_name" id="category_name" type="text" placeholder="<?php echo display('category_name') ?>"  required="">
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-customer" class="btn btn-success btn-large"
                                           name="add-customer" value="<?php echo display('save') ?>"/>
                                </div>
                            </div>

                    </div>
                    <?php echo form_close()?>
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


        <?php
        if ($this->permission1->method('add_category', 'read')->access() || $this->permission1->method('add_category', 'update')->access() || $this->permission1->method('add_category', 'delete')->access()) {
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('manage_category') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('category_id') ?></th>
                                        <th class="text-center"><?php echo display('category_name') ?></th>

                                        <?php
                                        if ($this->permission1->method('add_category', 'update')->access() || $this->permission1->method('add_category', 'delete')->access()) {
                                            ?>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                            <?php
                                        }
                                        ?>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($category_list) {
                                        ?>
                                        {category_list}
                                        <tr>
                                            <td class="text-center">{category_id}</td>
                                            <td class="text-center">{category_name}</td>

                                            <?php
                                            if ($this->permission1->method('add_category', 'update')->access() || $this->permission1->method('add_category', 'delete')->access()) {
                                            ?>
                                                <td>
                                                    <center>
                                                        <?php
                                                           if ($this->permission1->method('add_category', 'update')->access()) {
                                                         ?>
                                                            <a href="<?php echo base_url() . 'Ccategory/category_update_form/{category_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($this->permission1->method('add_category', 'delete')->access()) {
                                                            ?>
                                                            <a href="" class="DeleteCategory btn btn-danger btn-sm" name="{category_id}" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </center>
                                                </td>
                                                <?php
                                            }
                                            ?>

                                        </tr>
                                        {/category_list}
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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
    </section>
</div>
<script type="text/javascript">
    //Delete Category 
    $(".DeleteCategory").click(function()
    {   
        var category_id=$(this).attr('name');
        var csrf_test_name=  $("[name=csrf_test_name]").val();
        var x = confirm("<?php echo display('are_you_sure_to_delete')?>");
        if (x==true){
        $.ajax
           ({
                type: "POST",
                url: '<?php echo base_url('Ccategory/category_delete')?>',
                data: {category_id:category_id,csrf_test_name:csrf_test_name},
                cache: false,
                success: function(datas)
                {
                    location.reload();
                } 
            });
        }
    });
</script>
<!-- Add new customer end -->



