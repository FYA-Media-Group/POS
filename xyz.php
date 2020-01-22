<form method='post' id='userform' action='xyz.php'> <tr>
    <td>Trouble Type</td>
    <td><?$abc = "checkboxvar";?>
	<select name="<?=$abc?>[]" multiple>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	
	</select>
	<input type="text" name="<?=$abc?>[]">
    </td> </tr> </table> <input type='submit' class='buttons'> </form>

<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php 
	foreach ($_POST['checkboxvar'] AS $key => $val)
	{
		if(IsNull($sqlColumnValues))
		{
			$sqlColumn = $key;
			$sqlColumnValues = $val;
		}
		else
		{
			$sqlColumn = $sqlColumn.",".$key;
			$sqlColumnValues = $sqlColumnValues.", ".$val;
		}
	}
	echo $sqlColumnValues."<br>";
	$arr = array();
	$arr = explode(",",$sqlColumnValues);
	echo count($arr);
	?>
	<select multiple>
	<?
	foreach ($arr AS $key => $val)
	{
		if(IsNull($arr))
		{
			
		}
		else
		{
			?>
				<option><?=$val?></option>
			<?
			unset($arr[$key]);
			$key = $key + '1';
		}
	}
?>
	</select>