<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
$strPageTitle = "Invoice | Nailspa";
$strDisplayTitle = "Invoice for Nailspa";
$strMenuID = "10";
$strMyTable = "tblAppointmentsDetailsInvoice";
$strMyTableID = "AppointmentDetailsID";
$strMyActionPage = "appointment_invoice.php";
$strMessage = "";
$sqlColumn = "";
$sqlColumnValues = "";
//error_reporting(E_ALL);
// code for not allowing the normal admin to access the super admin rights	
if($strAdminType!="0")
{
	die("Sorry you are trying to enter Unauthorized access");
}
// code for not allowing the normal admin to access the super admin rights	

if(isset($_GET["toandfrom"]))
{
$strtoandfrom = $_GET["toandfrom"];
$arraytofrom = explode("-",$strtoandfrom);

$from = $arraytofrom[0];
$datetime = new DateTime($from);
$getfrom = $datetime->format('Y-m-d');


$to = $arraytofrom[1];
$datetime = new DateTime($to);
$getto = $datetime->format('Y-m-d');

if(!IsNull($from))
{
	$sqlTempfrom = " AND Date(AppointmentDate)>=Date('".$getfrom."')";
}

if(!IsNull($to))
{
	$sqlTempto = " and Date(AppointmentDate)<=Date('".$getto."')";
}
}
if(isset($_GET["toandfrom"]))
{
$strtoandfrom = $_GET["toandfrom"];
$arraytofrom = explode("-",$strtoandfrom);

$from = $arraytofrom[0];
$datetime = new DateTime($from);
$getfrom = $datetime->format('Y-m-d');


$to = $arraytofrom[1];
$datetime = new DateTime($to);
$getto = $datetime->format('Y-m-d');

if(!IsNull($from))
{
	$sqlTempfrom = " AND Date(AppointmentDate)>=Date('".$getfrom."')";
}

if(!IsNull($to))
{
	$sqlTempto = " and Date(AppointmentDate)<=Date('".$getto."')";
}
}


?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php require_once("incMetaScript.fya"); ?>
        </head>
        <script type="text/javascript">
$(document).ready(function() 
{

$(document).keydown(function(event) {
	var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

	if (event.ctrlKey && (pressedKey == "c" || pressedKey == "u" || pressedKey == "v" || pressedKey == "a" || pressedKey == "s")) {
		alert('Sorry, This Functionality Has Been Disabled For Security Reasons!');
		//disable key press porcessing
		return false;
	}
});


$(document).keyup(function(e) {
	if (e.keyCode == 44) return false;
});


//$("#payment").show();
$("#discounttr").hide();
$("#displaydetail").show();
// $("#displaymembership").hide();


////////////////////assign membership////////////////////////////////

//alert(222)
$("#assignmembership").click(function() {
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	var mem = $("#memidd").val();

	if (confirm('Are you sure you want to Assign Membership?')) {

		$.ajax({
			url: "Updatememid.php",
			type: 'post',
			data: "app_id=" + app_id + "&mem=" + mem,
			success: function(msg) {
				//alert(msg)
				if ($.trim(msg) == '2') {
					$msg = "Membership Assigned Successfully!";
					alert($msg)
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '6') {
					alert('Membership you are trying to apply has expired.Please renew the Membership!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '3') {
					alert('Please Remove Membership or Gift Voucher or Offer Code to perform this action!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '7') {
					alert('Kindly note membership discount is not applicable on packages and gift vouchers!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}


			}



		});
	} else {

	}
});

$("#renewmem").click(function() {

var app_id = $("#appointment_idd").val();
var app_idd = $("#appointment_id").val();
var mem = $("#memidd").val();
if (confirm('Are you sure you want to Renew Membership?')) {
	$.ajax({
		url: "renewmem.php",
		type: 'post',
		data: "app_id=" + app_id + "&mem=" + mem,
		success: function(msg) {

			if ($.trim(msg) == '2') {
				$msg = "Membership Renew Successfully";
				alert($msg)
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(msg) == '3') {
				alert('Please Remove Membership or Gift Voucher or Offer Code to perform this action!')
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(msg) == '4') {
				$msg = "Kindly note membership discount is not applicable on packages and gift vouchers!";
				alert($msg)
				window.location = "appointment_invoice.php?uid=" + app_idd;
			}


		}



	});
} else {

}

});


var app_id = $("#appointment_idd").val();
//alert(app_id)
////////////////////////////
$.ajax({
	type: "post",
	data: "app_id=" + app_id,
	url: "checkmembership.php",
	success: function(result) {
		//alert(result)

		if ($.trim(result) != '0') {
			if ($.trim(result) == 'Present') {
				$("#displaymembership2").show();

				$("#displaymembership").hide();
				$("#displaymembership1").hide();

			} else if ($.trim(result) == 'Absent') {
				$("#displaymembership").hide();
				$("#displaymembership1").show();

			} else if ($.trim(result) == 'Already') {
				$("#displaymembership").show();
				$("#displaymembership1").hide();


			}


		}




	}

});
//////////////////////////////////////////////////////

/////////////////////////////////remove gift voucher///////////////////////////////
$("#removevoucher").click(function() {
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	var giftname = $("#giftname").val();

	if (confirm('Are you sure you want to Remove This Voucher?')) {
		$.ajax({
			url: "RemoveVoucher.php",
			type: 'post',
			data: "app_id=" + app_id + "&giftname=" + giftname,
			success: function(msg) {
				//alert(msg)
				if ($.trim(msg) == '3') {
					$msg = "Gift voucher removed successfully!";
					alert($msg)
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '1') {
					alert('Cannot Removed')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}

			}



		});
	} else {

	}
});

$("#giftapply").click(function() {
var giftname = $("#giftname").val();
var app_idd = $("#appointment_id").val();
var app_id = $("#appointment_idd").val();
var cust_id = $("#cust_id").val();
if (confirm('Are you sure you want to Apply Gift Voucher?')) {
	if (giftname != "") {
		$.ajax({
			url: "checkvoucher.php",
			type: 'post',
			data: "giftname=" + giftname + "&app_id=" + app_id + "&cust_id=" + cust_id,
			success: function(msg) {

				if ($.trim(msg) == '8') {
					alert('Gift voucher expired!')
					window.location = "appointment_invoice.php?uid=" + app_idd;

				} else if ($.trim(msg) == '2') {
					alert('Gift voucher redemption code is incorrect!')
					window.location = "appointment_invoice.php?uid=" + app_idd;

				} else if ($.trim(msg) == '3') {
					alert('Please Remove Membership or Gift Voucher or Offer Code to perform this action!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '5') {
					alert('Gift Voucher Apply Successfully')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '4') {
					alert('Gift Voucher Already Used')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}




			}
		});
	} else {
		alert('Gift Voucher Code Cannot Be Blank')
	}
} else {

}

});
$("#gift").click(function() {

	var gift = $("#giftvoucher").val();
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	var store = $("#storet").val();
	var cust_id = $("#cust_id").val();
	var giftcvalidity = $("#giftcvalidity").val();
	var giftqty = $("#giftqty").val();
	if (confirm('Are you sure you want to Add Gift Voucher?')) {
		if (gift != "0" && giftcvalidity != "0" && giftqty != "0") {
			$.ajax({
				url: "AddVoucher.php",
				type: 'post',
				data: "id=" + gift + "&store=" + store + "&app_id=" + app_id + "&cust_id=" + cust_id + "&giftcvalidity=" + giftcvalidity,
				success: function(msg) {

					window.location = "appointment_invoice.php?uid=" + app_idd;



				}
			});

		} else {
			alert('Please select proper amount, quantity and validity to add a Gift voucher!')
		}
	} else {

	}


});
////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////offer/////////////////////////////////////////////////////////
$("#offerid").click(function() {
var offervalue = $("#offername").val();
//	alert(offervalue)
var app_id = $("#appointment_idd").val();
var app_idd = $("#appointment_id").val();

if (offervalue != "") {
	$.ajax({
		type: "post",
		data: "offervalue=" + offervalue + "&app_id=" + app_id,
		url: "checkoffer.php",
		success: function(result) {

			if ($.trim(result) == '2') {
				var msg = "Invalid Offer Code";
				//$("#displayoffererror").html(msg);
				alert(msg)
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(result) == '3') {
				var msg = "Please note, offer applied is not valid for some of the services in the bill!";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;

			} else if ($.trim(result) == '1') {
				var msg = "Offer Assigned Successfully";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;


			} else if ($.trim(result) == '8') {
				var msg = "Offer expired";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;


			} else if ($.trim(result) == '9') {
				var msg = "Please note the service amount is less then offer amount!";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;


			} else if ($.trim(result) == '4') {
				var msg = "This offer is not valid for this store";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(result) == '6') {
				var msg = "Offer Code Cannot Be Blank";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(result) == '10') {

				var msg = "Please Remove Membership or Gift Voucher or Offer Code to perform this action!";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(result) == '14') {
				var msg = "Please Remove Membership or Gift Voucher or Offer Code to perform this action!";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(result) == '20') {
				var msg = "Kindly note Offer discount is not applicable on packages and gift vouchers!";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else if ($.trim(result) == '15') {
				var msg = "Kindly note Offer discount is not applicable on packages and gift vouchers!";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			}




		}


	})
} else {
	alert('offer code cannot be blank')
	return false;
}

});
$("#offeridremove").click(function() {
var offervalue = $("#offername").val();
var app_id = $("#appointment_idd").val();
var app_idd = $("#appointment_id").val();

if (offervalue != "") {
	$.ajax({
		type: "post",
		data: "offervalue=" + offervalue + "&app_id=" + app_id,
		url: "removeoffer.php",
		success: function(result1) {
			//alert(result1)
			if ($.trim(result1) == '') {

			} else if ($.trim(result1) == '6') {
				var msg = "Offer Code Cannot Be Blank";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			} else {
				var msg = "Offer Removed Successfully";
				alert(msg)
					//$("#displayoffererror").html(msg);
				window.location = "appointment_invoice.php?uid=" + app_idd;
			}
		}
	});
} else {
	alert('offer code cannot be blank')
	return false;
}
});

$("#offeridnew").click(function() {
	var offervalue = $("#offername").val();
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();

	if (offervalue != "") {
		$.ajax({
			type: "post",
			data: "offervalue=" + offervalue + "&app_id=" + app_id,
			url: "newoffer.php",
			success: function(result1) {
				//alert(result1)
				if ($.trim(result1) == '2') {
					var msg = "Invalid Offer Code";
					alert(msg)
						//$("#displayoffererror").html(msg);
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(result1) == '3') {
					var msg = "Please note, offer applied is not valid for some of the services in the bill!";
					alert(msg)
						//$("#displayoffererror").html(msg);
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(result1) == '1') {
					var msg = "Offer Assigned Successfully";
					alert(msg)
						//$("#displayoffererror").html(msg);
					window.location = "appointment_invoice.php?uid=" + app_idd;

				} else if ($.trim(result1) == '4') {
					var msg = "This offer is not valid for this store";
					alert(msg)
						//$("#displayoffererror").html(msg);
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(result1) == '5') {
					var msg = "This offer is already assigned";
					alert(msg)
						//$("#displayoffererror").html(msg);
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(result1) == '6') {
					var msg = "Offer Code Cannot Be Blank";
					alert(msg)
						//$("#displayoffererror").html(msg);
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}
			}
		});
	} else {
		alert('offer code cannot be blank')
		return false;
	}

});

//////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////cash payment mode///////////////////////////////

$("#cash").click(function() {

	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	if (confirm('Are you sure you want to save this Invoice?')) {
		var test = $("#cash").val();
		//alert(test)
		if (test == 'cash') {
			$("#paymenttype").show();
			//$("#paymenttype1").show();


			var type = $('input[name="paytype"]:checked').val();
			//alert(type)
			if (type == 'Partial') {

				var completeamt = $("#completeamt").val();
				var amt = $("#totalpayment").val();
				// alert(amt)
			} else if (type == 'Complete') {

				var completeamt = $("#roundtotal").val();
				//alert(completeamt)
				var amt = $("#totalpayment").val();
				//alert(amt)
			}




			if (Number(completeamt) > Number(amt)) {
				alert('Amount Cannot Be Greater Than Total Amount')
			} else {

				$.ajax({
					url: "printbill.php",
					type: 'post',
					data: $("#printcontent").serialize() + "&type=" + "CS",
					success: function(msg) {


						if ($.trim(msg) == '2') {
							$msg = "Cash Received";
							window.location = "invoice_print.php?uid=" + app_idd + "&msg=" + $msg;
						} else {
							alert(msg)
						}

					}



				});
			}


		}
	} else {
		// Do nothing!
	}



});

$("#CompleteAmt").click(function() {
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	if (confirm('Are you sure you want to save this Invoice?')) {

		$("#paymenttype").show();
		//$("#paymenttype1").show();


		var type = $('input[name="paytype"]:checked').val();
		//alert(type)
		if (type == 'Partial') {

			var completeamt = $("#completeamt").val();
			var amt = $("#totalpayment").val();
			// alert(amt)
		} else if (type == 'Complete') {

			var completeamt = $("#roundtotal").val();
			//alert(completeamt)
			var amt = $("#totalpayment").val();
			//alert(amt)
		}




		if (Number(completeamt) > Number(amt)) {
			alert('Amount Cannot Be Greater Than Total Amount')
		} else {
			$.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize() + "&type=" + "CompleteAmt",
				success: function(msg) {
					//alert(msg)
					if ($.trim(msg) == '2') {
						$msg = "Invoice Complete";
						window.location = "invoice_print.php?uid=" + app_idd + "&msg=" + $msg;
					} else {
						alert(msg)
					}

				}



			});
		}



	} else {
		// Do nothing!
	}
});

                
$('input[type="radio"]').click(function() {
	if ($(this).attr("value") == "Partial") {
		$(".partial").show();
		$("#cardboth").val('');
		$("#cashboth").val('');
	}
	if ($(this).attr("value") == "Complete") {
		$(".partial").hide();
		$("#cardboth").val('');
		$("#cashboth").val('');
	}

});


$("#both").click(function() {

	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	var test = $("#both").val();

	if (test == 'both') {
		$("#card").hide();
		$("#cash").hide();
		$("#confirm").show();
		$("#both").hide();
		//$("#hold").hide();
		$("#payment1").show();
		var totalcost = $("#roundtotal").val();
		var cardamount = $("#cardboth").val();
		var cashamount = $("#cashboth").val();

		var bothamt = parseFloat(cardamount) + parseFloat(cashamount);

		//alert(totalcost)
		if (Number(bothamt) > Number(totalcost)) {
			alert('Card and Cash Amount Cannot Be Greater Than Total Amount')
		} else {

		}


		/* 		$.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"BOTH",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Amount Received";		     
						window.location="invoice_print.php?uid="+app_idd+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   }); 		 */


		// $("#displaytext1").show();


	}




});

$("#confirm").click(function() {

	if (confirm('Are you sure you want to save this Invoice?')) {
		var cardamt = $("#cardboth").val();
		var cashboth = $("#cashboth").val();
		var amt = $("#totalpayment").val();

		// alert(amt)
		if (cardamt == "" || cashboth == "") {
			alert('Card Amount And Cash Amount Cannot Blank')
		} else if (Number(cardamt) > Number(amt)) {
			alert('Card Amount Cannot Be Greater Total Amount');
		} else if (Number(cashboth) > Number(amt)) {
			alert('Cash Amount Cannot Be Greater Total Amount');
		} else {
			var app_id = $("#appointment_idd").val();
			var app_idd = $("#appointment_id").val();
			$.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize() + "&type=" + "BOTH",
				success: function(msg) {
					//alert(msg)
					if ($.trim(msg) == '2') {
						$msg = "Amount Received";
						window.location = "invoice_print.php?uid=" + app_idd + "&msg=" + $msg;
					} else {
						alert(msg)
					}

				}
			});
		}




	} else {

	}

});

$("#hold").click(function() {
var app_id = $("#appointment_idd").val();
var app_idd = $("#appointment_id").val();
if (confirm('Are you sure you want to save this Invoice?')) {
var test = $("#hold").val();
//alert(test)
if (test == 'hold') {

var type = $('input[name="paytype"]:checked').val();
//alert(type)
if (type == 'Partial') {

	var completeamt = $("#completeamt").val();
	var amt = $("#totalpayment").val();
	// alert(amt)
} else if (type == 'Complete') {

	var completeamt = Math.round($("#roundtotal").val());
	//alert(completeamt)
	var amt = $("#totalpayment").val();
	//alert(amt)
}



if (Number(completeamt) > Number(amt)) {
	alert('Amount Cannot Be Greater Than Total Amount')
} else {
	var abc = $("#paymentid").val();
	$("#totalpayment").html(abc);
	$.ajax({
		url: "printbill.php",
		type: 'post',
		data: $("#printcontent").serialize() + "&type=" + "H",
		success: function(msg) {
			//alert(msg)
			if ($.trim(msg) == '2') {
				$msg = "Amount is Pending";
				window.location = "invoice_print.php?uid=" + app_idd + "&msg=" + $msg;
			} else {
				alert(msg)
			}

		}



	});
}



}
} else {
// Do nothing!
}



});
$("#btnPrint").click(function() {
	//alert(111)
	var divContents = $("#printbill").html();
	//alert(divContents)
	var printWindow = window.open('', '', 'height=400,width=800');
	printWindow.document.write('<html><head><title>Invoice</title>');
	printWindow.document.write('</head><body >');
	printWindow.document.write(divContents);
	printWindow.document.write('</body></html>');
	printWindow.document.close();
	printWindow.print();
});
                
$("#ManagePackage").click(function() {
	$("#packagedetail").show();
});

$("#card").click(function() {

var app_id = $("#appointment_idd").val();
var app_idd = $("#appointment_id").val();


if (confirm('Are you sure you want to save this Invoice?')) {
	var test = $("#card").val();

	if (test == 'card') {
		$("#paymenttype").show();
		//$("#paymenttype1").show();




		var type = $('input[name="paytype"]:checked').val();
		//alert(type)
		if (type == 'Partial') {

			var completeamt = $("#completeamt").val();
			var amt = $("#totalpayment").val();
			// alert(amt)
		} else if (type == 'Complete') {

			var completeamt = $("#roundtotal").val();
			//alert(completeamt)
			var amt = $("#totalpayment").val();
			//alert(amt)
		}


		if (Number(completeamt) > Number(amt)) {

			alert('Amount Cannot Be Greater Than Total Amount')
		} else {
			$.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize() + "&type=" + "C",
				success: function(msg) {
					//alert(msg)
					if ($.trim(msg) == '2') {
						$msg = "Card Payment Received";
						window.location = "invoice_print.php?uid=" + app_idd + "&msg=" + $msg;
					} else {
						alert(msg)
					}

				}



			});
		}




	}

  


} else {
	// Do nothing!
}



});

$("#addtobill").click(function() {
	var totalpendamt = $("#totalpendamt").val();

	$("#pendingpayment").show();
	$("#totalpend").val(totalpendamt);
	var totalvalue = $("#totalcost").val();
	var totalpay = parseFloat(totalvalue) + parseFloat(totalpendamt);
	var roundtotal = Math.round(totalpay)
	$("#totalcost").val(totalpay);

	$("#roundtotal").val(roundtotal);
	$("#completeamtt").val(roundtotal);
	$("#totalpayment").val(roundtotal);
	$("#totalpaymentamt").val(roundtotal);
	$("#showpend").hide();

});


/* 	$("#hold").click(function(){
		
		
		var test=$("#hold").val();
		//alert(test)
		if(test=='hold')
		{
			$("#displaytext").html('Hold');
			$("#payment").show();
			
		}
	}); */

$("#remove_membership").click(function() {


	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	if (app_id != "") {
		$.ajax({
			type: "post",
			data: "&app_id=" + app_id,
			url: "removemember.php",
			success: function(respp) {
				//alert(respp)
				if ($.trim(respp) == '2') {
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}


			}

		})
	}


});
                //alert(number);


});
            var message = "Please dont try this as we are keeping a track of who is trying this!";

