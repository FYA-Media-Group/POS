<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
//echo 1;
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';

$filename = "uploads/".$_POST["excelfile"];
$update_current = $_POST["update_current"];
$GroupCount="0";
$SubGroupCount="0";
$BrandCode = "";
$BrandName = "";
$BrandDescription = "";
$Group = "";
$SubGroup = "";
$Floor = "";
$StoreContact = "";
$StoreTimings = "";
$SearchTags = "";
$OfferStartDate = "";
$OfferEndDate = "";
$OfferContent = "";
$FacebookURL = "";
$LinkedinURL = "";
$TwitterURL = "";
$GooglePlusURL = "";
$Status = "";

$AlsoLikeShopping = "";
$AlsoLikeDining = "";
$AlsoLikeEntertainment = "";
$serviceName="";
$comission="";
$MRPLessTax="";
$cost="";
$comission="";
$cost="";

$GMPercentage="";
$DirectCost="";
$GrossMargin="";
$Status="";
$strImageUploadPath1="";
$last_id="";
$Technicians="";
$Products="";
$StoreID="";
if (!file_exists($filename)) {
	exit("<font color='red'>File not uploaded properly. Please re-try</font>" . EOL);
}

$DB = Connect();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($filename);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	if($worksheet->getTitle()=="Sheet1")
	{
		foreach ($worksheet->getRowIterator() as $row) 
		{
			if($row->getRowIndex()!=1)
			{
				$ProductID = "";
				$servicecode = GetContents($row, $worksheet, "A");
				if(!IsNull($servicecode))
				{
					 $servicecode = GetContents($row, $worksheet, "A");
					 $serviceName = GetContents($row, $worksheet, "B");
					 $cost = GetContents($row, $worksheet, "C");
					 //$comission = GetContents($row, $worksheet, "D");
				    //$MRPLessTax = GetContents($row, $worksheet, "E");
					// $DirectCost = GetContents($row, $worksheet, "F");
					// $GMPercentage = GetContents($row, $worksheet, "G");
					 $GrossMargin = GetContents($row, $worksheet, "D");
					 $Status = GetContents($row, $worksheet, "E");
					 $Technicians = GetContents($row, $worksheet, "F");
					 $Products = GetContents($row, $worksheet, "G");
					 $Charges = GetContents($row, $worksheet, "H");
					 $ImagePath = GetContents($row, $worksheet, "I");
					 $StoreID = GetContents($row, $worksheet, "J");
					 $Priority = GetContents($row, $worksheet, "K");
					 $IsPrimary = GetContents($row, $worksheet, "L");
					
				/* 	$filepath = 'imageupload/images';
				CreateFolder($filepath);
				
				$strValidateImage1 = trim(ValidateImageFile2($_FILES, "ImagePath", UniqueStamp()."0".$ImagePath, $filepath));
				if($strValidateImage1=="Saved successfully")
				{
					// for First Image
					$filename1 = $_FILES["ImagePath"]["name"];
					
					$uploadFilename1 = UniqueStamp()."0".$filename1;		
					$strImageUploadPath1 = $filepath."/".$uploadFilename1;
					// #######################
				}
				else
				{
					die($strValidateImage1);
				}
					 */		
					/*  $filepath = 'imageupload/images';
				CreateFolder($filepath);
	$strValidateImage1 = trim(ValidateImageFile2($ImagePath, "ImagePath", UniqueStamp()."0".$_FILES["ImagePath"]["name"], $filepath));
				if($strValidateImage1=="Saved successfully")
				{
					// for First Image
					$filename1 = $_FILES["ImagePath"]["name"];
					
					$uploadFilename1 = UniqueStamp()."0".$filename1;		
					$strImageUploadPath1 = $filepath."/".$uploadFilename1;
					// #######################
				}
				else
				{
					die($strValidateImage1);
				}					 
					 */
					
				}
				else
				{
					
				}

				
				
				
			
				
				if($update_current=="Y")
				{
					$sqlQuery = "Select ServiceID from tblServices where ServiceCode='".$servicecode."'";
					$RS = $DB->query($sqlQuery);
					if ($RS->num_rows > 0) 
					{

					}
					else
					{
						$sql = "Delete from tblServices where ServiceCode='$servicecode'";
						ExecuteNQ($sql);
					
					}
					
					
				} 
				
				// Step 1 : Check if groups and subgroups exist in masters
				
			
					
					
					//echo $servicecode;
						$sqlQuery = "Select ServiceID from tblServices where ServiceCode='".$servicecode."'";
						//echo $sqlQuery;
						$RS = $DB->query($sqlQuery);
						if ($RS->num_rows > 0) 
						{
							//echo 567;
							while($row = $RS->fetch_assoc())
							{
								//echo $row["ProductID"];
								$service_id = $row["ServiceID"];
							}
							if($update_current=="Y")
							{
								//echo 12454;
								
								$seddataP=select("StoreID","tblStores","StoreName='$StoreID'");
							$store=$seddataP[0]['StoreID'];
							
								$sql = "Update tblServices set ServiceName='$serviceName', ServiceCode='$servicecode', ServiceCost='$cost', 
									,GrossMargin='$GrossMargin',Status='$Status',StoreID='$store' where ServiceID='$service_id'";
									//echo $sql;
								ExecuteNQ($sql);
								
	
							
								$seddatap=select("ChargeNameID","tblChargeNames","ChargeName='$Charges'");
							$chargeid=$seddatap[0]['ChargeNameID'];
								$sql1 = "Update tblServicesCharges set ChargeNameID='$chargeid', Status='$Status' where ServiceID='$service_id'";
									//echo $sql;
								ExecuteNQ($sql1);
								
								
								
								$seddata=select("EID","tblEmployees","EmployeeName='$Technicians'");
							$eid=$seddata[0]['EID'];
							
								$sql2 = "Update tblEmployeesServices set EID='$eid' ,Status='$Status' where ServiceID='$service_id'";
									//echo $sql;
								ExecuteNQ($sql2);
								
								
								$seddataq=select("ProductID","tblProducts","ProductName='$Products'");
							$productid=$seddataq[0]['ProductID'];
							
							$sql4 = "Update tblProductsServices set ProductID='$productid', Status='$Status' where ServiceID='$service_id'";
									//echo $sql;
								ExecuteNQ($sql4);
							
					
			
				
				$sql5 = "Update tblServicesImages set ImagePath='$ImagePath', Priority='1',IsPrimary='1',Status='$Status' where ServiceID='$service_id'";
									//echo $sql;
								ExecuteNQ($sql5);
								
									
							}
							if(IsNull($service_id))
						{
							echo('<div class="alert alert-danger alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Entry of'. '$ProductUniqueCode' .'ignored.</strong>
								</div>');
						}
						}
						else
						{
						//echo 134;
						//echo $StoreID;
						$seddataP=select("StoreID","tblStores","StoreName='$StoreID'");
							$store=$seddataP[0]['StoreID'];
							$sql = "Insert into tblServices (ServiceName,ServiceCode,ServiceCost, GrossMargin,Status,StoreID) Values ( '$serviceName', '$servicecode', '$cost','$GrossMargin','$Status','$store')";
						//	echo $sql;
							$DB->query($sql);
						//	ExecuteNQ($sql);
								$seddatapp=select("ServiceID","tblServices","ServiceCode='$servicecode'");
							$last_id=$seddatapp[0]['ServiceID'];
							
								$seddatap=select("ChargeNameID","tblChargeNames","ChargeName='$Charges'");
							$chargeid=$seddatap[0]['ChargeNameID'];
							$sqlInsert1 = "Insert into tblServicesCharges (ServiceID, ChargeNameID, Status) values
							('".$last_id."', '".$chargeid."','".$Status."')";
							// echo $sqlInsert1;
							$DB->query($sqlInsert1);
							$seddata=select("EID","tblEmployees","EmployeeName='$Technicians'");
							$eid=$seddata[0]['EID'];
							$sqlInsert2 = "Insert into tblEmployeesServices (EID, ServiceID, Status) values('".$eid."', '".$last_id."','".$Status."')";
							    	$DB->query($sqlInsert2);
							$seddataq=select("ProductID","tblProducts","ProductName='$Products'");
							$productid=$seddataq[0]['ProductID'];
							$sqlInsert3 = "Insert into tblProductsServices (ProductID, ServiceID, Status) values
					('".$productid."', '".$last_id."','".$Status."')";
					// echo $sqlInsert2;
					 // echo "Hello";
					$DB->query($sqlInsert3);
					// echo $sqlInsert1;
				 
					$sql1 = "INSERT INTO tblServicesImages (ImagePath, ServiceID, Priority, IsPrimary, Status) VALUES ('$ImagePath','$last_id', '1', '1', '0')";
				// echo $sql1;
				$DB->query($sql1);
				//ExecuteNQ($sql1);
				//exit;
						}
						
						
						
						
					
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
echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Saved successfully</strong>
	</div>');
echo('<a href="ManageProductDetailsStoreWise.php" class="btn btn-round btn-default btn-lg"><a>');	

function GetContents($row, $worksheet, $colindex)
{
	$cellIterator = $row->getCellIterator();
	$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
	$cell = $worksheet->getCell($colindex.$row->getRowIndex());
	$value = $cell->getCalculatedValue();
	return $value;
}
