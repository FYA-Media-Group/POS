<?php require_once("setting.fya"); $strAID = DecodeQ($_GET["AID"]);$DB = Connect();	$sql = "SELECT AdminID from tblAdmin where AdminID='".$strAID."' and Status='0'";	$RS = $DB->query($sql);	if ($RS->num_rows > 0) 	{?><!DOCTYPE html><html lang="en"><head>	<?php require_once 'incMetaScript.fya'; ?>		<script>		function update_password()		{	        var isValid = true;			var counter = 0;	        $('.required').each(function() {	            if ($.trim($(this).val()) == '') {					counter ++;					if(counter==1)					{						$(this).focus();					}	                isValid = false;	                $(this).css({	                    "border": "1px solid #BF0404",	                    "color": "#000000",						"background-color": "rgb(234, 221, 221)"	                });	            }	            else {	                $(this).css({	                    "border": "",						"background-color": "",	                });	            }	        });	        if (isValid == false)			{ 				alert('Fields marked red are compulsory');				return false;			}			var AID = $("#AID").val();			var password1 = $("#inputPassword1").val();			var password2 = $("#inputPassword2").val();						if ($.trim($(inputPassword1).val()).length<8) 			{				alert('1st Password must have minimum 8 characters');				return false;			}									if ($.trim($(inputPassword2).val()).length<8) 			{				alert('2st Password must have minimum 8 characters');				return false;			}						if (password1 == password2)			{					StartLoading();					$.ajax({					type:'POST', 					url: '<?=FindHost()?>/admin/UpdatePassword.php', 					data: {						password1 : password1,						password2 : password2,						AID : AID					},					success: function(response) 					{						EndLoading();						$('.result_message').html(response);						$('.mybutton').hide();					}				});			}			else			{				alert('Both passwords must match');				return false;			}			 		}			</script>	</head><body>    <?php require_once("incLoader.fya"); ?>	    <style type="text/css">        html,        body {            height: 100%;            background: #fff;        }    </style>    <div class="center-vertical">        <div class="center-content">			<form class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin My_LoginForm" method="post" onsubmit="update_password(); return false;">                <h3 class="text-center pad25B font-gray text-transform-upr font-size-23">My Pet Story <span class="opacity-80">v1.0</span></h3>								<input type="hidden" class="form-control admin_password required" value="<?=Encode($strAID)?>" id="AID" name="AID">                <div id="login-form" class="content-box bg-default">                    <div class="content-box-wrapper pad20A"><img class="mrg25B center-margin radius-all-100 display-block" src="assets/image-resources/app-icon (2).png" alt="">										<span class="result_message">                        <div class="form-group">                            <div class="input-group"><span class="input-group-addon addon-inside bg-gray"><i class="glyph-icon icon-unlock-alt"></i></span> 								<input type="password" class="form-control admin_password required" id="inputPassword1" placeholder="Password">							</div>                        </div>                        <div class="form-group">                            <div class="input-group"><span class="input-group-addon addon-inside bg-gray"><i class="glyph-icon icon-unlock-alt"></i></span> 								<input type="password" class="form-control admin_password required" id="inputPassword2" placeholder="Re enter Password">							</div>                        </div>					</span>                        <div class="form-group"><button type="submit" class="btn btn-block btn-primary mybutton">Update Password</button></div>                        <div class="form-group">                            <a href="<?=FindHostAdmin();?>" class="btn btn-block btn-success" title="Sign In">Sign In</a>                        </div>                    </div>                </div>							</form>				                    </div>    </div>	<?php require_once 'incFooter.fya'; ?>	</body></html><?php		}	else	{?><head>	<?php require_once 'incMetaScript.fya'; ?>	<style>	#passwordforget	{		color: rgb(68, 157, 68);		font-weight: bold;		text-align: center;		font-size: 15px;	}		#passwordforget2	{		color: rgb(255, 0, 0);		font-weight: bold;		text-align: center;		font-size: 15px;	}    </style></head><body>    <?php require_once("incLoader.fya"); ?>	    <style type="text/css">        html,        body {            height: 100%;            background: #fff;        }    </style>    <div class="center-vertical">        <div class="center-content">			<form class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin My_LoginForm">                <h3 class="text-center pad25B font-gray text-transform-upr font-size-23">My Pet Story <span class="opacity-80">v1.0</span></h3>								                <div id="login-form" class="content-box bg-default">                    <div class="content-box-wrapper pad20A"><img class="mrg25B center-margin radius-all-100 display-block" src="assets/image-resources/app-icon (2).png" alt="">					<div class="result_message" style="font-size:15px;">&nbsp;</div>                        <div class="form-group">                            <div class="input-group">								<div class="input-group"><center><span id="passwordforget">Link Expired OR <br> Admin is disabled OR<br> You are lost <br> <br> hence you will be redirected in 10 secs</span><center></div>							</div>                        </div>                        <meta http-equiv="refresh" content="10;url=<?=FindHostAdmin();?>" />                        <div class="form-group">                            <a href="<?=FindHostAdmin();?>" class="btn btn-block btn-success" title="Sign In">Sign In</a>                        </div>                    </div>                </div>							</form>				                    </div>    </div>	<?php require_once 'incFooter.fya'; ?>	</body></html><?php			}?>