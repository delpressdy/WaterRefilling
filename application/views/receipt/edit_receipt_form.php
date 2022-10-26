<h2><?php echo display('edit_receipt');?></h2>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>creceipt/receipt_update" id="insert_receipt" method="post"  name="insert_receipt" enctype="multypart/formdata">
        <legend><?php echo display('receipt_detail');?></legend>
		<?php $date = date('Y-m-d'); ?>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="invoice_date"><?php echo display('date');?>:</label>
                    <div class="controls">
                        <input type="text" class="span10" value="{date}" id="receipt_date" name="receipt_date" required />
                    </div>
                </div>
            </div>
            <div class="span8">
            	<div class="control-group">
                    <label class="control-label"><?php echo display('description');?>:</label>
                    <div class="controls">
                        <textarea class="span6 input-description" tabindex="1" id="description" name="description" placeholder="<?php echo display('description');?>" required>{description}</textarea>
                    </div>
                </div>
            </div>
        </div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label"><?php echo display('customer_name');?></label>
				<div class="controls">
					<input type="text" name="customer_name" value="{customer_name}" class="span3 customerSelection" placeholder='Type Customer Name' id="customer_name" >
					<input type="hidden" class="customer_hidden_value" value="{customer_id}" name="customer_id" id="SchoolHiddenId"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"><?php echo display('amount');?></label>
				<div class="controls">
					<input type="text" class="span3" value="{amount}" name="amount" placeholder="<?php echo display('amount');?>" required />
					<input type="hidden" value="{receipt_no}" name="receipt_no"  />
				</div>
			</div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-receipt" class="btn btn-primary btn-large" name="add-receipt" value="<?php echo display('save_changes');?>" />
        </div>
    </form>
</div>
