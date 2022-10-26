//Add Input Field Of Row
function addInputField(t) {
    var row = $("#normalinvoice tbody tr").length;
    var count = row + 1;
    var limits = 500;
     var taxnumber = $("#txfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_tax'+i+'_'+count+'" class="total_tax'+i+'_'+count+'" type="hidden"><input id="all_tax'+i+'_'+count+'" class="total_tax'+i+'" type="hidden" name="tax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits) alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "product_name_" + count,
            tabindex = count * 5,
            e = document.createElement("tr");
            tab1 = tabindex + 1;
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tabindex + 6;
            tab7 = tabindex + 7;
            tab8 = tabindex + 8;
            tab9 = tabindex + 9;
            tab10 = tabindex + 10;
            tab11 = tabindex + 11;
        e.innerHTML = "<td><input type='text' name='product_name' onkeyup='invoice_productList(" + count + ");' onkeypress='invoice_productList(" + count + ");' class='form-control productSelection' placeholder='Product Name' id='" + a + "' required tabindex='"+tab1+"'><input type='hidden' class='autocomplete_hidden_value  product_id_" + count + "' name='product_id[]' id='SchoolHiddenId'/></td><td><select class='form-control' required id='batch_id_" + count + "'  name='batch_id[]' onchange='product_stock(" + count + ")' tabindex='"+tab2+"'><option></option></select>     <td><input type='text' name='available_quantity[]' id='available_quantity_" + count + "' class='form-control text-right available_quantity_" + count + "' value='0' readonly='readonly' /></td> <td id='expire_date_" + count + "'></td><td><input class='form-control text-right unit_" + count + " valid' value='None' readonly='' aria-invalid='false' type='text'></td><td> <input type='text' name='product_quantity[]' onkeyup='quantity_calculate(" + count + "),checkqty(" + count + ");' onchange='quantity_calculate(" + count + ");' id='total_qntt_" + count + "' class='total_qntt_" + count + " form-control text-right' placeholder='0.00' min='0' tabindex='"+tab3+"' required/></td><td><input type='text' name='product_rate[]' onkeyup='quantity_calculate(" + count + "),checkqty(" + count + ");' onchange='quantity_calculate(" + count + ");' id='price_item_" + count + "' class='price_item"+count+" form-control text-right' required placeholder='0.00' readonly min='0' tabindex='"+tab4+"'/></td><td><input type='text' name='discount[]' onkeyup='quantity_calculate(" + count + "),checkqty(" + count + ");' onchange='quantity_calculate(" + count + ");' id='discount_" + count + "' class='form-control text-right' placeholder='0.00' min='0' tabindex='"+tab5+"' /><input type='hidden' value='' name='discount_type' id='discount_type_" + count + "'></td><td class='text-right'><input class='total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + count + "' value='0.00' readonly='readonly'/></td><td>" + tbfild + "<input type='hidden' id='all_discount_" + count + "' class='total_discount'/><a tabindex='"+tab6+"' style='text-align: right;' class='btn btn-danger'  value='Delete' onclick='deleteRow(this)'><i class='fa fa-close'></i></a></td>", 
        document.getElementById(t).appendChild(e), 
        document.getElementById(a).focus(),
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab7);
        document.getElementById("invdcount").setAttribute("tabindex", tab8);
         document.getElementById("paidAmount").setAttribute("tabindex", tab9);
        document.getElementById("full_paid_tab").setAttribute("tabindex", tab10);
        document.getElementById("add_invoice").setAttribute("tabindex", tab11);
        count++
    }
}

