<?php include_once('events/functions.php'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event Calendar</title>
<link type="text/css" rel="stylesheet" href="events/style.css"/>
<script src="events/jquery.min.js">

</script>
<!--<script>
jQuery(document).ready(function($) {
	alert("js is working");
});
</script>-->

</head>
<body>

<div id="calendar_div">
	<?php echo getCalender(); ?>
</div>

</body>
</html>
