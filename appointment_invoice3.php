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

	
	
	
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
</head>
  <script type="text/javascript">
  $(document).ready(function(){
	  //$("#payment").show();
	    $("#discounttr").hide();
			    $("#displaydetail").show();
				 // $("#displaymembership").hide();
	var app_id=$("#appointment_id").val();
	////////////////////////////
	$.ajax({
		type:"post",
		data:"app_id="+app_id,
		url:"checkmembership.php",
		success:function(result)
		{
			//alert($.trim(result))
			if($.trim(result)!= '0')
			{
				  $("#displaymembership").hide();
			}
			else
			{
				  $("#displaymembership").show();
			}
		}
		
	});
	////////////////////
	  
	 //alert(222)
	  
		$("#cash").click(function(){
			
		if (confirm('Are you sure you want to save this Invoice?')) {
				var test=$("#cash").val();
			//alert(test)
			if(test=='cash')
			{
				$("#paymenttype").show();
				$("#paymenttype1").show();

				
				
				
				 var completeamt=$("#completeamt").val();
				// alert(completeamt)
				 var pendamt=$("#pendamt").val();
		     if(completeamt=="")
			{
				
				alert('Please Check Amount Cannot Be Blank')
				     		
				 
			}
			else
			{
				   $.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"CS",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Cash Received";		     
						window.location="invoice_print.php?uid="+app_id+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   });
			}
		
				//paymentcheck
				 /* $("#payment").show();
				
			
				$("#displaytext").html('Cash');
				 $("#payment").show();
			 var abc = $("#paymentid").val();
			$("#totalpayment").html(abc);
			   $.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"CS",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Cash Received";		     
						window.location="invoice_print.php?uid="+app_id+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   }); */
	 
			}
		}
			 else {
				// Do nothing!
			}
		
			
			
		});
		
		$("#both").click(function(){
			//alert(111)
		
				var test=$("#both").val();
			//alert(test)
			if(test=='both')
			{
				
				 $("#payment1").show();
				 var cardamount=$("#cardboth").val();
				 var cashamount=$("#cashboth").val();
				 
				 var bothamt=parseFloat(cardamount)+parseFloat(cashamount);
				 var totalcost=$("#totalcost").val();
				 if(bothamt>totalcost)
				 {
					 alert('Card and Cash Amount Cannot Be Greater Than Total Amount')
				 }
				 else
				 {
					 
				 }
				
		 if(cardamount=="" && cashamount=="")
			{
				alert('Card Amount and Cash Amount Cannot be blank')
				     		
				 
			}
			else
			{
				$.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"BOTH",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Amount Received";		     
						window.location="invoice_print.php?uid="+app_id+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   }); 		
			}
      
				// $("#displaytext1").show();
				
				
			}
			
	 
			
		
			
			
		});
		
			$("#hold").click(function(){
			
		if (confirm('Are you sure you want to save this Invoice?')) {
				var test=$("#hold").val();
			//alert(test)
			if(test=='hold')
			{
				$("#displaytext").html('Hold');
				 $("#payment").show();
			 var abc = $("#paymentid").val();
			$("#totalpayment").html(abc);
			   $.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"H",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Amount is Pending";		     
						window.location="invoice_print.php?uid="+app_id+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   }); 
	 
			}
			} else {
				// Do nothing!
			}
		
			
			
		});
		   $("#btnPrint").click(function () {
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
		$("#offerid").click(function(){
			var offervalue = $("#offername").val();
		//	alert(offervalue)
				var app_id=$("#appointment_id").val();
			if(offervalue!="")
			{
				$.ajax({
					type:"post",
					data:"offervalue="+offervalue+"&app_id="+app_id,
					url:"checkoffer.php",
					success:function(result)
					{
				//alert(result)
						 if($.trim(result)=='2')
						{
							var msg="Invalid Offer Code";
							//$("#displayoffererror").html(msg);
							alert(msg)
							window.location="appointment_invoice.php?uid="+app_id;
						}
						else if($.trim(result)=='3')
						{
							var msg="Offer Not Applicable For Any Of This Services";
								alert(msg)
							//$("#displayoffererror").html(msg);
						window.location="appointment_invoice.php?uid="+app_id;
							
						}
						else if($.trim(result)=='1')
						{
							var msg="Offer Assign Successfully";
								alert(msg)
							//$("#displayoffererror").html(msg);
						window.location="appointment_invoice.php?uid="+app_id;
						
				
						}
						else if($.trim(result)=='8')
						{
							var msg="Offer is expired";
								alert(msg)
							//$("#displayoffererror").html(msg);
						window.location="appointment_invoice.php?uid="+app_id;
						
				
						}
							else if($.trim(result)=='9')
						{
							var msg="Service Amount is less than offer Amount";
								alert(msg)
							//$("#displayoffererror").html(msg);
						window.location="appointment_invoice.php?uid="+app_id;
						
				
						}
						else if($.trim(result)=='4')
						{
							var msg="This offer is not valid for this store";
								alert(msg)
							//$("#displayoffererror").html(msg);
					window.location="appointment_invoice.php?uid="+app_id;
						}
						else if($.trim(result)=='6')
									{
										var msg="Offer Code Cannot Be Blank";
											alert(msg)
										//$("#displayoffererror").html(msg);
										window.location="appointment_invoice.php?uid="+app_id;
									}
									
						
						
					}
					
					
				})
			}
			else
					{
						alert('offer code cannot be blank')
						return false;
					}
			
		});
		$("#offeridremove").click(function(){
				var offervalue = $("#offername").val();
				var app_id = $("#appointment_id").val();
					if(offervalue!="")
					{
						$.ajax({
							type:"post",
							data:"offervalue="+offervalue+"&app_id="+app_id,
							url:"removeoffer.php",
							success:function(result1)
							{
								//alert(result1)
									if($.trim(result1)=='')
									{
										
									}
								else if($.trim(result1)=='6')
									{
										var msg="Offer Code Cannot Be Blank";
											alert(msg)
										//$("#displayoffererror").html(msg);
								window.location="appointment_invoice.php?uid="+app_id;
									}
								 else
								 {
									var msg="Offer Removed Successfully";
										alert(msg)
									//$("#displayoffererror").html(msg);
							window.location="appointment_invoice.php?uid="+app_id;
								 }
							}
						});
					}
					else
					{
						alert('offer code cannot be blank')
				return false;
					}
			});
			$("#offeridnew").click(function(){
				var offervalue = $("#offername").val();
				var app_id = $("#appointment_id").val();
					if(offervalue!="")
					{
						$.ajax({
							type:"post",
							data:"offervalue="+offervalue+"&app_id="+app_id,
							url:"newoffer.php",
							success:function(result1)
							{
								//alert(result1)
									if($.trim(result1)=='2')
									{
										var msg="Invalid Offer Code";
											alert(msg)
										//$("#displayoffererror").html(msg);
										window.location="appointment_invoice.php?uid="+app_id;
									}
									else if($.trim(result1)=='3')
									{
										var msg="Offer Not Applicable For Any Of This Services";
											alert(msg)
                                        //$("#displayoffererror").html(msg);
										window.location="appointment_invoice.php?uid="+app_id;
									}
									else if($.trim(result1)=='1')
									{
										var msg="Offer Assign Successfully";
											alert(msg)
										//$("#displayoffererror").html(msg);
									window.location="appointment_invoice.php?uid="+app_id;
							
									}
									else if($.trim(result1)=='4')
									{
										var msg="This offer is not valid for this store";
											alert(msg)
										//$("#displayoffererror").html(msg);
										window.location="appointment_invoice.php?uid="+app_id;
									}
									else if($.trim(result1)=='5')
									{
										var msg="This offer is already assign";
											alert(msg)
										//$("#displayoffererror").html(msg);
									window.location="appointment_invoice.php?uid="+app_id;
									}
									else if($.trim(result1)=='6')
									{
										var msg="Offer Code Cannot Be Blank";
											alert(msg)
										//$("#displayoffererror").html(msg);
										window.location="appointment_invoice.php?uid="+app_id;
									}
							}
						});
					}
					else
					{
						alert('offer code cannot be blank')
						return false;
					}
				
			});
	
		$("#card").click(function(){
			
		if (confirm('Are you sure you want to save this Invoice?')) {
				var test=$("#card").val();
				
			if(test=='card')
			{
				$("#paymenttype").show();
				$("#paymenttype1").show();

				
				
				
				 var completeamt=$("#completeamt").val();
				// alert(completeamt)
				 var pendamt=$("#pendamt").val();
		     if(completeamt=="")
			{
				
				alert('Please Check Amount Cannot Be Blank')
				     		
				 
			}
			else
			{
				    $.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"C",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Card Payment Received";		     
						window.location="invoice_print.php?uid="+app_id+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   }); 
			
				
			   
			  
			}
		
				//paymentcheck
				 /* $("#payment").show();
				
			
				$("#displaytext").html('Cash');
				 $("#payment").show();
			 var abc = $("#paymentid").val();
			$("#totalpayment").html(abc);
			   $.ajax({
				url: "printbill.php",
				type: 'post',
				data: $("#printcontent").serialize()+"&type="+"CS",
				success:function(msg)
				{
					//alert(msg)
				if($.trim(msg)=='2')
						{
						  $msg = "Cash Received";		     
						window.location="invoice_print.php?uid="+app_id+"&msg="+$msg; 
						} 
						else
						{
							alert(msg)
						}
						
				}
			
				
			   
			   }); */
	 
			}
		    }
			 else {
				// Do nothing!
			}
		
		
			
		});
		$("#hold").click(function(){
			
			
			var test=$("#hold").val();
			//alert(test)
			if(test=='hold')
			{
				$("#displaytext").html('Hold');
				$("#payment").show();
				
			}
		});
		//alert(number);
	
	  
  });
  function checktypeofpayemnt()
  {
	  var type=$('input[name="paytype"]:checked').val();
				//alert(type)
				if(type=='Partial')
				{
					 $("#paymentcheck").show();
					 
				}
				else if(type=='Complete')
				{
					 var totalcost= Math.round($("#totalcost").val());
					 $("#completeamt").val(totalcost);
			 $("#paymentcheck").hide();
				}
  }
  function test()
  {
	  //alert(111)
	 var abc = $("#paymentid").val();
	//alert(abc)
	 var value = $("#totalvalue").text();
	// alert(value)
	
	if(parseFloat(value)>parseFloat(abc))
	{
		alert('Amount Should Not Be Greater Than Total Amount')
	}
	 $("#totalpayment").html(abc);
  }
  
 function checkinsert(evt)
 {
	 //alert(1111)
	 var serviceid=$(evt).closest('td').prev().prev().find('input').val();
	 //alert(serviceid);
	var app_id=$("#appointment_id").val();
	//alert(app_id)
	if(serviceid!="")
	{
		$.ajax({
			type:"post",
			data:"serviceid="+serviceid+"&app_id="+app_id,
			url:"insertservice.php",
			success:function(res)
			{
		//alert(res)
				if($.trim(res)=='2')
				{
			window.location="appointment_invoice.php?uid="+app_id;
				}
			}
			
		})
	}
	 
 }
 function checkdelete(evt)
 {
	  var serviceid=$(evt).closest('td').prev().prev().prev().find('input').val();
	//alert(serviceid);
	var app_id=$("#appointment_id").val();
	//alert(app_id)
	if(serviceid!="")
	{
		$.ajax({
			type:"post",
			data:"serviceid="+serviceid+"&app_id="+app_id,
			url:"deleteservice.php",
			success:function(res)
			{
				//alert(res)
				if($.trim(res)=='2')
				{
				 window.location="appointment_invoice.php?uid="+app_id;
				}
			}
			
		})
	}
	
 }
   function assignmember()
  {
	// alert(1111)
	  var member=$("#memebr").val();
	  	var app_id=$("#appointment_id").val();
		/* var service=$("#serviceid").val();
		alert(service) */
	 // alert(member)
	  $(".membertype").val(member);
	  if(member!="0")
	  {
		  	$.ajax({
			type:"post",
			data:"member="+member+"&app_id="+app_id,
			url:"updatemember.php",
			success:function(respp)
			{
				//alert(respp)
				if($.trim(respp)=='2')
				{
				 window.location="appointment_invoice.php?uid="+app_id;
				}
				
				//alert($.trim(respp))
				//ans=[];
				/* var ans = $.trim(respp);
				var ansd = ans.split(",");
				alert(ansd) */
				
				
/* 			  $("#discounttr").show();
			$("#type").html(arr[0]);
			  if(arr[1]=='Monthly')
			  {
				  var abc = arr[1]+' Amount Membership Discount';
				  
			  }
			  else
			  {
				  var abc = arr[1]+' % Membership Discount';
			  }
            //alert(arr[1]);
			
			$("#type1").html(abc);
			("#type2").html(arr[2]); */

			/*  $("#displaydetail").hide();
			$("#discounttr").show();
			$("#discounttr").html(respp); */
			//alert(sep);
		/* 	$("#membername").html(sep[0]);
			$("#discountvalue").html(sep[1]);
			$("#discountcost").html(sep[2]); */
				//$("#discounttr").html(res);
				
			}
			
		})
	  }
  }
  function test1(evt)
  {
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
	var amt=parseFloat(Amount);
	var qqty=parseFloat(qty);
	var AmountAfterMultiply=0;
	AmountAfterMultiply = qqty * amt;
	
	var totalamt=AmountAfterMultiply+".00";
  //  alert(qty);
	//alert(id);
	//alert(nexttdidfinal);
	//alert(Amount);
	//alert(AmountAfterMultiply);
	
	$('#' + nexttdidfinal).val(totalamt)+".00"
	 var serviceid=$(evt).closest('td').prev().find('input').val();
	//alert(serviceid);
	var app_id=$("#appointment_id").val();
	//alert(app_id)
//alert(qty)
	
  if(qty!="")
	{
		$.ajax({
			type:"post",
			data:"qty="+qty+"&amt="+totalamt+"&serviceid="+serviceid+"&app_id="+app_id,
			url:"updateqty.php",
			success:function(res)
			{
			//alert(res)
				if($.trim(res)=='2')
				{
					window.location="appointment_invoice.php?uid="+app_id;
				}
			}
			
			
		})
	}
	
  }

		function calculatecashamount()
		{
			
			var cashamt=$("#cashboth").val();
			 var totalcost = Math.round($("#totalcost").val());
			 	
			 var amt = parseFloat(totalcost)-parseFloat(cashamt);
	//	alert(amt)
			 $("#cardboth").val(amt);
			 
			  var cardboth=$("#cardboth").val();
			 
			  $("#totalpayment").val(totalcost);
		}
		 function calculatecardamt()
		{
			//alert(111)
			
		   var cardamtt = $("#cardboth").val();
			//alert(cardamtt)
			 var totalcost= Math.round($("#totalcost").val());
			 var amt = parseFloat(totalcost) - parseFloat(cardamtt);
		//alert(amt)
	       
			 $("#cashboth").val(amt);
			 
			  $("#totalpayment").val(totalcost);
		}
		
		//////////////////////////////////////
	function calculatecomplete()
		{
			
			
			var complete=$("#completeamt").val();
			
			 var totalcost = Math.round($("#totalcost").val());
			 if(complete>totalcost)
			 {
				 alert('Complete Amount Should Not Be Greater Total Payment')
			 }
			 else
			 {
				  $("#completeamt").val();
				  var amt = parseFloat(totalcost)-parseFloat(complete);
	//	alert(amt)
			 $("#pendamt").val(amt);
			 
			
			 
			  $("#totalpaymentamt").val(complete);
			 }
			 	
			
		}
		 function calculatepend()
		{
			//alert(111)
			
		   var pend = $("#pendamt").val();
			//alert(cardamtt)
			 var totalcost= Math.round($("#totalcost").val());
			  
			 if(pend>totalcost)
			 {
				 alert('Pending Amount Should Not Be Greater Total Payment')
			 }
			 else
			 {
				 $("#pendamt").val();
				  var amt = parseFloat(totalcost) - parseFloat(pend);
		//alert(amt)
		
			 $("#completeamt").val(amt);
			 
			  $("#totalpaymentamt").val(amt);
			 }
			
		}
		
