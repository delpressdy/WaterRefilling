<!-- <script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script> -->
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>
<style type="text/css">
     .hiddenRow {
  display: none;
}
</style>

<!-- Edit Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Delivery' ?></a></li>
                <li class="active"><?php echo 'Update' ?></li>
            </ol>
    </section>

    <?php
    if ($this->permission1->method('manage_invoice','update')->access()){ ?>
  <section class="content">
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
        <!-- Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <?php echo form_open('Cinvoice/invoice_update',array('class' => 'form-vertical','id'=>'invoice_update' ))?>
                    <div class="panel-body">

                        

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 220px"><?php echo 'Item' ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="130"><?php echo 'Batch #' ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo 'Stock Left' ?></th><!-- 
                                        <th class="text-center" width="120"><?php echo display('expiry') ?></th> -->
                                        <th class="text-center"><?php echo 'Weight' ?></th>
                                        <th class="text-center"><?php echo'Piece' ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('price') ?> <i class="text-danger">*</i></th>

                                        <?php if ($discount_type == 1) { ?>
                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                        <?php }elseif($discount_type == 2){ ?>
                                        <th class="text-center"><?php echo display('discount') ?> </th>
                                        <?php }elseif($discount_type == 3) { ?>
                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>

                                        <th class="text-center"><?php echo display('total') ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                <?php
                                if ($invoice_all_data) {
                                    foreach ($invoice_all_data as $invoice) {
                                        $batch_info = $this->db->select('batch_id')
                                                        ->from('product_purchase_details')
                                                        ->where('product_id',$invoice['product_id'])
                                                        ->get()
                                                        ->result();
                                ?>
                                <?php

                               $expire = $this->db->select('expeire_date')
                                                        ->from('product_purchase_details')
                                                        ->where('batch_id',$invoice['batch_id'])
                                                        ->group_by('batch_id')
                                                        ->get()
                                                        ->result();

                                ?>
                                    <tr>
                                        <td class="" style="width: 200px;">
                                            <input type="text" name="product_name" onkeyup="invoice_productList(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['product_name']?>-(<?php echo $invoice['product_model']?>)" class="form-control productSelection" required placeholder='<?php echo display('product_name') ?>' id="product_name_<?php echo $invoice['sl']?>" tabindex="<?php echo $invoice['sl']+2?>)">

                                            <input type="hidden" class="product_id_<?php echo $invoice['sl']?> autocomplete_hidden_value" name="product_id[]" value="<?php echo $invoice['product_id']?>" id="SchoolHiddenId"/>
                                        </td>
                                        <td>
                                            <select name="batch_id[]" id="batch_id_<?php echo $invoice['sl']?>" class="form-control" required="required" onchange="product_stock(<?php echo $invoice['sl']?>)" tabindex="<?php echo $invoice['sl']+3?>)">
                                                <?php foreach ($batch_info as $batch) {?>
                                                <option value="<?php echo $batch->batch_id; ?>" <?php if ($batch->batch_id == $invoice['batch_id']) {echo "selected"; }?>><?php echo $batch->batch_id; ?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_<?php echo $invoice['sl']?>" value="0" readonly="" id="available_quantity_<?php echo $invoice['sl']?>"/>
                                        </td>
                                        <!-- <td id="expire_date_<?php echo $invoice['sl']?>">
                                            <?php foreach ($expire as $vale) {
                                                echo $vale->expeire_date;
                                            }?>
                                        </td> -->
                                        <input type="hidden" name="expire_date_1">
                                         <td>
                                            <input name="" id="" class="form-control text-right unit_<?php echo $invoice['sl']?> valid" value="<?php echo $invoice['unit']?>" readonly="" aria-invalid="false" type="text">
                                        </td>
                                        <td>
                                            <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['quantity']?>" class="total_qntt_<?php echo $invoice['sl']?> form-control text-right" id="total_qntt_<?php echo $invoice['sl']?>" min="0" placeholder="0.00" tabindex="<?php echo $invoice['sl']+4?>)" />
                                        </td>

                                        <td>
                                            <input type="text" name="product_rate[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['rate']?>" id="price_item_<?php echo $invoice['sl']?>" class="price_item<?php echo $invoice['sl']?> form-control text-right" min="0" required="" placeholder="0.00" readonly/>
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text" name="discount[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);"  onchange="quantity_calculate(<?php echo $invoice['sl']?>);" id="discount_<?php echo $invoice['sl']?>" class="form-control text-right" placeholder="0.00" value="<?php echo $invoice['discount']?>" min="0" tabindex="<?php echo $invoice['sl']+5?>)"/>

                                            <input type="hidden" value="<?php echo $discount_type?>" name="discount_type" id="discount_type_<?php echo $invoice['sl']?>">
                                        </td>

                                        <td>
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $invoice['sl']?>" value="<?php echo $invoice['total_price']?>" readonly="readonly" />

                                            <input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="<?php echo $invoice['invoice_details_id']?>"/>
                                        </td>
                                         <td>

                                            <!-- Tax calculate start-->
                                            <?php $x=0;
                                            foreach($taxes as $taxfldt){?>
                                            <input id="total_tax<?php echo $x;?>_<?php echo $invoice['sl']?>" class="total_tax<?php echo $x;?>_<?php echo $invoice['sl']?>" type="hidden">
                                            <input id="all_tax<?php echo $x;?>_<?php echo $invoice['sl']?>" class="total_tax<?php echo $x;?>" type="hidden" name="tax[]">
                                             <?php $x++;} ?>
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_<?php echo $invoice['sl']?>" class="" value="<?php echo $invoice['discount']?>"/>

                                            <input type="hidden" id="all_discount_<?php echo $invoice['sl']?>" class="total_discount" value="<?php echo $invoice['discount'] * $invoice['quantity']?>" />
                                            <!-- Discount calculate end -->

                                           <!--  <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="<?php echo $invoice['sl']+6?>)"><i class="fa fa-close"></i></button> -->
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>

                                       <tfoot>
                                    
                                    <tr>
                                        <td colspan="7" rowspan="2">
                                        <center><label id="warning" style="text-align:center;" for="details" class="col-form-label text-danger"><?php echo '************DELIVERY STATUS************' ?></label></center>
                                        <textarea name="inva_details" class="form-control" placeholder="<?php echo display('invoice_details') ?>">{invoice_details}</textarea>
                                    </td>
                                        <!-- <td style="text-align:right;" colspan="1"><b><?php echo display('invoice_discount') ?>:</b></td> -->

                                      <input type="hidden" id="invdcount" class="form-control text-right" name="invdcount" onkeyup="calculateSum(),checknum();" onchange="calculateSum()" placeholder="0.00" value="{invoice_discount}" />
                                            <input type="hidden" name="invoice_id" id="invoice_id" value="{invoice_id}"/>
                                        <!-- <td> 
                                            <button style="text-align: right;" class="btn btn-info" type="button" onClick="addInputField('addinvoiceItem');" tabindex="12" id="add_invoice_item"><i class="fa fa-plus"></i>
                                            </button>

                                        </td> -->
                                    </tr>

                                    <tr>
                                        <td colspan="1"  style="text-align:right;"><b><?php echo display('total_discount') ?>:</b></td>
                                        <td class="text-right">
                                           <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount"  readonly="readonly" value="{total_discount}"/>
                                              <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                    </tr>
                                         <?php $i=0;
                                     foreach($taxes as $taxfldt){?>
                                    <tr class="hideableRow hiddenRow">
                                       
                                <td style="text-align:right;" colspan="8"><b><?php echo $taxfldt['tax_name'] ?></b></td>
                                <td class="text-right">
                                    <input id="total_tax_amount<?php echo $i;?>" tabindex="-1" class="form-control text-right valid totalTax" name="total_tax<?php echo $i;?>" value="<?php $txval ='tax'.$i;
                                     echo $taxvalu[0][$txval]?>" readonly="readonly" aria-invalid="false" type="text">
                                    
                                </td>
                               
                               
                                 
                                </tr>
                            <?php $i++;}?>
                             <td class="text-right">
                                            <input id="total_tax_amount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="{total_tax}" readonly="readonly" aria-invalid="false" type="hidden">
                                        </td>
                                    
                                             <input type="hidden" id="grandTotal" class="form-control text-right" name="grand_total_price" value="<?php $grandttl=$total_amount;
                                            echo $grandttl; ?>" readonly="readonly" />
                                              <input type="hidden" id="txfieldnum" value="<?php echo count($taxes);?>">
                                    <tr>
                                    <input type="hidden" id="previous" class="form-control text-right" name="previous" value="{prev_due}" readonly="readonly" />
                                <tr>
                                    <td colspan="8"  style="text-align:right;"><b><?php echo 'Earnings'; ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="n_total" class="form-control text-right" name="n_total" value="{total_amount}" readonly="readonly" placeholder="" />
                                    </td>
                                </tr>

                                        <td style="text-align:right;" colspan="8"><b><?php echo display('paid_ammount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="paidAmount"
                                            onkeyup="calculateSum(),checknum();" class="form-control text-right" name="paid_amount" placeholder="0.00" tabindex="13" value="{paid_amount}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td align="center">
                                            <input type="button" id="full_paid_tab" class="btn btn-warning" value="<?php echo display('full_paid') ?>" tabindex="14" onClick="full_paid()"/>
                                        </td> -->
                                            

                                       
                                        <td class="text-right">
                                            <input type="hidden" id="dueAmmount" class="form-control text-right" name="due_amount" value="{due_amount}" readonly="readonly"/>
                                        </td>
                                    </tr>
                                    <tr id="change_m"><td style="text-align:right;" colspan="8" id="ch_l"><b>Change:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="change" class="form-control text-right" name="change" value="" readonly="readonly"/>
                                        </td></tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">

                                         <input type="text" size="100"  name="customer_name" class=" form-control" placeholder='<?php echo display('customer_name').'/'.display('phone') ?>' id="customer_name" value="{customer_name}" tabindex="1" onkeyup="customer_autocomplete()"/>

                                        <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" name="customer_id" value="{customer_id}">
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                        echo display('payment_type');
                                        ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name="paytype" class="form-control" required="" onchange="bank_paymet(this.value)">
                                            <option value="">Select Payment Option</option>
                                            <option value="1" <?php if($paytype ==1){echo 'selected';}?>>Cash Payment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo 'Delivery' ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control datepicker" name="invoice_date" value="{date}"  required />
                                    </div>
                                </div>
                            </div>
                               <div class="col-sm-6" id="bank_div" style="display: <?php if($paytype == 2){echo 'block';}else{echo 'none';}?>;">
                            <div class="form-group row">
                                <label for="bank" class="col-sm-4 col-form-label"><?php
                                    echo display('bank');
                                    ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                   <select name="bank_id" class="form-control"  id="bank_id">
                                        <option value="">Select Location</option>
                                        <?php foreach($bank_list as $bank){?>
                                            <option value="<?php echo $bank['bank_id']?>" <?php if($bank['bank_id'] == $bank_id){echo 'selected';}?>><?php echo $bank['bank_name'];?></option>
                                        <?php }?>
                                    </select>
                                 
                                </div>
                             
                            </div>
                        </div>
                        </div>

                        <input type="submit" id="add_invoice" class="btn btn-success" name="add-invoice" value="<?php echo display('save_changes') ?>" tabindex="15"/>

                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
   <?php
    }
    else{
    ?>
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('You do not have permission to access. Please contact with administrator')?></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<!-- Edit Invoice End -->

<style type="text/css">
    .btn:focus {
      background-color: #6A5ACD;
    }
</style>

<script type="text/javascript">
      function bank_paymet(val){
        if(val==2){
           var style = 'block'; 
           document.getElementById('bank_id').setAttribute("required", true);
        }else{
   var style ='none';
    document.getElementById('bank_id').setAttribute("required", false);
        }
           
    document.getElementById('bank_div').style.display = style;
    }

</script>
<!-- Invoice Report End -->

<script type="text/javascript">
    $('.ac').click(function () {
     $('.customer_hidden_value').val('');
 });
$('#myRadioButton_1').click(function () {
     $('#customer_name').val('');
 });

$('#myRadioButton_2').click(function () {
     $('#customer_name_others').val('');
 });
$('#myRadioButton_2').click(function () {
     $('#customer_name_others_address').val('');
 });

// $(document).ready(function warning(){
//     $('#warning').fadeOut(500);
//     $('#warning').fadeIn(1000);
//     setInterval(warning, 2000);
// });

</script>
<script type="text/javascript">
$(document ).ready(function() {
    $('#normalinvoice .toggle').on('click', function() {
    $('#normalinvoice .hideableRow').toggleClass('hiddenRow');
  })
});
function product_stock(sl) {

            var  batch_id=$('#batch_id_'+sl).val();
            var dataString = 'batch_id='+ batch_id;
            var base_url    = $('.baseUrl').val();
            var available_quantity    = 'available_quantity_'+sl;
            var product_rate    = 'product_rate_'+sl;
            var expire_date    = 'expire_date_'+sl;
             $.ajax({
                type: "POST",
                url: base_url+"Cinvoice/retrieve_product_batchid",
                data: dataString,
                cache: false,
                success: function(data)
                {
                    obj = JSON.parse(data);

                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();

                    if(dd<10){
                        dd='0'+dd;
                    }
                    if(mm<10){
                        mm='0'+mm;
                    }
                    var today = yyyy+'-'+mm+'-'+dd;

                    aj = new Date(today);
                    exp = new Date(obj.expire_date);

                    // alert(today);

                    if (aj >= exp) {

                     alert('<?php echo display('date_expired_please_choose_another')?>');
                      $('#batch_id_'+sl)[0].selectedIndex = 0;


                      $('#'+expire_date).html('<p style="color:red;align:center">'+obj.expire_date+'</p>');
                       document.getElementById('expire_date_'+sl).innerHTML = '';


                    }else{
                       $('#'+expire_date).html('<p style="color:green;align:center">'+obj.expire_date+'</p>');
                    }
                    $('#'+available_quantity).val(obj.total_product);

                }
             });

            $(this).unbind("change");
            return false;



}


  function checkqty(sl)
{

  var quant=$("#total_qntt_"+sl).val();
  var price=$("#price_item_"+sl).val();
  var dis=$("#discount_"+sl).val();
  if (isNaN(quant))
  {
    alert("<?php echo display('must_input_numbers')?>");
    document.getElementById("total_qntt_"+sl).value = '';
     //$("#quantity_"+sl).val() = '';
    return false;
  }
  if (isNaN(price))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("price_item_"+sl).value = '';
    return false;
  }
  if (isNaN(dis))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("discount_"+sl).value = '';
    return false;
  }
}
//discount and paid check
function checknum(){
      var dis=$("#invdcount").val();
      var paid=$("#paidAmount").val();
      if (isNaN(dis))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("invdcount").value = '';
    return false;
  }
  if (isNaN(paid))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("paidAmount").value = '';
    return false;
  }
    }
