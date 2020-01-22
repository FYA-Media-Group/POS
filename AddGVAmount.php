<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		
		$DB = Connect();
		$totalstock=array();
		$stock=$_POST['stock'];
		$date=date('Y-m-d');
		$totalstock=[1000,2000,3000,4000,5000,10000];
		if(in_array("$stock",$totalstock))
		{
				$seldofferp=select("count(*)","tblGiftVoucherAmount","GiftVoucherAmount='".$stock."'");
				$cnt=$seldofferp[0]['count(*)'];	
				if($cnt>0)
				{
					$data=4;
				}
				else
				{
						$sql1="INSERT INTO tblGiftVoucherAmount(GiftVoucherAmount,DateTimeStamp) VALUES ('".$stock."','".$date."')";	
		
						if ($DB->query($sql1) === TRUE) 
						{
							$data=3;
						} 
						else 
						{
							$data="Error: " . $sql1 . "<br>" . $DB->error;
						}
				}
		
			
		}
		else
		{
			$data=2;
		}
				
		
		echo $data;
	}