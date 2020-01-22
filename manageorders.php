<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Place Order Request| Nailspa";
	$strDisplayTitle = "Place Order Request| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblOrder";
	$strMyTableID = "OrderID";
	$strMyActionPage = "manageorders.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	if($strStore=="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$strStep = Filter($_POST["step"]);
		if($strStep=="add")
		{
			foreach($_POST as $key => $val)
			{
				if($key!="step")
				{
					if(IsNull($sqlColumn))
					{
						$sqlColumn = $key;
						$sqlColumnValues = "'".$_POST[$key]."'";
					}
					else
					{
						$sqlColumn = $sqlColumn.",".$key;
						$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
					}
				}
	
			}
		$DB = Connect();
		//print_r($_POST);
		$category = Filter($_POST["category"]);
		$cntcat=count($category);
		$ServiceID = Filter($_POST["ServiceID"]);
		$productstock = $_POST["Products"];
		$cntprod=count($productstock);
		$productqty = Filter($_POST["productqty"]);
		for($i=0;$i<count($productstock);$i++)
		{
			$productstock[$i];
			$sqldata1 = "SELECT count(*) FROM tblFinalOrder WHERE ProductID='".$productstock[$i]."' and ServiceID='".$ServiceID."'";
						//echo $sqldata1.'<br>';
						$RSdiscountt = $DB->query($sqldata1);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$cnt = $rowdiscountt["count(*)"];
							
								
						
							}
						}
						else
						{
							
						}
				
		/* 	$sepp=select("count(*)","tblFinalOrder","ProductID='".$productstock[$i]."' or ProductStock='".$productstock[$i]."' and ServiceID='".$ServiceID."'");
			echo $cnt=$sepp[0]['count(*)']; */
		}
		
		   
			if($cntcat<=0 || $ServiceID=='' || $ServiceID=='0' || $cntprod<=0)
			{
			
					die('<div class="alert alert-close alert-success">
				
					<div class="alert-content">
						<h4 class="alert-title">Please Fill Required Fields</h4>
						<p></p>
					</div>
				</div>');
			}
			elseif($cnt<=0)
			{
					die('<div class="alert alert-close alert-success">
					
					<div class="alert-content">
						<h4 class="alert-title">Please Fill Required Fields</h4>
						<p></p>
					</div>
				</div>');
			}
			else
			{
				
				
				echo("<script>location.href='pendingorders.php';</script>");
			}
			
			
			
	
			
	

		}

		if($strStep=="edit")
		{
			$DB = Connect();
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID)
				{
					
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					
				}
			}
			$DB->close();
			die('<div class="alert alert-close alert-success">
					
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
						<p></p>
					</div>
				</div>');
		}
		die();
	}	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
<script>
$(document).ready(function(){
var store=$("#storeid").val();
$("#submit").hide();				
			   if(store!="")
			   {
				   $.ajax({
						type:"post",
						data:"storeid="+store,
						url:"storecategoryorder.php",
						success:function(res)
						{
						//alert(res)
						var rep = $.trim(res);
						$("#catid").show();
						$("#catid").html("");
						$("#catid").html("");
						$("#catid").html(rep);
						}
						
						})
			   }
$("#btnPrint").click(function () {
			//alert(111)
            var divContents = $("#printdata").html();
			//alert(divContents)
            var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><title>Product Stock</title>');
          printWindow.document.write('</head><body >');
          printWindow.document.write(divContents);
          printWindow.document.write('</body></html>');
			printWindow.document.close();
			printWindow.print();
        });
		
		
	
				
		
		
})


</script>
<body>
    <div id="sb-site">   
		<?php require_once("incOpenLayout.fya"); ?>	
		
        <?php require_once("incLoader.fya"); ?>
       
        <div id="page-wrapper">
            <div id="mobile-navigation"><button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button></div>
			<?php require_once("incLeftMenu.fya"); ?>
			
            
		<div id="page-content-wrapper">
			<div id="page-content">
				<?php require_once("incHeader.fya"); ?>									
					
				<div class="panel">
				<div class="panel-body">
