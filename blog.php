
<?php require_once 'setting.fya'; 
	$DB = Connect_blog();
?>

<!DOCTYPE html>
<html>
<head>
  <?$strTitle = "Nailspa | Blogs";?>
	<?php require_once 'incMetaScript.fya'; ?>

</head>
<body>
	<!--start-main-->
<div class="fluid-container" >

	<?php require_once 'incHeader.fya'; ?>

<!--********************** about us page start *******************-->
<!--about-->
<?
$sql = "SELECT * FROM tblBlogs WHERE Status=0";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
	while($row = $RS->fetch_assoc())
	{
		$strBlogID = $row['BlogID'];
		$getUID = EncodeQ($strBlogID);
		$getUIDDelete = Encode($strBlogID);
		$strTitle = $row['Title'];
		$strImagePath = "../pos/admin/".$row['ImagePath'];
		$strExcerpt = $row['Excerpt'];
		if(($counter/2)==0)
		{
			$strClass = "welcome1";
		}
		else
		{
			$strClass = "welcome";
		}
		?>
   <div class="<?=$strClass?>">
	   <div class="container">
				<div class="video-top">
			   <div class="col-md-4 video">
				<img src="<?=$strImagePath?>" width="300" height="300" alt="this is testing" class="animated bounceInLeft">
				</div>
				<div class="col-md-8 video-text animated bounceInLeft">
					<h4><?=$strTitle?></h4>
					<div class="para2">
					<p id="para1"><?=$strExcerpt?></p>
				 
				</div>
				   <button type="button" value="Read More...." onclick="window.location.href='blogdetails.php?uid=<?=$getUID?>'" style="float:right;">read more</button>

				</div>
					<div class="clearfix"> </div>
			</div>
		</div>				
	</div>
<?
		$counter++;
	}
}
// $CheckDB="Select * from tblBlogs";
// $RS = $DB->query($tblBlogs);
// if ($RS->num_rows > 0) 
// {
	// while($row = $RS->fetch_assoc())
	// {
		// $strBlogID = $row['BlogID'];
		// $strTitle = $row['Title'];
		// $strExcerpt = $row['Excerpt'];
		// echo $strBlogID."<br>";
		// echo $strTitle."<br>";
		// echo $strExcerpt."<br>";
	// }
// }
$DB->close();
?>    
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