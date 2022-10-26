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
            $error_message = (!empty(validation_errors())?validation_errors():$this->session->userdata('error_message'));
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_unit') ?> </h4>
                             
                        </div>
                    </div>
                 
                    <div class="panel-body">
                         <div class="row">
                    <div class="col-md-9 col-sm-12">

                    	      <?php echo form_open('Cproduct/unit_form/','class="form-inner"') ?>

                            <div class="form-group row">
                                <label for="unit_name" class="col-xs-3 col-form-label"><?php echo display('unit_name')?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="unit_name"  type="text" class="form-control" id="unit_name" placeholder="<?php echo display('unit_name')?>">
                                </div>
                            </div>

                          


                            <!--Radios-->
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                        <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="" class="btn btn-success btn-large"
                                           name="" value="<?php echo display('save') ?>"/>
                                </div>
                            </div>

                        <?php echo form_close() ?>
</div>
</div>

                    </div>
                    
                </div>
            </div>
        </div>
         


 
    </section>
</div>
