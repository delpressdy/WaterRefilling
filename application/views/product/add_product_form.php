
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js" type="text/javascript"></script>
<!-- Add Product Start -->
<div class="content-wrapper">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Gallons' ?></a></li>
                <li class="active"><?php echo 'Add Gallons' ?></li>
            </ol>
    </section>

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
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php
                    if($this->permission1->method('manage_medicine','read')->access()) { ?>
                     <a href="<?php echo base_url('Cproduct/manage_product')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo 'Manage'?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

     <?php
     if($this->permission1->method('add_medicine','create')->access()) { ?>
        <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <?php echo form_open_multipart('Cproduct/insert_product',array('class' => 'form-vertical', 'id' => 'insert_product','name' => 'insert_product'))?>
                    <div class="panel-body">
                        <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-18">
                                        <select name="manufacturer_id" class="form-control" required="required" tabindex="12" id="" required>
                                            <?php
                                            $manufacturer_id = $this->session->userdata('manufacturer_id');
                                            if ($manufacturer){
                                                foreach ($manufacturer as $manufac) {
                                            ?>
                                            <option value="<?php echo $manufac['manufacturer_id']?>"<?php if ($manufacturer_id == $manufac['manufacturer_id']){echo "selected";}?>><?php echo $manufac['manufacturer_name']?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                         <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <input class="form-control" name="product_id" type="hidden" id="product_id" value="<?php $id=rand(10000,99999); echo $id; ?>"  tabindex="1" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>

                           <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="generic_name" class="col-sm-4 col-form-label"><?php echo 'Product Name' ?>  <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" tabindex="1" name="product_name" type="text" id="product_name" value="" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <div class="col-sm-8">
                                        <input class="form-control" name="generic_name" type="hidden" id="generic_name" value="<?php $petsa=date('M-d-Y h:s a'); echo $petsa; ?>" tabindex="2" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('image') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="file" tabindex="8" name="image" class="form-control" id="image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-4 col-form-label"><?php echo 'Size' ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="unit" type="number" id="unit" placeholder="Size" tabindex="3" min="0" max="50" required="required">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="box_size" class="col-sm-4 col-form-label"><?php echo 'Weight' ?>  <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="box_size" name="box_size" required="required" tabindex="4">
                                            <option value="">Select Unit</option>
                                             <?php
                                            if ($unit_list) {
                                        ?>
                                        {unit_list}
                                            <option value="{unit_name}">{unit_name}</option>
                                        {/unit_list}
                                        <?php
                                            }
                                        ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_location" class="col-sm-4 col-form-label"><?php echo 'Active/Inactive' ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" tabindex="5" name="product_location" type="text" id="product_location" placeholder="Active/Inactive">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="3" tabindex="6" placeholder="<?php echo display('details') ?>"></textarea>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row"><div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_model" class="col-sm-4 col-form-label"><?php echo 'Model' ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="category_id" name="type_name" required="required" tabindex="7">
                                        <option value=""><?php echo display('select_one') ?></option>
                                        <?php
                                            if ($type_list) {
                                        ?>
                                        {type_list}
                                            <option value="{type_name}">{type_name}</option>
                                        {/type_list}
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                         <input class="form-control text-right" name="price" type="text" onkeyup="Checkprice()" required="required" id="price" placeholder="0.00" tabindex="10" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="category_id" class="col-sm-4 col-form-label"><?php echo 'Category' ?></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="category_id" name="category_id" tabindex="9">
                                        <option value=""><?php echo display('select_one') ?></option>
                                        <?php
                                            if ($category_list) {
                                        ?>
                                        {category_list}
                                            <option value="{category_id}">{category_name}</option>
                                        {/category_list}
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo 'Gallon/Bottle Price' ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="13"  onkeyup="ProfitPrice(),checkmprice()" class="form-control text-right"   name="manufacturer_price" placeholder="0.00" required min="0" id="mprice"/>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                   <!--      <div class="row">
                             <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="tax" class="col-sm-4 col-form-label"><?php echo display('tax') ?> </label>
                                    <div class="col-sm-8">
                                       <select name="tax" class="form-control dont-select-me" tabindex="11">
                                                <option><?php echo display('select_one')?></option>
                                            <?php if ($tax_list){ ?>
                                            {tax_list}
                                                <option value="{tax}">{tax}%</option>
                                            {/tax_list}
                                            <?php } ?>
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                         <div class="row">
                             <?php 
$i=0;
foreach ($taxfield as $taxss) {?>
                            <div class="col-sm-6">
                         <div class="form-group row">
                            <label for="tax" class="col-sm-4 col-form-label"><?php echo $taxss['tax_name']; ?> <i class="text-danger"></i></label>
                            <div class="col-sm-7">
                              <input type="text" name="tax<?php echo $i;?>" class="form-control" value="<?php echo number_format($taxss['default_value'], 2, '.', ',');?>">
                            </div>
                            <div class="col-sm-1"> <i class="text-success">%</i></div>
                        </div>
                    </div>
                    <?php $i++;}

?>
                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">

                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('save') ?>" tabindex="14"/>
                            </div>
                        </div>
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


</div>
<!-- Add Product End -->
  <div id="manufac_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="background-color: green;color: white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <center><strong></i><?php echo display('add_new_manufacturer') ?></strong></center>
                </div>
                <div class="modal-body">
                   <div id="manufacturerErr" class="alert hide"></div>
                   <div id="manufacturer_mess" class="alert hide"></div>
                      <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_manufacturer') ?> </h4>
                        </div>
                    </div>
                   <?php echo form_open_multipart('Cmanufacturer/new_manufacturer',array( 'id' => 'manufacturerform'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="manufacturer_name" class="col-sm-3 col-form-label"><?php echo display('manufacturer_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="manufacturer_name" id="manufacturer_name" type="text" placeholder="<?php echo display('manufacturer_name') ?>"  required="required" tabindex="1">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('manufacturer_mobile') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="mobile" id="mobile" type="text" placeholder="<?php echo display('manufacturer_mobile') ?>"  min="0" tabindex="2">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address " class="col-sm-3 col-form-label"><?php echo display('manufacturer_address') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('manufacturer_address') ?>" tabindex="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-sm-3 col-form-label"><?php echo display('manufacturer_details') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="details" id="details" rows="3" placeholder="<?php echo display('manufacturer_details') ?>" tabindex="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-manufacturer" class="btn btn-primary btn-large" name="add-manufacturer" value="<?php echo display('save') ?>" tabindex="6"/>

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

    </div>



<script type="text/javascript">
   $("#manufacturerform").submit(function(e){
        e.preventDefault();
        var manufacturer_mess  = $("#manufacturer_mess");
        var manufacturerErr    = $("#manufacturerErr");
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function()
            {
                manufacturer_mess.removeClass('hide');
                manufacturerErr.removeClass('hide');
            },

            success: function(data)
            {
                if (data.exception) {
                    manufacturerErr.addClass('alert-danger').removeClass('alert-success').html(data.exception);

                    //$('#manufac_modal').modal('hide');
                }else{
                    manufacturer_mess.addClass('alert-success').removeClass('alert-danger').html(data.message);
                    manufacturer_mess.hide().fadeIn('slow');
                    manufacturer_mess.fadeIn(700);
                    $('#manufac_modal').modal('hide');
                    $("#manufacturer_info").load(location.href+" #manufacturer_info>*","");

                }
            },
            error: function(xhr)
            {
                alert('<?php echo display('failed')?>!');
            }

        });

    });



</script>

<script>
function ProfitPrice() {
     var x = document.getElementById("price").value;
     var y = document.getElementById("mprice").value;
     var z = x - y;
     var profitalert = '<?php echo display('your_profit_is')?>: ';
      document.getElementById("prft").innerHTML = profitalert +  Number(z).toFixed(2);


      if (z < 0 ) {
        setTimeout(function(){
        alert('<?php echo display('please_check_your_price');?>');
        document.getElementById("mprice").value = '';
        document.getElementById("price").HTML = '';
        document.getElementById("prft").innerHTML = '';

        }, 1000);

            return false;
        }
        return true;
}
function Checkprice()
{
  var x=document.forms["insert_product"]["price"].value;

  if (isNaN(x)){
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("price").value = '';
    return false;
  }
}
 function checkmprice(){
  var y=document.forms["insert_product"]["manufacturer_price"].value;
  if (isNaN(y)){
    alert("<?php echo display('must_input_numbers');?>");
     document.getElementById("mprice").value = '';
     document.getElementById("prft").innerHTML = '';
    return false;
  }
}
</script>
<script type="text/javascript">
      window.onload = function () {
        var text_input = document.getElementById('product_id');
        text_input.focus();
        text_input.select();
    }

    
</script>