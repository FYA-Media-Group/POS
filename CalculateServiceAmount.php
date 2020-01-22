<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 

$serviceid=$_POST['serviceid'];
$qty=$_POST['qty'];
$serviceee=explode(",",$serviceid);
$qty1=explode(",",$qty);

$DB = Connect();
                                                  for($i=0;$i<count($serviceee);$i++)
												  {
													 	$seti=select("*","tblServices","ServiceID='".$serviceee[$i]."'");
														$ServiceCost = $seti[0]["ServiceCost"];
														$secost=$ServiceCost*$qty1[$i];
														$totalservice=$totalservice+$secost;
												  }
											   unset($serviceee);
echo $totalservice;				
			$totalservice="";										
														?>
