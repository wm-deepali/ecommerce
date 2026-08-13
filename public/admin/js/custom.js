$(document).ready(function() {
    $('#for_all').DataTable();
    $('.for_db').DataTable({
        "order": [[ 0, "desc" ]]
    });
});

!function(t,e,n)
{
	"use strict";n(".custom-file input").change(function(t){n(this).next(".custom-file-label").html(t.target.files[0].name)
})}(window,document,jQuery);

$("#pay_mode").change(function(){
   if($(this).val()=="1")
   {    
       $(".cash_collected").show();
   }
    else
    {
       $(".cash_collected").hide();
    }
});
$("#pay_mode").change(function(){
   if($(this).val()=="2")
   {    
       $(".chq").show();
   }
    else
    {
       $(".chq").hide();
    }
});
$("#pay_mode").change(function(){
   if($(this).val()=="3")
   {    
       $(".utr").show();
   }
    else
    {
       $(".utr").hide();
    }
});

$("#add_enq_pay").change(function(){
   if($(this).val()=="1")
   {    
       $(".add_enq_cash").show();
   }
    else
    {
       $(".add_enq_cash").hide();
    }
});
$("#add_enq_pay").change(function(){
   if($(this).val()=="2")
   {    
       $(".add_enq_chq").show();
   }
    else
    {
       $(".add_enq_chq").hide();
    }
});
$("#add_enq_pay").change(function(){
   if($(this).val()=="3")
   {    
       $(".add_enq_utr").show();
   }
    else
    {
       $(".add_enq_utr").hide();
    }
});

$("#category_gallery").change(function(){
   if($(this).val()=="1")
   {    
       $(".image_gal").show();
   }
    else
    {
       $(".image_gal").hide();
    }
});
$("#category_gallery").change(function(){
   if($(this).val()=="2")
   {    
       $(".video_gal").show();
   }
    else
    {
       $(".video_gal").hide();
    }
});

$(document).ready(function() {
    $("#basic-alert").on("click", function() {
        swal("Here's a message!")
    }), $("#with-title").on("click", function() {
        swal("Here's a message!", "It's pretty, isn't it?")
    }), $("#html-alert").on("click", function() {
        var e = document.createElement("span"),
            t = document.createTextNode("Custom HTML Message!!");
        e.style.cssText = "color:#F6BB42", e.appendChild(t), swal({
            title: "HTML Alert!",
            content: {
                element: e
            }
        })
    }), $("#type-success").on("click", function() {
        swal("Great!", "Your Reply has been send!", "success")
    }), $("#type-info").on("click", function() {
        swal("Info!", "You clicked the button!", "info")
    }), $("#type-warning").on("click", function() {
        swal("Warning!", "You clicked the button!", "warning")
    }), $("#type-error").on("click", function() {
        swal("Sorry!", "Something Error, Please Try again", "error")
    })
});

/** Send SMS Main Type **/
$("#sms_sender_type").change(function(){
   if($(this).val()=="2")
   {    
       $(".student_wise").show();
   }
    else
    {
       $(".student_wise").hide();
    }
});

$("#sms_sender_type").change(function(){
   if($(this).val()=="3")
   {    
       $(".franchise_wise").show();
   }
    else
    {
       $(".franchise_wise").hide();
    }
});

$("#sms_sender_type").change(function(){
   if($(this).val()=="4")
   {    
       $(".stateco_wise").show();
   }
    else
    {
       $(".stateco_wise").hide();
    }
});
$("#sms_sender_type").change(function(){
   if($(this).val()=="5")
   {    
       $(".zonalco_wise").show();
   }
    else
    {
       $(".zonalco_wise").hide();
    }
});
$("#sms_sender_type").change(function(){
   if($(this).val()=="6")
   {    
       $(".co_wise").show();
   }
    else
    {
       $(".co_wise").hide();
    }
});
/** Student Wise **/
$("#student_wise").change(function(){
   if($(this).val()=="2")
   {    
       $(".student_part").show();
   }
    else
    {
       $(".student_part").hide();
    }
});

$("#student_wise").change(function(){
   if($(this).val()=="3")
   {    
       $(".course_wise").show();
   }
    else
    {
       $(".course_wise").hide();
    }
});

$("#student_wise").change(function(){
   if($(this).val()=="4")
   {    
       $(".program_wise").show();
   }
    else
    {
       $(".program_wise").hide();
    }
});

/** Franchise Wise **/
$("#franchise_wise").change(function(){
   if($(this).val()=="2")
   {    
       $(".centre_part").show();
   }
    else
    {
       $(".centre_part").hide();
    }
});

$("#franchise_wise").change(function(){
   if($(this).val()=="3")
   {    
       $(".franchise_state").show();
   }
    else
    {
       $(".franchise_state").hide();
    }
});

