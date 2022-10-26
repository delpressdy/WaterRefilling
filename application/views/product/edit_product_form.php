<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js" type="text/javascript"></script>
<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Gallons' ?></a></li>
                <li class="active"><?php echo 'Edit Gallons' ?></li>
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
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('product_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cproduct/product_update',array('class' => 'form-vertical', 'id' => 'product_update','name' => 'product_update'))?>
                 <div class="panel-body">
                    <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('product_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="product_name" type="text" tabindex="1" id="product_name" placeholder="<?php echo display('product_name') ?>" value="{product_name}" required="required">

                                        <input type="hidden" name="product_id" value="{product_id}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo display('image') ?></label>
                                    <div class="col-sm-8">
                                        <input type="file" name="image" class="form-control" tabindex="7">
                                         <img class="img img-responsive text-center" src="{image}" height="80" width="80" style="padding: 5px;">
                                         <input type="hidden" value="{image}" name="old_image">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <div class="col-sm-8">
                                         <input class="form-control" required="required" name="generic_name" tabindex="2" type="hidden" id="generic_name" value="{generic_name}">
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            
                            
                        </div>

                        <div class="row">
                           <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_location" class="col-sm-4 col-form-label"><?php echo 'Active/Inactive' ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="product_location" type="text" tabindex="4" id="product_location" placeholder="<?php echo display('product_location') ?>" value="{product_location}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-4 col-form-label"><?php echo 'Size' ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="unit" type="text" id="unit" tabindex="3" placeholder="Size" required="required" value="{unit}" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo 'Category' ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name="category_id" class="form-control" required="required" tabindex="6">
                                            {category_list}
                                                <option value="{category_id}">{category_name} </option>
                                            {/category_list}
                                            <?php
                                            if ($category_selected) {   
                                            ?>
                                            {category_selected}
                                                <option selected value="{category_id}">{category_name} </option>
                                            {/category_selected}
                                            <?php
                                                }else{
                                            ?>
                                            <option selected value="0"><?php echo display('category_not_selected')?></option>
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
                                    <label for="typename" class="col-sm-4 col-form-label"><?php echo 'Model' ?>
                                     <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="category_id" name="type_name" required="required" tabindex="8">
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
                                         <?php
                                            if ($seleceted_type) {   
                                            ?>
                                            {seleceted_type}
                                                <option selected value="{type_name}">{type_name} </option>
                                            {/seleceted_type}
                                            <?php
                                                }else{
                                            ?>
                                            <option selected value="0"><?php echo display('category_not_selected')?></option>
                                            <?php
                                                }
                                            ?>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="sellprice" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                         <input class="form-control text-right" name="price" type="text" required="required" onkeyup="Checkprice()" placeholder="0.00" tabindex="9" min="0" value="{price}" id="price">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="box_size" class="col-sm-4 col-form-label"><?php echo 'Weight' ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="box_size" name="box_size" required="required" tabindex="10">
                                        
                                              <?php
                                            if ($unit_list) {
                                        ?>
                                        {unit_list}
                                            <option value="{unit_name}">{unit_name}</option>
                                        {/unit_list}
                                        <?php
                                            }
                                        ?>
                                         <?php
                                            if ($seleceted_unit) {   
                                            ?>
                                            {seleceted_unit}
                                                <option selected value="{unit_name}">{unit_name} </option>
                                            {/seleceted_unit}
                                            <?php
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                          <?php 
            $i=0;
            foreach ($taxfield as $txs) {
                $tax = 'tax'.$i;
                ?>       
                    <div class="col-sm-6">
                 <div class="form-group row">
                    <label for="tax" class="col-sm-4 col-form-label"><?php echo $txs['tax_name']; ?> <i class="text-danger"></i></label>
                    <div class="col-sm-7">
                      <input type="text" name="tax<?php echo $i;?>" class="form-control" value="<?php echo  number_format($pr_details[0][$tax]*100, 2, '.', ',');?>">
                    </div>
                    <div class="col-sm-1"> <i class="text-success">%</i></div>
                </div>
            </div>
                
                       <?php $i++;}

?>   
                             
                        </div> 
                         <div class="row" id="manufacturer_info">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="manufacturer" class="col-sm-4 col-form-label"><?php echo display('manufacturer') ?><i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name="manufacturer_id" class="form-control dont-select-me" required="required" tabindex="12">
                                                
                                                <?php foreach ($manufacturer_list as  $manufacturer) {?>
                                                    <option value="<?php echo $manufacturer['manufacturer_id']?>"><?php echo $manufacturer['manufacturer_name']?> </option>
                                                <?php }?>
                                                <?php
                                                    if ($manufacturer_selected) {
                                                ?>
                                                {manufacturer_selected}
                                                    <option selected value="{manufacturer_id}">{manufacturer_name} </option>
                                                {/manufacturer_selected}
                                                <?php
                                                    }else{
                                                ?>
                                                <option selected value="0"><?php echo display('manufacturer_not_selected')?></option>
                                                <?php 
                                                    }
                                                ?>

                                            </select>
                                <p style="color: green;cursor:pointer" data-target="#manufac_modal" data-toggle="modal"><i class="fa fa-plus"></i><?php echo display('add_new_manufacturer')?></p>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="manufacturer_price" class="col-sm-4 col-form-label"><?php echo display('manufacturer_price') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text"  onkeyup="ProfitPrice(),checkmprice()" tabindex="13" class="form-control text-right"   name="manufacturer_price" placeholder="0.00"  required="required"  min="0" id="mprice" value="{manuprice}" />
                                   
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <div class="col-sm-6">

                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('save_changes') ?>" tabindex="14"/>
                                
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Product End -->
<!-- Add Product End -->
  <div id="manufac_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="background-color: green;color: white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <center><strong><?php echo display('new_manufacturer');?></strong></center>
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
                alert('failed!');
            }

        });

    });

  

</script>


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
                alert('failed!');
            }

        });

    });

  

</script>

<script>
function ProfitPrice() {
    var x = document.getElementById("price").value;
     var y = document.getElementById("mprice").value;
     var z = x - y;
     var profitalert = 'Your Profit is : ';
      document.getElementById("prft").innerHTML = profitalert + Number(z).toFixed(2);


     if (z <= 0 ) { 
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

  if (isNaN(x)) 
  {
    alert("Must input numbers");
     document.getElementById("price").value = '';
    return false;
  }
}

 function checkmprice()
{
  var y=document.forms["insert_product"]["manufacturer_price"].value;
  if (isNaN(y)) 
  {
    alert("<?php echo display('must_input_numbers');?>");
     document.getElementById("mprice").value = '';
     document.getElementById("prft").innerHTML = '';
    return false;
  }
}
</script>