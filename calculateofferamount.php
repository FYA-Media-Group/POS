<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

		
<?php
	$test="";
	$testd=array();
	$cnts=array();
	$servicecost=array();
	$offeramt="";
	$offertotalamt="";
	if(isset($_POST["id"]))
	{
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			$stored=$_POST["stored"];
			$baseamount=$_POST["baseamount"];
			$type=$_POST["type"];
			$typeamt=$_POST["typeamt"];
			//$testd=explode(",",$_POST["id"]);
		}
	
		
		
	}
	//echo $test;
//print_r($test);
for($a=0;$a<count($test);$a++)
	{
     
		  $seld=select("*","tblServices","ServiceID='".$test[$a]."'");
	//print_r($seld);
			foreach($seld as $val)
			{
				$servicecost[]=$val['ServiceCost'];
			}
				
	
	}
	for($u=0;$u<count($servicecost);$u++)
	{
		
	
			//echo "else";
			$totalcost=$totalcost+$servicecost[$u];
			 if($baseamount!='')
			 {
				 if($type=='1')
				 {
						
					 $amt = $baseamount - $typeamt;
					 $offeramt = $totalcost - $amt;
						
					 }
				elseif($type=='2')
				 {
						 $amt = $baseamount * $typeamt/100;
						
						$offeramt = $totalcost - $amt ;
				 }
		     }
			else
			  {
					 if($type=='1')
				    {
						
						$offeramt = $totalcost - $typeamt;
						
					 }
					 elseif($type=='2')
					 {
						 $offeramt = $totalcost * $typeamt/100;
					 }
				}
			 $offertotalamt = $offeramt;
		
		
					
			
		//$offeramt="";
	}
	
 echo $totalcost."#".$offertotalamt;
		//$offertotalamt="";
	unset($servicecost);
	unset($test);

	
?>


			
			