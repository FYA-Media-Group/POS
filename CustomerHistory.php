<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Upload Profile | Nailspa";
	$strDisplayTitle = "Upload Profile for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblAdmin";
	$strMyTableID = "AdminID";
	$strMyField = "Title";
	$strMyActionPage = "CustomerHistory.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	
		$strStep = Filter($_POST["step"]);
		
		if($strStep=="add")
		{
			
		}

		if($strStep=="edit")
		{
			$DB = Connect();
			
			
			$email = Filter($_POST["email"]);
			$Acquisition = Filter($_POST["Acquisition"]);
			$firstname = ucfirst(Filter($_POST["firstname"]));
			$lastname = ucfirst(Filter($_POST["lastname"]));
			//$Acquisition = ucfirst(Filter($_POST["Acquisition"]));
			$strMyTableID=$_POST["CustomerID"];
			$strCustomerFullName = $firstname." ".$lastname;
			
					
					$sqlUpdate1 = "UPDATE tblCustomers SET FirstName='$firstname',LastName='$lastname',CustomerEmailID='$email',Acquisition='$Acquisition',CustomerFullName='$strCustomerFullName' WHERE CustomerID='".$strMyTableID."'";
					
					ExecuteNQ($sqlUpdate1);
				
					$filepath = 'imageupload/images';	

						if(isset($_FILES["PrimaryImage"]["error"]))
						{
							
							// echo "In if<br>";
							$strValidateImage1 = trim(ValidateImageFile($_FILES, "PrimaryImage"));
							
							if($strValidateImage1=="Saved successfully")
							{
							
								// As the image is valid first select the imagename for previous image
								// echo "In if<br>";
								$DB = Connect();
								$sql = "Select CustomerProfilePath FROM tblCustomers where CustomerID='".$strMyTableID."'";
								
								
								$RS = $DB->query($sql);
								if ($RS->num_rows > 0) 
								{
									while($row = $RS->fetch_assoc())
									{
										$strOldImageURL = $row["ProfilePath"];	
									}
									
									$file = $strOldImageURL;
									unlink($file);
									
									$filepath = 'imageupload/images';
									$filename1 = $_FILES["PrimaryImage"]["name"];
									
									$uploadFilename1 = UniqueStamp().$filename1;		
									$strImageUploadPath1 = $filepath."/".$uploadFilename1;
									// #######################
									
									 $sqlUpdate3 = "UPDATE tblCustomers SET CustomerProfilePath='".$strImageUploadPath1."' WHERE CustomerID='".$strMyTableID."'";
									 ExecuteNQ($sqlUpdate3);
								  
														
								}
								else
								{
									// echo "In else<br>";
									$filepath = 'imageupload/images';
									// for First Image
									$filename1 = $_FILES["PrimaryImage"]["name"];
									
									$uploadFilename1 = UniqueStamp().$filename1;		
									$strImageUploadPath1 = $filepath."/".$uploadFilename1;
									// #######################
									 $sqlUpdate3 = "UPDATE tblCustomers SET CustomerProfilePath='".$strImageUploadPath1."' WHERE CustomerID='".$strMyTableID."'";
									 ExecuteNQ($sqlUpdate3);
									
								
									
									
								}	
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Primary Image Added Successfully</strong>
										</div>');
							}
							else
							{
								die($strValidateImage1);
							}
						}
					
				/*  $KML="UPDATE tblCustomerMemberShip SET MembershipID='".$strmembershipIDabc."' WHERE CustomerID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($KML);  */
					
				
		
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
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
	<style>
		 #page-header {
			z-index: 9999;
		}
	</style>
</head>

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
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                        <p>Customer history reports allow you to view summarized statistical data for customer purchases/appointments.</p>
                    </div>
<?php

