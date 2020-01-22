<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<div class="form-group">
	<label class="col-sm-3 control-label">Available Packages<span>*</span></label>
		
		<div class="col-sm-3 ">
      	
<?php
	$test="";
	$testd=array();
	$cnts=array();
		$DB = Connect();
	if(isset($_POST["id"]))
	{
		if(!empty($_POST["id"]))
		{
			$store = $_POST["id"];
			
		}
		    
			        $sql = "SELECT * FROM tblPackages WHERE StoreID='$store'";
					$RS = $DB->query($sql);
			if ($RS->num_rows > 0)
			{
?>
 <select class="form-control required" name="packageid[]" multiple  id="packageid" >
	   <option value="" align="center"><b>--Select Package--</b></option>	
<?
				while($row = $RS->fetch_assoc())
				{
						?>
				<option value="<?=$row['PackageID']?>"><?php echo $row['Name']?></option>
						<?php
				}
				?>
				</select>
				<?php
			}
			else
			{
			
				echo "No Package Available For This Store";
			}
				
			
           
																	 
			
        
	
	}
?>


			
			</div>
			</div>