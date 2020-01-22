
	<?php require_once '../pos/admin/setting.fya'; 
	$DB = Connect_blog();
	?>


<!DOCTYPE html>
<html>
<head>
  <?$strTitle = "Nailspa | Blog Details";?>
	<?php require_once 'incMetaScript.fya'; ?>

</head>
<body>
	<!--start-main-->
<div class="fluid-container" >

	<?php require_once 'incHeader.fya'; ?>

<!--********************** about us page start *******************-->
<!--about-->

 <!--post 1-->
   <div class="welcome1">
		   <div class="container">
		   <?
				$strID = DecodeQ(Filter($_GET['uid']));
				$sql = "SELECT * FROM tblBlogs WHERE BlogID=$strID";
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					while($row = $RS->fetch_assoc())
					{
						$strBlogID = $row['BlogID'];
						$getUID = EncodeQ($strBlogID);
						$getUIDDelete = Encode($strBlogID);
						$strTitle = $row['Title'];
						$strImagePath = "../pos/admin/".$row['ImagePath'];
						$strContent = $row['Content'];
						
						
						?>
				<div class="video-top">
				<img src="<?=$strImagePath?>" width="900" height="400"  class="animated bounceInLeft">
				
			  <div class=" video-text animated ">
			  <br>
					<h4><?=$strTitle?></h4>
					<p id="para1">
					<?=$strContent?>
					
					</p>
					</div>
			 <!--  <div class="col-md-4 video">
			  <img src="images/service/Eyelash.jpg" width="900" height="300"  class="animated bounceInLeft">
			  
				</div>-->
				<!--<div class="col-md-8 video-text animated ">
					<h4>Lorem ipsum dolor sit amet</h4>
					<p id="para1">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tecum optime, deinde etiam cum mediocri amico. Nam Pyrrho, Aristo, Erillus iam diu abiecti.<br>
			
				</div>-->
					<div class="clearfix"> </div>
				</div>
						<?
					}
				}
		   ?>
			</div>				
		</div>

        
<!-- footer -->
	  
	  <?php require_once 'incFooter.fya'; ?>

<!-- //footer -->
          
          
          
          
	   <!-- <div class="copy"> -->
	          <!--<div class="logo two">
			    <a href="index.html"><h3>Nail Spa</h3></a>
			   </div>
			   <ul class="s_social two">
						<li><a href=""> <i class="fb1"> </i> </a></li>
						<li><a href=""><i class="tw1"> </i> </a></li>
					    <li><a href=""><i class="linked1"> </i> </a></li>
						<li><a href=""><i class="google1"> </i> </a></li>
		 			</ul>-->

		 <!--   <p>&copy; 2016 Nail Spa. All Rights Reserved.</p>
	   </div> -->
<!-- //footer -->
	
		<!--start-smooth-scrolling-->
						<script type="text/javascript">
									$(document).ready(function() {
										/*
										var defaults = {
								  			containerID: 'toTop', // fading element id
											containerHoverID: 'toTopHover', // fading element hover id
											scrollSpeed: 1200,
											easingType: 'linear' 
								 		};
										*/
										
										$().UItoTop({ easingType: 'easeOutQuart' });
										
									});
								</script>
								<!--end-smooth-scrolling-->
		<!--<a href="#home" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>-->
</body>
</html>