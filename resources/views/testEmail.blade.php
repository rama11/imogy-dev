<!DOCTYPE html>
<html>
<head>
	<title>Test Email</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

	<input type="file" name="file" id="fileBox" multiple>
	<button onclick="upload()">Upload + Send</button>

<script type="text/javascript">

	var files = [];
 
	$("input[type=file]").change(function(event) {
		$.each(event.target.files, function(index, file) {
			var reader = new FileReader();
			reader.onload = function(event) {  
				object = {};
				object.filename = file.name;
				object.data = event.target.result;
				files.push(object);
			};  
			reader.readAsDataURL(file);
		});
	});

	function upload(){
		$.each(files, function(index, file) {
			$.ajax({url: "testUpload",
				type: 'POST',
				data: {fileName: file.filename, data: file.data,_token: "{{ csrf_token() }}"},
				success: function(data, status, xhr) {}
			});      
		});
		files = [];
	}

</script>

</body>
</html>