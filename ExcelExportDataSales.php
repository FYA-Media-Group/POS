<?php


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





/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Saif Usmani")
							 ->setLastModifiedBy("Saif Usmani")
							 ->setTitle("Office 2007 XLSX Sales Report Document")
							 ->setSubject("Office 2007 XLSX Sales Report Document")
							 ->setDescription("Sales Report document for Office 2007 XLSX, generated using PHP.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Sales Report result file");






// Colour work Starts
		 
$objRichText2 = new PHPExcel_RichText();
$objRed = $objRichText2->createTextRun("Service Code");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );
		 
$objRichText3 = new PHPExcel_RichText();
$objRed = $objRichText3->createTextRun("Service Name");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );

$objRichText4 = new PHPExcel_RichText();
$objRed = $objRichText4->createTextRun("Cost");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );
		 
$objRichText5 = new PHPExcel_RichText();
$objRed = $objRichText5->createTextRun("# Sold");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );
	 
$objRichText6 = new PHPExcel_RichText();
$objRed = $objRichText6->createTextRun("Gross Rs");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );

$objRichText7 = new PHPExcel_RichText();
$objRed = $objRichText7->createTextRun("# Discount");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );

$objRichText8 = new PHPExcel_RichText();
$objRed = $objRichText8->createTextRun("Offer Disount Rs");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );

$objRichText9 = new PHPExcel_RichText();
$objRed = $objRichText9->createTextRun("Membership Disount Rs");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );

$objRichText10 = new PHPExcel_RichText();
$objRed = $objRichText10->createTextRun("Net Rs");
$objRed->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED  ) );
// Colour work Ends





// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', $objRichText2)
            ->setCellValue('B1', $objRichText3)
            ->setCellValue('C1', $objRichText4)
            ->setCellValue('D1', $objRichText5)
            ->setCellValue('E1', $objRichText6)
			->setCellValue('F1', $objRichText7)
			->setCellValue('G1', $objRichText8)
			->setCellValue('H1', $objRichText9)
			->setCellValue('I1', $objRichText10);




$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6);





// Create connection And Write Values
$DB = Connect();
$sql = "SELECT CustomerID, CustomerFullName, CustomerEmailID, CustomerMobileNo, 
		(Select MembershipName from tblMembership where MembershipID=tblCustomers.memberid)as MembershipName, RegDate, Gender FROM tblCustomers $sqlTempfrom $sqlTempto";

			
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		
		$counter = 1;
		$counter2 = 0;
		while($row = $RS->fetch_assoc())
		{
			$counter = $counter + 1;
			$counter2 = $counter2 + 1;
			
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
			
						
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$counter, $counter2)
            ->setCellValue('B'.$counter, $strCustomerFullName)
			->setCellValue('C'.$counter, $strCustomerEmailID)
			->setCellValue('D'.$counter, $strCustomerMobileNo)
			->setCellValue('E'.$counter, $strMembershipName)
			->setCellValue('F'.$counter, $strGender)
            ->setCellValue('G'.$counter, $strRegistrationDate);

			
			
		}
	}
	else 
	{

	
    		$objPHPExcel->setActiveSheetIndex(0)
            
            ->setCellValue('G2', 'No Data Found');



	}	
$DB ->close();	


$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('ReportsofCustomer');  // sheet name


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="CustomerReport'.date('Y-m-d').$filenamestamp.date('h:i:sa').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;

?>