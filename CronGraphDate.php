<?php require_once("setting.fya"); ?>

<?php
		$DB = Connect(); 
	    $sqlgraphx=select("RoleID","tblAdminRoles","Status='0'");
		foreach($sqlgraphx as $twst)
		{
		$RoleID[]=$twst['RoleID'];
		}
		for($i=0;$i<count($RoleID);$i++)
		{
		   $sqlp="delete from tblGraphDateParameter where RoleID='".$RoleID[$i]."'";
		   ExecuteNQ($sqlp);	
		   $First= date('Y-m-01');
		   $Last= date('Y-m-t');
		   $DateInsertUpdate=date("Y-m-d H:i:s");
		   $sqlInsert3ptr = "INSERT INTO tblGraphDateParameter(FromDate,ToDate, Type,RoleID,DateInsertUpdate) VALUES('".$First."', '".$Last."','1','".$RoleID[$i]."','".$DateInsertUpdate."')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
									echo "success";		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
			
		}
		
		$DB->close();

  //  echo("<script>location.href=http://pos.nailspaexperience.com/admin/Dashboard.php';</script>");
   
		?>