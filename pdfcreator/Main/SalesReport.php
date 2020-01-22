<?php
//get data
//-------------- Functions used on this page starts ------------------//

function Filter($data) 
{
	// Every thing from form or query string must come through this function
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function IsNull($Value)
{
	if($Value=="" || $Value==null)
	{
		return true;
	}
	else
	{
		return false;
	}

}

function FormatDateTime($param_date, $paramname)
{
	$date=date_create($param_date);
	if($paramname=="1")
	{
		return date_format($date,"jS M Y H:i:s");
	}
	else
	{
		return date_format($date,"jS M Y");
	}
}


function ServerName()
{
	return "43.225.52.142";
}
function Username()
{
	return "nailspae_saiffya";
}
function Password()
{
	return "saif@123";
}
function DBName()
{
	return "nailspae_dbpos";
}


function Connect()
{
	$servername = ServerName();
	$username = Username();
	$password = Password();
	$dbname = DBName();

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if (mysqli_connect_error()) 
	{
	    die('Connect Error (' . mysqli_connect_errno() . ') '
	            . mysqli_connect_error());
	}
	return $conn;
}


//-------------- Functions used on this page ends ------------------//




//-------------- Setting the conditions for report starts ------------------//


$strFromDate = Filter($_GET["from"]);
$strToDate = Filter($_GET["to"]);


//Date Conditions

	if(!IsNull($strFromDate))
	{
		$sqlTempfrom = " where Date(RegDate)>=Date('".$strFromDate."')";	
	}
	else
	{
		$sqlTempfrom = "";
	}

	if(!IsNull($strToDate))
	{
		$sqlTempto = " and Date(RegDate)<=Date('".$strToDate."')";
	}
	else
	{
		$sqlTempto = "";
	}
	
	$filenamestamp = "Sales";

//-------------- Setting the conditions for report ends ------------------//




// Data control parameter
$Orientation = "L";
$Downloadfilename = 'SalesReport'.date('Y-m-d').$filenamestamp.date('h:i:sa').'.pdf';
$logoimagefile = "tcpdf_logo.jpg";
$documentheading = "Sales Reports";
$documentdescription = "This is the report of Sales with date filter from - ".$strFromDate." to - ".$strToDate;
$logowidth = "50";


$HTMLContent = "";
$DB = Connect();
$sql = "SELECT * from tblCategories where Status='0'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCategoryID = $row["CategoryID"];
		$strCategoryName = $row["CategoryName"];
		$HTMLContent .= '<small>
						<h3><font color="Red">'.$strCategoryName.'</font></h3>
							
								<style>
								table, th, td {
									border: 1px solid black;
								}
								</style>
								<table>
									<thead>
										<tr>
											<th>Code</th>
											<th>Service Name</th>
											<th class="numeric">Cost</th>
											<th class="numeric"># Sold</th>
											<th class="numeric">Gross Rs</th>
											<th class="numeric"># Discount</th>
											<th class="numeric">O Dis Rs</th>
											<th class="numeric">M Dis Rs</th>
											<th class="numeric">Net Rs</th>
										</tr>
									</thead>';


		$sqlservice = "SELECT tblProductsServices.CategoryID, tblProductsServices.ServiceID , tblServices.ServiceName, tblServices.ServiceCost, tblServices.ServiceCode
					FROM `tblProductsServices` left join tblServices 
					on tblProductsServices.ServiceID=tblServices.ServiceID
					where tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL' 
					group by tblProductsServices.ServiceID order by tblProductsServices.ProductServiceID desc ";
		//echo $sqlservice ;
		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$strqty = "";
				$strServiceAmount = "";	
				$strOfferAmount = "";
				$strMembershipAmount = "";
				$strServiceNet2 = "";
				$strServiceNet = "";
				
				$counterservice ++;
				$strCategoryID = $rowservice["CategoryID"];
				$strServiceID = $rowservice["ServiceID"];
				$strServiceName = $rowservice["ServiceName"];
				$strServiceCost = $rowservice["ServiceCost"];
				$strServiceCode = $rowservice["ServiceCode"];
				
					$sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentID 
								WHERE tblAppointmentsDetailsInvoice.ServiceID ='$strServiceID' $sqlTempfrom $sqlTempto";
					//echo $sqldata;
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							$strAppointmentID = $rowdata["AppointmentID"];
							$strqty += $rowdata["qty"];
							$strServiceAmount += $rowdata["ServiceAmount"];
						}
					}
					else
					{
						$strqty = "0";
						$strServiceAmount = "0";
					}
					
					$sqldiscount = "SELECT tblAppointmentMembershipDiscount.OfferAmount, tblAppointmentMembershipDiscount.MembershipAmount 
									FROM tblAppointmentMembershipDiscount
									left join tblInvoiceDetails 
									on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails.AppointmentID 
									WHERE tblAppointmentMembershipDiscount.ServiceID ='$strServiceID' $sqlTempfrom $sqlTempto";
					//echo $sqldiscount;
					$RSdiscount = $DB->query($sqldiscount);
					$counterDiscountUsage = "0";
					if ($RSdiscount->num_rows > 0) 
					{
						while($rowdiscount = $RSdiscount->fetch_assoc())
						{
							$counterDiscountUsage = $counterDiscountUsage + 1;
							$strOfferAmount += $rowdiscount["OfferAmount"];
							$strMembershipAmount += $rowdiscount["MembershipAmount"];
						}
					}
					else
					{
						$strOfferAmount = "0";
						$strMembershipAmount = "0";
					}
					
					$strServiceNet = ($strServiceAmount) - ($strMembershipAmount);
					$strServiceNet2 = ($strServiceNet) - ($strOfferAmount);

					
				$HTMLContent .= '<tbody>
								<tr>
									<td>'.$strServiceCode.'</td>
									<td>'.$strServiceName.'</td>
									<td class="numeric">Rs '.$strServiceCost.'</td>
									<td class="numeric">'.$strqty.'</td>
									<td class="numeric">Rs '.$strServiceAmount.'</td>
									<td class="numeric">'.$counterDiscountUsage.'</td>
									<td class="numeric">Rs '.$strOfferAmount.'</td>
									<td class="numeric">Rs '.$strMembershipAmount.'</td>
									<td class="numeric">Rs '.$strServiceNet2.'</td>
								</tr>
							</tbody>';	
			}
		}
		else
		{
				$HTMLContent .= '<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>No Data Found</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>';
		}	
			$HTMLContent .= '</table>

		</small>';
	}
}
else
{
	$HTMLContent .="Opps! No category found according to selected search parameter...";
}
$DB->close();


				

require_once('tcpdf_include.php');
require_once('incdatacontent.php');

$pdf->SetFont('times', '', 15);

$pdf->AddPage();

$html = <<<EOD
$HTMLContent
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '6', '', $html, 0, 1, 0, true, '', true);

// use D instead if I to save as output
$pdf->Output($Downloadfilename, 'D');

?>