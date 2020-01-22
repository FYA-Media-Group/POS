<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>X-editable starter template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>  

    <!-- x-editable (bootstrap version) -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/js/bootstrap-editable.min.js"></script>
    
    <!-- main.js -->
    <script src="main.js"></script>
  </head>

  <body>

    <div class="container">

      <h1>X-editable starter template</h1>
      <?
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		echo $_POST['name']." is ".$_POST['value'];
	}
	else
	{
?>		
		<div id="abc">
        <span>Username:</span>
        <input id="username" name="username" data-type="text" data-placement="right" data-title="Enter username" class="editable editable-click" contenteditable data-original-title="" title="">
      </div>
<?
	}
?>
<script>
document.querySelector('#username').addEventListener('keypress', function (e) {
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
      var value = document.getElementById('username').value;
	  var name = $('#username').attr("name");
    alert(name+" is "+value);
		if (name == "username") {		
		  $.ajax
		  ({
				type: "POST",
				url: "dummy1.php",
				data: {name : 'name', value : 'value'},
				success: function(result){
				document.getElementById('abc').innerHTML = result;
			}});
			// alert(name+" is "+value);
		}
	}
});
</script>
	  
    </div>

  </body>
</html>