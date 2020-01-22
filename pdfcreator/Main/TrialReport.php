<?php

// Data control parameter
$Orientation = "L";
$Downloadfilename = "CustomerReport.pdf";
$logoimagefile = "tcpdf_logo.jpg";
$documentheading = "Customer Reports";
$documentdescription = "This is the report of customer with date filter from 01/09/2016 to 30/09/2016";
$logowidth = "50";

$HTMLContent = '<!DOCTYPE html>
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
				  </tr>
				  <tr>
					<td>Saif Usmani</td>
					<td>saiffya@hotmail.com</td>
					<td>9967716324</td>
					<td>Gold</td>
					<td>Male</td>
					<td>15th Sep 2016</td>
				  </tr>
				  
				</table>
				</small>
				</body>
				</html>';


require_once('tcpdf_include.php');
require_once('incdatacontent.php');



// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));


// Set some content to print
$html = <<<EOD
$HTMLContent
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '6', '', $html, 0, 1, 0, true, '', true);



// This method has several options, check the source code documentation for more information.
// use D instead if I to save as output
$pdf->Output($Downloadfilename, 'I');

?>