function clickIE4() {
	if (event.button == 2) {
		alert(message);
		return false;
	}
}

function clickNS4(e) {
	if (document.layers || document.getElementById && !document.all) {
		if (e.which == 2 || e.which == 3) {
			alert(message);
			return false;
		}
	}
}
if (document.layers) {
	document.captureEvents(Event.MOUSEDOWN);
	document.onmousedown = clickNS4;
} else if (document.all && !document.getElementById) {
	document.onmousedown = clickIE4;
}
document.oncontextmenu = new Function("alert(message);return false")


function removesinglevoucher() {
	//	alert(11)
	var gift = $("#GiftVoucherID").val();
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	// alert(app_idd)
	if (gift != "") {
		$.ajax({
			url: "DeleteVoucher.php",
			type: 'post',
			data: "gift=" + gift + "&app_idd=" + app_id,
			success: function(msg) {
				//alert(msg)
				if ($.trim(msg) == '3') {
					$msg = "Gift Voucher Removed Successfully";
					alert($msg)
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(msg) == '1') {
					alert('Cannot Removed Voucher')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}

			}
		});
	}

	///alert(gift)
}


function refreshdropdown() {
	var dropDown = document.getElementById("giftqty");
	dropDown.selectedIndex = 0;

	//$("#giftqty").reload();

}

function checkamt(evt) {
	//alert(111)
	var qty = $(evt).val();
	var gift = $("#giftvoucher").val();
	//alert(gift)
	var app_id = $("#appointment_idd").val();
	//alert(app_id)
	var app_idd = $("#appointment_id").val();
	var store = $("#storet").val();
	// alert(store)
	var cust_id = $("#cust_id").val();
	if (gift != "0" && gift != "" && gift != null && qty != "0" && qty != "") {

		$.ajax({
			url: "CalculateVoucherAmt.php",
			type: 'post',
			data: "id=" + gift + "&store=" + store + "&app_id=" + app_id + "&cust_id=" + cust_id + "&qty=" + qty,
			success: function(msg) {
				//alert(msg)

				$("#validitylimit").show();

				$("#validitylimit").html(msg);


			}
		});
	} else {
		alert('Please select amount first!')
	}


}

function checktypeofpayemnt() {
	var type = $('input[name="paytype"]:checked').val();
	//alert(type)
	if (type == 'Partial') {
		$("#paymentcheck").show();

	} else if (type == 'Complete') {
		var totalcost = $("#roundtotal").val();
		$("#completeamt").val(totalcost);
		$("#paymentcheck").hide();
	}
}

function test() {
	//alert(111)
	var abc = $("#paymentid").val();
	//alert(abc)
	var value = $("#totalvalue").text();
	// alert(value)

	if (Number(value) > Number(abc)) {
		alert('Amount Should Not Be Greater Than Total Amount')
	}
	$("#totalpayment").html(abc);
}

