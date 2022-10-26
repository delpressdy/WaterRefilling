<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('payroll') ?></h1>
            <small><?php echo display('manage_salary_setup') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('payroll') ?></a></li>
                <li class="active"><?php echo display('manage_salary_setup') ?></li>
            </ol>
        </div>
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
  <!--  table area -->
  <div class="col-sm-12">
    
    <div class="panel panel-default thumbnail"> 

      <div class="panel-body">
        <table width="100%" class="datatable table table-striped table-bordered table-hover"  id="dataTableExample3">
          <thead>
            <tr>
              <th><?php echo display('sl') ?></th>
              <th><?php echo display('employee_name') ?></th>
              <th><?php echo display('salary_type') ?></th>
              <th><?php echo display('date') ?></th>
              <th><?php echo display('action') ?></th>

            </tr>
          </thead>
          <tbody>
            <?php if (!empty($emp_sl_setup)) { ?>
              <?php $sl = 1; ?>
              <?php foreach ($emp_sl_setup as $que) { ?>
                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                  <td><?php echo $sl; ?></td>
                  <td><?php echo $que->first_name.' '.$que->last_name; ?></td>
                  <td><?php if($que->sal_type==1){
                    echo 'Hourly';
                  }else{
                    echo 'Salary';
                  } ?></td>
                  <td><?php echo $que->create_date; ?></td>
                  <td class="center"> 
       <?php if($this->permission1->method('manage_salary_setup','update')->access()){ ?>                         
                  <a href="<?php echo base_url("Cpayroll/salsetup_upform/$que->employee_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a> 
                <?php }?>
       <?php if($this->permission1->method('manage_salary_setup','delete')->access()){ ?>           
                  <a href="<?php echo base_url("Cpayroll/delete_salsetup/$que->employee_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>') "><i class="fa fa-trash"></i></a>
                   <?php }?>
                    </td>
                </tr>
                <?php $sl++; ?>
              <?php } ?> 
            <?php } ?> 
          </tbody>
        </table>  <!-- /.table-responsive -->
      </div>
    </div>
  </div>
</div>
    </section>
</div>



