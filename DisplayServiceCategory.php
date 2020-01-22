<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
?>
<?php
		$DB = Connect(); 
        $sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
	
	     $sqlp="delete from tblCronServiceCategoryBase where StoreID!='0' and CategoryID!='0'";
		 ExecuteNQ($sqlp);
		$stppstore=select("*","tblStores","Status='0'");
		foreach($stppstore as $vqapp)
		{
			$storrd=$vqapp['StoreID'];
			$storrdname=$vqapp['StoreName'];
			
			
			
			$sumqttytc=0;
			$sumServiceAmountac=0;
			$set=selectcategory($storrd,$First,$ToDate);
			foreach($set as $tes)
			{
				$CATTUp[]=$tes['CategoryID'];
			}
			for($q=0;$q<count($CATTUp);$q++)
		   {
			   $stppsertyptop=selectservice($storrd,$First,$ToDate,$CATTUp[$q]);
			   foreach($stppsertyptop as $catq)
								{
									//$serrtp[]=$catq['ServiceID'];
									$ServiceIDtq=$catq['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqw=selectservicedetail($storrd,$First,$ToDate,$ServiceIDtq);
								
										foreach($stppsertyptupqw as $trty)
										{
											$qty=$trty['qty'];
											$ServiceAmount=$trty['ServiceAmount'];
											$sumqttytc +=$qty;
											$strServiceAmountr = $ServiceAmount*$qty;
											$sumServiceAmountac=$sumServiceAmountac+$strServiceAmountr;
										}
								}
								
			   
		   }
		
		
		$set=selectcategory($storrd,$First,$ToDate);
		foreach($set as $tes)
		{
			$CATTU[]=$tes['CategoryID'];
		}
		
		for($q=0;$q<count($CATTU);$q++)
		{
			
		
							$counter = 0;
							$totaltpcostT=0;
							$qttyt=0;
							$qttyt="";
							$totalstrServiceAmount="";
							$totaltpcostT="";
							$totalstrprofitT="";
							$totalARPU=0;
							$totalstrServiceAmount=0;
							$totaltpcost=0;
							$totalstrprofit=0;
							
?>
        
								<tbody>
<?php
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storrd,$First,$ToDate,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					            /* foreach($stppsertypt as $cat)
								{
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupamt=servicedetailssumamt($storrd,$getfrom,$getto,$ServiceIDt);
									$sumamt=$stppsertyptupamt[0]['sumamt'];
									 $stppsertyptupqty=servicedetailssumqty($storrd,$getfrom,$getto,$ServiceIDt);
									$sumqty =$stppsertyptupqty[0]['sumqty '];
								}
								 */
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storrd,$First,$ToDate,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storrd."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
										}
									
								}  
							//	print_r($ProductID);
								foreach($ProductIDtP as $valtP)
									{
										
											$sqldata3 = "SELECT * FROM tblNewProducts WHERE ProductID='".$valtP."'";
										
											$RSdiscountt = $DB->query($sqldata3);
										
											if ($RSdiscountt->num_rows > 0) 
											{
												while($rowdiscounttt = $RSdiscountt->fetch_assoc())
												{
													
													$ProductMRPst = $rowdiscounttt["ProductMRP"];
													$PerQtyServest = $rowdiscounttt["PerQtyServe"];
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
												}
											}
											else
											{
												$product_costt="0";
											}
									
										
										
									}
									unset($ProductIDtP);
									unset($ServiceIDt);	
									$product_costt="";
									
									if($ARPU=='')
										{
											$ARPU=0;
										}
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
											
									  if($totalstrServiceAmount=='')
									  {
										  $totalstrServiceAmount=0;
									  }
									  if($qttyt=="")
									  {
										  $qttyt=0;
									  }
									  if($totalstrServiceAmount=="")
									 {
										$totalstrServiceAmount=0;
										
									 }
									 else
									 {
										 $totalstrServiceAmount=$totalstrServiceAmount;
									 }
									 $totalstrServiceAmountT=$totalstrServiceAmountT+$totalstrServiceAmount;
									  if($qttyt=="")
									 {
										$qttyt=0;
										
									 }
									 else
									 {
										 $qttyt=$qttyt;
									 }
									 
									 $totalstrqty=$totalstrqty+$qttyt;
									 
									  
									 $totaltpcosttM=$totaltpcosttM+$totaltpcostT;
									  if($strprofit=="")
									 {
										$strprofit=0;
										
									 }
									 else
									 {
										 $strprofit=$strprofit;
									 }
									 $totalstrprofitT=$totalstrprofitT+$strprofit;
									 $totalstrprofittM=$totalstrprofittM+$totalstrprofitT;
									 if($ARPU=="")
									 {
										 $ARPU=0;
									 }
									 else
									 {
										  $ARPU=$ARPU;
									 }
									 $totalARPU=$totalARPU+$ARPU;
									  $totalARPUt=$totalARPUt+$totalARPU;
									  
									  $seramtper=($totalstrServiceAmount/$sumServiceAmountac)*100;
									  $qtyper=($qttyt/$sumqttytc)*100;
									  $totalsamt +=$seramtper;
									  $totalsqty +=$qtyper;
									 
								
											 $sqlInsert2 = "Insert into tblCronServiceCategoryBase(StoreName,StoreID, CategoryID, CategoryName,AmountPercentage) values
										('".$storrdname."','".$storrd."','".$CATTU[$q]."','".$CategoryName."','".$seramtper."')";
									    ExecuteNQ($sqlInsert2);
									
									
		}
		unset($CATTU);
		}
		echo 1;
	//header('Location:http://pos.nailspaexperience.com/admin/Dashboard.php');
	//echo "<script type='text/javascript'> document.location = 'http://pos.nailspaexperience.com/admin/Dashboard.php'; </script>";
		?>