<!-- Product Purchase js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- manufacturer Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/manufacturer.js.php" ></script>

<script src="<?php echo base_url()?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<style type="text/css">
    .close{color:white;}
</style>

<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Stockage' ?></a></li>
                <li class="active"><?php echo 'Add Stock' ?></li>
            </ol>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
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
                
            </div>
        </div>
        <?php
        if($this->permission1->method('add_purchase','create')->access()){ ?>
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_purchase') ?></h4>
                        </div>
                    </div>

                    <div class="panel-body">
                    <?php echo form_open_multipart('Cpurchase/insert_purchase',array('class' => 'form-vertical', 'id' => 'insert_purchase','name' => 'insert_purchase'))?>
                        

                        <div class="row" id="manufacturer_info">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    
                                    </label>
                                    <div class="col-sm-4">
                                        <select name="manufacturer_id" id="manufacturer_id" class="form-control " required="required" tabindex="1" onchange="product_pur_or_list()"> 
                                          

                                           
                                            <?php 
                                            $manufacturer_id = $this->session->userdata('manufacturer_id');
                                            if ($all_manufacturer){ 
                                                foreach ($all_manufacturer as $manufac) {
                                            ?>
                                            <option value="<?php echo $manufac['manufacturer_id']?>" <?php if ($manufacturer_id == $manufac['manufacturer_id']){echo "selected";} ?>><?php echo $manufac['manufacturer_name']?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                   
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="hidden" tabindex="2" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="purdate" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        <input type="hidden" tabindex="3" class="form-control" name="chalan_no" value="<?php $rand = rand(10000,99999); echo $rand; ?>" id="invoice_no" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    
                                    <div class="col-sm-8">
                                        <textarea hidden> class="form-control" tabindex="4" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                              <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    
                                    <div class="col-sm-9">
                                        <select hidden> name="paytype" class="form-control" required="" onchange="bank_paymet(this.value)">
                                            <option value="1">Cash Payment</option>
                                            <option value="2">Bank Payment</option>
                                            <option value="3">Due Payment</option> 
                                        </select>
                                      

                                     
                                    </div>
                                 
                                </div>
                            </div>
                             <div class="col-sm-6" id="bank_div" style="display: none;">
                            <div class="form-group row">
                                <label for="bank" class="col-sm-4 col-form-label"><?php
                                    echo display('bank');
                                    ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                   <select name="bank_id" class="form-control"  id="bank_id">
                                        <option value="">Select Location</option>
                                        <?php foreach($bank_list as $bank){?>
                                            <option value="<?php echo $bank['bank_id']?>"><?php echo $bank['bank_name'];?></option>
                                        <?php }?>
                                    </select>
                                 
                                </div>
                             
                            </div>
                        </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                    <tr>
                                            <th class="text-center" width="20%"><?php echo 'Product' ?><i class="text-danger">*</i></th> 
                                            <th class="text-center"><?php echo 'Batch #' ?> <i class="text-danger">*</i></th>
                                             <th class="text-center"><?php echo 'Date' ?> <i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo 'Stock' ?></th>
                                            <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo 'Price' ?><i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo 'Total amount' ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <td class="span3 manufacturer">
                                           <input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list(1);" placeholder="Search item" tabindex="5" >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="sl" value="1">
                                        </td>
                                         <td>
                                                <input type="text" name="batch_id[]" id="batch_id_1" class="form-control text-right"  tabindex="6" value="<?php $id=rand(1,10); echo $id; ?>" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="expeire_date[]" id="expeire_date_1" class="form-control" tabindex="7"    value="<?php $date= date('Y-m-d'); echo $date; ?>" readonly>
                                            </td>

                                       <td class="wt">
                                                <input type="text" id="available_quantity_1" class="form-control text-right stock_ctn_1" placeholder="0.00" readonly/>
                                            </td>
                                        
                                            <td class="text-right">
                                                <input type="text" name="product_quantity[]" id="quantity_1" class="form-control text-right store_cal_1" onkeyup="calculate_store(1),checkqty(1);" onchange="calculate_store(1);" placeholder="0.00" value="" min="0" tabindex="8" required="required"/>
                                            </td>
                                            <td class="test">
                                                <input type="text" name="product_rate[]" onkeyup="calculate_store(1),checkqty(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="9" required="required" readonly/>
                                            </td>
                                           

                                            <td class="text-right">
                                                <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                            </td>
                                            <td>

                                               

                                                <button style="text-align: right;" class="btn btn-danger red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="10"><?php echo display('delete')?></button>
                                            </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <input type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField1('addPurchaseItem');" value="<?php echo display('add_new_item') ?>"  tabindex="11"/>

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                        <td style="text-align:right;" colspan="4"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('submit') ?>" />
                              
                            </div>
                        </div>
                    <?php echo form_close()?>
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
        <div id="purchase_csv_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Csv Purchase</h4>
      </div>
      <div class="modal-body">

                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo 'CSV Purchase'; ?><a href="<?php echo base_url('assets/data/csv/purchase_csv_sample.csv') ?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Download Sample File</a></h4>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                     <div class="col-sm-12"></div>
                      <?php echo form_open_multipart('Cpurchase/uploadCsv_Purchase',array('class' => 'form-vertical', 'id' => 'validate','name' => 'insert_csv_purchase'))?>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="upload_csv_file" class="col-sm-4 col-form-label"><?php echo display('upload_csv_file') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="upload_csv_file" type="file" id="upload_csv_file" placeholder="<?php echo display('upload_csv_file') ?>" required>
                                    </div>
                                </div>
                            </div>
                        
                       <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('submit') ?>" />
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                               
                            </div>
                        </div>
                        </div>
                          <?php echo form_close()?>
                    </div>
                    </div>
                  
               
     
      </div>
     
    </div>

  </div>
</div>
    </section>
</div>




<!-- Purchase Report End -->

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
    document.getElementById('bank_id').removeAttribute("required");
        }
           
    document.getElementById('bank_div').style.display = style;
    }

</script>
<script type="text/javascript">

function product_pur_or_list(sl) {

    var manufacturer_id = $('#manufacturer_id').val();
    if ( manufacturer_id == 0) {
        alert('<?php echo display('please_select_manufacturer');?> !');
        return false;
    }

    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var product_name = $('#product_name_'+sl).val();
        $.ajax( {
          url: "<?php echo base_url('Cpurchase/product_search_by_manufacturer')?>",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            manufacturer_id:$('#manufacturer_id').val(),
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
            var sl = $(this).parent().parent().find(".sl").val(); 

            var product_id          = ui.item.value;
          
          var  manufacturer_id=$('#manufacturer_id').val();
     
           
            var base_url    = $('.baseUrl').val();


            var available_quantity    = 'available_quantity_'+sl;
            var product_rate    = 'product_rate_'+sl;

           
         
         
            $.ajax({
                type: "POST",
                url: base_url+"Cinvoice/retrieve_product_data",
                 data: {product_id:product_id,manufacturer_id:manufacturer_id},
                cache: false,
                success: function(data)
                {
                    console.log(data);
                    obj = JSON.parse(data);
                   $('#'+available_quantity).val(obj.total_product);
                    $('#'+product_rate).val(obj.manufacturer_price);
                  
                } 
            });

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keydown.autocomplete', '.product_name', function() {
       $(this).autocomplete(options);
   });

}

</script>


<script type="text/javascript">

  // Counts and limit for purchase order
    var count = 2;
    var limits = 500;

    function addPurchaseOrderField1(divName){

  
        if (count == limits)  {
            alert("<?php echo display('you_have_reached_the_limit_of_adding')?> " + count + "<?php echo display('inputs')?> ");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="product_name_"+count;
             tabindex = count * 7 ,
           newdiv = document.createElement("tr");
            tab1 = tabindex + 1;
            
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tabindex + 6;
            tab7 = tabindex + 7;
            tab8 = tab7 + 1;
           
           


            newdiv.innerHTML ='<td class="span3 manufacturer"><input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list('+ count +');" placeholder="<?php echo display("product_name") ?>" id="product_name_'+ count +'" tabindex="'+tab1+'" > <input type="hidden" class="autocomplete_hidden_value product_id_'+ count +'" name="product_id[]" id="SchoolHiddenId"/>  <input type="hidden" class="sl" value="'+ count +'">  </td> <td> <input type="text" name="batch_id[]" id="batch_id_'+ count +'" tabindex="'+tab2+'" class="form-control text-right" required  tabindex="11" placeholder="<?php echo display('batch_id') ?>"/></td><td><input type="text" name="expeire_date[]" onchange="checkExpiredate('+ count +')" id="expeire_date_'+ count +'" required class="form-control datepicker" tabindex="'+tab3+'"  placeholder="<?php echo display('expeire_date') ?>"/> </td>  <td class="wt"> <input type="text" id="available_quantity_'+ count +'" class="form-control text-right stock_ctn_'+ count +'" placeholder="0.00" readonly/> </td><td class="text-right"><input type="text" name="product_quantity[]" tabindex="'+tab4+'" required  id="quantity_'+ count +'" class="form-control text-right store_cal_' + count + '" onkeyup="calculate_store(' + count + '),checkqty(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="" min="0"/>  </td><td class="test"><input type="text" name="product_rate[]" readonly required onkeyup="calculate_store('+ count +'),checkqty(' + count + ');" onchange="calculate_store('+ count +');" id="product_rate_'+ count +'" class="form-control product_rate_'+ count +' text-right" placeholder="0.00" value="" min="0" tabindex="'+tab5+'"/></td><td class="text-right"><input class="form-control total_price text-right total_price_'+ count +'" type="text" name="total_price[]" id="total_price_'+ count +'" value="0.00" readonly="readonly" /> </td><td> <input type="hidden" id="total_discount_1" class="" /><input type="hidden" id="all_discount_1" class="total_discount" /><button style="text-align: right;" class="btn btn-danger red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"tabindex="'+tab6+'"><?php echo display('delete')?></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            document.getElementById("add_invoice_item").setAttribute("tabindex", tab7);
            document.getElementById("add_purchase").setAttribute("tabindex", tab8);
        
           
            count++;
$(".datepicker").datepicker({ dateFormat:'yy-mm-dd' });
            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        }
    }

    //Calculate store product
    function calculate_store(sl) {
       
        var gr_tot = 0;
        var item_ctn_qty    = $("#quantity_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();

        var total_price     = item_ctn_qty * vendor_rate;
        $("#total_price_"+sl).val(total_price.toFixed(2));

       
        //Total Price
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        $("#grandTotal").val(gr_tot.toFixed(2,2));
    }
</script>



<!-- JS -->



<script type="text/javascript">
    function checkExpiredate(sl) {
        var purdates =  $("#purdate").val();
        var expiredate = $("#expeire_date_"+sl).val();
        var purchasedate = new Date(purdates);
        var expirydate = new Date(expiredate);
        if (expirydate <= purchasedate ) { 
            alert('<?php echo display('expiry_date_should_be_greater_than_puchase_date')?>');
          document.getElementById("expeire_date_"+sl).value = '';
            return false;
        }
        return true;
    }

     function checkqty(sl)
{
  
  var y=$("#quantity_"+sl).val();
  var x=$("#product_rate_"+sl).val();
  if (isNaN(y)){
    alert("<?php echo display('must_input_numbers')?>");
    document.getElementById("quantity_"+sl).value = '';
     //$("#quantity_"+sl).val() = '';
    return false;
  }
  if (isNaN(x)) 
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("product_rate_"+sl).value = '';
    return false;
  }
}
</script>