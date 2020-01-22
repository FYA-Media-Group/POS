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
							.	"<th class='table_header'>CustomerFirstName</th>"  
							.   "<th class='table_header'>CustomerLastName</th>"
							.	"<th class='table_header'>Customer Email</th>"  
							.	"<th class='table_header'>Customer Mobile</th>"  
							.	"<th class='table_header'>Status</th>"  
							.	"<th class='table_header'>Gender</th>"  
							.	"<th class='table_header'>Membership</th>"  
							.	"<th class='table_header'>Total Visits</th>"  
							.	"<th class='table_header'>Last Visit</th>"  
                            .	"<th class='table_header'>RegDate</th>"  
                            .	"<th class='table_header'>Start Date</th>"  
                            .	"<th class='table_header'>End Date</th>"	
                            .	"<th class='table_header'>Membership Code</th>"							
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