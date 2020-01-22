<?php
	require_once 'setting.fya';
	$strStep = Filter($_POST["step"]);
	//$strStep = Filter($_POST["step"]);
	$strID = Decode(Filter($_POST["dataid"]));
	$strID1 = Decode(Filter($_POST["dataid1"]));
    $strID2 = Filter($_POST["dataid"]);
		//echo $strID1;
	if($strStep=="Step4")
	{
		$sqlDelete = "delete from tblAdminRoles where RoleID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step3")
	{
		$sqlDelete = "delete from tblAdmin where AdminID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step5")
	{
		$sqlDelete = "delete from tblAdminMenuMasters where MenuMasterID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step6")
	{
		$sqlDelete = "delete from tblProductStocks where ProductStockID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	if($strStep=="Step7")
	{
		$DB = Connect();
		$sql = "Select ImageURL FROM tblProductsImages where ProductID='".$strID."'";
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$Image = $row["ImageURL"];
				unlink($Image);
			}
		}
		$sqlDelete = "delete from tblProducts where ProductID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step8")
	{
		$sqlDelete = "delete from tblStores where StoreID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step9")
	{
		$DB = Connect();
		$SelectEMPCODE="Select EmployeeCode from tblEmployees where EID='".$strID."'";
		$RS1 = $DB->query($SelectEMPCODE);
		if ($RS1->num_rows > 0) 
		{
			while($row1 = $RS1->fetch_assoc())
			{
				$EmployeeCode = $row1["EmployeeCode"];
				echo $EmployeeCode."<br>";
			}
		}		
		$sql = "Select ImagePath FROM tblEmployeesImages where EID='".$strID."'";
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$Image = $row["ImagePath"];
				unlink($Image);
			}
		}
		
		$sqlDelete1 = "delete from tblEmployeesImages where EID='".$strID."'";
		ExecuteNQ($sqlDelete1);
		$sqlDelete = "delete from tblEmployees where EID='".$strID."'";
		ExecuteNQ($sqlDelete);
		$sqlDeletetarget="delete from tblEmployeeTarget where EmployeeCode='$EmployeeCode'";
		echo $sqlDeletetarget."<br>";
		ExecuteNQ($sqlDeletetarget);
		
		
	}
	else if($strStep=="Step10")
	{
		$sqlDelete = "delete from tblStoreSalesTarget where STID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step11")
	{
		// $asmitaquery="Select distinct ServiceCode from tblInvoiceDetails";
		// echo $asmitaquery;
		// $RS = $DB->query($asmitaquery);
		// if ($RS->num_rows > 0) 
		// {
			// echo "Hello";
			// while($row = $RS->fetch_assoc())
			// {
				// $strServiceCode = $row["ServiceCode"];
				
			// }
		// }
		// echo $strServiceCode;
		// die();
		
		$sqlDelete = "DELETE FROM tblServices WHERE ServiceCode='".$strID2."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step12")
	{
		$sqlDelete = "DELETE FROM tblChargeNames WHERE ChargeNameID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step13")
	{
		$sqlDelete = "DELETE FROM tblChargeSets WHERE ChargeSetID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step14")
	{
		$sqlDelete = "DELETE FROM tblOperationsMasters WHERE OMID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step15")
	{
		$sqlDelete = "DELETE FROM tblPages WHERE PageID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step16")
	{
		$sqlDelete = "DELETE FROM tblMenuMaster WHERE MenuID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step17")
	{
		$sqlDelete = "DELETE FROM tblSocial WHERE SocialID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step18")
	{
		$sqlDelete = "DELETE FROM tblCategories WHERE CategoryID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step19")
	{
		$sqlDelete = "DELETE FROM tblWidgetMasters WHERE WidgetMasterID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step20")
	{
		$sqlDelete = "DELETE FROM tblCustomers WHERE CustomerID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step21")
	{
		$sqlDelete = "DELETE FROM tblMembership WHERE MembershipID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step22")
	{
		$sqlDelete = "DELETE FROM  tblAdminMenuRole WHERE RoleID='".$strID."' and MenuMasterID='".$strID1."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step23")
	{
		$sqlDelete = "DELETE FROM  tblAdminMenuRole WHERE RoleID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step24")
	{
		$sqlDelete = "DELETE FROM  tblOffers WHERE OfferID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	if($strStep=="Step25")
	{
		$DB = Connect();
		$sql = "Select SliderImgURL FROM tblSlider where SliderID='".$strID."'";
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$Image = $row["SliderImgURL"];
				unlink($Image);
			}
		}
		$sqlDelete = "delete from tblSlider where SliderID='".$strID."'";
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step26")
	{
		$sqlDelete = "DELETE FROM  events WHERE id='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	else if($strStep=="Step27")
	{
		$sqlDelete = "DELETE FROM  tblProductBrand WHERE BrandID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	if($strStep=="Step28")
	{
		$DB = Connect();
		$sql = "Select ImagePath FROM tblImages where ImageID='".$strID."'";
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$Image = $row["ImagePath"];
				unlink($Image);
			}
		}
		$sqlDelete = "delete from tblImages where ImageID='".$strID."'";
		ExecuteNQ($sqlDelete);
		
	}
	else if($strStep=="Step29")
	{
		$sqlDelete = "DELETE FROM tblNewProductStocks WHERE ProductID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
		
		$sqlDelete1 = "DELETE FROM tblNewProducts WHERE ProductID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete1);
		
		$sqlDelete2 = "DELETE FROM tblNewProductCategory WHERE ProductID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete2);
		
	}
	elseif($strStep=="Step30")
	{
		$sqlDelete = "DELETE FROM tblNewProductStocks WHERE ProductStockID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	elseif($strStep=="Step31")
	{
		$sqlDelete = "DELETE FROM tblBlogs WHERE BlogID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	elseif($strStep=="Step32")
	{
		$sqlDelete = "DELETE FROM tblFinalOrder WHERE ID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	elseif($strStep=="Step33")
	{
		$sqlDelete = "DELETE FROM tblSMSApproval WHERE SMSApprovalID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	elseif($strStep=="Step34")
	{
		$sqlDelete = "DELETE FROM tblPackages WHERE Code='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	elseif($strStep=="Step35")
	{
		$sqlDelete = "DELETE FROM  tblEmployeeWeekOff WHERE EmployeeWeekOffID='".$strID."'";
		//echo $sqlDelete;
		ExecuteNQ($sqlDelete);
	}
	
?>