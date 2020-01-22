<?php require_once("setting.fya"); ?>
<?php

	$strRemember_me = ValidateCookie("CookieRemember_me");
	if($strRemember_me=="Y")
	{
		$strAdminUsername = ValidateCookie("CookieAdminUsername");
	}
	else
	{
		session_start();
		$strAdminUsername = $_SESSION["AdminUsername"];
	}


	if (!IsNull($strAdminUsername))
	{
		header('Location: Dashboard.php'); 
	}

	$strPageTitle = "Login | NailSpa";
	$strMenuID = "1";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once 'incMetaScript.fya'; ?>
	
	<script>
		function proceed_login()
		{
	        var isValid = true;
			var counter = 0;
	        $('.required').each(function() {
	            if ($.trim($(this).val()) == '') {
					counter ++;
					if(counter==1)
					{
						$(this).focus();
					}
	                isValid = false;
	                $(this).css({
	                    "border": "1px solid #BF0404",
	                    "color": "#000000",
						"background-color": "rgb(234, 221, 221)"
	                });
	            }
	            else {
	                $(this).css({
	                    "border": "",
						"background-color": "",
	                });
	            }
	        });
	        if (isValid == false)
			{ 
				alert('Fields marked red are compulsory');
				return false;
			}

			StartLoading();
			var email = $("#inputEmail").val();
			var password = $("#inputPassword").val();
			var rememberme = "";
			if(document.getElementById("remember_me").checked == true)
			{
				rememberme = "Y";
			}

		    $.ajax({
				type:'POST', 
				url: '<?=FindHost()?>/admin/accountverify.php', 
				data: {

				    email : email,
				    password : password,
					rememberme : rememberme
				},

				success: function(response) 
				{
					EndLoading();
			        $('.result_message').html(response);
			    }
			});
		}
		
		
		function proceed_forgot_password()
		{
	        var isValid = true;
			var counter = 0;
	        $('.required2').each(function() {
	            if ($.trim($(this).val()) == '') {
					counter ++;
					if(counter==1)
					{
						$(this).focus();
					}
	                isValid = false;
	                $(this).css({
	                    "border": "1px solid #BF0404",
	                    "color": "#000000",
						"background-color": "rgb(234, 221, 221)"
	                });
	            }
	            else {
	                $(this).css({
	                    "border": "",
						"background-color": "",
	                });
	            }
	        });
	        if (isValid == false)
			{ 
				alert('Fields marked red are compulsory');
				return false;
			}

			StartLoading();
			var email = $("#InputEmail2").val();
			var username = $("#username").val();

		    $.ajax({
				type:'POST', 
				url: '<?=FindHost()?>/admin/Forgotpassword.php', 
				data: {

				    email : email,
					username : username
				},

				success: function(response) 
				{
					EndLoading();
			        $('.result_message2').html(response);
					$('.mybutton').hide();

			    }
			});
		}
	</script>
	
</head>

<body>
    <?php require_once("incLoader.fya"); ?>
	
    <style type="text/css">
        html,
        body {
            height: 100%;
            background: #fff;
        }
    </style>
    <div class="center-vertical">
        <div class="center-content">
			<form class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin My_LoginForm" method="post" onsubmit="proceed_login(); return false;">
                <h3 class="text-center pad25B font-gray text-transform-upr font-size-23">NailSpa<span class="opacity-80">&nbsp;v1.0</span></h3>
				
				
                <div id="login-form" class="content-box bg-default">
                    <div class="content-box-wrapper pad20A"><img class="mrg25B center-margin radius-all-100 display-block" src="assets/image-resources/app-icon (2).png" alt="">
					<div class="result_message" style="font-size:15px;">&nbsp;</div>
                        <div class="form-group">
                            <div class="input-group"><span class="input-group-addon addon-inside bg-gray"><i class="glyph-icon icon-envelope-o"></i></span> 
								<input type="text" class="form-control required" id="inputEmail" placeholder="Enter username">
							</div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"><span class="input-group-addon addon-inside bg-gray"><i class="glyph-icon icon-unlock-alt"></i></span> 
								<input type="password" class="form-control required" id="inputPassword" placeholder="Password">
							</div>
                        </div>
                        <div class="form-group"><button type="submit" class="btn btn-block btn-primary">Login</button></div>
                        <div class="row">
                            <div class="checkbox-primary col-md-6" style="height: 20px"><label><input type="checkbox" id="remember_me" value="Y" checked="checked" class="custom-checkbox"> Remember me</label></div>
                            <div class="text-right col-md-6"><a href="#" class="switch-button" switch-target="#login-forgot" switch-parent="#login-form" title="Recover password">Forgot your password?</a></div>
                        </div>
                    </div>
                </div>
				
			</form>	
			<form class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin My_LoginForm" method="post" onsubmit="proceed_forgot_password(); return false;">
                <div id="login-forgot" class="content-box bg-default hide">
                    <div class="content-box-wrapper pad20A result_message2" >
                        <div class="form-group"><label for="exampleInputEmail2">Email address:</label>
                            <div class="input-group"><span class="input-group-addon addon-inside bg-gray"><i class="glyph-icon icon-envelope-o"></i></span> <input type="email" class="form-control required2" id="InputEmail2" placeholder="Enter email to recover password"></div>
                        </div>
						<div class="form-group"><label for="exampleInputEmail2">Username:</label>
                            <div class="input-group"> <input type="text" class="form-control required2" id="username" placeholder="Enter your unique Username"></div>
                        </div>
                    </div>
					
                    <div class="button-pane text-center"><button type="submit" class="btn btn-md btn-primary mybutton">Recover Password</button> <a href="#" class="btn btn-md btn-link switch-button" switch-target="#login-form" switch-parent="#login-forgot" title="Cancel">Sign in</a></div>
                </div>
			</form>	
            
        </div>
    </div>

	<?php require_once 'incFooter.fya'; ?>
	
</body>

</html>