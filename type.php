<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<select name="MainCategoryType" class="form-control" id="subtype">
<option value="" Selected>-- Choose Type --</option>
<?php 
$DB = Connect();
$type=$_POST['type'];
if($type=="2")
{
$seldata=select("*","tblCategories","CategoryType='1'");
foreach($seldata as $val)
{
?>

																<option value="<?php echo $val['CategoryID'] ?>"><?php echo $val['CategoryName'] ?></option>	
																
																
															
<?
}
}
$DB->close();
?>
	
</select>
