<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
	<title>Loader</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="#" />
	<link rel="stylesheet" href="src/styles/table.css">
</head>
<body>
<div style="margin: left;width: 60%;">
	<form id="parserForm" name="parserForm" method="post">
		<div class="form-group">
			<label id="labelInfo" name="labelInfo" for="pwd">Data is ready for loading.</label><br>
			<table class="scroll"><?php 
				use \Parser\Output\Output;
				(new Output)->outputData($_SESSION['filteredData']);
			?></table><br>
			<input type="button" name="load" class="btn btn-primary" value="Load Data" id="btnload">
			<input type="button" name="back" class="btn btn-primary" value="Back to Parse" id="btnback">
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {
		$('#btnload').on('click', function() {
			$('#labelInfo').text("Loading...");
			$('#btnload').attr("disabled", true);
			$('#btnback').attr("disabled", true);
			$.ajax({
				url: "src/Loader/execute.php",
				type: "POST",
				data: {
					success:true
				},
				cache: false,
				success: function(dataResult) {
					var data = JSON.parse(dataResult);
					// если данные валидны, то...
					if (typeof data.statusCode !== 'undefined' && data.statusCode == 200) {
						$('#btnback').attr("disabled", false);
						$('#labelInfo').text("Loading is successful!");
					}
				} 
			});
		});
		
		$('#btnback').on('click', function() {
			$.ajax({
				url: "src/Cleaner/execute.php",
				type: "POST",
				data: {
					success:true
				},
				cache: false,
				success: function(dataResult) {
					console.log(dataResult);
					var data = JSON.parse(dataResult);
					// если данные валидны, то...
					if (typeof data.statusCode !== 'undefined' && data.statusCode == 200) {
						location.href = "";
					}
				} 
			});
		});
	});
</script>
</body>
</html>