function checkinsert(evt) {

	var serviceid = $(evt).closest('td').prev().prev().find('input').val();

	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	//alert(app_id)
	if (serviceid != "") {
		$.ajax({
			type: "post",
			data: "serviceid=" + serviceid + "&app_id=" + app_id,
			url: "insertservice.php",
			success: function(res) {
				//alert(res)
				if ($.trim(res) == '2') {
					
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} 
				else if($.trim(res) == '3')
				{
					alert('You Cannot Add Same Service Again')
					 window.location = "appointment_invoice.php?uid=" + app_idd;
				}
				else {
					alert('Please Remove Membership or Gift Voucher or Offer Code to perform this action!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}
			}

		})
	}

}

function checkdelete(evt) {
	var serviceid = $(evt).closest('td').prev().prev().prev().find('input').val();
	var idd = $(evt).closest('td').find('input').val();
	//alert(serviceid);
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	//alert(app_id)
	if (serviceid != "") {
		$.ajax({
			type: "post",
			data: "serviceid=" + serviceid + "&app_id=" + app_id + "&idd=" + idd,
			url: "deleteservice.php",
			success: function(res) {
				//	alert(res)
				if ($.trim(res) == '2') {
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(res) == '3') {
					alert('Please Remove Membership or Gift Voucher or Offer Code to perform this action!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(res) == '4') {
					alert('There should be atleast one service in this appointment')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}
			}

		})
	}

}

function checkdeletepackage(evt) {

	var idd = $(evt).closest('td').find('input').val();

	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	//alert(app_id)
	if (idd != "") {
		$.ajax({
			type: "post",
			data: "app_id=" + app_id + "&idd=" + idd,
			url: "deletepackage.php",
			success: function(res) {
				//alert(res)
				if ($.trim(res) == '2') {
					alert('Package removed successfully!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}

			}

		})
	}

}

function assignmember() {
	// alert(1111)
	var member = $("#memebr").val();
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	//	alert(app_idd)

	/* var service=$("#serviceid").val();
	alert(service) */
	// alert(member)
	$(".membertype").val(member);
	if (member != "0") {
		$.ajax({
			type: "post",
			data: "member=" + member + "&app_id=" + app_id,
			url: "updatemember.php",
			success: function(respp) {

				if ($.trim(respp) == '2') {
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(respp) == '3') {
					alert('First Remove Gift Voucher')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(respp) == '4') {
					alert('Remove Offer Discount Or Gift Voucher And Then Apply Membership')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(respp) == '5') {
					alert('Remove Offer Discount Or Gift Voucher And Then Apply Membership')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(respp) == '6') {
					alert('Membership you are trying to apply has expired. Please renew the Membership!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(respp) == '7') {
					alert('Kindly note membership discount is not applicable on packages and gift vouchers!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(respp) == '8') {
					alert('Kindly note membership discount is not applicable on packages and gift vouchers!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}
				//alert($.trim(respp))
				//ans=[];




			}

		})
	}
}

function test1(evt) {
	//alert(222)
	// alert(evt)
	var qty = $(evt).val();
	//alert(qty)
	var id = $(evt).attr("id");
	//alert(id)
	var nexttdid = parseInt(id) + 1;
	//alert(nexttdid)
	var nexttdidfinal = "saif" + nexttdid;
	var Amount = $('#' + nexttdidfinal).val();
	//alert(Amount)
	var amt = parseFloat(Amount);
	var qqty = parseFloat(qty);
	var AmountAfterMultiply = 0;
	AmountAfterMultiply = qqty * amt;

	var totalamt = AmountAfterMultiply + ".00";
	//  alert(qty);
	//alert(id);
	//alert(nexttdidfinal);
	//alert(Amount);
	//alert(AmountAfterMultiply);

	$('#' + nexttdidfinal).val(totalamt) + ".00"
	var serviceid = $(evt).closest('td').prev().find('input').val();
	var idd = $(evt).closest('td').next().next().find('input').val();
	//alert(idd);
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	//alert(app_id)
	//alert(qty)

	if (qty != "") {
		$.ajax({
			type: "post",
			data: "qty=" + qty + "&amt=" + totalamt + "&serviceid=" + serviceid + "&app_id=" + app_id + "&idd=" + idd,
			url: "updateqty.php",
			success: function(res) {
				//alert(res)
				if ($.trim(res) == '2') {
					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(res) == '3') {
					alert('Please Remove Membership or Gift Voucher or Offer Code to perform this action!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}

			}


		})
	}

}

function calculatecashamount() {

	var totalcost = Math.round($("#totalcost").val());
	var cashamt = $("#cashboth").val();

	var completeamt = Math.round($("#completeamt").val());
	var ans = $('input:radio:checked').val();

	if (ans == 'Complete') {
		if (Number(cashamt) > Number(totalcost)) {
			alert('Cash Amount Greater Than Complete Amount');
		} else {


			var amt = parseFloat(totalcost) - parseFloat(cashamt);
			//	alert(amt)
			$("#cardboth").val(amt);

			var cardboth = $("#cardboth").val();

			$("#totalpayment").val(totalcost);
		}
	} else {
		if (Number(cashamt) > Number(completeamt)) {
			alert('Cash Amount Greater Than Partial Amount');
		} else {


			var amt = parseFloat(completeamt) - parseFloat(cashamt);
			//	alert(amt)
			$("#cardboth").val(amt);

			var cardboth = $("#cardboth").val();

			$("#totalpayment").val(totalcost);
		}
	}



}

function calculatecardamt() {
	//alert(111)
	var totalcost = Math.round($("#totalcost").val());
	var cardamtt = $("#cardboth").val();

	var completeamt = Math.round($("#completeamt").val());
	//alert(cardamtt)

	var ans = $('input:radio:checked').val();

	if (ans == 'Complete') {
		if (Number(cardamtt) > Number(totalcost)) {
			alert('Card Amount Greater Than Complete Amount');
		} else {
			var amt = parseFloat(totalcost) - parseFloat(cardamtt);
			//alert(amt)

			$("#cashboth").val(amt);

			$("#totalpayment").val(totalcost);
		}
	} else {
		if (Number(cardamtt) > Number(completeamt)) {
			alert('Card Amount Greater Than Partial Amount');
		} else {
			var amt = parseFloat(completeamt) - parseFloat(cardamtt);
			//alert(amt)

			$("#cashboth").val(amt);

			$("#totalpayment").val(completeamt);
		}
	}

}

//////////////////////////////////////
function calculatecomplete() {


	var complete = $("#completeamt").val();

	var totalcost = Math.round($("#totalcost").val());
	if (Number(complete) > Number(totalcost)) {
		alert('Complete Amount Should Not Be Greater Total Payment')
	} else {
		$("#completeamt").val();
		var amt = parseFloat(totalcost) - parseFloat(complete);
		//	alert(amt)
		$("#pendamt").val(amt);



		$("#totalpaymentamt").val(totalcost);
	}


}

function checkinsertpackage(evt) {
	var packageid = $(evt).closest('td').prev().prev().find('input').val();

	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	//alert(app_id)
	if (packageid != "") {
		$.ajax({
			type: "post",
			data: "packageid=" + packageid + "&app_id=" + app_id,
			url: "InsertPackage.php",
			success: function(res) {
				// alert(res)
				if ($.trim(res) == '2') {
					alert('Package added successfully!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}

			}

		})
	}
}

function calculatepend() {
	//alert(111)

	var pend = $("#pendamt").val();
	//alert(cardamtt)
	var totalcost = Math.round($("#totalcost").val());

	if (Number(pend) > Number(totalcost)) {
		alert('Pending amount should not be greater then total pending amount!')
	} else {
		$("#pendamt").val();
		var amt = parseFloat(totalcost) - parseFloat(pend);
		//alert(amt)

		var test = parseFloat(totalcost) + parseFloat(amt);
		$("#completeamt").val(amt);

		$("#totalpaymentamt").val(totalcost);
	}

}

function addtopackageservice(evt) {

	var packageid = $(evt).closest('td').next().find('input').val();
	var validdate = $(evt).closest('td').prev().find('input').val();
	var service = $(evt).closest('td').prev().prev().find('input').val();
	var app_id = $("#appointment_idd").val();
	var app_idd = $("#appointment_id").val();
	var store = $("#storet").val();
	var app_date = $("#app_date").val();

	if (packageid != "") {
		$.ajax({
			type: "post",
			data: "packageid=" + packageid + "&app_id=" + app_id + "&validdate=" + validdate + "&service=" + service + "&store=" + store + "&app_date=" + app_date,
			url: "AddServiceToPackage.php",
			success: function(res) {
				// alert(res)
				if ($.trim(res) == '2') {

					window.location = "appointment_invoice.php?uid=" + app_idd;
				} else if ($.trim(res) == '3') {
					alert('Package expired!')
					window.location = "appointment_invoice.php?uid=" + app_idd;
				}


			}

		})
	}
}

</script>
<style>
	.btn-success {
		background-color: lightgreen;
		color: black;
	}
	
	.btn-success:hover {
		background-color: lightgreen;
		color: black;
	}
	
	@media print {
		.no-print {
			display: none;
		}
	}
</style>

<body>
	<div id="sb-site">

		<?php require_once("incOpenLayout.fya"); ?>




		<div id="page-wrapper">
			<div id="mobile-navigation"><button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button></div>

			<?php require_once("incLeftMenu.fya"); ?>

			<div id="page-content-wrapper">
				<div id="page-content">

					<?php require_once("incHeader.fya"); ?>
					<link rel="stylesheet" type="text/css" href="print.css" media="print" />
					<div id="print_bill"></div>
					<?php                  
if(isset($_GET['uid']))
{
$DB = Connect();
$uidd = DecodeQ($_GET['uid']);
$ud=EncodeQ($uidd);
$counter = 0;
$strID = DecodeQ($_GET['uid']);

	?>
	<div class="panel">

		<div class="panel-body">
			<div class="fa-hover">
				<a href="javascript:window.location = document.referrer;" class="btn btn-primary btn-lg btn-block"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a><br/>
				<center><b><span id="displayoffererror" style="text-align:center;text-weight:bold"></b></center>
				</span>
				<?php 
	if(isset($data)!="")
	{
		?>
				<h1><b><?php echo $data; ?></b></h1>
				<?php
	}
	else
	{
		
	}
	?>
   </div>



<div class="panel-body col-md-4">
<br/>
<div class="example-box-wrapper">


<?php 
////////////////////////check condition for to display gift voucher/////////////////////////////				
	$seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
	$FreeService=$seldoffert[0]['FreeService'];
 
	$VoucherID=$seldoffert[0]['VoucherID'];
	$seldInvoice=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."'");
	$invoiceflag=$seldInvoice[0]['Flag'];
	$selp=select("*","tblGiftVouchers","Status='0' and AppointmentID='".DecodeQ($_GET['uid'])."'");
	$GiftVoucherID=$selp[0]['GiftVoucherID'];
	$RedemptionCode=$selp[0]['RedemptionCode'];
	$Amount=$selp[0]['Amount'];
	$RedempedBy=$selp[0]['RedempedBy'];
	if($FreeService!="0")
	 {
		 
	 }
	 elseif($invoiceflag=='H')
	 {
		 
	 }
	 else
	 {
		if($RedempedBy=='0')
		{
			?>
			<label class="control-label" style="width:25%">Gift Voucher</label>
			<input type="text" value="<?= $RedemptionCode?>" readonly /><input type="hidden" id="GiftVoucherID" value="<?= $GiftVoucherID?>" />&nbsp;&nbsp;&nbsp;<b><?=$Amount?></b>&nbsp;&nbsp;&nbsp;
			<a href="#" id="removesinglevoucher" class="btn btn-primary" value="Remove" onclick="removesinglevoucher()">Remove</a>
			<?php
					
		}
		else
		{
			?>

			<label class="control-label" style="width:48%">Available Gift Vouchers</label>
			<label class="control-label" style="width:48%;">Qty</label><br/>
			<select id="giftvoucher" style="width:45%;display:inline" class="form-control giftvoucher required" name="giftvoucher" onchange="refreshdropdown()">
			<option value="0">Select Voucher</option>
			<?php
			$selpk=select("*","tblGiftVoucherAmount","1");
			$GiftVoucherAmount=$selpk[0]['GiftVoucherAmount'];
			foreach($selpk as $vapq)
			{
				if($vapq['GiftVoucherAmount']!="")
				{
					?>
				<option value="<?=$vapq['GiftVoucherAmount']?>"><?=$vapq['GiftVoucherAmount']?></option>
				<?php
				}
				
			}
			?>
			</select>
            <select id="giftqty" class="giftqty form-control" onchange="checkamt(this)" name="giftqty" style="width:45%;display:inline">
			<option value="0">Select Here</option>
			<?php
			$count=1;
				while($count<11)
				{
					
						?>
					
				
			<option value="<?= $count ?>"><?= $count ?></option>
					<?php
					
					
					$count++;
				}
			?>
					
			</select>
	<div id="validitylimit" style="display:none"></div>
	<br/>
	<button type="button" id="gift" value="gift" class="btn btn-success" data-toggle="button"><center>Add Voucher</center></button>
	<?php
		}
					
						
					
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				 ?>


</div>
<!---display package table and service table------>
<button type="button" id="ManagePackage" class="btn btn-success" data-toggle="button"><center>Load Packages</center></button>
<?php
if($invoiceflag=='H')
{
}
else
{
?>
<div class="example-box-wrapper" id="packagedetail" style="display:none">
	<table class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="90%">
		<thead>
			<tr>
				<th>
					<center>Sr</center>
				</th>
				<th>
					<center>Package Name</center>
				</th>
				<th>
					<center>Package Cost
						<center>
				</th>
				<th class="no-print">
					<center>Action</center>
				</th>
			</tr>
		</thead>

		<tbody>
	<?php 
	$seldp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
	$stor=$seldp[0]['StoreID'];
	$PackageIDt=$seldp[0]['PackageID'];
	$packages=explode(",",$PackageIDt);
	$sepcontp=select("*","tblPackages","Status='0'");
	foreach($sepcontp as $qq)
	{
		$st[]=$qq['StoreID'];
		
	}
	$counte=1;
	 if(in_array("$stor",$st))
	 {
		 $sepcontpw=select("*","tblPackages","Status='0' and StoreID IN('".$stor."')");
		 foreach($sepcontpw as $ui)
		 {
		   $PackageNewPrice=$ui['PackageNewPrice'];
		   $PackageID=$ui['PackageID'];
			 $Name=$ui['Name'];
		   if(in_array("$PackageID",$packages))
		   {
			   
		   }
		   else
		   {
			  $dcountp=$counte ++;
			  ?>
			<tr id="my_data_tr_<?=$dcountp?>">
				<td style="text-align: center">
					<?=$dcountp?>
				</td>
				<td>
					<center>
						<?php echo $Name ?>
						<input type="hidden" name="PackageID[]" id="PackageID" value="<?php echo $PackageID ?>" /></center>
				</td>
				<td class="center">
					<center>
						<?php echo $PackageNewPrice ?>
					</center>
				</td>
				<td class="center">
					<center>
						<a id="inertpackage" href="#" onClick="checkinsertpackage(this)">Add</center></td>
	       </tr>
			  <?php
			 }
			
			  
			  
		 }
	 
	 }
	 else
	 {
		?>
		<tr><td></td><td>No Recors Found</td><td></td><td></td></tr>
		<?php
	 }

?>

 
	
</tbody>
</table>
</div>
<div class="example-box-wrapper">
<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="90%">
<thead>
	<tr>
		<th><center>Sr</center></th>
		<th><center>Service<center></th>
		<th><center>Cost</center></th>
		<th class="no-print"><center>Action</center></th>
	</tr>
</thead>
	<tfoot>
	<tr>
		<th><center>Sr</center></th>
		<th><center>Service<center></th>
		<th><center>Cost</center></th>
		<th class="no-print"><center>Action</center></th>
	</tr>
			</tfoot>
<tbody>
<?php 
$seldp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
$countp=1;
$seld=select("*","tblServices","StoreID='".$seldp[0]['StoreID']."'");
foreach($seld as $val)
{
   $dcount=$countp ++;
   $service=$val['ServiceID'];
   $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
   $cntserp=$sepcont[0]['count(*)'];
   if($cntserp>0)
   {
	   $selp=select("ServiceID","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");

		foreach($selp as $vap)
		{
			
			 
			$ServiceID=$vap['ServiceID'];
			
			if($ServiceID!=$service)
			{
				$datat=2;
			
			}
			else
			{
					$datat=1;
				
			}
			$dat2=$datat;
		}
   }
   else
   {
	   $datat=2;
	   $dat2=$datat;
   }
	
	if($dat2==2)
	{
		?>
		 <tr id="my_data_tr_<?=$dcount?>">
		<td style="text-align: center"><?=$dcount?></td>
		<td><center><?php echo $val['ServiceName'] ?>
		<input type="hidden" id="serviceid" value="<?php echo $val['ServiceID'] ?>" /></center>
		</td>
		<td class="center"><center><?php echo $val['ServiceCost'] ?></center></td>
		<td class="center">
		<center>
		<a id="insertservice" href="#" onClick="checkinsert(this)">Add
		</center>
		</td>
	  </tr>
		<?php
	}
	
	
}
?>

 
	
</tbody>
</table>
</div>
<?php
}
///////////////////////////////////////////////////////////////////////////////////////////////////
?>


</div>
<!-----------------display membership dropdown----------------->
<div class="panel-body col-md-8" >
<?php
	        if($FreeService!="0")
					 {
						 
					 }
			elseif($invoiceflag=='H')
					 {
						 
					 }
		      else
					 {
						?>
							
				<div id="displaymembership" class="panel-body">
			    <label class="control-label" style="width:25%" >Select Membership</label>
									
					<?php 
					$seldata=select("*","tblMembership","Status='0'");
					?>
					<select class="form-control" style="width:45%;display:inline-block;" style="text-align:center" id="memebr" onchange="assignmember()">
					<option value="0">Select Here</option>
					<?php
					foreach($seldata as $val)
					{
					?>

					<option value="<?= $val['MembershipID'];?>"><?= $val['MembershipName'];?></option>


					<?php
					}

					?>
					</select>

                 </div>
					<?php
					if($invoiceflag=='H')
					{
											 
					}
					else
					{
					?>
					<div id="displaymembership1" class="panel-body">
					<button type="button" id="remove_membership"  class="btn btn-success" data-toggle="button" ><center>Remove MemberShip</center></button>

					</div>
					<?php
					}																
                    }
///////////////////////////////////////////assign same membership or renew membership////////////////////////////////////////////////////////////////
$seldoffertq=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
$CustomerID=$seldoffertq[0]['CustomerID'];


$sqp=select("count(memberid)","tblAppointments","CustomerID='".$CustomerID."' and memberid!='0'");	
$seldoffertqt=select("*","tblCustomers","CustomerID='".$CustomerID."'");
$memberidp=$seldoffertqt[0]['memberid'];
$seldoffertqtm=select("*","tblMembership","MembershipID='".$memberidp."'");
$MembershipName=$seldoffertqtm[0]['MembershipName'];
//print_r($sqp);
$cnt=$sqp[0]['count(memberid)'];
$seldatapttptqppp=select("count(*)","tblCustomerMemberShip","CustomerID='".$CustomerID."'");
$cntttp=$seldatapttptqppp[0]['count(*)'];
$seldatapttptqp=select("*","tblCustomerMemberShip","CustomerID='".$CustomerID."'");	
//print_r($seldataptt);
$date=date('Y-m-d');
$enddate=$seldatapttptqp[0]['EndDay'];
$RenewStatus=$seldatapttptqp[0]['RenewStatus'];
				if($FreeService!="0")
					 {
						 
					 }
				elseif($invoiceflag=='H')
					 {
														 
					 }
					 else
					 {

							?>
							<div id="displaymembership2" class="panel-body" style="display:none">
							<input type="hidden" id="memidd" value="<?= $memberidp?>" />
							<button type="button" id="assignmembership"  class="btn btn-success" data-toggle="button" ><center>Assign Membership <?=$MembershipName?></center></button>

							</div>
							<?php
							if($cntttp>0)
							{
							if($date>=$enddate)
							{


							?>
							<div id="displaymembership3" class="panel-body" >
							<input type="hidden" id="memidd" value="<?= $memberidp?>" />
							<button type="button" id="renewmem"  class="btn btn-success" data-toggle="button" ><center>Renew & Assign Membership <?=$MembershipName?></center></button>

							</div>
							<?php

							}
							}


					 }
					 
					 
///////////////////////////////////////////////////display gift voucher code apply and remove div ///////////////////////////////////////////////////////////////////////
		 ?>
<div class="panel-body">
<?php 
$seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
$VoucherID=$seldoffert[0]['VoucherID'];
$memberid=$seldoffert[0]['memberid'];
$seldvoucher=select("count(GiftVoucherID),RedemptionECode,RedemptionCode","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
$cnt=$seldvoucher[0]['count(GiftVoucherID)'];		
$RedemptionECode=$seldvoucher[0]['RedemptionECode'];	
$RedemptionCode=$seldvoucher[0]['RedemptionCode'];
		    if($FreeService!="0")
					 {
						 
					 }
			elseif($invoiceflag=='H')
					 {
						 
					 }
					 else
					 {
									  
  
							if($cnt!='0')
							{
							?>
							<label class="control-label" style="width:25%" >Gift Voucher Code</label>
							<input type="text" style="width:45%;display:inline-block;"  name="giftname" id="giftname" class="form-control" value="<?=$RedemptionCode?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="removevoucher" style="width:12%;display:inline-block;" value="<?php echo $RedemptionECode ?>" class="btn btn-success" data-toggle="button" ><center>Remove</center></button>	
							<?php

							}
							else
							{
							?>
							<label class="control-label" style="width:25%" >Gift Voucher Code</label>
							<input type="text" style="width:45%;display:inline-block;"  name="giftname" id="giftname" class="form-control" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="giftapply" style="width:25%;display:inline-block;"  class="btn btn-success" data-toggle="button" ><center>Voucher Code</center></button>

							<?php


							}
					 }
					 //////////////////////////////////////////////////////////////////////////////////
?>             


</div>


<div class="panel-body">
<?php 
////////////////////////////////////////////////display offer div/////////////////////////////////////
$seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
$offerid=$seldoffer[0]['offerid'];
$seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
$OfferCode=$seldofferp[0]['OfferCode'];						
			 if($FreeService!="0")
					 {
						 
					 }
			 elseif($invoiceflag=='H')
					 {
						 
					 }
			 else
					 {		
							if($offerid!="0")
							{
							?>

							<label class="control-label" style="width:25%" >Offer Name</label>
							<input type="text"  readonly style="width:45%;display:inline-block;" value="<?php echo $OfferCode ?>" name="offername" id="offername" class="form-control" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="offeridremove" style="width:12%;display:inline-block;" value="<?php echo $OfferCode ?>" class="btn btn-success" data-toggle="button" ><center>Remove</center></button>
							</div>

							<?php
							}
							else
							{
							?>
							<label class="control-label" style="width:25%" >Offer Name</label>
							<select id="offername" style="width:45%;display:inline-block;" class="form-control offername" name="offername">
													<option value="0">Select Here</option>
													<?php 
													$seldata=select("*","tblOffers","Status='0'");
													foreach($seldata as $val)
													{
														?>
														<option value="<?= $val['OfferID']?>"><?=$val['OfferName'] ?></option>
														<?php
													}
													?>
													
													</select>
							&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="offerid" style="width:25%;display:inline-block;" value="Check Offer" class="btn btn-success" data-toggle="button" ><center>Apply Offer</center></button>
							</div>
																<?php
							}
						}
/////////////////////////////////////////////////////////start bill code//////////////////////////////////////
								?>
							  
					
<div class="example-box-wrapper" id="printbill" >
<form id="printcontent" name="printcontent">
   <table border="0" cellspacing="0" cellpadding="0" width="100%" >
    <tbody>
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
                    <tbody>
                        <tr>
						<td>
							<table style="BORDER-BOTTOM:#d0ad53 1px solid;BORDER-LEFT:#d0ad53 1px solid;BORDER-TOP:#d0ad53 1px solid;BORDER-RIGHT:#d0ad53 1px solid;background:url('http://nailspaexperience.com/images/test3.png') no-repeat; background-position:50% -140px;" border="0" cellspacing="0" cellpadding="0" width="98%" bgcolor="#ffffff" align="center" >
								<tbody>
								<?php
								//echo DecodeQ($_GET['uid']);
								$seldp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
								// $seldpd=select("StoreBillingAddress","tblStores","StoreID='".$seldp[0]['StoreID']."'");
								$seldpd=select("*","tblStores","StoreID='".$seldp[0]['StoreID']."'");
								$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
								$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
									//print_r($seldpdep);
									//$seldpdepp=select("EmployeeName","tblEmployeesServices","EID='".$seldp[0]['EID']."'");
								$seldpdeptp=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
								foreach($seldpdeptp as $ty)
								{
								 $totalservices=$ty['ServiceID'];
								 $seldpdepp=select("*","tblEmployeesServices","ServiceID='".$totalservices."'");
									//print_r($seldpdepp);
									
								}
								//$sereviceep=implode(",",$totalservices);
							
								?>
							<tr>
								<input type="hidden" name="cust_id" id="cust_id" value="<?= $seldpdep[0]['CustomerID'];?>" />
								<input type="hidden" name="storet" id="storet" value="<?= $seldpd[0]['StoreID'];?>" />
							<input type="hidden" name="appointment_id" id="appointment_id" value="<?=$ud?>" />
							<input type="hidden" name="appointment_idd" id="appointment_idd" value="<?= DecodeQ($_GET['uid']); ?>" />
								<td align="middle">
									<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
										<tbody>
											<tr>
												<td width="50%" align="left" style="padding:1%;"><img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"></td>
												<td width="50%" align="right" style="LINE-HEIGHT:15px; padding:1%; FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold;">
												
												<input readonly name="billaddress" style="FONT-WEIGHT:bold;" value="<?php echo $seldpd[0]['StoreName']; ?>" />
											   
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
							 <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:0px;" height="5"></td>
							</tr>
							  <tr>
								<td align="middle">
									<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
										<tbody>
										  <tr>
											<td width="50%">To ,</td>
											<td width="25%" >Invoice No :</td>
											<td width="25%"style="float:left;"><input readonly name="invoiceid" value="<?php echo $seldpde[0]['InvoiceID']; ?>" /></td>
										  </tr>
										   <tr>
											<td width="50%"><b><input readonly name="CustomerFullName" value="<?php echo $seldpdep[0]['CustomerFullName']; ?>" /></b></td>
											<td width="25%">Membership No :</td>
											<td width="25%"style="float:left;">
											<?php
											//////////check membership is blank or /////////////////////
											if($seldp[0]['memberid']=='0')
											{
												?>
												<input readonly name="memberid" value="-" /></td>
												<?php
											}
											else
											{
												?>
												<input readonly name="memberid" value="<?php echo $seldp[0]['memberid']; ?>" /></td>
												<?php
												
											}
											?>
											
										  </tr>
											 <tr>
											<td width="50%"><input readonly name="email" value="<?php echo $seldpdep[0]['CustomerEmailID'] ?>" /></td>
											
										  </tr>
										   <tr>
											<td width="50%"><input readonly name="mobile" value="<?php echo $seldpdep[0]['CustomerMobileNo'] ?>" /></td>
											<td width="25%">stylist(s) :</td>
											
											<td width="25%"style="float:left;">
											<?php
										//////////////////////////check stylist is blank or not/////////////////////////////////
											$seldpdeppt=select("distinct(MECID)"," tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."'");
											foreach($seldpdeppt as $vap)
											{
											$empname=$vap['MECID'];
											$emppp=$emppp.','.$empname;
											}
											//$empnamep=implode(",",$empname);
										
											if($emppp=="")
											{
												?>
												<input readonly name="EID" value="-" />
												<?php
											}
											else
											{
												?>
												<input readonly name="EID" value="<?php echo trim($emppp,","); ?>" />
												<?php
											}
											?>
											
											</td>
										  </tr>
										</tbody>
									</table>
								</td>
							</tr>
										
                                        
							<tr>
								<td height="8"></td>
							</tr>
							<tr>
								<td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:20px;text-align:center;" height="30"><b>Invoice</b></td>
							</tr>
							<tr>
								<td height="8">
									<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
										<tbody>
											<tr>
												<td bgcolor="#e4e4e4" height="4"></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						<tr>
							<td>
								<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
							  
								
								<tbody>
										<tr>
										  <th width="5%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Sr</th>
										  <th width="40%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
										   <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Qty / Valid Till</th>
										  <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
										  <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Action</th>
										
										</tr>
										<?php 
										
										$seldpdept=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."' and PackageService='0'");
										$sub_total=0;
										
										$countersaif = "";
										$countsf = "0";
										$counterusmani = "1";
										foreach($seldpdept as $val)
										{
											//echo $val['ServiceID'];
											$countersaif ++;
											$countsf++;
											$counterusmani = $counterusmani + 1;
											$totalammt=0;
											$AppointmentDetailsID=$val['AppointmentDetailsID'];
											
											$servicee=select("*","tblServices","ServiceID='".$val['ServiceID']."'");
											$qtyyy=$val['qty'];
											$amtt=$val['ServiceAmount'];
											$totalammt=$qtyyy*$amtt;
											$total=0;
										
										 ?>	
                                         <!--display service detail-->										 
										<tr>
										  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input type="hidden"  name="servicecode[]" value="<?php echo $servicee[0]['ServiceCode']; ?>" /><input type="hidden" name="membertype" id="membertype" class="membertype"/><?=$countsf?></td>
										  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input type="hidden" name="serviceid[]" id="serviceid" value="<?php echo $val['ServiceID'] ?>" /><?php echo $servicee[0]['ServiceName']; ?></td>
											<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">
											<select id="<?=$countersaif?>" class="quantity" onchange="test1(this)" name="qty[]">
											
											<?php
											/////////////qty////////////////////
											$count=1;
												while($count<11)
												{
													if($val['qty']==$count)
													{
														//echo 2324;
														?>
												<option value=" <?php  echo $count;   ?>" selected='selected'  ><?php  echo $count;   ?></option>
												<?php
														
													}
													else
													{
														?>
													
												
											<option value="<?= $count ?>"><?= $count ?></option>
													<?php
													}
													
													$count++;
												}
											?>
												
											</select>
											
										 </td>
										  <td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input id="saif<?=$counterusmani?>" name="serviceamt[]" type="text" readonly value="<?php echo $totalammt.".00"; ?>" />
										  <?php 
										 
										  $sub_total=$sub_total+$totalammt;
										  $total=$total+$sub_total;
										  
										  
										  ?></td>
										  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;" class="no-print">
										  <input type="hidden" id="AppointmentDetailsID" value="<?= $AppointmentDetailsID?>" />
												<a id="deleteservice" href="#" onClick="checkdelete(this)">Remove</a></td>
										<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;" class="no-print">
												<?php
												 $seldpdepp=select("*","tblEmployeesServices","1");
												 ?>
										</td>
										</tr>
<!------display membership discount % or amount as per service ---------->
										<tr>
											<?php 
											$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$memid=$seldember[0]['memberid'];
											
										if($memid!="0")
										{
											
											 
											$DB = Connect();
											$seldatap=select("DiscountType","tblMembership","MembershipID='".$memid."'");	
											$type=$seldatap[0]['DiscountType'];
											if($type=='0')
											{
											$seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$memid."'");	  
											//print_r($seldata);
											$services=$seldata[0]['NotValidOnServices'];
											$membershipname=$seldata[0]['MembershipName'];
											$Discount=$seldata[0]['Discount'];
											$sericesd=explode(",",$services);

											if(in_array($val['ServiceID'],$sericesd))
													{
											
													}
													else
													{
														$serviceid=$val['ServiceID'];
											$serviceamount=$val['ServiceAmount'];
											$qty=$val['qty'];
											$amount=$qty*$serviceamount;
											$totalamount=$amount*$Discount/100;
	
		?>
												<input type="hidden" name="serviceidm[]" id="serviceidm" value="<?= $serviceid ?>" />
												<input type="hidden" name="discountm[]" id="discountm" value="<?= $totalamount ?>" />
												<input type="hidden" name="memid[]" id="memid" value="<?= $memid ?>" />
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input readonly name="membershipname[]" value="<?php echo $membershipname; ?>" /></td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input readonly name="Discount[]" value="<?php echo $Discount; ?>" />%
													<?=$membershipname?>&nbsp; Discount </td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
												<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">

													<input id="disamt" type="text" name="disamt[]" readonly value="<?=$totalamount." .00 " ?>" />
													<?php 
											  $offdisp=$offdisp+$Discount;
											  $memberdis=$memberdis+$totalamount;
											   $seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											
											 $FreeService=$seldoffert[0]['FreeService'];
												 if($FreeService!="0")
												 {
													 
												 }
												 else
												 {
												  if($memid!="0")
												  {
													$amt=$totalammt-$totalamount;
													$serve=$val['ServiceID'];
													$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serve."'";
													//echo $sqlcharges."<br>";
													$charges = $DB->query($sqlcharges);
													if ($charges->num_rows > 0) 
													{
														while($row = $charges->fetch_assoc())
														{
															$ChargeNameId = $row["ChargeNameId"];
															$ArrayChargeSet = $row["ArrayChargeSet"];
															$strChargeSet = explode(",",$ArrayChargeSet);
														}
													}		

													for($j=0; $j<count($strChargeSet); $j++) 
													{
														$strChargeSetforwork = $strChargeSet[$j];
														$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";

													$RS2 = $DB->query($sqlchargeset);
													if ($RS2->num_rows > 0) 
													{
														while($row2 = $RS2->fetch_assoc())
														{
															$strChargeAmt = $row2["ChargeAmt"];
															$strSetName = $row2["SetName"];
															$strChargeFPType = $row2["ChargeFPType"];
															// Calculation of charges
															$ServiceCost = $amt;
															if($strChargeFPType == "0")
															{
																$strChargeAmt = $strChargeAmt;
															}
															else
															{
																$percentage = $strChargeAmt;
																//echo "percentage=".$percentage."<br/>";
																 $outof = $ServiceCost;
																 //echo "ServiceCost=".$ServiceCost."<br/>";
																 $strChargeAmt = ($percentage / 100) * $outof;
																 //echo "strChargeAmt=".$strChargeAmt."<br/>";
															
															}
																 $totalamt=$strChargeAmt;
																 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																 $cntserp=$sepcont[0]['count(*)'];
															   if($cntserp>0)
															   {
																  $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";
																  ExecuteNQ($sqlUpdate1);
															   }
															   else
															   {
																  
															   }
														
														}
													 }
													}
													unset($strChargeSet);
												  }
												  else
												  {
													 $amt=$totalammt;
													 $serve=$val['ServiceID'];
													 $sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serve."'";
													//echo $sqlcharges."<br>";
														$charges = $DB->query($sqlcharges);
														if ($charges->num_rows > 0) 
														{
															while($row = $charges->fetch_assoc())
															{
																$ChargeNameId = $row["ChargeNameId"];
																$ArrayChargeSet = $row["ArrayChargeSet"];
																$strChargeSet = explode(",",$ArrayChargeSet);
															}
														}		

													for($j=0; $j<count($strChargeSet); $j++) 
													{
													$strChargeSetforwork = $strChargeSet[$j];
													$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";

													$RS2 = $DB->query($sqlchargeset);
														if ($RS2->num_rows > 0) 
														{
															while($row2 = $RS2->fetch_assoc())
															{
																$strChargeAmt = $row2["ChargeAmt"];
																$strSetName = $row2["SetName"];
																$strChargeFPType = $row2["ChargeFPType"];
																// Calculation of charges
																$ServiceCost = $amt;
																if($strChargeFPType == "0")
																{
																	$strChargeAmt = $strChargeAmt;
																}
																else
																{
																	
																	$percentage = $strChargeAmt;
																	//echo "percentage=".$percentage."<br/>";
																	 $outof = $ServiceCost;
																	 //echo "ServiceCost=".$ServiceCost."<br/>";
																 $strChargeAmt = ($percentage / 100) * $outof;
																	 //echo "strChargeAmt=".$strChargeAmt."<br/>";
																
																
																
																}
															$totalamt=$strChargeAmt;
															$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$cntserp=$sepcont[0]['count(*)'];
															   if($cntserp>0)
															   {
																$sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";
																ExecuteNQ($sqlUpdate1);
															   }
															   else
															   {
																   
															   }

															}
														}
													}
													unset($strChargeSet);
												  }
													 }
											




												  ?></td>
													<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
													<?php

											}
										}
										else
										{
										$seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$memid."'");	  
										//print_r($seldata);
										$services=$seldata[0]['NotValidOnServices'];
										$membershipname=$seldata[0]['MembershipName'];
										$Discount=$seldata[0]['Discount'];
										$sericesd=explode(",",$services);
										//print_r($sericesd);

										if(in_array($val['ServiceID'],$sericesd))
											{
											
											}
											else
											{
											   ?>
												<input type="hidden" name="serviceidm[]" id="serviceidm" value="<?= $serviceid ?>" />
												<input type="hidden" name="discountm[]" id="discountm" value="<?= $Discount ?>" />
												<input type="hidden" name="memid[]" id="memid" value="<?= $memid ?>" />
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input readonly name="membershipname[]" value="<?php echo $membershipname; ?>" /></td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input readonly name="Discount[]" value="<?php echo $Discount; ?>" />
												<?=$membershipname?>&nbsp; Discount </td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
												<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
												<input id="disamt" name="disamt[]" type="text" readonly value="<?=$Discount." .00 " ?>" />
													<?php 
											  $offdisp=$offdisp+$Discount;
											  $memberdis=$memberdis+$Discount;
											  $seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											  $FreeService=$seldoffert[0]['FreeService'];
												 if($FreeService!="0")
												 {
													 
												 }
												 else
												 {
														if($memid!="0")
														  {
																$amt=$totalammt-$Discount;
																$serve=$val['ServiceID'];
																$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serve."'";
																//echo $sqlcharges."<br>";
																$charges = $DB->query($sqlcharges);
																if ($charges->num_rows > 0) 
																{
																while($row = $charges->fetch_assoc())
																{
																$ChargeNameId = $row["ChargeNameId"];
																$ArrayChargeSet = $row["ArrayChargeSet"];
																$strChargeSet = explode(",",$ArrayChargeSet);
																}
																}		

																for($j=0; $j<count($strChargeSet); $j++) 
																{
																$strChargeSetforwork = $strChargeSet[$j];
																$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";

																$RS2 = $DB->query($sqlchargeset);
																if ($RS2->num_rows > 0) 
																{
																while($row2 = $RS2->fetch_assoc())
																{
																$strChargeAmt = $row2["ChargeAmt"];
																$strSetName = $row2["SetName"];
																$strChargeFPType = $row2["ChargeFPType"];
																// Calculation of charges
																$ServiceCost = $amt;
																if($strChargeFPType == "0")
																{
																$strChargeAmt = $strChargeAmt;
																}
																else
																{

																$percentage = $strChargeAmt;
																//echo "percentage=".$percentage."<br/>";
																$outof = $ServiceCost;
																//echo "ServiceCost=".$ServiceCost."<br/>";
																$strChargeAmt = ($percentage / 100) * $outof;
																//echo "strChargeAmt=".$strChargeAmt."<br/>";

																}
																$totalamt=$strChargeAmt;
																$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																$cntserp=$sepcont[0]['count(*)'];
																   if($cntserp>0)
																   {
																	$sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";
																	ExecuteNQ($sqlUpdate1);
																   }
																   else
																   {
																	  
																   }

																}
																}
																}
																unset($strChargeSet);
														  }
														  else
														  {
																	 $amt=$totalammt;
																	 $serve=$val['ServiceID'];
																	 $sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serve."'";
																	//echo $sqlcharges."<br>";
																		$charges = $DB->query($sqlcharges);
																		if ($charges->num_rows > 0) 
																		{
																		while($row = $charges->fetch_assoc())
																		{
																		$ChargeNameId = $row["ChargeNameId"];
																		$ArrayChargeSet = $row["ArrayChargeSet"];
																		$strChargeSet = explode(",",$ArrayChargeSet);
																		}
																		}		

																		for($j=0; $j<count($strChargeSet); $j++) 
																		{
																		$strChargeSetforwork = $strChargeSet[$j];
																		$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";

																		$RS2 = $DB->query($sqlchargeset);
																		if ($RS2->num_rows > 0) 
																		{
																		while($row2 = $RS2->fetch_assoc())
																		{
																		$strChargeAmt = $row2["ChargeAmt"];
																		$strSetName = $row2["SetName"];
																		$strChargeFPType = $row2["ChargeFPType"];
																		// Calculation of charges
																		$ServiceCost = $amt;
																		if($strChargeFPType == "0")
																		{
																		$strChargeAmt = $strChargeAmt;
																		}
																		else
																		{

																		$percentage = $strChargeAmt;
																		//echo "percentage=".$percentage."<br/>";
																		$outof = $ServiceCost;
																		//echo "ServiceCost=".$ServiceCost."<br/>";
																		$strChargeAmt = ($percentage / 100) * $outof;
																		//echo "strChargeAmt=".$strChargeAmt."<br/>";
																		}
																		$totalamt=$strChargeAmt;
																		$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																		$cntserp=$sepcont[0]['count(*)'];
																	   if($cntserp>0)
																	   {
																		$sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";
																		ExecuteNQ($sqlUpdate1);
																	   }
																	   else
																	   {
																		  
																	   }

																		}
																		}
																		}
																unset($strChargeSet);
														  }
									

											 }
										



										//  $sub_total=$sub_total-$Discount;
									// $total=$total+$sub_total;
										//  $amt=$sub_total-$memberdis;
										  
										  ?></td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>

												<?php
											}


															
										//echo "<br/>";


										}
										$DB->close();
																		   
																			
										}
										else
										{
											
										}
								
																?>
										</tr>

										<?php
						
								//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//////////////////////////////////display package name with validity-price//////////////////////////////////////		
										
										}
										$seldoffertpp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										$Package=$seldoffertpp[0]['PackageID'];
										$packagess=explode(",",$Package);
										$AppointmentDate=$seldoffertpp[0]['AppointmentDate'];
										for($i=0;$i<count($packagess);$i++)
										{
											
										if($packagess[$i]!=0)
										{
										
											   $seldpack=select("*","tblPackages","PackageID='".$packagess[$i]."'");
											   $packname=$seldpack[0]['Name'];
											   $PackageNewPrice=$seldpack[0]['PackageNewPrice'];
											   $Validityp=$seldpack[0]['Validity'];
											   $valid="+".$Validityp."Months";
											   $validpack = date('Y-m-d', strtotime($valid));
											  
											   
											   $seldpackq=select("count(*),PackageID","tblBillingPackage","PackageID='".$packagess[$i]."' and AppointmentID='".DecodeQ($_GET['uid'])."'");
											   $countpack=$seldpackq[0]['count(*)'];
											   $PackagePack=$seldpackq[0]['PackageID'];
											   $sub_total=$sub_total+$PackageNewPrice;
											   
											?>
											<tr>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:Bold; padding-left:2%;">&nbsp;&nbsp;
													<?=$packname?>
												</td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal;"><input type="hidden" id="app_date" value="<?=$AppointmentDate?>" />
													<?=$validpack?>
												</td>
												<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
													<?=$PackageNewPrice?>
												</td>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;" class="no-print"> <input type="hidden" id="PackageID" name="PackageID[]" value="<?=$packagess[$i]?>" />
													<?php
												   if($countpack>0)
												   {
													   
												   }
												   else
												   {
													   ?>
										<a id="deletepackage" href="#" onClick="checkdeletepackage(this)">Remove</a></td>
									<?php
												   }
							   ?>


											</tr>
											<?php
										
					//////////////////////////////////display package services//////////////////////////////////////////////					
									   
									 if($packagess[$i]!="0" || $packagess[$i]!="")
										{
											$date=date('Y-m-d');
											$seldpdeptwp=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."' and PackageService='".$packagess[$i]."'");
												foreach($seldpdeptwp as $vatq)
												{
													$servicee=select("*","tblServices","ServiceID='".$vatq['ServiceID']."'");
													$ServiceName=$servicee[0]['ServiceName'];
													$qtyyy=$val['qty'];
													$amtt=$val['ServiceAmount'];
													$seldpdepte=select("*","tblBillingPackage","AppointmentID='".DecodeQ($_GET['uid'])."' and PackageID='".$packagess[$i]."' and ServiceID='".$vatq['ServiceID']."'");
													$sstatus=$seldpdepte[0]['Status'];
													?>
														<tr>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input type="hidden" name="detailid" id="detailid" value="<?=$vatq['ServiceID']?>" /></td>
                                                       <?php 
															if($sstatus=='1')
															{
																?>
																<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:green;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input type="hidden" id="app_validdate" value="<?=$validpack?>" />
																<?=$ServiceName?>
															    </td>
															  <?php
															}
															else
															{
																?>
																<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:red;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input type="hidden" id="app_validdate" value="<?=$validpack?>" />
															    <?=$ServiceName?>
																</td>
																<?php
															}
															
															?>

												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">
												<?php
														if($sstatus=='1')
														{
															echo "Done";
														}
														else
														{
															$seldata=select("ValidTill","tblAppointmentPackageValidity","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$ValidTill=$seldata[0]['ValidTill'];
															 if($date>$ValidTill)
															 {
															   echo "Service Expired";
															 }
															 else
															 {
																 ?>
																<button type="button" id="addtopackage" onclick="addtopackageservice(this)" style="display:inline-block;" class="btn btn-xs btn-primary" data-toggle="button"><center>Done</center></button>
																<?php
															 }
														}
				?>
												</td>
												<td style="display:none"><input type="hidden" name="packid" id="packid" value="<?=$packagess[$i]?>" /></td>
                                                </tr>
												<?php
												}
										}
										}
										
										}
						///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						/////////////////////////////////////////display gift voucher wih name and amount///////////////////////////////////////////////////////
										$seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										$VoucherID=$seldoffert[0]['VoucherID'];
											if($VoucherID!='0')
											{
												$selp=select("*","tblGiftVouchers","Status='0' and AppointmentID='".DecodeQ($_GET['uid'])."'");
											$GiftVoucherID=$selp[0]['GiftVoucherID'];
											$RedemptionCode=$selp[0]['RedemptionCode'];
											$Status=$selp[0]['Status'];
											$Amount=$selp[0]['Amount'];
			 
												if($RedemptionCode!="0")
												{
																	if($Status=='0')
																	{
																	//echo $RedemptionCode;
																
																	?>
																				<tr>
																					<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
																					<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"> <input type="text" style="width:60%" value="<?= $RedemptionCode?>" readonly />&nbsp;&nbsp;Gift Voucher Code</td>
																					<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
																					<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
																						<?=$Amount?>
																					</td>


																				</tr>
																				<?php
																   $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																   $cntserp=$sepcont[0]['count(*)'];
																   if($cntserp>0)
																   {
																	  
																   }
																   else
																   {
																		$sub_total=$sub_total+$Amount;
																   }
																   }
												}
											}
											///////////////////////////
											?>




									</tbody>

								</table>
								</td>


								</tr>

		
							  <tr>
									<td>
										<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">

											<tbody>
	  <!---------------------------------display sub totatl------------->

												<tr>
													<td width="50%">&nbsp;</td>
													<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Sub Total</td>
													<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" id="sub_total" name="sub_total" readonly value="<?php echo number_format($sub_total,2);?>" />
													</td>
												</tr>
												<?php 
												
													$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
													$VoucherID=$seldember[0]['VoucherID'];  
											        $seldembert=select("Status","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."'");
													//print_r($seldembert);
													$Status=$seldembert[0]['Status'];  
												
												if($Status=='0')
												{
													
													$selpt=select("*","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."' and Status='0'");
													//print_r($selpt);
                                                    $amtt=$selpt[0]['Amount'];
												    $id=$selpt[0]['GiftVoucherID'];
												    $selptp=select("*","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
													if($selptp!='0')
													{

														   $amttp=$selptp[0]['Amount'];
														   $id=$selptp[0]['GiftVoucherID'];
														   if($amttp!="0")
																   {
																		if($amtt > $sub_total)
																		{
																		$redamt=$sub_total;	
																		$sub_total=0;
																		
																		}
																		else{
																		$totalamt=$amtt-$amttp;
																	   $sub_total=$sub_total+$totalamt;
																			
																		}
															  
																	
		?>
														<tr>
															<td width="50%">&nbsp;</td>
															<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Redemption Gift Voucher Discount</td>
															<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="hidden" name="Redemptid" Value="<?=$id?>" /><input type="text" name="vouchercost" readonly value="<?php echo " - ".number_format($amttp,2);?>" />
															</td>
														</tr>
														<?php
																	}
																else
																{
												   
																}
													   } 
													 ////////////////////////////////////////////////////////////////////////////////////////
													 ///////////////////////////////////////////////display gift voucher purchase cost/////////////////////////////
														   $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
														   $cntserp=$sepcont[0]['count(*)'];
														   if($cntserp>0)
														   {
															   
																 $sub_total=$sub_total+$amtt;
																						   
								?>
																				<tr>
																					<td width="50%">&nbsp;</td>
																					<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Gift Voucher Cost</td>
																					<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="hidden" name="purchaseid" Value="<?=$id?>" /><input type="text" name="vouchercost" readonly value="<?php echo " + ".number_format($amtt,2);?>" />
																					</td>
																					<?php
														   }
														   else
														   {
															   
														   }
														   ?>

													</tr>
													<?php
														   
															
														 
													
													
												 
													
													
												}
												else
												{
													
									    ////////////////////////////display gift voucher redemption amount//////////////
													 $selpt=select("*","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
												     $amtt=$selpt[0]['Amount'];
													 $RedempedBy=$selpt[0]['RedempedBy'];
													 $id=$selpt[0]['GiftVoucherID'];
													 
													 if($amtt!='0')
													 {
														
													   if($RedempedBy==DecodeQ($_GET['uid']))
															{
																
																
																if($amtt > $sub_total)
																{
																	$redamt=$sub_total;
																	$sub_total=0;
																
																}
																else{
																		$sub_total=$sub_total-$amtt;
																}																					
																
														  
?>
														<tr>
															<td width="50%">&nbsp;</td>
															<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Redemption Gift Voucher Discount</td>
															<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="hidden" name="Redemptid" Value="<?=$id?>" /><input type="text" name="vouchercost" readonly value="<?php echo " - ".number_format($amtt,2);?>" />
															</td>
														</tr>
														<?php
															}
														 } 
										   
														$selpt=select("*","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."' and Status='0'");
																 if($selpt!='0')
																 {
													   $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
													   $cntserp=$sepcont[0]['count(*)'];
													   if($cntserp>0)
													   {
																			  
																			   $amttp=$selpt[0]['Amount'];
																			   $id=$selpt[0]['GiftVoucherID'];
																			   $sub_total=$sub_total+$amttp;
																				   ?>
																					<tr>
																						<td width="50%">&nbsp;</td>
																						<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Gift Voucher Cost</td>
																						<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="hidden" name="purchaseid" Value="<?=$id?>" /><input type="text" name="vouchercost" readonly value="<?php echo " + ".number_format($amttp,2);?>" />
																						</td>
																					</tr>
																					<?php
																				

																				  
																			 
																  }
																 else
																 {

																 }			
																					   
													   }
													   else
													   {
														   
													   }
																		  

													 
												
													
												}
												
										

							//////////////////////////////////////display first time membercost if flag is processing and hold/////////////////////////////				   
										
									        $seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$memid=$seldember[0]['memberid'];  
											$custid=$seldember[0]['CustomerID'];  
										    $seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
										 	$Cost=$seldemberg[0]['Cost'];  		
											$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
											$memberflag=$selcust[0]['memberflag'];  		
											$cust_name=$selcust[0]['CustomerFullName'];
											$memidd=$selcust[0]['memberid'];
											if($memberflag=='0')
											{
												if($memid!="0")
												{
													 $sub_total=$sub_total+$Cost;
														?>
																<tr>
																	<td width="50%">&nbsp;</td>
																	<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
																		<?=$membershipname?>&nbsp;Cost</td>
																	<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="membercost" readonly value="<?php echo " + ".number_format($Cost,2);?>" />
																	</td>
																</tr>
																<?php
												}
												
											}
											elseif($memberflag=='1')
											{
								
											}
											elseif($memberflag=='2')
											{
												
										
											}
										   else
											{
												////////////////check type of bill if hold with flag in memberflag of customer table///////////////////
												$est=explode(",",$memberflag);
												if($est[0]=='3')
												{
													$app_id=DecodeQ($_GET['uid']);
													if($app_id==$est[1])
													{
														$selcustd=select("Membership_Amount","tblInvoiceDetails","CustomerFullName='".$cust_name."' and AppointmentId='".DecodeQ($_GET['uid'])."'");	
														$Membership_Amount=$selcustd[0]['Membership_Amount'];
														if($Membership_Amount!="")
														{
															 $sub_total=$sub_total+$Cost;
															?>
																	<tr>
																		<td width="50%">&nbsp;</td>
																		<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
																			<?=$membershipname?>&nbsp;Cost</td>
																		<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="membercost" readonly value="<?php echo " + ".number_format($Cost,2);?>" />
																		</td>
																	</tr>
																	<?php
														}
														
													}
												}
														?>

																		<?php
											}
											
											/////////////////////////////////////////////////////
											////////////////////////////////////////display offer td/////////////////////////////////
											$seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$offerid=$seldoffer[0]['offerid'];
											if($offerid!="0")
											{
												
									?>

											<tr>
											<td width="50%">&nbsp;</td>
                              <?php 
									        $seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$offerid=$seldoffer[0]['offerid'];
											$StoreIDd=$seldoffer[0]['StoreID'];
											$memid=$seldoffer[0]['memberid'];  
									        $seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
											$services=$seldofferp[0]['ServiceID'];
											$offernamee=$seldofferp[0]['OfferName'];
											$baseamt=$seldofferp[0]['BaseAmount'];
											$Type=$seldofferp[0]['Type'];
											$TypeAmount=$seldofferp[0]['TypeAmount'];
											$StoreID=$seldofferp[0]['StoreID'];
											$stores=explode(",",$StoreID);
											
											$servicessf=explode(",",$services);
											if(in_array("$StoreIDd",$stores)) /////////////////check service in specified store
												{
													$statuscheck="No";
													foreach($seldpdept as $val)
															{
															$totalammt=0;
															$serviceid=$val['ServiceID'];
															$AppointmentDetailsID=$val['AppointmentDetailsID'];
															$AppointmentID=$val['AppointmentID'];
															 if(in_array("$serviceid",$servicessf)) ///////////////check which service in offer
																   {
																	$sqp=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$AppointmentID."'");
																	$amtt=$sqp[0]['ServiceAmount'];
																	$qtyyy=$sqp[0]['qty'];
																	$totals=$qtyyy*$amtt;
																    $totalpp=$totalpp+$totals;
																	if($baseamt!="")
																	{
																	  if($totalpp>=$baseamt)
																			{
																		//echo 1;
																				if($Type=='1') ////////////check type of amount % or amount
																				{
																					if($statuscheck=="No")
																					   {
																							$servicefinal=$serviceid;
																							//$offeramtt=$totalpp-$TypeAmount;
																							$offeramtt=$TypeAmount;
																							$statuscheck="Yes";
																					   }
																					   else{
																						   
																					   }
																				}
																				else
																				{
																					$amt=$totals*$TypeAmount/100;
																					$offeramtt=$amt;
																					if($Type=='2')
																					  {
																				
																							$amttp=$totals-$offeramtt;
									                                                        $seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										                                                    $FreeService=$seldoffert[0]['FreeService'];
																							 if($FreeService!="0")
																							 {
																								 
																							 }
																							 else
																							 {
														
																								$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
																									ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serviceid."'";
																						//echo $sqlcharges."<br>";
																								$charges = $DB->query($sqlcharges);
																									if ($charges->num_rows > 0) 
																									{
																										while($row = $charges->fetch_assoc())
																										{
																											$ChargeNameId = $row["ChargeNameId"];
																											$ArrayChargeSet = $row["ArrayChargeSet"];
																											$strChargeSet = explode(",",$ArrayChargeSet);
																										}
																									}		
		
																										for($j=0; $j<count($strChargeSet); $j++) 
																										{
																											$strChargeSetforwork = $strChargeSet[$j];
																											$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";
																											
																											$RS2 = $DB->query($sqlchargeset);
																											if ($RS2->num_rows > 0) 
																											{
																												while($row2 = $RS2->fetch_assoc())
																												{
																													$strChargeAmt = $row2["ChargeAmt"];
																													$strSetName = $row2["SetName"];
																													$strChargeFPType = $row2["ChargeFPType"];
																													// Calculation of charges
																													$ServiceCost = $amttp;
																													if($strChargeFPType == "0")
																													{
																														$strChargeAmt = $strChargeAmt;
																													}
																													else
																													{
																														
																														$percentage = $strChargeAmt;
																														//echo "percentage=".$percentage."<br/>";
																														 $outof = $ServiceCost;
																														 //echo "ServiceCost=".$ServiceCost."<br/>";
																													 $strChargeAmt = ($percentage / 100) * $outof;
																														 //echo "strChargeAmt=".$strChargeAmt."<br/>";
																													
																													
																													
																													}
																												$totalamt=$strChargeAmt;
																											   $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																													   $cntserp=$sepcont[0]['count(*)'];
																													   if($cntserp>0)
																													   {
																											 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";

																											  ExecuteNQ($sqlUpdate1);
																													   }
																													   else
																													   {
																														   
																													   }
																											
																												}
																											}
																										}
																								unset($strChargeSet);
																									 }																 
																								 }
																	                      $offeramount=$offeramount+$offeramtt;
																	             }
																			
																				}
																				else
																				{
																					$data="Offer Not Applicable Offer Amount is Less Than Billing Amount";
																				}
																		
																	}
																	else
																	{
																		if($Type=='1')
																		{
																			 if($statuscheck=="No")
																				   {
																					    $servicefinal=$serviceid;
																						//$offeramtt=$totalpp-$TypeAmount;
																						$offeramtt=$TypeAmount;
																						$statuscheck="Yes";
																				   }
																		}
																		else
																		{
																										$amt=$totals*$TypeAmount/100;
																										$offeramtt=$amt;
																										if($Type=='2')
																										  {
																									
																									     $amttp=$totals-$offeramtt;
																							             $seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
																					
																					                     $FreeService=$seldoffert[0]['FreeService'];
																										 if($FreeService!="0")
																										 {
																											 
																										 }
																										 else
																										 {
																										$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
																													ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serviceid."'";
																													//echo $sqlcharges."<br>";
																													$charges = $DB->query($sqlcharges);
																														if ($charges->num_rows > 0) 
																														{
																															while($row = $charges->fetch_assoc())
																															{
																																$ChargeNameId = $row["ChargeNameId"];
																																$ArrayChargeSet = $row["ArrayChargeSet"];
																																$strChargeSet = explode(",",$ArrayChargeSet);
																															}
																														}		
																											
																													for($j=0; $j<count($strChargeSet); $j++) 
																													{
																														$strChargeSetforwork = $strChargeSet[$j];
																														$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";
																														
																														$RS2 = $DB->query($sqlchargeset);
																														if ($RS2->num_rows > 0) 
																														{
																															while($row2 = $RS2->fetch_assoc())
																															{
																																$strChargeAmt = $row2["ChargeAmt"];
																																$strSetName = $row2["SetName"];
																																$strChargeFPType = $row2["ChargeFPType"];
																																// Calculation of charges
																																$ServiceCost = $amttp;
																																if($strChargeFPType == "0")
																																{
																																	$strChargeAmt = $strChargeAmt;
																																}
																																else
																																{
																																	
																																$percentage = $strChargeAmt;
																																//echo "percentage=".$percentage."<br/>";
																																 $outof = $ServiceCost;
																																 //echo "ServiceCost=".$ServiceCost."<br/>";
																																 $strChargeAmt = ($percentage / 100) * $outof;
																																 //echo "strChargeAmt=".$strChargeAmt."<br/>";
																															
																															
																																
																																}
																															$totalamt=$strChargeAmt;
																														    $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																															   $cntserp=$sepcont[0]['count(*)'];
																															   if($cntserp>0)
																															   {
																												                 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";
																																 ExecuteNQ($sqlUpdate1);
																															   }
																															   else
																															   {
																																  
																															   }
																															
																															}
																														}
																													}
																											unset($strChargeSet);
																										 }
																												
																
																	
																								 }
																   $offeramount=$offeramount+$offeramtt;
																		}
																		
																		
																		
									
															  
																		
																	}
																	
																	?>
																				<input type="hidden" name="serviceido[]" id="serviceido" value="<?= $serviceid ?>" />
																				<input type="hidden" name="offeramttt[]" id="offeramttt" value="<?= $offeramtt ?>" />
																				<input type="hidden" name="offerid[]" id="offerid" value="<?= $offerid ?>" />
																				<?php
																		
																}
																else
																{
																	$data="Offer Not Applicable For Some Of These Services";
																}
															
																
															}
															///////////////////////////////////////////////////////////
													
									        if($offerid!="")
													 {
														 if($Type=='1')
														 {
															// echo $servicefinal;
															 $sqpt=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$servicefinal."' and AppointmentID='".$AppointmentID."'");
															//print_r($sqpt);				
															 $amttt=$sqpt[0]['ServiceAmount'];
															 $AppointmentDetailsIDs=$sqpt[0]['AppointmentDetailsID'];	
															 $qtyyyt=$sqpt[0]['qty'];
															 $totalst=$qtyyyt*$amttt;
															 $amttw=$totalst-$offeramtt;
															 $seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															 $FreeService=$seldoffert[0]['FreeService'];
															 if($FreeService!="0")
															 {
																 
															 }
															 else
															 {
																$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
																			ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$servicefinal."'";
																	//echo $sqlcharges."<br>";
																$charges = $DB->query($sqlcharges);
																if ($charges->num_rows > 0) 
																{
																	while($row = $charges->fetch_assoc())
																	{
																		$ChargeNameId = $row["ChargeNameId"];
																		$ArrayChargeSet = $row["ArrayChargeSet"];
																		$strChargeSet = explode(",",$ArrayChargeSet);
																	}
																}		

																for($j=0; $j<count($strChargeSet); $j++) 
																{
																	$strChargeSetforwork = $strChargeSet[$j];
																	$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";
																	
																	$RS2 = $DB->query($sqlchargeset);
																	if ($RS2->num_rows > 0) 
																	{
																		while($row2 = $RS2->fetch_assoc())
																		{
																			$strChargeAmt = $row2["ChargeAmt"];
																			$strSetName = $row2["SetName"];
																			$strChargeFPType = $row2["ChargeFPType"];
																			// Calculation of charges
																			$ServiceCost = $amttw;
																			if($strChargeFPType == "0")
																			{
																				$strChargeAmt = $strChargeAmt;
																			}
																			else
																			{
																				$percentage = $strChargeAmt;
																				//echo "percentage=".$percentage."<br/>";
																				 $outof = $ServiceCost;
																				 //echo "ServiceCost=".$ServiceCost."<br/>";
																				 $strChargeAmt = ($percentage / 100) * $outof;
																				 //echo "strChargeAmt=".$strChargeAmt."<br/>";
																			
																			}
																		$totalamt=$strChargeAmt;
																	//echo $AppointmentDetailsIDs;
																		$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																						   $cntserp=$sepcont[0]['count(*)'];
																						   if($cntserp>0)
																						   {
																					 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsIDs."'";
																					 ExecuteNQ($sqlUpdate1);
																						   }
																						   else
																						   {
																							 
																						   }
																	
																		}
																	}
																}
															unset($strChargeSet);
										
															 }
														
						
															}
													 }
													 $servicefinal="";
													 $statuscheck="";      
																		
																}
																else
																{
																	$data="This Offer Is Not Valid For This Store";
																			
																}
																		
															
												
							
							
											//print_r($servicessf);
								
									 if($offeramtt!="")
									 {
										 if($Type=="1")
										 {
											$offeramtt=$offeramtt;
										 }
										 else
										 {
											$offeramtt=$offeramount;
										 }
										 
										
										 ?>
											<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
												<?=$offernamee?>
											</td>
											<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">
												<input id="offeramt" type="text" name="offeramt" readonly value="<?=" - ".$offeramtt ?>" /></td>
											<?php
									 }
									 ?>
                                          </tr>
																			<?php
											}
									
											
									///////////////////////////////////////////////////////////////
										////////////////Member Discount///////////////////////
										    $seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$memid=$seldember[0]['memberid'];  
											$offerid=$seldember[0]['offerid'];
											$custid=$seldember[0]['CustomerID'];  
											$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
											$Cost=$seldemberg[0]['Cost'];  		
											$selcustd=select("Membership_Amount","tblInvoiceDetails","CustomerFullName='".$cust_name."' and AppointmentId='".DecodeQ($_GET['uid'])."'");	
											$Membership_Amount=$selcustd[0]['Membership_Amount'];
											$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
											$memberflag=$selcust[0]['memberflag'];  
											$CustomerFullName=$selcust[0]['CustomerFullName']; 
											$seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
											$services=$seldofferp[0]['ServiceID'];
											$baseamt=$seldofferp[0]['BaseAmount'];
											$Type=$seldofferp[0]['Type'];
											$TypeAmount=$seldofferp[0]['TypeAmount'];
											$StoreID=$seldofferp[0]['StoreID'];
											$stores=explode(",",$StoreID);
											if($memid!="0")
												{
											?>
																				<tr>
																					<td width="50%">&nbsp;</td>
																					<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
																						<?=$membershipname?>&nbsp; Discount</td>
																					<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="memberdiscost" readonly value="<?php echo " - ".number_format($memberdis,2);?>" />
																					</td>
																				</tr>
																				<?php
												}
										
													


//////////////////////////////////////////////////////////////////////////////////////////////////													
	//////////////////////////////////////display charges////////////////////////////////////////////////////////////////////////
											$seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$FreeService=$seldoffert[0]['FreeService'];
											 if($FreeService!="0")
												 {
													 
												 }
												 else
												 {
												$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
							                    $cntserp=$sepcont[0]['count(*)'];
												$sqlExtraCharges=select("DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize","tblAppointmentsChargesInvoice","AppointmentID ='".DecodeQ($_GET['uid'])."' GROUP BY ChargeName");
											//print_r($sqlExtraCharges);
									
												foreach($sqlExtraCharges as $vaqq)
												{
														$strChargeNameDetails = $vaqq["ChargeName"];
												  $strChargeAmountDetails = $vaqq["Sumarize"];
													?>
														<tr>
															<td width="50%">&nbsp;</td>
															<td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><input type="text" name="chargename[]" readonly value="<?=$strChargeNameDetails ?>" /></td>
															<td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="chargeamount[]" readonly value="<?=" + ".$strChargeAmountDetails ?>" /></td>
														</tr>
																								<?php
									              $amountdetail=$amountdetail+$strChargeAmountDetails;
												}
								
									
												  
											 }
								
										$total=0;
						//echo 
										 if($amtt > $sub_total)
													{
														$totalred=$sub_total+$redamt;
														$total=$total+$sub_total;
														?>

																			<input type="hidden" name="totalredamt" id="totalredamt" value="<?= $totalred ?>" />
																			<?php
													}
													else
													{
													
														$total=$total+$sub_total+$amountdetail-$offeramtt-$memberdis;
													}
							
	
					
			
					
					
									?>
								</tr>
                                                <?php 
												////////////////////////////if pending amount is remain then it display//////////////////
				                                       $sept=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."'");
														foreach($sept as $val)
														{
															$totalpendamt=$totalpendamt+$val['PendingAmount'];
														}
				?>
                                                <tr id="pendingpayment" style="display:none">
                                                    <td>&nbsp;</td>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="totalpend" id="totalpend" readonly /></td>

                                                </tr>
												<!-------display round total--------->
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total</td>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" id="totalvalue"><input type="text" name="total" id="totalcost" readonly value="<?= $total ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Round Off</td>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input id="roundtotal" type="text" name="roundtotal" readonly value="<?php  
													  echo round($total);
													//  $total=0;
													  ?>" /></td>
                                                </tr>

                                                </tbody>

                                                </table>
                                                </td>
                                                </tr>
<?php 
										//////////////////////////check type of flag and display pending amount according //////////////////////////
										$seldppay=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."'");
										$amount=$seldppay[0]['CashAmount'];
										$flag=$seldppay[0]['Flag'];
										if($flag=='CS')
										{
											?>
                                                <tr>
                                                    <td id="payment">
                                                        <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">


                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                    <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                                    <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">
                                                                        <?php echo $amount?>
                                                                    </td>
                                                                </tr>



                                                            </tbody>

                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php
										}
										elseif($flag=='H')
										{
											$seldppayt=select("*","tblPendingPayments","AppointmentID='".DecodeQ($_GET['uid'])."'");
											$pendamt=$seldppayt[0]['PendingAmount'];
													?>
                                                    <tr>
                                                        <td id="payment">
                                                            <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">


                                                                <tbody>

                                                                    <tr>
                                                                        <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                        <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                                        <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">
                                                                            <?php echo $pendamt?>
                                                                        </td>
                                                                    </tr>



                                                                </tbody>

                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php
										}
										elseif($flag=='C')
										{
													?>
                                                        <tr>
                                                            <td id="payment">
                                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">


                                                                    <tbody>

                                                                        <tr>
                                                                            <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                            <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                                            <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">
                                                                                <?php echo $amount?>
                                                                            </td>
                                                                        </tr>



                                                                    </tbody>

                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <?php
										}
										else
										{
											?>
                                                            <tr>
                                                                <td style="display:none" id="payment">
                                                                    <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">


                                                                        <tbody>

                                                                            <tr>
                                                                                <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                                                <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="paymentid" name="cashamt" value="<?php echo $total; ?>" onkeyup="test()" /></td>


                                                                            </tr>

                                                                            <tr>
                                                                                <td>&nbsp;</td>
                                                                                <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                                                <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input id="totalpayment" name="totalpayment" value="<?php  
													  echo round($total);
													//  $total=0;
													  ?>" /></td>
                                                                            </tr>


                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                            </tr>

                                                            <?php
											
										}
										
										/////////////////////////////////////////////////////////////////////
										?>

                                                                <tr>
                                                                    <td id="paymenttype">
                                                                        <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                                           <tbody>
                                                                                <?php 
																						$sep=select("count(PendingPaymentID)","tblPendingPayments","CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'");
																						$cnt=$sep[0]['count(PendingPaymentID)'];
																						$totalpendamt=0;
																						if($cnt>0)
																						{
																							$sept=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."'");
																							foreach($sept as $val)
																							{
																								$totalpendamt=$totalpendamt+$val['PendingAmount'];
																							}
																							if($flag=='H')
																							{
																								
																							}
																							else
																							{
																						?>
																													<tr id="showpend">
																														<td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
																														<td width="15%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;">Till Date Pending Payments</td>
																														<td width="15%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"><input type="text" name="totalpendamt" id="totalpendamt" readonly value="<?= $totalpendamt?>" /></td>
																														<td width="15%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"><button type="button" id="addtobill" style="display:inline-block;" value="<?php echo $totalpendamt ?>" class="btn btn-success" data-toggle="button"><center>Add</center></button></td>



																													</tr>
																													<?php
																							}
																						}
																						else
																						{
																							
																						}
												?>
												<!--decide which type of paymenyt--->

                                                                                    <tr id="paymenttype1">
                                                                                        <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                        <td width="20%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-WEIGHT:bold;FONT-SIZE:14px;"><input type="radio" name="paytype" id="paytype" value="Partial" />Partial</td>
                                                                                        <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;"><input type="radio" name="paytype" value="Complete" id="paytype" checked />Complete</td>
                                                                                    </tr>
																					<!--distribute amount complete partial and pending-->
                                                                                    <tr>
                                                                                        <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                        <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Complete Amount</td>

                                                                                        <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="completeamtt" name="completeamtt" readonly value="<?= round($total); ?>" /></td>


                                                                                    </tr>
                                                                                    <tr style="display:none" class="partial">
                                                                                        <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                        <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Partial Amount</td>
                                                                                        <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="completeamt" name="completeamt" onkeyup="calculatecomplete()" /></td>
                                                                                    </tr>
                                                                                    <tr style="display:none" class="partial">
                                                                                        <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                        <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                                                        <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="pendamt" name="pendamt" onkeyup="calculatepend()" readonly /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>&nbsp;</td>
                                                                                        <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>

                                                                                        <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input id="totalpaymentamt" name="totalpaymentamt" readonly value="<?= round($total); ?>" /></td>
                                                                                    </tr>

                                                                            </tbody>

                                                                        </table>
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td style="display:none" id="payment1">
                                                                        <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">


                                                                            <tbody>

                                                                                <tr>
                                                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                    <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash Amount</td>
                                                                                    <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="cashboth" name="cashboth" onkeyup="calculatecashamount()" /></td>


                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                                                    <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card Amount</td>
                                                                                    <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="cardboth" name="cardboth" onkeyup="calculatecardamt()" /></td>
                                                                                </tr>




                                                                            </tbody>

                                                                        </table>
                                                                    </td>
                                                                </tr>





                                                                <tr>
                                                                    <td height="8">
                                                                        <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td bgcolor="#e4e4e4" height="4"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>





                                                                <!--<tr>
                                            <td height="8"></td>
                                        </tr>-->

                                                                <!--<tr>
										 <style>
												.con  {
												height:200px;
												width:100%;
												border:1px solid #d0ad53;
												}												
												</style>
												<td>
                                           <div class="con">
												<p align="center">Advertisement </p>
										   </div>
										   </td>
                                        </tr>-->
                                                                <tr>

                                                                    <td style="BACKGROUND:#d0ad53;">
                                                                        <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">

                                                                            <tbody>





                                                                                <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px; padding:1%;" height="32" align="center">
                                                                                    <span style="font-size:14px; font-weight:600;">KHAR | BREACH CANDY | ANDHERI | COLABA | LOKHANDWALA</span><br>
                                                                                </td>

                                                                            </tbody>
                                                                        </table>
                                                                    </td>


                                                                </tr>

                                                                </tbody>
                                                                </table>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                </tbody>
                                                                </table>
                                                                </td>
                                                                </tr>
                                                                </tbody>
                                                                </table>
                                                                </form>

                                            </div>
                                            <?php
											//////////////////////////check any employee is assign or not/////////////////////////////////////
									           $seldoffertqy=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
								               $FreeService=$seldoffertqy[0]['FreeService'];
									           $PackageID=$seldoffertqy[0]['PackageID'];
										       $packbunch=explode(",",$PackageID);
									           $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												   if($FreeService!="0")
													{
														
													foreach($seldpdept as $val)
													   {
														$seldt=select("count(AppointmentAssignEmployeeID)","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
														$cnt=$seldt[0]['count(AppointmentAssignEmployeeID)'];
														if($cnt>0)
														{
														$seldppay=select("*","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
														
														foreach($seldppay as $value)
														{
														
														   if($value['ServiceID']=='0')
															{
																	$daata=1;
																
															}
															elseif($value['MECID']=='0')
															{
																$daata=1;
															}
															else
															{
																$daata=2;
															}	
														}
														}
														elseif($cnt=='0')
														{
															$daata=3;
														}
														else
														{
																$daata=2;
														}
													
														
															
													}
														
													if($daata=='1')
													{
														?>
																<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>


																<?php
													}
													elseif($daata=='3')
													{
														?>
																	<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>

																	<?php
													}
													elseif($daata=='2')
													{
														?>
																		<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;<button type="button" id="CompleteAmt" value="Complete" class="btn btn-primary active" data-toggle="button" style="float:left;">Complete Free Bill</button>

																		<!-- Modal -->
																		<?php
													}
														
													}
												   else
													{
														
														if($PackageID!="")
														{
														
															
															$seldtpt=select("count(AppointmentAssignEmployeeID)","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."'");
																	$cnty=$seldtpt[0]['count(AppointmentAssignEmployeeID)'];
																	if($cnty>0)
																	{
																	  $seldpdeptq=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
																		foreach($seldpdeptq as $val)
																	   {
																	 $seldpdas=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."' and PackageService!='0'");
																	 $cntas=$seldpdas[0]['count(*)'];
																	 if($cntas>0)
																	 {
																		
																		  $seldt=select("count(AppointmentAssignEmployeeID)","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																	$cnt=$seldt[0]['count(AppointmentAssignEmployeeID)'];
																	if($cnt>0)
																	{
																	$seldppay=select("*","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																	
																	foreach($seldppay as $value)
																	{
																	
																	   if($value['ServiceID']=='0')
																		{
																				$daata=1;
																			
																		}
																		elseif($value['MECID']=='0')
																		{
																			$daata=1;
																		}
																		else
																		{
																			$daata=2;
																		}	
																	}
																	
																	}
																	elseif($cnt=='0')
																	{
																		$seldpdaspo=select("PackageService","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																		$PackageService=$seldpdaspo[0]['PackageService'];
																		if($PackageService!="0")
																		{
																			$daata=2;
																		}
																		else
																		{
																			$daata=3;
																		}
																		
																	}
																	else
																	{
																	   $daata=2;
																	}
																		 
																	 }
																	 else
																	 {
																			$seldt=select("count(AppointmentAssignEmployeeID)","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																	$cnt=$seldt[0]['count(AppointmentAssignEmployeeID)'];
																	if($cnt>0)
																	{
																	$seldppay=select("*","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																	
																	foreach($seldppay as $value)
																	{
																	
																	   if($value['ServiceID']=='0')
																		{
																				$daata=1;
																			
																		}
																		elseif($value['MECID']=='0')
																		{
																			$daata=1;
																		}
																		else
																		{
																			$daata=2;
																		}	
																	}
																	
																	}
																	elseif($cnt=='0')
																	{
																		
																		$daata=3;
																	}
																	else
																	{
																	   $daata=2;
																	}
																	 }														 
																		   
																
																
																	
																		
																}
																
																if($daata=='1')
																{
																	?>
																			<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>


																			<?php
																}
																elseif($daata=='3')
																{
																	?>
																				<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>

																				<?php
																}
																elseif($daata=='2')
																{
																	
																	if($invoiceflag=='H')
																	{
																		?>
																					<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button"><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																					<button type="button" id="card" value="card" class="btn btn-info" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="display:none" id="confirm" value="Confirm" class="btn btn-info" data-toggle="button" style="float:left;">Confirm</button>

																					<button type="button" id="both" value="both" class="btn btn-blue-alt" data-toggle="button" style="float:left;">Both</button>&nbsp;&nbsp;
																					<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>

																					<?php
																		
																	}
																	else
																	{
																		?>
																						<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button"><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																						<button type="button" id="card" value="card" class="btn btn-info" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="display:none" id="confirm" value="Confirm" class="btn btn-info" data-toggle="button" style="float:left;">Confirm</button>
																						<button type="button" id="hold" value="hold" class="btn btn-primary active" data-toggle="button" style="float:left;">Balance Payable</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																						<button type="button" id="both" value="both" class="btn btn-blue-alt" data-toggle="button" style="float:left;">Both</button>&nbsp;&nbsp;
																						<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>
																						<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>
																						<?php
																	}
																}
																		
																	}
																	else
																	{
																		?>
																							<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button"><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																							<button type="button" id="card" value="card" class="btn btn-info" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="display:none" id="confirm" value="Confirm" class="btn btn-info" data-toggle="button" style="float:left;">Confirm</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																							<button type="button" id="both" value="both" class="btn btn-blue-alt" data-toggle="button" style="float:left;">Both</button>&nbsp;&nbsp;
																							<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>
																							<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>

																							<?php
																	}
															
																
														
														
														}
														else
														{
															
																		foreach($seldpdept as $val)
																	   {
																	$seldt=select("count(AppointmentAssignEmployeeID)","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																	$cnt=$seldt[0]['count(AppointmentAssignEmployeeID)'];
																	if($cnt>0)
																	{
																	$seldppay=select("*","tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."' and ServiceID='".$val['ServiceID']."'");
																	
																	foreach($seldppay as $value)
																	{
																	
																	   if($value['ServiceID']=='0')
																		{
																				$daata=1;
																			
																		}
																		elseif($value['MECID']=='0')
																		{
																			$daata=1;
																		}
																		else
																		{
																			$daata=2;
																		}	
																	}
																	
																	}
																	elseif($cnt=='0')
																	{
																		
																		$daata=3;
																	}
																	else
																	{
																	   $daata=2;
																	}
																
																	
																		
																}
																//echo $daata;	
																if($daata=='1')
																{
																	?>
																								<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>


																								<?php
																}
																elseif($daata=='3')
																{
																	?>
																									<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>&nbsp;&nbsp;&nbsp;<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>

																									<?php
																}
																elseif($daata=='2')
																{
																	
																	if($invoiceflag=='H')
																	{
																		?>
																										<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button"><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																										<button type="button" id="card" value="card" class="btn btn-info" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="display:none" id="confirm" value="Confirm" class="btn btn-info" data-toggle="button" style="float:left;">Confirm</button>

																										<button type="button" id="both" value="both" class="btn btn-blue-alt" data-toggle="button" style="float:left;">Both</button>&nbsp;&nbsp;
																										<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>

																										<?php
																		
																	}
																	else
																	{
																		?>
																											<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button"><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																											<button type="button" id="card" value="card" class="btn btn-info" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="display:none" id="confirm" value="Confirm" class="btn btn-info" data-toggle="button" style="float:left;">Confirm</button>
																											<button type="button" id="hold" value="hold" class="btn btn-primary active" data-toggle="button" style="float:left;">Balance Payable</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																											<button type="button" id="both" value="both" class="btn btn-blue-alt" data-toggle="button" style="float:left;">Both</button>&nbsp;&nbsp;
																											<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>
																											<a href="updateemployee.php?uid=<?=$ud ?>" class="btn btn-primary">Assign Employee</a>
																											<?php
																	}
																}
														}
														
														
													
													}
													
												}
												else
												{
													?>
																												<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button"><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																												<button type="button" id="card" value="card" class="btn btn-info" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="display:none" id="confirm" value="Confirm" class="btn btn-info" data-toggle="button" style="float:left;">Confirm</button>
																												<button type="button" id="hold" value="hold" class="btn btn-primary active" data-toggle="button" style="float:left;">Balance Payable</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																												<button type="button" id="both" value="both" class="btn btn-blue-alt" data-toggle="button" style="float:left;">Both</button>&nbsp;&nbsp;
																												<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>

																												<?php
																   
												}
											
									/////////////////////////////////////////////////////////////////////////////
									?>
                                    </div>





                                </div>

                            </div>
                            <?php
}	
else
{
if(isset($_GET["toandfrom"]))
{
	$strtoandfrom = $_GET["toandfrom"];
	$arraytofrom = explode("-",$strtoandfrom);
	
	$from = $arraytofrom[0];
	$datetime = new DateTime($from);
	$getfrom = $datetime->format('Y-m-d');
	
	
	$to = $arraytofrom[1];
	$datetime = new DateTime($to);
	$getto = $datetime->format('Y-m-d');

	if(!IsNull($from))
	{
		$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
	}

	if(!IsNull($to))
	{
		$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
	}
}
if(isset($_GET["toandfrom"]))
{
	$strtoandfrom = $_GET["toandfrom"];
	$arraytofrom = explode("-",$strtoandfrom);
	
	$from = $arraytofrom[0];
	$datetime = new DateTime($from);
	$getfrom = $datetime->format('Y-m-d');
	
	
	$to = $arraytofrom[1];
	$datetime = new DateTime($to);
	$getto = $datetime->format('Y-m-d');

	if(!IsNull($from))
	{
		$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
	}

	if(!IsNull($to))
	{
		$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
	}
}
?>
                                <div class="panel">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="example-box-wrapper">
                                                <span class="form_result">&nbsp; <br></span>
                                                <div class="panel-body">
                                                    <h3 class="title-hero">List of Invoice | Nailspa</h3>
                                                    <form method="get" class="form-horizontal bordered-row" role="form">
                                                        <div class="form-group"><label for="" class="col-sm-4 control-label">Select date</label>
                                                            <div class="col-sm-4">
                                                                <div class="input-prepend input-group">
                                                                    <span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span>
                                                                    <input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><label class="col-sm-3 control-label"></label>
                                                            <button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button> &nbsp;&nbsp;&nbsp;
                                                            <a class="btn btn-link" href="appointment_invoice.php">Clear All Filter</a> &nbsp;&nbsp;&nbsp;


                                                        </div>

                                                    </form>
                                                    <br/>
                                                    <?php
													if($_GET["toandfrom"]!="")
													{
												?>
                                                        <h3 class="title-hero">Date Range selected : FROM -
                                                            <?=$getfrom?> / TO -
                                                                <?=$getto?>
                                                        </h3>

                                                        <br>
                                                        <div class="example-box-wrapper">
                                                            <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr.No</th>


                                                                        <th>Invoice Name</th>
                                                                        <th>Appointment Date</th>
                                                                        <th>Store Name</th>
                                                                        <th>Invoice Amount</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Sr.No</th>


                                                                        <th>Invoice Name</th>
                                                                        <th>Appointment Date</th>
                                                                        <th>Store Name</th>
                                                                        <th>Invoice Amount</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>

                                                                    <?php
// Create connection And Write Values
$DB = Connect();
$date=date('Y-m-d');


if(isset($_GET["uids"]))
{
	$asmitaabc=DecodeQ($_GET["uids"]);
	if($strAdminRoleID=="36") ////////superadmin
   {  
	$sql = "SELECT * FROM tblAppointments where IsDeleted!='1' and AppointmentID=$asmitaabc $sqlTempfrom $sqlTempto";
   }
   elseif($strAdminRoleID=="39") ///admin
   {
	   $sql = "SELECT * FROM tblAppointments where IsDeleted!='1' and AppointmentID=$asmitaabc $sqlTempfrom $sqlTempto";
   }
   else
   {
	   	$sql = "SELECT * FROM tblAppointments where StoreID='".$strStore."' and IsDeleted!='1' and AppointmentID=$asmitaabc $sqlTempfrom $sqlTempto";
   }


}
else
{
	if($strAdminRoleID=="36")
   {  
	$sql = "SELECT * FROM tblAppointments where IsDeleted!='1' $sqlTempfrom $sqlTempto order by AppointmentID desc ";
   }
   elseif($strAdminRoleID=="39")
   {
	 	$sql = "SELECT * FROM tblAppointments where IsDeleted!='1' $sqlTempfrom $sqlTempto order by AppointmentID desc ";
   }
   else
   {
	   	$sql = "SELECT * FROM tblAppointments where StoreID='".$strStore."' and IsDeleted!='1' $sqlTempfrom $sqlTempto order by AppointmentID desc";
   }
}

// $sql = "SELECT * FROM tblAppointmentlog order by id desc";
// echo $sql."<br>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;

while($row = $RS->fetch_assoc())
{
$counter ++;
$appointment_id = $row["AppointmentID"];
if($strAdminRoleID=="36")
{
	$selda=select("*","tblAppointments","AppointmentID='$appointment_id' and IsDeleted!='1' $sqlTempfrom $sqlTempto");
}
elseif($strAdminRoleID=="39")
{
	$selda=select("*","tblAppointments","AppointmentID='$appointment_id' and IsDeleted!='1' $sqlTempfrom $sqlTempto");
}
else{
	$selda=select("*","tblAppointments","AppointmentID='$appointment_id' and IsDeleted!='1' and StoreID='".$strStore."' $sqlTempfrom $sqlTempto");
}

$invoice_name = $selda[0]["CustomerID"];
$FreeService = $selda[0]["FreeService"];
$sada=select("CustomerFullName","tblCustomers","CustomerID='".$invoice_name."'");
$customer=$sada[0]['CustomerFullName'];

$getUID = EncodeQ($appointment_id);

$appointment_date = $selda[0]["AppointmentDate"];
$statusd = $selda[0]["Status"];
$store = $selda[0]["StoreID"];
$sadad=select("StoreName","tblStores","StoreID='".$store."'");
$storename=$sadad[0]['StoreName'];
$status = $selda[0]["Status"];
 if($FreeService=='1')
 {
$seldappt=select("*","tblFreeServices","AppointmentId='$appointment_id'");	
$Flagt=$seldappt[0]['Flag'];
$invoiceamt=$seldappt[0]['RoundTotal'];
$amt=number_format($invoiceamt,2);
	
 }
 else
 {
$seldapp=select("*","tblInvoiceDetails","AppointmentId='$appointment_id'");	
$invoiceamt=$seldapp[0]['RoundTotal'];
$amt=number_format($invoiceamt,2);
$flag=$seldapp[0]['Flag'];
$PackageIDFlag=$seldapp[0]['PackageIDFlag'];
$seldapptq=select("*","tblAppointmentPackageValidity","AppointmentID='$appointment_id'");	
$ValidTill=$seldapptq[0]['ValidTill'];
 }

?>
											<script>
												function checkstatus(ext, ep) {
													//alert(111)
													var uid = $("#uid").val();
													//alert(ext)
													//	alert(ep)
													var number = $("#status").text();
													//alert(number)
													if (ext == 'Hold') {
														//alert(1234)
														// window.location="ManageAppointments.php";
														window.location = "appointment_invoice.php?uid=" + ep;
													} else if (ext == 'Processing') {
														window.location = "appointment_invoice.php?uid=" + ep;
													} else if (ext == 'Completed') {

														//	window.location="appointment_invoice.php?uid=<?php echo $appointment_id ?>";


													} else {

													}
												}
											</script>
											<tr id="my_data_tr_<?=$counter?>">
												<td style="text-align: center">
													<?=$counter?>
														<input type="hidden" id="uid" value="<?php echo $getUID  ?>" />
												</td>


												<td style="text-align: center">

													<?=$customer?>

												</td>
												<td style="text-align: center">

													<?=$appointment_date?>

												</td>
												<td style="text-align: center">

													<?=$storename?>

												</td>
												<td style="text-align: center">

													<?=$amt?>

												</td>
												<td style="text-align: center" id="statusp">
													<?																		
										if($Flagt=='Complete')
										{
											if($FreeService=='1')
											{
													$Status = "Completed";
												//echo $Status;
													?>
														<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
															<?php echo $Status; ?>
														</a>
														<?php
											}
											else
											{
											if($flag=="H")
											{
												if($PackageIDFlag=='P')
												{
														  if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
															<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																<?php echo $Status; ?>
															</a>
															<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																	<?php echo $Status; ?>
																</a>
																<?php
																 }
													
												}
												else
												{
													$Status = "Balance Payable";
												?>
																	<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Hold','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																	<?php
												}
												
											
												
												
												
											}
											elseif($flag=="CS")
											{
												
												if($PackageIDFlag=='P')
												{
														  if($date>$ValidTillx)
																 {
											$Status = "Package Service Expired";
												?>
																		<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																		<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																		<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																				<?php echo $Status; ?>
																		</a>
																			<?php
																 }
													
												}
												else
												{
													$Status = "Completed";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
																					<?php echo $Status; ?>
																		</a>
																				<?php
												}
												
											}
											elseif($flag=="C")
											{
											if($PackageIDFlag=='P')
												{
														  if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
																		<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																						<?php echo $Status; ?>
																		</a>
																					<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																		<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																							<?php echo $Status; ?>
																		</a>
																						<?php
																 }
													
												}
												else
												{
													$Status = "Completed";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
																								<?php echo $Status; ?>
																		</a>
																							<?php
												}
												
												
												
											}
											elseif($flag=="BOTH")
											{
												if($PackageIDFlag=='P')
												{
														 if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
																		<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																									<?php echo $Status; ?>
																		</a>
																								<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																		<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																										<?php echo $Status; ?>
																		</a>
																									<?php
																 }
													
												}
												else
												{
													$Status = "Both";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
																											<?php echo $Status; ?>
																		</a>
																										<?php
												}
												
												
											}
											elseif($flag=="")
											{
												//echo $flag;
												if($statusd=='1')
												{
													$Status = "Processing";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																											<?php
												}
												elseif($statusd=='0')
												{
													$Status = "Need To Checkin First";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																												<?php
												}
											elseif($statusd=='3')
												{
													$Status = "Cancel";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																													<?php
												}
												else
												{
													$Status = "Immediate Checkout";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																														<?php
												}
											}
											}
											
										}
										else
										{
											
											
											if($flag=="H")
											{
												if($PackageIDFlag=='P')
												{
														  if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
																	<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																															<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																	<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																																<?php
																 }
													
												}
												else
												{
													$Status = "Balance Payable";
												?>
																	<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Hold','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																																	<?php
												}
										
												
												
												
											}
											elseif($flag=="CS")
											{
												
												if($PackageIDFlag=='P')
												{
													//echo $date;
													//echo $ValidTill;
														  if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
																	<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																																		<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																	<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																																			<?php
																 }
													
												}
												else
												{
													$Status = "Completed";
												//echo $Status;
													?>
																	<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
																		<?php echo $Status; ?>
																	</a>
																																				<?php
												}
												
												
												
											}
											elseif($flag=="C")
											{
											
												if($PackageIDFlag=='P')
												{
														  if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
																		<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																																					<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																		<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																																						<?php
																 }
													
												}
												else
												{
												
													$Status = "Completed";
												//echo $Status;
													?>
																	<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
																		<?php echo $Status; ?>
																	</a>
																																							<?php
												}
												
												
												
												
											}
											elseif($flag=="BOTH")
											{
												if($PackageIDFlag=='P')
												{
														  if($date>$ValidTill)
																 {
											$Status = "Package Service Expired";
												?>
																		<a id="status" href="#" class="btn btn-link disabled" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																																								<?php
																 }
																 else
																 {
												 $Status = "Package Service Pending";
												?>
																		<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																																									<?php
																 }
													
												}
												else
												{
													$Status = "Both";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">
																			<?php echo $Status; ?>
																		</a>
																																										<?php
												}
												
												
												
											}
											elseif($flag=="")
											{
												if($statusd=='1')
												{
													$Status = "Processing";
												//echo $Status;
													?>
																		<a id="status" class="btn btn-link" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																																											<?php
												}
												elseif($statusd=='0')
												{
													$Status = "Need To Checkin First";
												//echo $Status;
?>
																		<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																			<?php echo $Status; ?>
																		</a>
																																												<?php
												}
												elseif($statusd=='3')
												{
													$Status = "Cancel";
												//echo $Status;
													?>
																	<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																																													<?php
												}
												else
												{
													
													$Status = "Immediate Checkout";
												//echo $Status;
													?>
																	<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Processing','<?=$getUID;?>')">
																		<?php echo $Status; ?>
																	</a>
																																														<?php
												}
												
											}
										}
										
										
										//echo $Status;
										?>

												</td>


											</tr>

                                                                        <?php
}
}
else
{
?>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td>No Records Found</td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <?php
}
$DB->close();
?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php
														}	
														else
														{
															echo "<br><center><h3>Please select dates!</h3></center>";
														}															
														?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
					}
					?>
                        </div>
                    </div>
                </div>



                <?php require_once 'incFooter.fya'; ?>

            </div>
        </body>

        </html>