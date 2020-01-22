<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';

$filename = "uploads/".$_POST["excelfile"];
$update_current = $_POST["update_current"];


if (!file_exists($filename)) {
	exit("<font color='red'>File not uploaded properly. Please re-try</font>" . EOL);
}

$DB = Connect();

function Excel_Date_Converter($strExcel_Date)
{
	$UNIX_DATE = ($strExcel_Date - 25569) * 86400;
	return $UNIX_DATE;
}

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($filename);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
{
	if($worksheet->getTitle()=="Sheet1")
	{
		foreach ($worksheet->getRowIterator() as $row) 
		{
			if($row->getRowIndex()!=1)
			{
				$CustomerID = "";

				$CustomerFirstName = "";
				$CustomerSecondName = "";
				$CustomerEmailID = "";
				$CustomerMobileNo = "";
				$Status = "";
				$Gender = "";
				$Membership = "";
				$TotalVisits = "";
				$LastVisit = "";
				$strRegistrationDate = "";
				$strMembershipStartDate = "";
				$strMembershipEndDate = "";
				$strMembershipCode = "";
				
				$CustomerFirstName = GetContents($row, $worksheet, "A");
				if(!IsNull($CustomerFirstName))
				{
					$CustomerFirstName = GetContents($row, $worksheet, "A");
					$CustomerSecondName = GetContents($row, $worksheet, "B");
					$CustomerEmailID = GetContents($row, $worksheet, "C");
					$CustomerMobileNo = GetContents($row, $worksheet, "D");
					$Status = GetContents($row, $worksheet, "E");
					$Gender = GetContents($row, $worksheet, "F");
					$Membership = GetContents($row, $worksheet, "G");
					$TotalVisits = GetContents($row, $worksheet, "H");
					$LastVisit = GetContents($row, $worksheet, "I");
					$strRegistrationDate = GetContents($row, $worksheet, "J");
					$strMembershipStartDate = GetContents($row, $worksheet, "K");
					$strMembershipEndDate = GetContents($row, $worksheet, "L");
					$strMembershipCode = GetContents($row, $worksheet, "M");
					
					$CustomerFullName=$CustomerFirstName." ".$CustomerSecondName;
				 
					$strRegistrationDate = Excel_Date_Converter($strRegistrationDate);
					$strMembershipStartDate = Excel_Date_Converter($strMembershipStartDate);
					$strMembershipEndDate= Excel_Date_Converter($strMembershipEndDate);
					$LastVisit = Excel_Date_Converter($LastVisit);
				
				
					$seldata=select("CustomerID","tblCustomers","CustomerMobileNo='".$CustomerMobileNo."'");
					if($seldata[0]['CustomerID']!='')
					{
						echo('<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Record Already Exist for '.$CustomerFullName.' - '.$CustomerMobileNo.'</strong>
							</div>');
					}
					else
					{
						if(trim($Membership)==1 || trim($Membership)==2)
						{
							$strFlag = "1";
						}
						else
						{
							$strFlag = "";
						}
						
						$sql = "Insert into tblCustomers (FirstName,LastName,CustomerFullName,CustomerEmailID,CustomerMobileNo,
								Status,Gender,memberid,MembershipDateTime,TotalVisits,LastVisit,RegDate,memberflag) 
								Values ('$CustomerFirstName','$CustomerSecondName','$CustomerFullName', '$CustomerEmailID', 
								'$CustomerMobileNo','$Status','$Gender','$Membership','$strMembershipStartDate','$TotalVisits',FROM_UNIXTIME('$LastVisit'),FROM_UNIXTIME('$strRegistrationDate'),'$strFlag')";
						
						if ($DB->query($sql) === TRUE) 
						{
							$last_id = $DB->insert_id;	
							
							if(trim($Membership)==1 || trim($Membership)==2)
							{	
								$sql1 = "Insert into tblCustomerMemberShip 
								(CustomerID,MembershipID,StartDay,EndDay,Comment,Status,MembershipCode) 
								Values ('$last_id','$Membership',FROM_UNIXTIME('$strMembershipStartDate'),FROM_UNIXTIME('$strMembershipEndDate'), 
								'initial state','0','$strMembershipCode')";
								ExecuteNQ($sql1);
								//echo $sql1;									
							}
							else
							{
								
															
							}
						}
						else
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
								
						
						echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<strong>Saved successfully</strong>
						</div>');
					}
			
				}
				else
				{
					echo('<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<strong>First Name missing </strong>
					</div>');
				}

				
		
						
			}
			else
			{
									
			}	
					
		}
	}
	else
	{
		echo('<div class="alert alert-danger alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<strong>Worksheet does not have sheet 1</strong>
			</div>');
	}	
}	

$DB->close();
// unlink($filename);

echo('<a href="ManageCustomers.php" class="btn btn-default btn-lg">Go back to Manage Customers<a>');	

function GetContents($row, $worksheet, $colindex)
{
	$cellIterator = $row->getCellIterator();
	$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
	$cell = $worksheet->getCell($colindex.$row->getRowIndex());
	$value = $cell->getCalculatedValue();
	return $value;
}
