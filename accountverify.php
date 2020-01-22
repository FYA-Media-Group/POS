<?php    
require_once('setting.fya');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

	$Email = $_POST["email"];
	$Password = $_POST["password"];
	$Remember_me = $_POST["rememberme"];

	$DB = Connect();
	$sql = "SELECT AdminID, AdminFullName, AdminPassword, AdminType, AdminRoleID, AdminEmailID , Status from tblAdmin where AdminUsername='".$Email."'";
	$RS = $DB->query($sql); 
	if ($RS->num_rows > 0) 
	{
		while($row = $RS->fetch_assoc())
		{
			$AdminID = $row["AdminID"];
			$AdminUsername = $Email;
			$AdminFullName = $row["AdminFullName"];
			$AdminPassword = $row["AdminPassword"];
			$AdminType = $row["AdminType"];
			$verify = ENCODEQ($AdminType);
			$Status = $row["Status"];
			$AdminRoleID = $row["AdminRoleID"];
			
			$selectStore="Select StoreID from tblAdminStore where AdminID=$AdminID";
			$RS1 = $DB->query($selectStore); 
			if ($RS1->num_rows > 0) 
			{
				while($row1 = $RS1->fetch_assoc())
				{
					$strStoreID = $row1["StoreID"];
				}
			}
			$seldata=select("StoreID","tblAdminStore","AdminID='".$AdminID."'");
			$storeid=$seldata[0]['StoreID'];

		}
		if($Status=="0")
		{
			if($AdminPassword==$Password)
			{
				$CookieRemember_me = Encode("Remember_me,".$Remember_me.",Remember_me");
				setcookie("CookieRemember_me",$CookieRemember_me,time() + (10 * 365 * 24 * 60 * 60));

				if($Remember_me=="Y")
				{
					$CookieAdminID = Encode("AdminID,".$AdminID.",AdminID");
					$CookieAdminUsername = Encode("AdminUsername,".$AdminUsername.",AdminUsername");
					$CookieAdminFullName = Encode("AdminFullName,".$AdminFullName.",AdminFullName");
					$CookieAdminRoleID = Encode("AdminRoleID,".$AdminRoleID.",AdminRoleID");
					$CookieAdminType = Encode("AdminType,".$AdminType.",AdminType");
					$CookieStore = Encode("StoreID,".$storeid.",StoreID");
					

					setcookie("CookieAdminID",$CookieAdminID,time() + (10 * 365 * 24 * 60 * 60));
					setcookie("CookieAdminUsername",$CookieAdminUsername,time() + (10 * 365 * 24 * 60 * 60));
					setcookie("CookieAdminFullName",$CookieAdminFullName,time() + (10 * 365 * 24 * 60 * 60));
					setcookie("CookieAdminType",$CookieAdminType,time() + (10 * 365 * 24 * 60 * 60));
					setcookie("CookieStore",$CookieStore,time() + (10 * 365 * 24 * 60 * 60));
					setcookie("CookieAdminRoleID",$CookieAdminRoleID,time() + (10 * 365 * 24 * 60 * 60));
				}
				else
				{
					session_start();
					$_SESSION["AdminID"]=$AdminID;
					$_SESSION["AdminFullName"]=$AdminFullName;
					$_SESSION["AdminUsername"]=$AdminUsername;
					$_SESSION["AdminType"]=$AdminType;
					$_SESSION["Store"]=$storeid;
					$_SESSION["AdminRoleID"]=$AdminRoleID;
				}


				ExecuteNQ("update tblAdmin set LastLogin=NOW() where AdminID='$AdminID'");
				echo('<font color="green">Processing Login Process.. Please wait !!</font>');
				
							
				//added by asmita --Start************************************
				if($AdminRoleID=='36')
				{
					echo("<script>location.href='Dashboard.php';</script>");
				}
				elseif($AdminRoleID=='2')
				{
					echo("<script>location.href='Marketing-Dashboard.php';</script>");
				}
				elseif($AdminRoleID=='38')
				{
					echo("<script>location.href='Audit-Dashboard.php';</script>");
				}
				elseif($AdminRoleID=='6')
				{
					echo("<script>location.href='Salon-Dashboard.php';</script>");
				}
				elseif($AdminRoleID=='4')
				{
					echo("<script>location.href='Operation-Dashboard.php';</script>");
				}elseif($AdminRoleID=='39')
				{
					echo("<script>location.href='Admin-Dashboard.php';</script>");
				}
				else
				{
					echo("<script>location.href='Dashboard.php';</script>");
				}
				//added by asmita--End***************************************
				
				
				
				// echo("<script>location.href='Dashboard.php';</script>"); 
			}
			else
			{
				echo('<font color="red">Invalid Password. Please try again</font>'); 
			}
		}
		else
		{
			echo('<font color="red">Account Locked !!</font>'); 
		}
	}
	else
	{
			echo('<font color="red">Invalid Username. Please try again</font>'); 
	}

	$DB->close();

}
else
{
	echo "Chori Naa munnaa !! ";
}




?> 