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

   
         <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('unit_list') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('unit_name') ?></th>
                                        <?php
                                          if ($this->permission1->method('unit_list', 'update')->access() || $this->permission1->method('unit_list', 'delete')->access()){
                                         ?>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                            <?php
                                          }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                   foreach($unit as $units){
                                ?>
                               
                                    <tr>
                                        <td class="text-center"><?php echo $units['unit_name']?></td>
                                        <?php
                                        if ($this->permission1->method('unit_list', 'update')->access() || $this->permission1->method('unit_list', 'delete')->access()){
                                        ?>
                                        <td>
                                            <center>
                                                <?php
                                                if ($this->permission1->method('unit_list', 'update')->access()){
                                                ?>
                                                  <a href="<?php echo base_url().'Cproduct/unit_form/'.$units['id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php }?>

                                                <?php
                                                if ($this->permission1->method('unit_list', 'delete')->access()){
                                                ?>
                                                <a onclick="return confirm('Are You Sure to Want To Delete ?')" href="<?php echo base_url().'Cproduct/delete_unit/'.$units['id']; ?>" class="btn btn-danger btn-sm" name="{type_id}"  data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                <?php }?>
                                            </center>
                                        </td>
                                        <?php } ?>
                                    </tr>
                               
                                <?php
                                   $sl++; }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  

    </section>
</div>




