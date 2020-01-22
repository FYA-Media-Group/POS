<?php
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

$version = $_GET["v"];
$filename = "uploads/".$_GET["fn"];

if (!file_exists($filename)) {
	exit("File not uploaded properly. Please re-try" . EOL);
}

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($filename);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
	if($worksheet->getTitle()=="Sheet1")
	{
		echo "<table style='border-collapse:collapse;' width='100%'>";
		foreach ($worksheet->getRowIterator() as $row) 
		{
			if($row->getRowIndex()==1)
			{
				if($version=="1")
				{
					echo  "<tr>"
							.	"<th class='table_header'>Product Unique Code</th>"  
							.	"<th class='table_header'>Product Name</th>"  
							.	"<th class='table_header'>Product Description</th>"  
							.	"<th class='table_header'>Status</th>"  
							.	"<th class='table_header'>StoreID</th>"  
							."</tr>";
				}
			}
			else
			{
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
				echo "<tr>";
				foreach ($cellIterator as $cell) 
				{
					if (!is_null($cell)) 
					{
						echo "<td class='table_cell'>".$cell->getCalculatedValue()."</td>";
					}
					
				}
				echo "</tr>";
				
			}
		}
		echo "</table>";
	}
}
?>
<style>
	.table_header
	{
		background:#B0B9C1;
		border:1px solid black;
		padding:2px;
	}
	.table_cell
	{
		border:1px solid black;
		text-align:center;
	}
</style>