/*   function checkstatus(ext)
		{
		//alert(111)
		var uid=$("#uid").val();
		alert(ext)
		var number=$("#status").text();
		//alert(number)
		if(ext=='Hold')
		{
			//alert(1234)
			// window.location="ManageAppointments.php";
			window.location="appointment_invoice.php?uid=<?php echo $appointment_id ?>";
		}
		else if(ext=='Completed')
		{
			
	//	window.location="appointment_invoice.php?uid=<?php echo $appointment_id ?>";
			
			
		}
		
		else
		{
			
		}
		}
        */
 
    </script>
<style>
.btn-success
{
	background-color:lightgreen;
	color:black;
	
}
.btn-success:hover
{
	background-color:lightgreen;
		color:black;
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
$counter = 0;
$strID = $_GET['uid'];
	?>
	             <div class="panel">
				
						<div class="panel-body">
							<div class="fa-hover">	
								<a href="javascript:window.location = document.referrer;" class="btn btn-primary btn-lg btn-block"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a><br/>
										   	<center><b><span id="displayoffererror" style="text-align:center;text-weight:bold"></b></center></span>
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
							
									<div id="displaymembership" class="panel-body col-md-12">
							   <label class="col-md-6 control-label" >Select Membership<span>*</span></label>
															
														
								 <?php 
							   $seldata=select("*","tblMembership","Status='0'");
							   ?>
							  	<select class="form-control"  style="text-align:center" id="memebr" onchange="assignmember()">
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
							  
							   
							</div>
					          
						 
						
						<div class="panel-body col-md-4">
                              
							   
                                    <div class="example-box-wrapper">
                                        	<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>Sr</th>
                                                    <th>Service</th>
                                                    <th>Cost</th>
													<th class="no-print">Action</th>
                                                </tr>
                                            </thead>
												<tfoot>
													<tr>
                                                    <th>Sr</th>
                                                    <th>Service</th>
                                                    <th>Cost</th>
													<th class="no-print">Action</th>
                                                </tr>
														</tfoot>
                                            <tbody>
											<?php 
											$seld=select("*","tblServices","1");
											foreach($seld as $val)
											{
												$counter ++;
												?>
												   <tr id="my_data_tr_<?=$counter?>">
                                                    <td style="text-align: center"><?=$counter?></td>
                                                    <td><?php echo $val['ServiceName'] ?>
													<input type="hidden" id="serviceid" value="<?php echo $val['ServiceID'] ?>" />
													</td>
                                                    <td class="center"><?php echo $val['ServiceCost'] ?></td>
													<td class="center">
													
													<a id="insertservice" href="#" onClick="checkinsert(this)">Insert</td>
                                                  </tr>
												<?php
											}
											?>
											
                                             
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
										<div class="panel-body col-md-8" >
                                <div class="panel-body">
								<?php 
									$seldoffer=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
															$offerid=$seldoffer[0]['offerid'];
															
										$seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$OfferCode=$seldofferp[0]['OfferCode'];						
															
								if($offerid!="0")
								{
									?>
									
									  <label class="control-label" style="width:25%" >Offer Name<span>*</span></label>
								<input type="text"  readonly style="width:45%;display:inline-block;" value="<?php echo $OfferCode ?>" name="offername" id="offername" class="form-control" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="offeridremove" style="width:12%;display:inline-block;" value="<?php echo $OfferCode ?>" class="btn btn-success" data-toggle="button" ><center>Remove</center></button>
							   </div>
									  
									<?php
								}
								else
								{
									?>
									<label class="control-label" style="width:25%" >Offer Name<span>*</span></label>
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
										$seldp=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
										// $seldpd=select("StoreBillingAddress","tblStores","StoreID='".$seldp[0]['StoreID']."'");
										$seldpd=select("StoreName","tblStores","StoreID='".$seldp[0]['StoreID']."'");
										$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".$_GET['uid']."'");
										$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
										//print_r($seldpdep);
										//$seldpdepp=select("EmployeeName","tblEmployeesServices","EID='".$seldp[0]['EID']."'");
									$seldpdeptp=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".$_GET['uid']."'");
									foreach($seldpdeptp as $ty)
									{
									 $totalservices=$ty['ServiceID'];
										$seldpdepp=select("EID","tblEmployeesServices","ServiceID='".$totalservices."'");
										//print_r($seldpdepp);
										
									}
									//$sereviceep=implode(",",$totalservices);
								
									?>
                                        <tr>
										<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $_GET['uid'] ?>" />
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
														foreach($seldpdepp as $vca)
														{
															$eppp=$vca['EID'];
															$seldpdeppt=select("EmployeeName","tblEmployees","EID='".$eppp."'");
														$empname=$seldpdeppt[0]['EmployeeName'];
														$emppp=$emppp.','.$empname;
															//$empnamep=implode(",",$empname);
														}
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
                                            <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:20px;text-align:center;" height="30"><b>Service's</b></td>
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
                                                          <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Code</th>
                                                          <th width="60%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
														   <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Quantity</th>
                                                          <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
														  <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Action</th>
                                                        </tr>
														<?php 
														$seldpdept=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".$_GET['uid']."'");
														$sub_total=0;
														
														$countersaif = "";
														$counterusmani = "1";
														foreach($seldpdept as $val)
														{
															$countersaif ++;
															$counterusmani = $counterusmani + 1;
															$totalammt=0;
															$servicee=select("*","tblServices","ServiceID='".$val['ServiceID']."'");
															$qtyyy=$val['qty'];
															$amtt=$val['ServiceAmount'];
															$totalammt=$qtyyy*$amtt;
															$total=0;
															?>
															
                                                        <tr>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input readonly name="servicecode[]" value="<?php echo $servicee[0]['ServiceCode']; ?>" /><input type="hidden" name="membertype" id="membertype" class="membertype"/></td>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input type="hidden" name="serviceid[]" id="serviceid" value="<?php echo $val['ServiceID'] ?>" /><?php echo $servicee[0]['ServiceName']; ?></td>
														    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">
															<select id="<?=$countersaif?>" class="quantity" onchange="test1(this)" name="qty[]">
																<option value="0">0</option>
															<?php
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
														  		<a id="deleteservice" href="#" onClick="checkdelete(this)">Delete</a></td>
                                                        </tr>
									
														<tr>
														<?php 
															$seldember=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
															$memid=$seldember[0]['memberid'];
															
														if($memid!="0")
														{
															
															 
			$DB = Connect();
			
		
				$seldatap=select("DiscountType","tblMembership","MembershipID='".$memid."'");	
				$type=$seldatap[0]['DiscountType'];
          if($type=='1')
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
					
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input readonly name="membershipname[]" value="<?php echo $membershipname; ?>" /></td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input readonly name="Discount[]" value="<?php echo $Discount; ?>" />Amount Membership Discount </td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
						<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
						<input id="disamt" name="disamt[]" type="text" readonly value="<?=$Discount.".00" ?>" />
														  <?php 
														  	  $offdisp=$offdisp+$Discount;
														 $memberdis=$memberdis+$Discount;
														//  $sub_total=$sub_total-$Discount;
													// $total=$total+$sub_total;
														  
														  
														  ?></td> 
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						
						<?php
						//echo "<br/>";
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
			  
					$serviceid=$val['ServiceID'];
					$serviceamount=$val['ServiceAmount'];
					$qty=$val['qty'];
					$amount=$qty*$serviceamount;
					$totalamount=$amount*$Discount/100;
					if(in_array($val['ServiceID'],$sericesd))
					{
						
					}
					else
					{
						
						
											
																
				                                               
															//print_r($servicessf);
												
						
						//echo $membershipname.",".$Discount.",".$totalamount.",".$serviceid.",";
						?>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input readonly name="membershipname[]" value="<?php echo $membershipname; ?>" /></td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input readonly name="Discount[]" value="<?php echo $Discount; ?>" />% Membership Discount </td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td><td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
						
						<input id="disamt" type="text" name="disamt[]" readonly value="<?=$totalamount.".00" ?>" />
														  <?php 
														  $offdisp=$offdisp+$Discount;
														  $memberdis=$memberdis+$totalamount;
														//  $sub_total=$sub_total-$totalamount;
													// $total=$total+$sub_total;
														  
														  
														  ?></td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						<?php
					}
			}
						$DB->close();
														   
															
														}
														else
														{
															
														}
														
														?>
														  </tr>
														 
													<?php
															
														
														}
														
														?>
													
												

														
									
														
                                                        
                                                        
                                                      </tbody>
                                              
                                                </table>
                                            </td>
											
											 
                                        </tr>
                                         
                                        
                                        <!--<tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>-->
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                <tbody>
											
											
                                                    <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Sub Total</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" id="sub_total" name="sub_total" readonly value="<?php echo number_format($sub_total,2);?>" />
													</td>
                                                    </tr>
												    <?php 
												 	$seldember=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
															$memid=$seldember[0]['memberid'];  
															$custid=$seldember[0]['CustomerID'];  
														$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
															$Cost=$seldemberg[0]['Cost'];  		
															
														$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
															$memberflag=$selcust[0]['memberflag'];  		
															
															if($memberflag=='0')
															{
																 $sub_total=$sub_total+$Cost;
																		?>
												 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Membership Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="membercost" readonly value="<?php echo "+".number_format($Cost,2);?>" />
													</td>
                                                    </tr>
													<?php
															}
															elseif($memberflag=='1')
															{
												
															}
														    elseif($memberflag=='2')
															{
																
														
															}
														   else
															{
																$est=explode(",",$memberflag);
																if($est[0]=='3')
																{
																	$app_id=$_GET['uid'];
																	if($app_id==$est[1])
																	{
																		 $sub_total=$sub_total+$Cost;
																		?>
																		 <tr>
																  <td width="50%">&nbsp;</td>
																  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Membership Amount</td>
																  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="membercost" readonly value="<?php echo "+".number_format($Cost,2);?>" />
																</td>
																</tr>
																<?php
																	}
																}
																		?>
											     	 
													<?php
															}
															
															/////////////////////////////////////////////////////
																$seldoffer=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
															$offerid=$seldoffer[0]['offerid'];
															if($offerid!="0")
															{
																
													?>
													
													 <tr>
													 <td width="50%">&nbsp;</td>
										 
			
                                                     <?php 
													$seldoffer=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
															$offerid=$seldoffer[0]['offerid'];
															$StoreIDd=$seldoffer[0]['StoreID'];
																$memid=$seldoffer[0]['memberid'];  
													
													$seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															
															$servicessf=explode(",",$services);
															if(in_array("$StoreIDd",$stores))
															    {
																	foreach($seldpdept as $val)
																		    {
																			$totalammt=0;
																			$serviceid=$val['ServiceID'];
																	     	$AppointmentID=$val['AppointmentID'];
																				if(in_array("$serviceid",$servicessf))
																				{
																					
																					
																					$sqp=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$AppointmentID."'");
																					
																					$amtt=$sqp[0]['ServiceAmount'];
																					
																						 // print_r($serviceqty);
																					 $qtyyy=$sqp[0]['qty'];
																					$totals=$qtyyy*$amtt;
																				  $totalpp=$totalpp+$totals;
																					if($baseamt!="")
																		            {
																					
																							if($totalpp>=$baseamt)
																							{
																						//echo 1;
																							if($Type=='1')
																							{
																								$offeramtt=$totalpp-$TypeAmount;
																							}
																							else
																							{
																								$amt=$totalpp*$TypeAmount/100;
																								
																								$offeramtt=$amt;
																							}
																							
																							$offeramount=$offeramount+$offeramtt;
																						
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
																							$offeramtt=$totalpp-$TypeAmount;
																						}
																						else
																						{
																							$amt=$totalpp*$TypeAmount/100;
																							
																							$offeramtt=$amt;
																						}
																						
																						$offeramount=$offeramount+$offeramtt;
																						
																					}
																					
																				}
																				else
																				{
																					$data="Offer Not Applicable For Any Of This Services";
																				}
																			}
																			
																		
																}
																else
																{
																	$data="This Offer Is Not Valid For This Store";
																			
																}
																		
																		
																
											
																
				                                               
															//print_r($servicessf);
												
													 if($offeramtt!="")
													 {
														
														 ?>
														  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
																							Offer Discount</td>
																							 <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">
																							<input id="offeramt" type="text" name="offeramt" readonly value="<?="-".$offeramtt ?>" /></td>
														 <?php
													 }
													 ?>
													 
													
                                                    </tr>
													<?php
															}
													
															
													///////////////////////////////////////////////////////////////
                                                        ////////////////Member Discount///////////////////////
  
												 	$seldember=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
															$memid=$seldember[0]['memberid'];  
															 $offerid=$seldember[0]['offerid'];
															$custid=$seldember[0]['CustomerID'];  
														$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
															$Cost=$seldemberg[0]['Cost'];  		
															
														$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
															$memberflag=$selcust[0]['memberflag'];  

                                                         $seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															
															$servicessf=explode(",",$services);															
														if($offerid!="0")
														{
																if($memid!="0")
														        {
																	$DB = Connect();
			
																	
																			$seldatap=select("DiscountType","tblMembership","MembershipID='".$memid."'");	
																			$type=$seldatap[0]['DiscountType'];
																	  if($type=='1')
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
																			  
																					$serviceid=$val['ServiceID'];
																					$serviceamount=$val['ServiceAmount'];
																					$qty=$val['qty'];
																					$amount=$qty*$serviceamount;
																					$totalamount=$amount*$Discount/100;
																					if(in_array($val['ServiceID'],$sericesd))
																					{
																						
																					}
																					else
																					{
																							if(in_array("$StoreIDd",$stores))
															                                 {
																	                    foreach($seldpdept as $val)
																							{
																							$totalammt=0;
																							$serviceid=$val['ServiceID'];
																							$AppointmentID=$val['AppointmentID'];
																							if(in_array("$serviceid",$servicessf))
																								{
																									$sqp=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$AppointmentID."'");
																					
																										$amtt=$sqp[0]['ServiceAmount'];
																										
																											 // print_r($serviceqty);
																										 $qtyyy=$sqp[0]['qty'];
																										$totals=$qtyyy*$amtt;
																									  $totalpp=$totalpp+$totals;
																										if($baseamt!="")
																										{
																											if($totalpp>=$baseamt)
																											{
																										//echo 1;
																											if($Type=='1')
																											{
																												$offeramttm=$totals-$TypeAmount;
																											}
																											else
																											{
																												$amt=$totals*$TypeAmount/100;
																												
																												$offeramttm=$amt;
																											}
																											
																											$offeramount=$offeramount+$offeramttm;
																										
																												}
																												else
																												{
																													
																												}
																												$totaloffp=$totals-$offeramttm;
																												$totalofferamt=$totaloffp*$Discount/100;
																										}
																										else
																										{
																											if($Type=='1')
																												{
																													$offeramttm=$totals-$TypeAmount;
																												}
																												else
																												{
																													//echo $totals;
																													//echo $TypeAmount;
																											$amt=$totals*$TypeAmount/100;
																												//	echo $amt;
																													$offeramttm=$amt;
																												}
																											
																											$offeramount=$offeramount+$offeramttm;
																											
																											$totaloffp=$totals-$offeramttm;
																											
																											$totalofferamt=$totaloffp*$Discount/100;

																										}
																								}
																								else
																								{
																									$sqp=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$AppointmentID."'");
																					
																										$amtt=$sqp[0]['ServiceAmount'];
																										
																											 // print_r($serviceqty);
																										 $qtyyy=$sqp[0]['qty'];
																										$totals=$qtyyy*$amtt;
																									  $totalpp=$totalpp+$totals;
																									 $totalofferamt=$totals*$Discount/100;
																								}
																								$totalofferamts=$totalofferamts+$totalofferamt;
																							 }
																							 }
																							 else
																							 {
																								 
																							 }
																							
																					}
																	  }
																	
																}
																else
																{
																	
																}
															
														$memberdis=$totalofferamts;
														?>
															 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Membership Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="memberdiscost" readonly value="<?php echo "-".number_format($memberdis,2);?>" />
													</td>
                                                    </tr>
															<?php
														}
														else
														{
															?>
															 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Membership Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" name="memberdiscost" readonly value="<?php echo "-".number_format($memberdis,2);?>" />
													</td>
                                                    </tr>
															<?php
														}
																	


