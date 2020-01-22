<style>
	#passwordforget
	{
		color: rgb(68, 157, 68);
		font-weight: bold;
		text-align: center;
		font-size: 15px;
	}
	
	#passwordforget2
	{
		color: rgb(255, 0, 0);
		font-weight: bold;
		text-align: center;
		font-size: 15px;
	}
    
</style>

<?php    
require_once('setting.fya');
require 'MailSend/mail/MailSend.php';
$DB = Connect();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$Email = Filter($_POST["email"]);
	$Username = Filter($_POST["username"]);
	
	
	$sql = "SELECT AdminID, AdminFullName from tblAdmin where AdminUsername='".$Username."' and AdminEmailID='".$Email."' and Status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		while($row = $RS->fetch_assoc())
		{
			$AdminID = $row["AdminID"];
			$AdminFullName = $row["AdminFullName"];
			$AdminEncode = EncodeQ($row["AdminID"]);
			$RecoveryURL = FindHostAdmin()."/PasswordRecovery.php?AID=" . $AdminEncode;
			// SendPHPMail($to, $toName, $from, $fromName, $replyto, $replytoName, $subject, $body, $attachments)


			SendPHPMail($Email, $AdminFullName, "noreply@mypetstory.in", "MP Story", "noreply@mypetstory.in", "MP Story", "Password recovery", "<font color='black'>To reset your password, please click on the following link and follow the instructions:</font><br> <a target='_blank' href='$RecoveryURL'>Click here</a>", "");

			
			
			echo'<div class="content-box-wrapper pad20A" >
						<div class="form-group">
							<div class="input-group"><center><span id="passwordforget">Verification email sent <br> Check your inbox</span><center></div>
						</div>
					</div>';
		}
	}
	
	else
	{
		echo'<div class="content-box-wrapper pad20A" >
				<div class="form-group">
					<div class="input-group"><center><span id="passwordforget2">Sorry no user with such email id exist on this system</span><center></div>
				</div>
			</div>';
	}
	
}
else
{
	echo "beta hum tumhare baap hai";
}
$DB->close();
?>