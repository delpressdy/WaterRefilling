<!-- Admin Home Start -->
 <div class="content-wrapper">
    <!-- Content Header(Page header)-->
    <section class="content-header">
        <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home')?></a></li>
                <li class="active"><?php echo display('dashboard')?></li>
            </ol>
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
        <!-- First Counter -->
        <div class="row">

           <?php
            if($this->permission1->method('manage_customer','read')->access()){ ?>
               <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="count-number"><?php echo $total_customer?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
                            <div class="small"><?php echo display('total_customer')?></div>
                            <div class="sparkline1 text-center"></div>
                        </div>
                    </div>
                </div>
               </div>
            <?php } ?>

            <?php
            if($this->permission1->method('manage_medicine','read')->access()){ ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="count-number"><?php echo $total_product?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
                            <div class="small"><?php echo 'Total Items';?></div>
                            <div class="sparkline1 text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
           <?php } ?>


             <?php
             if($this->permission1->method('manage_manufacturer','read')->access()) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                 <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="count-number"><?php echo $total_sales ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> </span></h2>
                            <div class="small"><?php echo 'Total Delivery';?></div>
                            <div class="sparkline1 text-center"></div>
                        </div>
                    </div>
                 </div>
                </div>
             <?php } ?>


                <?php
                if($this->permission1->method('manage_invoice','read')->access()) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="count-number"><?php echo $sales_amount ?></span><span class="slight"> <i class="fa fa-play fa-rotate-270 text-warning"> </i> </span></h2>
                            <div class="small"><?php echo 'Earnings'?></div>
                            <div class="sparkline1 text-center"></div>
                        </div>
                    </div>
                </div>
                </div>
                <?php } ?>

        </div>
        <hr>
        <!-- Second Counter -->
        <div class="row">

