<!-- Manage Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('manage_invoice') ?></li>
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
                    if($this->permission1->method('new_invoice','create')->access()): ?>
                      <a href="<?php echo base_url('Cinvoice')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo 'New Order'?> </a>
                    <?php endif;?>

                   <!--  <?php
                    if($this->permission1->method('pos_invoice','create')->access()): ?>
                    <a href="<?php echo base_url('Cinvoice/pos_invoice')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('pos_invoice')?> </a>
                    <?php endif;?> -->

                </div>
            </div>
        </div>

        <?php
        if($this->permission1->method('manage_invoice','read')->access() || $this->permission1->method('manage_invoice','update')->access() || $this->permission1->method('manage_invoice','delete')->access()) { ?>
        <!-- date between search -->
        <div class="row">
            <div class="col-sm-7">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php echo form_open('Cinvoice/date_to_date_invoice',array('class' => 'form-inline'))?>
                        <?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" style="width:120px;height:32px" id="from_date" value="<?php echo $today?>" placeholder="<?php echo display('start_date') ?>" >
                        </div>

                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" style="width:120px;height:32px" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today?>">
                        </div>
                        <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                        <?php echo form_close()?>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php echo base_url('Cinvoice/manage_invoice_invoice_id')?>" class="form-inline" method="post" accept-charset="utf-8">
                            <label for="invoice_no"><?php echo display('invoice_no')?></label>
                            <input type="text" class="form-control" name="invoice_no" placeholder="<?php echo display('invoice_no') ?>">
                            <button type="submit" class="btn btn-primary btn-sm"><?php echo display('search')?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <!-- Manage Invoice report -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="dataTableExample4" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('invoice_no') ?></th>
                                        <th><?php echo display('payment_type') ?></th>
                                        <th><?php echo display('customer_name') ?></th>
                                        <th><?php echo 'Delivery' ?></th>
                                        <th class="text-danger"><?php echo 'Status' ?></th>
                                        <th><?php echo display('total_amount') ?></th>
                                        <?php
                                        if ($this->permission1->method('invoice', 'read')->access() || $this->permission1->method('invoice', 'update')->access() || $this->permission1->method('invoice', 'delete')->access()) {
                                            ?>
                                            <th><?php echo display('action') ?></th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($invoices_list) {
                                        ?>
                                        {invoices_list}
                                        <tr>
                                            <td>{sl}</td>

                                            <?php
                                            if($this->permission1->method('manage_customer','read')->access()) { ?>
                                                <td><a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>">{invoice}</a></td>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <td>{invoice}</td>
                                             <?php
                                            }
                                            ?>

                                   
                                                <td>{payment_type}</td>
                                                

                                            <?php
                                            if($this->permission1->method('manage_customer','read')->access()) { ?>
                                            <td>
                                              <a href="<?php echo base_url() . 'Ccustomer/customerledger/{customer_id}'; ?>">{customer_name}</a>
                                            </td>
                                            <?php
                                            }
                                            else{
                                            ?>
                                                <td>{customer_name}</td>
                                            <?php
                                            }
                                            ?>



                                            <td>{final_date}</td>
                                            <td class="text-danger">{invoice_details}</td>
                                            <td style="text-align: right;"><?php echo(($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?></td>
                                                <td>
                                                    <center>
                                                        <!-- <?php
                                                        if($this->permission1->method('manage_invoice','read')->access() ){ ?>
                                                            <a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
                                                        <?php } ?> -->

                                                        <?php
                                                        if($this->permission1->method('pos_invoice', 'read')->access()){ ?>
                                                            <a href="<?php echo base_url() . 'Cinvoice/pos_invoice_inserted_data/{invoice_id}'; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('pos_invoice') ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>
                                                        <?php } ?>


                                                        <?php
                                                        if ($this->permission1->method('manage_invoice', 'update')->access()){ ?>
                                                            <a href="<?php echo base_url() . 'Cinvoice/invoice_update_form/{invoice_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <?php } ?>

                                                        <?php
                                                        if ($this->permission1->method('manage_invoice', 'delete')->access()){ ?>
                                                            <a href="<?php echo base_url("Cinvoice/invoice_delete/{invoice_id}")?>" onClick="alert('Are You Sure,Want to Delete ?')" class="deleteInvoice btn btn-danger btn-sm" name="{invoice_id}" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </center>
                                                </td>
                                        </tr>
                                        {/invoices_list}
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
<!-- Manage Invoice End -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Delete Invoice ajax code -->
<script type="text/javascript">
    //Delete Invoice Item
    //$(".deleteInvoice").click(function()
    //{
    //    var invoice_id=$(this).attr('name');
    //    var csrf_test_name=  $("[name=csrf_test_name]").val();
    //    var x = confirm("Are You Sure,Want to Delete ?");
    //    if (x==true){
    //        $.ajax
    //        ({
    //            type: "POST",
    //            url: '<?php //echo base_url('Cinvoice/invoice_delete')?>//',
    //            data: {invoice_id:invoice_id,csrf_test_name:csrf_test_name},
    //
    //            success: function(data)
    //            {
    //              //  $("#tab_up_cart").load(location.href+" #tab_up_cart>*","");
    //                location.reload();
    //            }
    //        });
    //    }
    //});

    $(document).ready(function(){
        //Datatable
        $("#dataTableExample4").DataTable( {
            dom:"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp", lengthMenu:[[10, 25, 50, -1], [10, 25, 50, "All"]], buttons:[ {
                extend: "copy", className: "btn-sm"
            }
                , {
                    extend: "csv", title: "InvoiceList", className: "btn-sm"
                }
                , {
                    extend: "excel", title: "InvoiceList", className: "btn-sm"
                }
                , {
                    extend: "pdf", title: "InvoiceList", className: "btn-sm"
                }
                , {
                    extend: "print", className: "btn-sm"
                }
            ],
            paging: false,
        });
    });
</script>