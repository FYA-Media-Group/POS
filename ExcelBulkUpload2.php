<div class="upload">
	<a class="btn btn-success btn-sm" href="downloads/UploadFormat2.xlsx">Click Here to Download the Excel Format</a><br><br>
	<span><b>Click to upload the excel file, only valid excel file format are accepted</b></span>
	<form method="post" class="upload_form" enctype="multipart/form-data" onsubmit="uploadFile(); return false;">
		<input type="file" name="Excel" id="file_excel"><br>
		<input class="btn btn-primary" type="submit" value="Upload Excel">
	</form>
</div>

<div class="save" style="display:none;">
	<form method="post" class="save_form" enctype="multipart/form-data" onsubmit="saveFile(); return false;">
		<input type="hidden" class="excelfile" name="excelfile" value="">
		
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">You want to update current values if data is already there ?</label>
			<div class="col-md-1 col-sm-6 col-xs-12">
				<select class="form-control" name="update_current">
					<option value="N" selected>No</option>
					<option value="Y">Yes</option>
				</select>
			</div>
		</div>
		<input class="btn btn-primary" type="submit" value="Save">
		<input class="btn btn-danger" type="button" value="Delete" onclick="DeleteFile();">
	</form>
</div>

<script>

	function getFileExtension(filename)
	{
		return filename.split('.').pop();
	}
	
	
	function DeleteFile()
	{
		var proceed = confirm("Are you sure you want to delete this file and upload another ??");
		if(proceed==true)
		{
			StartLoading();
			var filename = $(".excelfile").val();
			$.ajax({
				type:'POST', 
				url: 'ExcelDeleteFile2.php', 
				data:({
					fn:filename
				}),
				success: function(data) 
				{
					EndLoading();
					$(".save").slideUp();
					$(".upload").slideDown();
					$(".result_message_excel").html('');
				}
			});
		}
	}
	function saveFile()
	{
		StartLoading();
		$.ajax({
			type:'POST', 
			url: 'ExcelSave2.php', 
			data:$(".save_form").serializeArray(),
			success: function(data) 
			{
				//alert(data)
				EndLoading();
				$(".save").slideUp();
				$(".result_message_excel").html(data);

			}
		});
	}
	function uploadFile()
	{
		//alert(12345)
		var extension = getFileExtension(document.getElementById("file_excel").value);
		if(extension!="xls"&&extension!="xlsx")
		{
			alert('Please select a valid excel file');
			return false;
		}
		var data;
		data = new FormData();
		data.append( 'Excel', $( '#file_excel' )[0].files[0] );
		
		var other_data = $('.upload_form').serializeArray();
		$.each(other_data,function(key,input){
			data.append(input.name,input.value);
		});
		
		StartLoading();
		$.ajax({
			url: 'ExcelUpload2.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'post',
			success: function ( data ) 
			{
				
				//alert(data)
				EndLoading();
				if(data.indexOf("file-uploaded") > -1)
				{
					$(".upload").slideUp();
					$(".save").slideDown();
					var filename = data.replace("file-uploaded", "");
					$(".excelfile").val(filename);
					$(".result_message_excel").html('<iframe src="ExcelDisplay2.php?v=1&fn='+filename+'" width="100%" height="600px"></iframe>');
				}
				else
				{
					$(".result_message_excel").html('<font color="red">'+data+'</font>');
				}
				
			}
	  
		});


	
	}
</script>

<div class="result_message_excel"></div>