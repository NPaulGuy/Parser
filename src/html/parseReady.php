<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
	<title>Loader</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="#" />
</head>
<body>
<div style="margin: auto;width: 60%;">
	<!--<button type="button" class="btn btn-success btn-sm" id="register">Register page</button>
	<button type="button" class="btn btn-success btn-sm" id="login">Login page</button>-->
	<form id="parserForm" name="parserForm" method="post">
		<div class="form-group">
			<label id="labelInfo" name="labelInfo" for="pwd">Data is ready for loading.</label><br>
			<input type="button" name="load" class="btn btn-primary" value="Load Data" id="btnload">
			<input type="button" name="back" class="btn btn-primary" value="Back to Parse" id="btnback">
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {

		$('#btnload').on('click', function() {
			$('#labelInfo').text("Loading...");
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
						$('#btnload').attr("disabled", true);
						$('#labelInfo').text("Loading is successful!");
					}
					// если данные некорректны, то...
					else {

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
					var data = JSON.parse(dataResult);
					// если данные валидны, то...
					if (typeof data.statusCode !== 'undefined' && data.statusCode == 200) {
						location.href = "";
					}
					// если данные некорректны, то...
					else {

					}
				} 
			});
		});
	});
</script>
</body>
</html>
