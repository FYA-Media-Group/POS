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
				$ProductUniqueCode = GetContents($row, $worksheet, "A");
				if(!IsNull($ProductUniqueCode))
				{
					$ProductUniqueCode = GetContents($row, $worksheet, "A");
					$ProductName = GetContents($row, $worksheet, "B");
					$ProductDescription = GetContents($row, $worksheet, "C");
					$Status = GetContents($row, $worksheet, "D");
					$StoreID = GetContents($row, $worksheet, "E");
					
				}
				else
				{
					
				}

				
				
				
			
				
				if($update_current=="Y")
				{
					$sqlQuery = "Select ProductID from tblProducts where ProductUniqueCode='$ProductUniqueCode'";
					$RS = $DB->query($sqlQuery);
					if ($RS->num_rows > 0) 
					{

					}
					else
					{
						$sql = "Delete from tblProducts where ProductUniqueCode='$ProductUniqueCode'";
						ExecuteNQ($sql);
					
					}
					
					
				}
				
				// Step 1 : Check if groups and subgroups exist in masters
				
			
					
					
					
						$sqlQuery = "Select ProductID from tblProducts where ProductUniqueCode='$ProductUniqueCode'";
						//echo $sqlQuery;
						$RS = $DB->query($sqlQuery);
						if ($RS->num_rows > 0) 
						{
							//echo 567;
							while($row = $RS->fetch_assoc())
							{
								//echo $row["ProductID"];
								$ProductID = $row["ProductID"];
							}
							if($update_current=="Y")
							{
								//echo 12454;
								$sql = "Update tblProducts set ProductUniqueCode='$ProductUniqueCode', ProductName='$ProductName', ProductDescription='$ProductDescription', 
									Status='$Status', StoreID='$StoreID' where ProductID='$ProductID'";
									//echo $sql;
								ExecuteNQ($sql);
							}
							if(IsNull($ProductID))
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
							$sql = "Insert into tblProducts (ProductUniqueCode, ProductName, ProductDescription, Status, StoreID) Values ( '$ProductUniqueCode', '$ProductName', '$ProductDescription', '$Status', '$StoreID')";
							//echo $sql;
							ExecuteNQ($sql);
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