//Edit invoice field
function editInputField(t) {
    var row = $("#normalinvoice tbody tr").length;
    var count = row + 1;
    var limits = 500;
    if (count == limits) alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "product_name" + count,
            tabindex = count * 5,
            e = document.createElement("tr");
            tab1 = tabindex + 1;
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tabindex + 6;
            tab7 = tabindex + 7;
            tab8 = tabindex + 8;
            tab9 = tabindex + 9;
        e.innerHTML = "<td><input type='text' name='product_name' onkeyup='invoice_productList(" + count + ");' class='form-control productSelection' placeholder='Product Name' id='" + a + "' required tabindex='"+tab1+"'><input type='hidden' class='autocomplete_hidden_value  product_id_" + count + "' name='product_id[]' id='SchoolHiddenId'/></td><td><select class='form-control' id='batch_id_" + count + "' name='batch_id[]' onchange='product_stock(" + count + ")'><option></option></select>     <td><input type='text' name='available_quantity[]' id='available_quantity_" + count + "' class='form-control text-right available_quantity_" + count + "' value='0' readonly='readonly' /></td> <td id='expire_date_" + count + "'></td><td><input class='form-control text-right unit_" + count + " valid' value='None' readonly='' aria-invalid='false' type='text'></td><td> <input type='text' name='product_quantity[]' onkeyup='quantity_calculate(" + count + "),checkqty(" + count + ");' onchange='quantity_calculate(" + count + ");' id='total_qntt_" + count + "' class='total_qntt_" + count + " form-control text-right' placeholder='0.00' min='0' tabindex='"+tab2+"'/></td><td><input type='text' name='product_rate[]' readonly onkeyup='quantity_calculate(" + count + "),checkqty(" + count + ");' onchange='quantity_calculate(" + count + ");' id='price_item_" + count + "' readonly class='price_item"+count+" form-control text-right' required placeholder='0.00' min='0' tabindex='"+tab3+"'/></td><td><input type='text' name='discount[]' onkeyup='quantity_calculate(" + count + "),checkqty(" + count + ");' onchange='quantity_calculate(" + count + ");' id='discount_" + count + "' class='form-control text-right' placeholder='0.00' min='0' tabindex='"+tab4+"' /><input type='hidden' value='' name='discount_type' id='discount_type_" + count + "'></td><td class='text-right'><input class='total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + count + "' value='0.00' readonly='readonly'/></td><td><input type='hidden' id='total_tax_" + count + "' class='total_tax_" + count + "' /><input type='hidden' id='all_tax_" + count + "' class=' total_tax' name='tax[]'/><input type='hidden'  id='total_discount_" + count + "' class='total_tax_" + count + "' /><input type='hidden' id='all_discount_" + count + "' class='total_discount'/><button tabindex='"+tab5+"' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow(this)'>Delete</button></td>", 
        document.getElementById(t).appendChild(e), 
        document.getElementById(a).focus(),
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
        document.getElementById("paidAmount").setAttribute("tabindex", tab7);
        document.getElementById("full_paid_tab").setAttribute("tabindex", tab8);
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab9);
        count++
    }
}

