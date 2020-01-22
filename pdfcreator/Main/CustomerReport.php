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
	return "localhost";
}
function Username()
{
	return "fyatedjh_nailspa";
}
function Password()
{
	return "q&#RrLdW,&i7";
}
function DBName()
{
	return "fyatedjh_nailspa";
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
	
	$filenamestamp = "Customers";

//-------------- Setting the conditions for report ends ------------------//




// Data control parameter
$Orientation = "L";
$Downloadfilename = 'CustomerReport'.date('Y-m-d').$filenamestamp.date('h:i:sa').'.pdf';
$logoimagefile = "tcpdf_logo.jpg";
$documentheading = "Customer Reports";
$documentdescription = "This is the report of customer with date filter from - ".$strFromDate." to - ".$strToDate;
$logowidth = "50";



// Database records

$HTMLContent = "";
$HTMLContent .= '<!DOCTYPE html>
						<html>
						<head>
						<style>
						table, th, td {
							border: 1px solid black;
						}
						</style>
						</head>
						<body>
						<small>
						<table style="width:100%">
						  <tr>
						    <th><b>Name</b></th>
						    <th><b>Email</b></th>
						    <th><b>Mobile</b></th>
							<th><b>Membership</b></th>
							<th><b>Gender</b></th>
							<th><b>Date</b></th>
						  </tr>';


$DB = Connect();
$sql = "SELECT CustomerID, CustomerFullName, CustomerEmailID, CustomerMobileNo, 
		(Select MembershipName from tblMembership where MembershipID=tblCustomers.memberid)as MembershipName, RegDate, Gender FROM tblCustomers $sqlTempfrom $sqlTempto";

			
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 1;
		while($row = $RS->fetch_assoc())
		{
			$counter = $counter + 1;
			
			$strCustomerID = $row["CustomerID"];
			$strCustomerFullName = $row["CustomerFullName"];
			$strCustomerEmailID = $row["CustomerEmailID"];
			$strCustomerMobileNo = $row["CustomerMobileNo"];
			$strMembershipName = $row["MembershipName"];
			$strRegistrationDate = FormatDateTime($row["RegDate"],"0");
			$strGender = $row["Gender"];
			
			if($strMembershipName =="NULL" || $strMembershipName =="null" || $strMembershipName =="")
			{
				$strMembershipName = "-";
			}
			else
			{
				$strMembershipName = $strMembershipName;
			}
			
			if($strGender =="0")
			{
				$strGender = "Male";
			}
			elseif($strGender =="1")
			{
				$strGender="Female";
			}
		
		$HTMLContent .= '<tr>
							<td>'.$strCustomerFullName.'</td>
							<td>'.$strCustomerEmailID.'</td>
							<td>'.$strCustomerMobileNo.'</td>
							<td>'.$strMembershipName.'</td>
							<td>'.$strGender.'</td>
							<td>'.$strRegistrationDate.'</td>
						  </tr>';
		
		}
	}
	else
	{
		$HTMLContent .= '<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>No Data Found</td>
							<td></td>
							<td></td>
						  </tr>';
	}			
				
$DB ->close();

$HTMLContent .= '</table>
				</small>
				</body>
				</html>';
				

				

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