//////////////////////////////////////////////////////////////////////////////////////////////////													
					
	
												
														//print_r($value);
														//echo $value['AppointmentDetailsID'];
														$sqlExtraCharges=select("DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize","tblAppointmentsCharges","AppointmentID ='".$_GET['uid']."' GROUP BY ChargeName");
													//print_r($sqlExtraCharges);
													
													foreach($sqlExtraCharges as $vaqq)
													{
															$strChargeNameDetails = $vaqq["ChargeName"];
						                              $strChargeAmountDetails = $vaqq["Sumarize"];
														?>
														  <tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><input  type="text" name="chargename[]" readonly value="<?=$strChargeNameDetails ?>" /></td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input  type="text" name="chargeamount[]" readonly value="<?="+".$strChargeAmountDetails ?>" /></td>
										</tr>
										<?php
										$amountdetail=$amountdetail+$strChargeAmountDetails;
													}
													$total=0;
										//echo 
								 
								
												$total=$total+$sub_total+$amountdetail-$offeramtt-$memberdis;
										
									
									
													?>
													
										<?php
													
			/* 	//echo $sqlExtraCharges;
				$RScharges = $DB->query($sqlExtraCharges);
				if ($RScharges->num_rows > 0) 
				{
					while($rowcharges = $RScharges->fetch_assoc())
					{
						echo $strChargeNameDetails = $rowcharges["ChargeName"];
						$strChargeAmountDetails = $rowcharges["Sumarize"];
						
						$strChargetotalAmount += $strChargeAmountDetails;
						?>
					                      <tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?= $strChargeNameDetails ?></td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?= $strChargeAmountDetails ?></td>
										</tr>
										<?php
						
						
					}
				} */
                
				?>
				</tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" id="totalvalue"><input  type="text" name="total" id="totalcost" readonly value="<?= $total ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Round Off</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input  type="text" name="roundtotal" readonly value="<?php  
													  echo round($total);
													//  $total=0;
													  ?>" /></td>
                                                    </tr>
                                                    
                                                  </tbody>
                                                                                                   
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        
                                       <!-- <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> -->
                                      
										<?php 
										
										$seldppay=select("*","tblInvoiceDetails","AppointmentId='".$_GET['uid']."'");
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
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo $amount?></td>
                                                    </tr>
                                                  
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
										}
										elseif($flag=='H')
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
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo $amount?></td>
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
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo $amount?></td>
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
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="paymentid" name="cashamt" value="<?php echo $total; ?>" onkeyup="test()"/></td>
													   
													 
                                                    </tr>
												
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" ><input id="totalpayment" name="totalpayment" value="<?php  
													  echo round($total);
													//  $total=0;
													  ?>"/></td>
                                                    </tr>
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											
											<?php
											
										}
										?>
                                            <tr>
											<td style="display:none" id="payment1">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
                                                     <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%"  style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="cashboth" name="cashboth" onkeyup="calculatecashamount()" /></td>
													   
													 
                                                    </tr>
													<tr>
													   <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
													  <td width="30%"  style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="cardboth" name="cardboth" onkeyup="calculatecardamt()"/></td>
													</tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" ><input id="totalpayment" name="totalpayment" value="<?php  
													  echo round($total);
													//  $total=0;
													  ?>"/></td>
                                                    </tr>
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											  <tr>
											<td style="display:none" id="paymenttype">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
                                                     <tr id="paymenttype1">
													  <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-WEIGHT:bold;FONT-SIZE:14px;"><input type="radio" name="paytype"  value="Partial"/>Partial</td>
                                                      <td width="20%"  style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;"><input type="radio" name="paytype"  value="Complete"  checked />Complete</td>
													  <td width="20%">
                                                   <a onclick="checktypeofpayemnt()" class="btn btn-xs btn-primary" id="confirm" >Please Confirm<div class="ripple-wrapper"></div></a>
												   </td>
													   
													 
                                                    </tr>
													
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
                                          <tr>
											<td style="display:none" id="paymentcheck">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
                                                     <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%"  style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Complete Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="completeamt" name="completeamt" onkeyup="calculatecomplete()" /></td>
													   
													 
                                                    </tr>
													<tr>
													   <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
													  <td width="30%"  style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="number" id="pendamt" name="pendamt" onkeyup="calculatepend()"/></td>
													</tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" ><input id="totalpaymentamt" name="totalpaymentamt"/></td>
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
                                        
                                         <td  style="BACKGROUND:#d0ad53;">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                              
                                                <tbody>
                                        
                                        
                                        
                                          
                                            
                                              <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px; padding:1%;" height="32" align="center">
                                            <span style="font-size:14px; font-weight:600;" >Our Branches : KHAR | BREACH CANDY | ANDHERI | COLABA</span><br>
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
									$seldppay=select("*","tblInvoiceDetails","AppointmentId='".$_GET['uid']."'");
										$amount=$seldppay[0]['CashAmount'];
										$flag=$seldppay[0]['Flag'];
										?>
										<a href="appointment_invoice.php" class="btn btn-primary" style="float: left;">Go Back</a>
										<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button" ><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" id="card" value="card" class="btn btn-info" id="btnPrint" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" id="hold" value="hold"  class="btn btn-primary active" id="btnPrint" data-toggle="button" style="float:left;">Hold</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="button" id="both" value="both"  class="btn btn-blue-alt" id="both" data-toggle="button" style="float:left;">Both</button>
									
									
										
                                </div>
				
							
								
								
									
							</div>
							
							</div>
							<?php
}	
else
{
?>	
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<div class="example-box-wrapper">
								<span class="form_result">&nbsp; <br></span>
									<div class="panel-body">
										<h3 class="title-hero">List of Invoice | Nailspa</h3>
										<div class="example-box-wrapper">
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Appointment ID</th>
													
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
														<th>Appointment ID</th>
													
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



if(isset($_GET["uids"]))
{
	$asmitaabc=DecodeQ($_GET["uids"]);
	$sql = "SELECT * FROM tblAppointmentlog where appointment_id=$asmitaabc";

}
else
{
	$sql = "SELECT * FROM tblAppointmentlog order by id desc";
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
$appointment_id = $row["appointment_id"];

$selda=select("*","tblAppointments","AppointmentID='$appointment_id'");
$invoice_name = $selda[0]["CustomerID"];
$sada=select("CustomerFullName","tblCustomers","CustomerID='".$invoice_name."'");
$customer=$sada[0]['CustomerFullName'];

$getUID = EncodeQ($appointment_id);
$appointment_date = $selda[0]["AppointmentDate"];

$store = $selda[0]["StoreID"];
$sadad=select("StoreName","tblStores","StoreID='".$store."'");
$storename=$sadad[0]['StoreName'];
 $status = $selda[0]["Status"];
$seldapp=select("*","tblInvoiceDetails","AppointmentId='$appointment_id'");	
$invoiceamt=$seldapp[0]['RoundTotal'];
$amt=number_format($invoiceamt,2);
$flag=$seldapp[0]['Flag'];
?>	
<script>
 	function checkstatus(ext,ep)
		{
		//alert(111)
		var uid=$("#uid").val();
		//alert(ext)
		//alert(ep)
		var number=$("#status").text();
		//alert(number)
		if(ext=='Hold')
		{
			//alert(1234)
			// window.location="ManageAppointments.php";
			window.location="appointment_invoice.php?uid="+ep;
		}
		else if(ext=='Processing')
		{
			window.location="appointment_invoice.php?uid="+ep;
		}
		else if(ext=='Completed')
		{
			
	//	window.location="appointment_invoice.php?uid=<?php echo $appointment_id ?>";
			
			
		}
		
		else
		{
			
		}
		}
</script>
													<tr id="my_data_tr_<?=$counter?>">
														<td style="text-align: center"><?=$counter?>
														<input type="hidden" id="uid" value="<?php echo $getUID  ?>" />
														</td>
														<td style="text-align: center">
														<?=$appointment_id?>
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
																	
																		if($flag=="H")
																		{
																		//	echo $appointment_id;
																			
																			$Status = "Hold";
																			?>
																		<a id="status" href="#" class="btn btn-link" onClick="checkstatus('Hold','<?=$appointment_id?>')"><?php echo $Status; ?></a>
																			<?php
																			
																		}
																		elseif($flag=="CS")
																		{
																			$Status = "Completed";
																			//echo $Status;
																				?>
																			<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Completed')"><?php echo $Status; ?></a>
																			<?php
																		}
																		elseif($flag=="C")
																		{
																			$Status = "Completed";
																			//echo $Status;
																				?>
																			<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Completed')"><?php echo $Status; ?></a>
																			<?php
																		}
																		elseif($flag=="BOTH")
																		{
																			$Status = "Both";
																			//echo $Status;
																				?>
																			<a id="status" class="btn btn-link disabled" href="#" onClick="checkstatus('Completed')"><?php echo $Status; ?></a>
																			<?php
																		}
																		elseif($flag=="")
																		{
																			$Status = "Processing";
																			//echo $Status;
																				?>
																			<a id="status" class="btn btn-link" href="#" onClick="checkstatus('Processing','<?=$appointment_id?>')"><?php echo $Status; ?></a>
																			<?php
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