//Quantity calculat
function quantity_calculate(item) {
     // alert(item);
    var quantity    = $("#total_qntt_" + item).val();
    var price_item  = $("#price_item_" + item).val();
    var discount    = $("#discount_" + item).val();
    var invoice_discount = $("#invdcount").val();
    var total_tax   = $("#total_tax_" + item).val();
    var total_discount = $("#total_discount_" + item).val();
    var dis_type    = $("#discount_type_" + item).val();
        var taxnumber = $("#txfieldnum").val();

    if (quantity > 0 || discount > 0) {
        if (dis_type == 1) {
           var price = quantity * price_item;
//             alert(dis_type+"distype");

            // Discount cal per product
//            var dis = +(price * discount / 100) + +invoice_discount;
            var dis = +(price * discount / 100)+  + invoice_discount;
 

            $("#all_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            var ttletax = 0;
            $("#total_price_" + item).val(price);
             for(var i=0;i<taxnumber;i++){
           var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }


        }else if(dis_type == 2){
            var price = quantity * price_item;

            // Discount cal per product
            var dis   = discount * quantity;
            $("#all_discount_" + item).val(dis);

            //Total price calculate per product
           
             var temp = price - dis;
            $("#total_price_" + item).val(price);

            var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }

        }else if(dis_type == 3){
            var total_price = quantity * price_item;

            // Discount cal per product
            $("#all_discount_" + item).val(discount);

            //Total price calculate per product
            var price = total_price - dis;
            $("#total_price_" + item).val(total_price);

             var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (price-ttletax) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }
        }
    }else {
        var n = quantity * price_item;
        var c = quantity * price_item * total_tax;
        $("#total_price_" + item).val(n), 
        $("#all_tax_" + item).val(c)
    }
    calculateSum();
    invoice_paidamount();
}
//Calculate Sum
function calculateSum() {
document.getElementById("change").value = '';
  var taxnumber = $("#txfieldnum").val();

    var t = 0,
        a = 0,
        e = 0,
        o = 0,
        f = 0,
        p = 0,
     invdis =  $("#invdcount").val();
    //Total Tax
      for(var i=0;i<taxnumber;i++){
      
var j = 0;
    $(".total_tax"+i).each(function () {
        isNaN(this.value) || 0 == this.value.length || (j += parseFloat(this.value))
    });
            $("#total_tax_amount"+i).val(j.toFixed(2, 2));
             
    }
    //Total Discount
    $(".total_discount").each(function() {
        isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
    }), 
    
    $("#total_discount_ammount").val(p.toFixed(2,2)), 

     $(".totalTax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (f += parseFloat(this.value))
    }),
            $("#total_tax_amount").val(f.toFixed(2, 2)),

    //Total Price
    $(".total_price").each(function() {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }), 

    o = a.toFixed(2,2), 
    e = t.toFixed(2,2);
    tx = f.toFixed(2, 2),
    ds = p.toFixed(2, 2);

    var test = +tx + +e + -ds+ -invdis;
    // var invdis    = $("#invdcount").val();
    var totaldiscount = +ds + +invdis;
    $("#grandTotal").val(test.toFixed(2, 2));
     $("#total_discount_ammount").val(totaldiscount.toFixed(2, 2));
 var previous    = $("#previous").val();
 var gt          = $("#grandTotal").val();
   
   var grnt_totals = +gt+ +previous;
   $("#n_total").val(grnt_totals.toFixed(2,2));
   invoice_paidamount();

}

//Invoice Paid Amount
function invoice_paidamount() {

    var t = $("#n_total").val(),

        a = $("#paidAmount").val(),
        e = t - a;
        d = a - t;
        if(e > 0){
    $("#dueAmmount").val(e.toFixed(2,2))
}else{
  $("#dueAmmount").val(0)   
   $("#change").val(d.toFixed(2,2))

}
}
//Stock Limit
function stockLimit(t) {
    var a = $("#total_qntt_" + t).val(),
        e = $(".product_id_" + t).val(),
        o = $(".baseUrl").val();
    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function(e) {
            if (a > Number(e)) {
                var o = "You can purchase maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0")
            }
        }
    })
}

function stockLimitAjax(t) {
    var a = $("#total_qntt_" + t).val(),
        e = $(".product_id_" + t).val(),
        o = $(".baseUrl").val();
    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function(e) {
            if (a > Number(e)) {
                var o = "You can purchase maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0.00"), calculateSum()
            }
        }
    })
}

//Invoice full paid
function full_paid() {
    var grandTotal = $("#n_total").val();
    $("#paidAmount").val(grandTotal);
    invoice_paidamount();
    calculateSum();
}

function invoice_discount(){
   var gt = $("#n_total").val();
   var invdis    = $("#invdcount").val();
   var grnt_totals = gt-invdis;
   
   $("#total_discount_ammount").val(grnt_totals.toFixed(2,2))
   $("#invtotal").val(grnt_totals.toFixed(2,2))
   $("#dueAmmount").val(grnt_totals.toFixed(2,2))

}
//Delete a row of table
function deleteRow(t) {
    var a = $("#normalinvoice > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e), 
        calculateSum();
        invoice_paidamount();
    }
}
var count = 2,
    limits = 500;



    