if(isset($_GET["uid"]))
{
	$datee=date('Y-m-d');
	$strCustomerID = DecodeQ($_GET["uid"]);
	$sqlTempfrom = " and  Date(tblInvoiceDetails.OfferDiscountDateTime)>='2017-01-01'";
    $sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$datee."')";
	
	        $sqlTempfrom1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='2017-01-01'";
			$sqlTempfrom2 = " and Date(tblGiftVouchers.RedempedDateTime)>='2017-01-01'";
			$sqlTempfrom3 = " and Date(tblPendingPayments.DateTimeStamp)>='2017-01-01'";
			$sqlTempfrom4 = " and Date(tblGiftVouchers.Date)>='2017-01-01'";
			
			$sqlTempto1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<=Date('".$datee."')";
			$sqlTempto2 = " and Date(tblGiftVouchers.RedempedDateTime)>=Date('".$datee."')";
			$sqlTempto3 = " and Date(tblPendingPayments.DateTimeStamp)>=Date('".$datee."')";
			$sqlTempto4 = " and Date(tblGiftVouchers.Date)>=Date('".$datee."')";
			
	$DB = Connect();
	$sepqtewwSSS=select("SUM(Amount) AS giftamt","tblGiftVouchers","CustomerID='".$strCustomerID."'");
	//print_r($sepqtewwSSS);
	$gPurchaseAmounttss=$sepqtewwSSS[0]['giftamt'];
	$sepqtewwSSSamt=select("Membership_Amount","tblInvoiceDetails","CustomerID='".$strCustomerID."' and Membership_Amount!=''");
	$memammm=$sepqtewwSSSamt[0]['Membership_Amount'];
	
	$sepqtpacdk=select("PackageID","tblInvoiceDetails","CustomerID='".$strCustomerID."' and PackageIDFlag='P'");
	foreach($sepqtpacdk as $ty)
	{
		$PACKIDsss[]=$ty['PackageID'];
	}
	
	for($q=0;$q<count($PACKIDsss);$q++)
	{
		if($PACKIDsss[$q]!='')
		{
			$sepqtewpack=select("*","tblPackages","PackageID='".$PACKIDsss[$q]."'");
			$packprice=$sepqtewpack[0]['PackageNewPrice'];
			$PackageNewPricedgf +=$packprice;
	
		
		}
	
	}
	unset($PACKIDsss);
																
	
	
	$serr=select("sum(tblInvoiceDetails.RoundTotal) as summm","tblAppointments left join tblInvoiceDetails on tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId left join tblCustomers on tblAppointments.CustomerID=tblCustomers.CustomerID","tblAppointments.IsDeleted!='1' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' and tblInvoiceDetails.AppointmentId!='NULL' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto and tblCustomers.CustomerID='".$strCustomerID."'");
	$summm=$serr[0]['summm'];
	
	$serrappttt=select("tblAppointments.AppointmentID","tblAppointments left join tblInvoiceDetails on tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId left join tblCustomers on tblAppointments.CustomerID=tblCustomers.CustomerID","tblAppointments.IsDeleted!='1' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' and tblInvoiceDetails.AppointmentId!='NULL' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto and tblCustomers.CustomerID='".$strCustomerID."'");
	foreach($serrappttt as $dty)
	{
		$app[]=$dty['AppointmentID'];
	}
	
	$sqlpending = select("sum(tblPendingPayments.PendingAmount) as penout","tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblCustomers on tblAppointments.CustomerID=tblCustomers.CustomerID","tblAppointments.IsDeleted!='1' and tblPendingPayments.Status='1' $sqlTempfrom $sqlTempto and tblCustomers.CustomerID='".$strCustomerID."'");
	$penout=$sqlpending[0]['penout'];
	if($penout=='')
	{
		$penout=0;
	}
	$serrapp=select("count(tblAppointments.AppointmentID) as cntapp","tblAppointments left join tblInvoiceDetails on tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId left join tblCustomers on tblAppointments.CustomerID=tblCustomers.CustomerID","tblAppointments.IsDeleted!='1' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' and tblInvoiceDetails.AppointmentId!='NULL' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto and tblCustomers.CustomerID='".$strCustomerID."'");
	$cntapp=$serrapp[0]['cntapp'];
	$strselect = "SELECT tblCustomers.Gender, tblCustomers.FirstName, tblCustomers.LastName, tblCustomers.CustomerFullName, tblCustomers.CustomerEmailID,  tblCustomers.CustomerMobileNo, tblCustomers.memberid, tblCustomers.Acquisition,tblCustomers.RegDate, tblCustomerMemberShip.MembershipID, tblCustomerMemberShip.EndDay,tblCustomers.CustomerProfilePath FROM `tblCustomers` LEFT JOIN tblCustomerMemberShip on tblCustomers.CustomerID=tblCustomerMemberShip.CustomerID where tblCustomers.CustomerID='$strCustomerID'";
	
	
	$RS = $DB->query($strselect);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$strFirstName = $row["FirstName"];
				$strLastName = $row["LastName"];
				$strEmail = $row["CustomerEmailID"];
				$strMembershipID = $row["memberid"];
				$strEndDay = $row["EndDay"];
				$strGender = $row["Gender"];
				$CustomerMobileNo = $row["CustomerMobileNo"];
				$Acquisition = $row["Acquisition"];
				$RegDate = $row["RegDate"];
				$ProfilePath = $row["CustomerProfilePath"];
				
				$RegDates = FormatDateTime($RegDate);
				// Gender
				if($strGender=='0')
				{
					$strGenderDsiplay = 'man';
				}
				elseif($strGender=='1')
				{
					$strGenderDsiplay = 'girl (1)';
				}
				else
				{
					$strGenderDsiplay = 'girl (1)';
				}
				
				// Membership
				if($strMembershipID =='' || $strMembershipID =='0')
				{
					// Do nothing at all
				}
				else
				{
				
					if($strMembershipID =='1')
					{
						$strMembershipDisplay = '<div class="bg-primary" style="background:#D4AF37;">Gold</div>';
					}
					elseif($strMembershipID =='2')
					{
						$strMembershipDisplay = '<div class="bg-primary" style="background:#C0C0C0;">Silver</div>';
					}
					else
					{
						// Do nothing at all
					}
				}
			}
		}
		else
		{
			$strGenderDsiplay = 'girl (1)';
?>
			<script>	alert('Customer does not exist');		</script>	
<?php
		}
		if($ProfilePath!="")
		{
			$strkonami=$ProfilePath;
		}
		else
		{
			$strkonami="images/".$strGenderDsiplay.".png";
		}
	$DB->Close();
								
											$DB = Connect();
													for($i=0;$i<count($app);$i++)
													{
														$sqlservice = "SELECT tblInvoiceDetails.AppointmentId, tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.CustomerID,tblInvoiceDetails.ServiceAmt,tblInvoiceDetails.ServiceName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.CashAmount,tblInvoiceDetails.CardAmount,tblInvoiceDetails.Membership_Amount,tblAppointments.StoreID,tblInvoiceDetails.AppointmentId,tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime,tblInvoiceDetails.GVPurchasedID,tblInvoiceDetails.PendingAmount,tblInvoiceDetails.Flag from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblPendingPayments on tblInvoiceDetails.AppointmentId=tblPendingPayments.AppointmentID  where tblAppointments.StoreID!='0' and tblAppointments.Status='2'  $sqlTempfrom $sqlTempto and tblInvoiceDetails.AppointmentId='".$app[$i]."'";
														
														//echo $sqlservice;
															$RSservice = $DB->query($sqlservice);
															if ($RSservice->num_rows > 0) 
															{
																$counterservice = 0;

																while($rowservice = $RSservice->fetch_assoc())
																{
																	$toatlseramt="";
																	
																	$SaifAppointmentID = $rowservice["AppointmentId"];
																	$getUID = EncodeQ($SaifAppointmentID);
																	$CustomerFullName = $rowservice["CustomerFullName"];
																	$RoundTotal = $rowservice["RoundTotal"];
																	$AppointmentId = $rowservice["AppointmentId"];
																
																	$counterservice ++;
																	$ServiceAmt = $rowservice["ServiceAmt"];
																	$ServiceName = $rowservice["ServiceName"];
																	$CustomerID = $rowservice["CustomerID"];
																	
																	$Flag = $rowservice["Flag"];
																	
																	if($Flag=='CS')
																	{
																		$PendingAmountycs = $rowservice["PendingAmount"];
																		$PendingAmountyc=0;
																	}
																	else
																	{
																		$PendingAmountyc = $rowservice["PendingAmount"];
																		$PendingAmountycs=0;
																	}
																	
																	$sepqts=select("*","tblCustomers","CustomerID='".$CustomerID."'");
																	$CustomerEmailID=$sepqts[0]['CustomerEmailID'];
																	$StoreID = $rowservice["StoreID"];
																	
																	$sepqto=select("*","tblInvoice","AppointmentID='".$AppointmentId."'");
																	$invoice=$sepqto[0]['InvoiceID'];
																	
																	$sepqtpack=select("PackageID","tblInvoiceDetails","AppointmentId='".$AppointmentId."' and PackageIDFlag='P'");
																	$PACKID=$sepqtpack[0]['PackageID'];
																	
																	$package=explode(",",$PACKID);
																	
																	$sepqt=select("*","tblPendingPayments","PendingStatus='2' and AppointmentID='".$AppointmentId."' $sqlTempfrom3 $sqlTempto3");
																	$PendingAmount=$sepqt[0]['PendingAmount'];
																
																	$sepqtQW=select("count(*)","tblPendingPayments","Status='1' and PendingStatus='2' and AppointmentID='".$AppointmentId."' $sqlTempfrom3 $sqlTempto3");
																	$cnttt=$sepqtQW[0]['count(*)'];
																	 if($cnttt>0)
																	{
																	$CashAmount = $rowservice["CashAmount"];
																	$CardAmount = $rowservice["CardAmount"];	
																	if($CashAmount!="0.00")
																	{
																		$CashAmount=$RoundTotal-$PendingAmount;
																	}
																	elseif($CardAmount!="0.00")
																	{
																			$CardAmount =$RoundTotal-$PendingAmount;
																	}
																	
																	}
																	else
																	{
																		$CashAmount = $rowservice["CashAmount"];
																		$CardAmount = $rowservice["CardAmount"];
																	}
																	
																		
																	
														
																	$Membership_Amount = $rowservice["Membership_Amount"];
																	$memamtfirst = explode(",", $Membership_Amount);
																		
																		$memamtfirst=str_replace("+", "", $Membership_Amount);
																		$memamtfirst=str_replace(".00", "", $memamtfirst);
																		$memamtfirst=str_replace(".", "", $memamtfirst);

																		$memamtfirst=str_replace(",", "", $memamtfirst);
																//	$memamtfirst=str_replace("+", "", $Membership_Amount);
																	 if($memamtfirst=='')
																			{
																				$memamtfirst="0.00";
																			}
																	
																	$Totalmemamtfirst += $memamtfirst;
																			
																			
																	$sepqtpt=select("sum(ChargeAmount) as sumcharge","tblAppointmentsChargesInvoice","AppointmentID='".$AppointmentId."'");
																	// echo $sepqtpt;
																	$tax=$sepqtpt[0]['sumcharge'];
																	
																
																	
																	$OpenTime=$rowservice['AppointmentCheckInTime'];
																	$CloseTime=$rowservice['AppointmentCheckOutTime'];
																	$sepqtp=select("sum(OfferAmount) as offamt,sum(MembershipAmount) as memamt","tblAppointmentMembershipDiscount","AppointmentID='".$AppointmentId."' $sqlTempfrom1 $sqlTempto1");
																	$offamt=$sepqtp[0]['offamt'];
																	$memamt=$sepqtp[0]['memamt'];
																	
																		$GVPurchasedID = $rowservice["GVPurchasedID"];
																		$sepqteww=select("*","tblGiftVouchers","GiftVoucherID='".$GVPurchasedID."' and AppointmentID='".$AppointmentId."' $sqlTempfrom4 $sqlTempto4");
																	
																	$gPurchaseAmountt=$sepqteww[0]['Amount'];
																	
																	$sepqtew=select("*","tblGiftVouchers","Status='1' and RedempedBy='".$AppointmentId."' $sqlTempfrom2 $sqlTempto2");
																	
																	
																$gAmount=$sepqtew[0]['Amount'];
																if($gAmount =="")
																{
																	$gAmount ="0.00";
																}
																else
																{
																
																	$gAmount = $gAmount;
																	
																}
															
																$TotalgAmount += $gAmount;
																	$saleamount=$RoundTotal-$gAmount;
																	$saleamount=$saleamount+$PendingAmountyc;
																	$saleamount=$saleamount+$PendingAmountycs;
																if($saleamount =="")
																{
																	$saleamount ="0.00";
																}
																else
																{
																
																	$saleamount = $saleamount;
																	
																}
																$Totalsaleamount += $saleamount;
														if($gPurchaseAmountt =="")
																{
																	$gPurchaseAmountt ="0.00";
																}
																else
																{
																
																	$gPurchaseAmountt = $gPurchaseAmountt;
																	
																}
																$TotalgPurchaseAmountt += $gPurchaseAmountt;
																	if($OpenTime!='0000-00-00 00:00:00')
																	 {
																			 $LoginTimet=date('h:i:s', strtotime($OpenTime));
																	 }
																	 else
																	 {
																			 $LoginTimet="00:00:00";
																	 }
																
																  if($CloseTime!='0000-00-00 00:00:00')
																	 {
																			 $LogoutTimet=date('h:i:s', strtotime($CloseTime));
																	 }
																	 else
																	 {
																			 $LogoutTimet="00:00:00";
																	 }
																	
																	$serviceamts = explode(",",$ServiceAmt);
																	$ServiceNames = explode(",",$ServiceName);
																	$sep=select("*","tblStores","StoreID='".$StoreID."'");
																	$storename=$sep[0]['StoreName'];
																  if($CashAmount=='')
																  {
																	  $CashAmount="0.00";
																  }
																	if($CardAmount=='')
																  {
																	  $CardAmount="0.00";
																  }
																  
																	for($i=0;$i<count($serviceamts);$i++)
																	{
																		$toatlseramt +=$serviceamts[$i];
																	}
																	unset($serviceamts);
																	$serviceamts="";
																	
																
																	for($q=0;$q<count($package);$q++)
																	{
																		if($package[$q]!='')
																		{
																			$sepqtewpack=select("*","tblPackages","PackageID='".$package[$q]."'");
																			$packprice=$sepqtewpack[0]['PackageNewPrice'];
																			$PackageNewPrice +=$packprice;
																	
																		
																		}
																	
																	}
																	unset($package);
																
																	
																	
																if($PackageNewPrice =="")
																{
																	$PackageNewPrice ="0.00";
																}
																else
																{
																
																	$PackageNewPrice = $PackageNewPrice;
																	
																}
																$TotalPackageNewPrice += $PackageNewPrice;	
															   
															   
															   
															  if($toatlseramt =="")
																{
																	$toatlseramt ="0.00";
																}
																else
																{
																
																	$toatlseramt = $toatlseramt;
																	
																}
																$Totaltoatlseramt += $toatlseramt;
																
															if($offamt =="")
																{
																	$offamt ="0.00";
																}
																else
																{
																
																	$offamt = $offamt;
																	
																}
																$Totaloffamt += $offamt;
																if($tax =="")
																{
																	$tax ="0.00";
																}
																else
																{
																
																	$tax = $tax;
																	
																}
																$Totaltax += $tax;
															if($memamt =="")
																{
																	$memamt ="0.00";
																}
																else
																{
																
																	$memamt = $memamt;
																	
																}
																$Totalmemamt += $memamt;
																if($PendingAmount =="")
																{
																	$PendingAmount ="0.00";
																}
																else
																{
																
																	$PendingAmount = $PendingAmount;
																	
																}
																$TotalPendingAmount += $PendingAmount;
																
																
																if($PendingAmountyc =="")
																{
																	$PendingAmountyc ="0.00";
																}
																else
																{
																
																	$PendingAmountyc = $PendingAmountyc;
																	
																}
																$TotalPendingAmountyc += $PendingAmountyc;
																if($PendingAmountycs =="")
																{
																	$PendingAmountycs ="0.00";
																}
																else
																{
																
																	$PendingAmountycs = $PendingAmountycs;
																	
																}
																$TotalPendingAmountycs += $PendingAmountycs;
																if($CashAmount =="")
																{
																	$CashAmount ="0.00";
																}
																else
																{
																
																	$CashAmount = $CashAmount;
																	
																}
																$TotalCashAmount += $CashAmount;
																
																if($CardAmount =="")
																{
																	$CardAmount ="0.00";
																}
																else
																{
																
																	$CardAmount = $CardAmount;
																	
																}
																$TotalCardAmount += $CardAmount;
																
																if($RoundTotal =="")
																{
																	$RoundTotal ="0.00";
																}
																else
																{
																
																	$RoundTotal = $RoundTotal;
																	
																}
																$TotalRoundTotal += $RoundTotal;
												


												


											
															
																  $PackageNewPrice="";
															}
															unset($serviceamts);
															$toatlseramt="";
															 $PackageNewPrice="";
															
														}
					
													}
														
														?>
	
					
					<div class="row mailbox-wrapper">
                        <div class="col-md-4">
                            <div class="panel-layout">
                                <div class="panel-box">
                                    <div class="panel-content image-box">
                                        <div class="ribbon">
                                            <?=$strMembershipDisplay;?>
                                        </div>
                                        <div class="image-content font-white">
                                            <div class="meta-box meta-box-bottom"><img width="150" height='150' src="<?=$strkonami?>" alt="" class="meta-image img-bordered img-circle">
                                                <h3 class="meta-heading"><?=$strFirstName?> <?=$strLastName?></h3>
                                                <h4 class="meta-subheading"><?=$strEmail?></h4>
                                            </div>
                                        </div><img src="assets/image-resources/blurred-bg/blurred-bg-13.jpg" alt=""></div>
                                    <!--<div class="panel-content pad15A bg-white radius-bottom-all-4">
                                        <div class="mrg15T mrg15B"></div>
                                        <blockquote class="font-gray">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Last appointments feedback</small></blockquote>
                                    </div>-->
                                </div>
                            </div>
                            <div class="content-box mrg15B">
                                <h3 class="content-box-header clearfix">Payment Details</h3>
                                <div class="content-box-wrapper text-center clearfix">
                                    <div class="timeline-box timeline-box-right">
									
                                        <div class="tl-row">
                                            <div class="tl-item">
                                                <div class="tl-icon bg-yellow"><i class="glyph-icon icon-eyedropper"></i></div>
                                                <div class="popover left">
                                                    <div class="arrow"></div>
                                                    <div class="popover-content">
                                                        <div class="tl-label bs-label label-success">Outstanding Payment</div>
                                                        <p class="tl-content"><b>Rs. <?=$penout?> /-</b></p>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                      
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
					   <?php 
					   if($summm=="")
					   {
						  $summm=0; 
					   }
					    if($gPurchaseAmounttss=="")
					   {
						  $gPurchaseAmounttss=0; 
					   }
					    if($memammm=="")
					   {
						  $memammm=0; 
					   }
					    if($PackageNewPricedgf=="")
					   {
						  $PackageNewPricedgf=0; 
					   }
					   ?>
                        <div class="col-md-8">
                            <div class="content-box">
                                <div class="mail-header clearfix">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-lg" href="#">Sale <span class="bs-badge badge-azure">Rs <?=$summm?> /-</span><div class="ripple-wrapper"></div></a>
                                    </div>
									 <div class="btn-group">
                                        <a class="btn btn-default btn-lg" href="#">Gift <span class="bs-badge badge-azure">Rs <?=$gPurchaseAmounttss?> /-</span><div class="ripple-wrapper"></div></a>
                                    </div>
									 <div class="btn-group">
                                        <a class="btn btn-default btn-lg" href="#">Membership <span class="bs-badge badge-azure">Rs <?=$memammm?> /-</span><div class="ripple-wrapper"></div></a>
                                    </div>
									 <div class="btn-group">
                                        <a class="btn btn-default btn-lg" href="#">Package<span class="bs-badge badge-azure">Rs <?=$PackageNewPricedgf?> /-</span><div class="ripple-wrapper"></div></a>
                                    </div>
									
                                    <div class="float-right">
                                        <a class="btn btn-default btn-lg" href="#">Total Appointments <span class="bs-badge badge-info"><?=$cntapp?></span><div class="ripple-wrapper"></div></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="example-box-wrapper">
                                <ul class="list-group row list-group-icons">
                                    <li class="col-md-3 active"><a href="#tab-example-4" data-toggle="tab" class="list-group-item"><i class="glyph-icon font-red icon-bullhorn"></i> Personal Information</a></li>
                                    <li class="col-md-3"><a href="#tab-example-1" data-toggle="tab" class="list-group-item"><i class="glyph-icon icon-dashboard"></i> Complete History</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade" id="tab-example-1">
                                        <div class="row">
											<div class="content-box mrg15B">
												<h3 class="content-box-header clearfix">Service Details
													<div class="font-size-11 float-right"><a href="#" title=""><i class="glyph-icon mrg5R opacity-hover icon-plus"></i></a> <a href="#" title=""><i class="glyph-icon opacity-hover icon-cog"></i></a></div>
												</h3>
												<div class="content-box-wrapper text-center clearfix">
													<div class="timeline-box timeline-box-right">

														<?php 
																									$DB = Connect();

													for($i=0;$i<count($app);$i++)
													{
														$selptrtty=select("*","tblInvoiceDetails","AppointmentId='".$app[$i]."'");
														$InvoiceID=$selptrtty[0]['InvoiceId'];
														$ServiceAmount=$selptrtty[0]['ServiceAmt'];
														$ServiceName=$selptrtty[0]['ServiceName'];
														$serrname=explode(",",$ServiceName);
														$ServiceAmountss=explode(",",$ServiceAmount);
														$selptrttyADD=select("*","tblAppointments","AppointmentID='".$app[$i]."'");
														$AppointmentDate=$selptrttyADD[0]['AppointmentDate'];
													    $appaaa=FormatDateTime($AppointmentDate);
														//print_r($serrname);
													    $selptrttyEMP=select("distinct(MECID)","tblAppointmentAssignEmployee","AppointmentID='".$app[$i]."' group by AppointmentID");
														foreach($selptrttyEMP as $vap)
														{
															$emoo[]=$vap['MECID'];
														}  
													
														//$InvoiceID=$selptrtty[0]['InvoiceID'];
														?>
														<div class="tl-row">
															<div class="tl-item">
																<div class="tl-icon bg-yellow"><i class="glyph-icon icon-eyedropper"></i></div>
																<div class="popover left">
																	<div class="arrow"></div>
																	<div class="popover-content">
																		
																		<p class="tl-content">
																		<?php 
																		foreach($serrname as $ser)
																		{
																			$serroo=$ser;
																			$selptrttyNAME=select("*","tblServices","ServiceID='".$serroo."'");
														                    $ServiceNameddd=$selptrttyNAME[0]['ServiceName'];
																		?>
																		<b>Service Name : <?php echo $ServiceNameddd?><br/>
																		<?php
																		}
																		//unset($serrname);
																		?>
																		<br/>
																		<?php 
																	 foreach($ServiceAmountss as $sers)
																		{
																			
																		?>
																		<b>Service Amount : <?php echo $sers?><br/>
																		<?php
																		}
																	
																		?>
																		
																		<br/>
										                           <b>Date Of Service : <?php echo $appaaa?>
																		<br/>
																		<?php 
																	foreach($emoo as $empppaa)
																		{
																			$EMPPP=$empppaa;
																			$selptrttyNAMEss=select("*","tblEmployees","EID='".$EMPPP."'");
														                    $EmployeeName=$selptrttyNAMEss[0]['EmployeeName'];
																			
																		?>
																		<b>Technician : <?php echo  $EmployeeName?><br/>
																		<?php
																		}
																	
																		?>
																		<b>View Invoice : <a id="status" class="btn btn-link" target='blank' href="PendingInvoicesForDisplay.php?uid=<?=EncodeQ($app[$i]);?>"><?="#".$InvoiceID?></a>
																		</p>
																	
																	
																	</div>
																</div>
															</div>
														</div>
											
														<?php
													}
													unset($app);
													?>
													
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="tab-pane pad0A fade active in" id="tab-example-4">
                                        <div class="content-box">
										 <form  method="post" action="CustomerHistory.php" enctype="multipart/form-data" name="multi" class="enquiry_form form-horizontal pad15L pad15R bordered-row" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '','', '.file_upload'); return false;">
										 <span class="result_message">&nbsp; <br>
								             </span>
											 <input type="hidden" name="CustomerID" value="<?=$strCustomerID?>">
                                             <input type="hidden" id="step" name="step" value="edit">
                                                <div class="form-group remove-border"><label class="col-sm-3 control-label">First Name:</label>
                                                    <div class="col-sm-6"><input type="text" name="firstname" class="form-control" value="<?=$strFirstName?>" id="" placeholder="First name..."></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-3 control-label">Last Name:</label>
                                                    <div class="col-sm-6"><input type="text" name="lastname" value="<?=$strLastName?>" class="form-control" id="" placeholder="Last name..."></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-3 control-label">Email:</label>
                                                    <div class="col-sm-6"><input type="text" name="email" value="<?=$strEmail?>" class="form-control" id="" placeholder="Email address..."></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-3 control-label">Mobile:</label>
                                                    <div class="col-sm-6"><input readonly name="mobile" type="text" value="<?=$CustomerMobileNo?>" class="form-control" id="" placeholder="Mobile..."></div>
                                                </div>
												   <div class="form-group"><label class="col-sm-3 control-label">Acquisition:</label>
                                                    <div class="col-sm-6"><select name="Acquisition" class="form-control required">
																<option value="Leaflet" <?php if($Acquisition=="Leaflet") { ?> selected="selected" <?php } ?>>Leaflet</option>
																<option value="WordOfMouth" <?php if($Acquisition=="WordOfMouth") { ?> selected="selected" <?php } ?>>Word Of Mouth</option>	
																<option value="Reference" <?php if($Acquisition=="Reference") { ?> selected="selected" <?php } ?>>Reference</option>
																<option value="Facebook" <?php if($Acquisition=="Facebook") { ?> selected="selected" <?php } ?>>Facebook</option>
																<option value="Instagram" <?php if($Acquisition=="Instagram") { ?> selected="selected" <?php } ?>>Instagram</option>
																<option value="Website" <?php if($Acquisition=="Website") { ?> selected="selected" <?php } ?>>Website</option>
																<option value="PR" <?php if($Acquisition=="PR") { ?> selected="selected" <?php } ?>>PR</option>
																<option value="Voucher" <?php if($Acquisition=="Voucher") { ?> selected="selected" <?php } ?>>Voucher</option>
															</select></div>
                                                </div>
												   <div class="form-group"><label class="col-sm-3 control-label">Register Date:</label>
                                                    <div class="col-sm-6"><input readonly type="text" value="<?=$RegDates?>" class="form-control" id="" placeholder="Mobile..."></div>
                                                </div>
                                           
                                                <div class="form-group"><label class="col-sm-3 control-label">Profile Picture:</label>
												<?php
												if($ProfilePath!="")
												{
													?>
														<div class="col-sm-6">
														<img src="<?=$ProfilePath?>" alt="<?=$ProfilePath?>" width="100px" height="50px" /><br><br>
														<input class="file_upload" type="file" data-source="PrimaryImage" name="PrimaryImage" id="fileSelect">
														Click to change the Prfile image
														<hr width="100%" align="left">
													</div>
													<?php
													
												}
												else
												{
													?>
													    <div class="col-sm-6">
                                                      	<input class="file_upload required" type="file" data-source="PrimaryImage" name="PrimaryImage" id="fileSelect">
														<hr width="100%" align="left">
                                                    </div>
													<?php
												}
												?>
											
                                                
                                                </div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
                                            </form>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
<?php
} // End null condition
else
{

}
?>						
							
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>