<!--          <?php
         if($this->permission1->method('pos_invoice','create')->access()) { ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight" style="margin-left: 70px;">
                                <img src="<?php echo base_url('my-assets/image/pos_invoice.png');?>" height="40" width="40" >
                             </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Cinvoice/pos_invoice')?>"><?php echo display('create_pos_invoice')?></a></div>
                        </div>
                    </div>
                </div>
            </div>
          <?php } ?> -->





                <?php
                if($this->permission1->method('new_invoice','create')->access()) { ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                         <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/invoice.png');?>" height="40" width="40" > </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Cinvoice')?>"><?php echo 'New Delivery'?></a></div>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?>


                <?php
                if($this->permission1->method('add_medicine','create')->access()) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                         <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/product.png');?>" height="40" width="40" > </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Cproduct')?>"><?php echo 'Add Item';?></a></div>
                        </div>
                    </div>
                </div>
                </div>
                <?php } ?>


          <?php
           if($this->permission1->method('add_customer','create')->access()) { ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                         <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/customer.png');?>" height="40" width="40" > </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Ccustomer')?>"><?php echo display('add_customer')?></a></div>
                        </div>
                    </div>
                </div>
            </div>
         <?php } ?>

         <?php
        if($this->permission1->method('sales_report','read')->access()){ ?>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/sale.png');?>" height="40"> </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>"><?php echo display('sales_report')?></a></div>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?>

        </div>

        <!-- Third Counter -->
        <div class="row">

         


           <!-- <?php
            if($this->permission1->method('purchase_report','read')->access()){ ?>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/purchase.png');?>" height="40"> </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Admin_dashboard/todays_purchase_report')?>"><?php echo display('purchase_report')?></a></div>
                        </div>
                    </div>
                </div>
            </div>
           <?php } ?> -->


                <!-- <?php
                if($this->permission1->method('stock_report','read')->access()){ ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/stock.png');?>" height="40"> </span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Creport')?>"><?php echo display('stock_report')?></a></div>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?> -->


                <!-- <?php
                if($this->permission1->method('todays_report','read')->access()){ ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <h2><span class="slight" style="margin-left: 70px;"><img src="<?php echo base_url('my-assets/image/account.png');?>" height="40"></span></h2>
                            <div class="small" style="font-size: 17px;margin-top: 20px;text-align: center;"><a href="<?php echo base_url('Admin_dashboard/all_report')?>"><?php echo display('todays_report')?></a></div>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?> -->

        </div>
        <hr>
        <div class="row">
            <!-- This month progress -->
            <div class="col-sm-12 col-md-8">
                <?php
                if($this->permission1->method('monthly_progress_report','read')->access()){ ?>
                <div class="panel panel-bd">
                    <!-- <div class="panel-heading">
                        <div class="panel-title">
                            <h4> <?php echo display('monthly_progress_report')?></h4>
                        </div>
                    </div> -->
                    <div class="panel-body">
                        <canvas id="lineChart" height="142"></canvas>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="col-sm-12 col-md-8">
                <?php
                if($this->permission1->method('monthly_progress_report','read')->access()){ ?>
                <div class="panel panel-bd">
                    <!-- <div class="panel-heading">
                        <div class="panel-title">
                            <h4> <?php echo display('monthly_progress_report')?></h4>
                        </div>
                    </div> -->
                    <div class="panel-body">
                        <canvas id="lineChart2" height="142"></canvas>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Total Report -->
            <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <?php
                if($this->permission1->method('todays_report','read')->access()){ ?>
                <div class="panel panel-bd lobidisable">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('todays_report')?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="message_inner">
                            <div class="message_widgets">
                                
                                <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th><?php echo display('todays_report')?></th>
                                    <th><?php echo display('amount')?></th>
                                </tr>
                                    <tr>
                                        <th><?php echo display('total_sales')?></th>
                                        <td><?php echo (($position==0)?"$currency $sales_amount":"$sales_amount $currency") ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo display('total_purchase')?></th>
                                        <td><?php echo (($position==0)?"$currency $purchase_amount":"$purchase_amount $currency") ?></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div> -->
        </div>

    </section> <!-- /.content -->

     <?php if($this->session->userdata('user_type') == '1')
     {
     ?>
   <div id="stockmodal" class="modal fade" role="dialog">
     <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo display('out_of_stock_and_date_expired_medicine')?></h4>
              </div>
      <div class="modal-body">
        <?php
         $date=date('Y-m-d');
        $this->db->select('a.expeire_date as expdate,a.*,b.*,c.*');
        $this->db->from('product_purchase_details a');
        $this->db->join('product_information c','c.product_id=a.product_id');
        $this->db->join('view_m_total_batch_stock b','b.batch_id=a.batch_id');
        $this->db->where('a.expeire_date <=', $date);
        $this->db->group_by('a.product_id');
        $this->db->group_by('b.batch_id');
        $query = $this->db->get()->result_array();
        ?>
       <table id="" class="table table-bordered table-striped table-hover">
         <caption> <h4><center>Date Expired Medicine</center></h4></caption>
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('product_name') ?></th>
                                        <th class="text-center"><?php echo display('batch_id') ?></th>
                                        <th class="text-center"><?php echo display('expeire_date') ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ($query) {
                                        foreach ($query as $out) {
                                 
                                ?>
                               
                                    <tr>
                                      
                                        <td class="text-center">
                                            <a href="<?php echo base_url().'Cproduct/product_details/'.$out['product_id']; ?>">
                                           <?php echo $out['product_name']?> 
                                            </a>    
                                        </td>
                                        <td class="text-center"> <?php echo $out['batch_id']?> </td>
                                        <td class="text-center"><?php echo $out['expdate']?>
                                     <input type="hidden" id="expdate" value="<?php echo $out['expdate']?>">
                                         </td>
                                        
                                    </tr>
                             <?php     }
                             ?>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>

                           <?php 
                            $this->db->select('a.*, (sum(b.Purchase) - sum(b.sell)) as stock');
                            $this->db->from('product_information a');
                            $this->db->join('view_l_stock_history b','b.product_id = a.product_id','left',true);
                            $this->db->group_by('a.product_id');
                            $this->db->having('stock < 10', null, false);
                            $this->db->order_by('a.product_id','desc');
                            $out_of_stock = $this->db->get()->result_array();
                            ?>
        <table id="" class="table table-bordered table-striped table-hover">
             <caption> <h4><center>Out of Stock Medicine</center></h4></caption>
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('product_name') ?></th>
                                        <th class="text-center"><?php echo display('product_type') ?></th>
                                        <th class="text-center"><?php echo display('unit') ?></th>
                                        <th class="text-center"><?php echo display('stock') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ($out_of_stock) {
                                        foreach ($out_of_stock as $stockout) { ?>
                                       
                            
                                    <tr>
                                        
                                        <td class="text-center">
                                            <a href="<?php echo base_url().'Cproduct/product_details/{product_id}'; ?>">
                                           <?php echo $stockout['product_name']?> 
                                            </a> 
                                            <input type="hidden" id="stockqty" value="<?php echo $stockout['stock']?>">   
                                        </td>
                                        <td class="text-center"><?php echo $stockout['product_model']?> </td>
                                        <td class="text-center"><?php echo $stockout['unit']?></td>
                                        <td class="text-center"><span style="color:red"><?php echo $stockout['stock']?></span></td>
                                    </tr>
                                <?php  }
                                ?>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="is_modal_shown" id="is_modal_shown" value="<?php echo $this->session->userdata('is_modal_shown');?>">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:green;color:white"><?php echo display('close')?></button>
          </div>
        </div>
     </div>
  </div>

     <?php } ?>

</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->
 
<!-- ChartJs JavaScript -->
<script src="<?php echo base_url()?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>

<script type="text/javascript"> 
    //line chart
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
            datasets: [
                {
                    label: "Delivery",
                    borderColor: "#f91b1b",
                    borderWidth: "1",
                    backgroundColor: "#f91b1b",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php foreach ($inv_jan as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_feb as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_mar as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_apr as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_may as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_jun as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_jul as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_aug as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_sep as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_oct as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_nov as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_dec as  $value){echo $value['invoice_id'];} ?>
                    ]
                },
                // {
                //     label: "Delivery",
                //     borderColor: "#73BC4D",
                //     borderWidth: "1",
                //     backgroundColor: "#73BC4D",
                //     pointHighlightStroke: "rgba(26,179,148,1)",
                //     data: [<?php foreach ($pur_jan as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_feb as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_mar as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_apr as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_may as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_jun as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_jul as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_aug as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_sep as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_oct as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_nov as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_dec as  $value){echo $value['purchase_id'];} ?>
                //     ]
                // }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    }); 





    var ctx = document.getElementById("lineChart2");
    var myChart2 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
            datasets: [
                {
                    label: "Earnings",
                    borderColor: "#165eed",
                    borderWidth: "1",
                    backgroundColor: "#165eed",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php foreach ($inv_jan as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_feb as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_mar as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_apr as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_may as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_jun as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_jul as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_aug as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_sep as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_oct as  $value){echo $sales_amount;} ?>,<?php foreach ($inv_nov as  $value){echo $value['invoice_id'];} ?>,<?php foreach ($inv_dec as  $value){echo $value['invoice_id'];} ?>
                    ]
                },

                // {
                //     label: "Delivery",
                //     borderColor: "#73BC4D",
                //     borderWidth: "1",
                //     backgroundColor: "#73BC4D",
                //     pointHighlightStroke: "rgba(26,179,148,1)",
                //     data: [<?php foreach ($pur_jan as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_feb as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_mar as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_apr as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_may as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_jun as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_jul as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_aug as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_sep as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_oct as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_nov as  $value){echo $value['purchase_id'];} ?>,<?php foreach ($pur_dec as  $value){echo $value['purchase_id'];} ?>
                //     ]
                // }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    }); 





 var  dismodl=$('#is_modal_shown').val();
 var  stockqt=$('#stockqty').val();
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 
today = yyyy + '-' + mm + '-' + dd;

 var  expdate=$('#expdate').val();
 var is_modal_shown = 1;
 if (dismodl == '' && stockqt > 0 || dismodl == '' && new Date(expdate) > new Date(today)){
     $(window).load(function(){        
     $('#stockmodal').modal('show');
    });
      $.ajax
       ({ 
            type: "POST",
            url: '<?php echo base_url('User/modaldisplay')?>',
            data: {is_modal_shown:is_modal_shown},
            cache: false,
            success: function(data)
            {
            } 
        });
     }


</script>