</script>
<script type="text/javascript">
function customer_due(id){
        $.ajax({
            url: '<?php echo base_url('Cinvoice/previous')?>',
            type: 'post',
            data: {customer_id:id}, 
            success: function (msg){
                $("#previous").val(msg);
            },
            error: function (xhr, desc, err){
                 alert('failed');
            }
        });        
    }


function customer_autocomplete(sl) {

    var customer_id = $('#customer_id').val();
    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var customer_name = $('#customer_name').val();
         
        $.ajax( {
          url: "<?php echo base_url('Cinvoice/customer_autocomplete')?>",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            customer_id:customer_name,
          },
          success: function( data ) {
              // alert(data);
            response( data );

          }
        });
      },
       focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
       },
       select: function( event, ui ) {
            $(this).parent().parent().find("#autocomplete_customer_id").val(ui.item.value); 
            var customer_id          = ui.item.value;
            customer_due(customer_id);

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keydown.autocomplete', '#customer_name', function() {
       $(this).autocomplete(options);
   });

}

</script>
<script type="text/javascript">

function invoice_productList(sl) {

   var priceClass = 'price_item'+sl;
    
        var unit = 'unit_'+sl;
        var tax = 'total_tax_'+sl;
        var discount_type = 'discount_type_'+sl; 
        var batch_id = 'batch_id_'+sl;

    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var product_name = $('#product_name_'+sl).val();
        $.ajax( {
          url: "<?php echo base_url('Cinvoice/autocompleteproductsearch')?>",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            product_name:product_name,
          },
          success: function( data ) {
            response( data );

          }
        });
      },
       focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
       },
       select: function( event, ui ) {
            $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
            //var sl = $(this).parent().parent().find(".sl").val(); 
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();

                $.ajax
                   ({
                        type: "POST",
                        url: base_url+"Cinvoice/retrieve_product_data_inv",
                        data: dataString,
                        cache: false,
                        success: function(data)
                        {
                            var obj = jQuery.parseJSON(data);
                                for (var i = 0; i < (obj.txnmber); i++) {
                            var txam = obj.taxdta[i];
                            var txclass = 'total_tax'+i+'_'+sl;
                           $('.'+txclass).val(txam);
                            }

                         $('.'+priceClass).val(obj.price);
                            $('.'+unit).val(obj.unit);
                            $('.'+tax).val(obj.tax);
                            $('#txfieldnum').val(obj.txnmber);
                            $('#'+discount_type).val(obj.discount_type);
                            $('#'+batch_id).html(obj.batch);
                            
                            //This Function Stay on others.js page
                            quantity_calculate(sl);
                            
                        } 
                    });

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keydown.autocomplete', '.productSelection', function() {
       $(this).autocomplete(options);
   });

}

</script>