<?php
$DB = Connect();
		$strID = $_GET['id'];

		$strIDs = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
		$RS_store = $DB->query($sql_store);
		$row_store = $RS_store->fetch_assoc();
		$strStoreName = $row_store['StoreName'];
		
	?>

					<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
					
					<div id="normal-tabs-2">
					<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ManageProductsMaster.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					
					
											<div class="panel-body ">
											
											
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Order Request</h3>
												<div class="example-box-wrapper">
												<script>
		
		function checktype()
		{
		var type=$("#type").val();
		//alert(type)
	   var store=$("#storeid").val();
	   if(type!="0")
		{
		$.ajax({
		type:"post",
		data:"type="+type+"&storeid="+store,
		url:"servicecategory.php",
		success:function(res)
		{
	//alert(res)
		var rep= $.trim(res);
		$("#serviceid").show();
		$("#serviceid").html("");
		$("#serviceid").html("");
		$("#serviceid").html(rep);
	
	
	
		}
		
		})
		}
		
		
		}
		
function checkproduct()
	{
		//alert(111)
		//alert(12233)
		valuable=[];
		var valuable = $('#ServiceID').val();


//	alert(valuable)
		 $.ajax({
			type: 'POST',
			url: "serviceproduct.php",
			data: {
				id:valuable
				
			},
			success: function(response) {
//alert(response)
				
				var rep= $.trim(response);
				$("#prodid").show();
				$("#prodid").html("");
				$("#prodid").html("");
				$("#prodid").html(response);
				//asmita1
				/* $("#asmita1").show();
				$("#asmita1").html("");
				$("#asmita1").html(response); */
					
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$("#prodid").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
				return false;
				//alert (response);
			}
		}); 
	}
			
function ProdDetails()
{
		valuable=[];
		var valuable = $('#prodidd').val();
		var servicee=$('#ServiceID').val();
	
//alert(valuable)
	   $.ajax({
		type: 'POST',
		url: "productdetails.php",
		data: {
			id:valuable,
			service:servicee
			
		},
		success: function(response) {
//alert(response)
			
			var rep= $.trim(response);
			$("#productdetails").show();
			$("#productdetails").html("");
			$("#productdetails").html("");
			$("#productdetails").html(response);
			//asmita1
			/* $("#asmita1").show();
			$("#asmita1").html("");
			$("#asmita1").html(response); */
				
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$("#productdetails").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
			return false;
			//alert (response);
		}
	}); 
}
			</script>
													
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
		}
		else if ($row["Field"]=="CategoryID")
		{
?>	                                         <input type="hidden" id="storeid" value="<?= $strStore ?>" />
                                               <span id="catid"></span>
													
											
											
<?php

		}
		else if($row["Field"]=="ServiceID")
		{
			?>
			<span id="serviceid"></span>
			<?php
		}
		else if($row["Field"]=="ProductID")
		{
			?>
			<span id="prodid"></span>
			<div id="productdetails"></div>
			<?php
		}
	
		
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" id="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-2"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
															
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
												<!----------------Display--->
		<script>
		function orderconfirm(evt)
			{
				//alert(1111)
			 var qty=$(evt).closest('td').prev().find('input').val();
			 var stock=$(evt).closest('td').prev().prev().find('input').val();
			 var prodid=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
		     var prodidstock=$(evt).closest('td').prev().prev().prev().find('input').val();
		     valuprod=[];
		     valuservice=[];
			var valuprod = $('#prodidd').val();
			var valuservice = $('#ServiceID').val();
		
			var catid=$("#type").val();
		
				 if(qty!="" && qty!="0")
					{
						if(qty<0)
						{
							alert('Quantity cannot be negative')
						}
						else
						{
							
							if(Number(stock) < Number(qty))
							{
								alert('Quantity cannot be greater than stock')
							}
							else
							{
								if(prodid!="0")
								{
								   $.ajax({
									   type:"post",
									   data:"qty="+qty+"&stock="+stock+"&prodid="+prodid+"&catid="+catid+"&valuservice="+valuservice+"&prodidstock="+prodidstock,
									   url:"addtoorder.php",
									   success:function(response)
									   {
										  // alert(response)
										   if($.trim(response)=='4')
										   {
												var p = evt.parentNode.parentNode;
												p.parentNode.removeChild(p);
												$("#submit").show();
										   }
										   else if($.trim(response)=='2')
										   {
											   alert('This Product is already order for this service')
										   }
									   }
								   })
								} 
							}
							  
						}
						
					}
					else
					{
						alert('Quantity cannot be blank')
					} 
			
		
			}
		</script>
											</div>
											
											
											
					</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
			</div>
	
		
	
				</div>	
				
			
				</div>
			</div>
		</div>
		</div>
			
			<?php require_once 'incFooter.fya'; ?>
        </div>
        
    </div>
</body>
</html>