$("#franchise_wise").change(function(){
   if($(this).val()=="4")
   {    
       $(".franchise_city").show();
   }
    else
    {
       $(".franchise_city").hide();
    }
});

/** State Co-Ordinator Wise **/

$("#stateco_wise").change(function(){
   if($(this).val()=="2")
   {    
       $(".stateco_part").show();
   }
    else
    {
       $(".stateco_part").hide();
    }
});
$("#stateco_wise").change(function(){
   if($(this).val()=="3")
   {    
       $(".stateco_selected").show();
   }
    else
    {
       $(".stateco_selected").hide();
    }
});

/** Zonal Co-Ordinator Wise **/

$("#zonalco_wise").change(function(){
   if($(this).val()=="2")
   {    
       $(".zonalco_part").show();
   }
    else
    {
       $(".zonalco_part").hide();
    }
});
$("#zonalco_wise").change(function(){
   if($(this).val()=="3")
   {    
       $(".zonalco_selected").show();
   }
    else
    {
       $(".zonalco_selected").hide();
    }
});

/** Co-Ordinator Wise **/

$("#co_wise").change(function(){
   if($(this).val()=="2")
   {    
       $(".co_part").show();
   }
    else
    {
       $(".co_part").hide();
    }
});
$("#co_wise").change(function(){
   if($(this).val()=="3")
   {    
       $(".co_selected").show();
   }
    else
    {
       $(".co_selected").hide();
    }
});

/** SMS Inputs Count **/
$(document).ready(function(){
    var $remaining = $('#remaining'),
        $messages = $remaining.next();

    $('#message').keyup(function(){
        var chars = this.value.length,
            messages = Math.ceil(chars / 160),
            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

        $remaining.text(remaining + ' characters remaining');
        $messages.text('- ' + messages + ' message(s)');
    });
});

$("#role_cat").change(function(){
   if($(this).val()=="custom")
   {    
       $(".custom_permission").show();
   }
    else
    {
       $(".custom_permission").hide();
    }
});


$("#paymentmode_wallet").change(function(){
 if($(this).val()=="2")
 {    
   $(".chq_div").show();
 }
 else
 {
  $(".chq_div").hide();
}
});

$("#paymentmode_wallet").change(function(){
 if($(this).val()=="3")
 {    
   $(".net_div").show();
 }
 else
 {
  $(".net_div").hide();
}
});

$("#paymentmode_wallet").change(function(){
 if($(this).val()=="4")
 {    
   $(".upi_div").show();
 }
 else
 {
  $(".upi_div").hide();
}
});

$("#paymentmode_wallet").change(function(){
 if($(this).val()=="5")
 {    
   $(".paytm_div").show();
 }
 else
 {
  $(".paytm_div").hide();
}
});


$("#paymentmode_order").change(function(){
 if($(this).val()=="1")
 {    
   $(".cash_div").show();
 }
 else
 {
  $(".cash_div").hide();
}
});

$("#shipping_type").change(function(){
   if($(this).val()=="courier")
   {    
       $(".courier_div").show();
   }
    else
    {
       $(".courier_div").hide();
    }
});

$("#shipping_type").change(function(){
   if($(this).val()=="valet")
   {    
       $(".valet_div").show();
   }
    else
    {
       $(".valet_div").hide();
    }
});


$(document).ready(function(){
$('.add_op').click(function() {
    $('.block_op:last').after('<div class="block_op"><div class="form-group row"><div class="col-sm-2"><label class="label-control">Subject</label><input type="text" class="form-control" placeholder="Enter Subject Name"></div><div class="col-sm-2"><label class="label-control">Day</label><select class="form-control"><option>Sunday</option><option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option><option>Saturday</option></select></div><div class="col-sm-2"><label class="label-control">Date</label><input type="date" class="form-control"></div><div class="col-sm-2"><label class="label-control">Theory Time</label><input type="time" class="form-control"></div><div class="col-sm-2"><label class="label-control">Practical Time</label><input type="time" class="form-control"></div><span class="remove_op"><i class="fa fa-minus"></i> Remove</span></div></div></div>');
});
$('.optionBox_op').on('click','.remove_op',function() {
 	$(this).parent().remove();
});
	});

$(document).ready(function(){
$('.add_vd').click(function() {
    $('.block_vd:last').after('<div class="block_vd"><div class="form-group row"><div class="col-sm-3"><label class="label-control">Document Title	</label><input type="text" class="form-control" placeholder="Document Title"></div><div class="col-sm-3"><label class="label-control">Upload Document</label><input type="file" class="form-control"></div><div class="col-sm-3"><label class="label-control">Document Remark</label><input type="text" placeholder="Enter Remark" class="form-control"></div><span class="remove_vd"><i class="fa fa-minus"></i> Remove</span></div></div></div>');
});
$('.optionBox_vd').on('click','.remove_vd',function() {
 	$(this).parent().remove();
});
});