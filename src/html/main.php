<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
	<title>Parser</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="#" />
</head>
<body>
<div style="margin: auto;width: 60%;">
	<form id="parserForm" name="parserForm" method="post">
		<div class="form-group">
			<label for="pwd" class="error-label" id="articleError" style="color: red" ></label><br>
			<label for="pwd">Article:</label><br>
			<input type="text" class="form-control" id="productArticle" placeholder="ex:200E2113" name="productArticle">
		</div>
		<div class="form-group">
			<label for="pwd" class="error-label" id="nameError" style="color: red" ></label><br>
			<label for="pwd">Product Name:</label><br>
			<input type="text" class="form-control" id="productName" placeholder="ex: 155/13 R13 LAUFENN LW32 88T" name="productName"><br>
		</div>
		<div class="form-group">
			<label for="pwd" class="error-label" id="articleBeginError" style="color: red" ></label><br>
			<label for="pwd">Article Beginning:</label><br>
			<input type="text" class="form-control" id="productBeginArticle" placeholder="ex: 200E " name="productBeginArticle"><br>
		</div>
		<div class="form-group">
		<label for="pwd" class="error-label" id="articleEndError" style="color: red" ></label><br>
			<label for="pwd">Article Ending:</label><br>
			<input type="text" class="form-control" id="productEndArticle" placeholder="ex: 113" name="productEndArticle"><br>
		</div>
		<div class="form-group">
			<label for="pwd" class="error-label" id="priceLeftError" style="color: red" ></label><br>
			<label for="pwd">Price(min):</label><br>
			<input type="text" class="form-control" id="productLeftPrice" placeholder="ex: 2500" name="productLeftPrice"><br>
		</div>
		<div class="form-group">
			<label for="pwd" class="error-label" id="priceRightError" style="color: red" ></label><br>
			<label for="pwd">Price(max):</label><br>
			<input type="text" class="form-control" id="productRightPrice" placeholder="ex: 6700" name="productRightPrice">
		</div>
		<input type="button" name="parse" class="btn btn-primary" value="Parse" id="btnparse">
	</form>
</div>

<script>
	$(document).ready(function() {
		$('#btnparse').on('click', function() {
			var productArticle = $('#productArticle').val();
			var productName = $('#productName').val();
			var productBeginArticle = $('#productBeginArticle').val();
			var productEndArticle = $('#productEndArticle').val();
			var productLeftPrice = $('#productLeftPrice').val();
			var productRightPrice = $('#productRightPrice').val();
			if(productArticle != "" || productName != "" ||
			productBeginArticle != "" || productEndArticle != "" ||
			productLeftPrice != "" || productRightPrice != "") {
				$.ajax({
					url: "src/Parser/execute.php",
					type: "POST",
					data: {
						success:true,
						productArticle: productArticle,
						productName: productName,
						productBeginArticle: productBeginArticle,
						productEndArticle: productEndArticle,
						productLeftPrice: productLeftPrice,
						productRightPrice: productRightPrice
					},
					cache: false,
					success: function(dataResult) {
						$('.error-label').text("");
						var data = JSON.parse(dataResult);
						// если данные валидны, то...
						if (typeof data.statusCode !== 'undefined' && data.statusCode == 200) {
							location.href = "";
						}
						// если данные некорректны, то...
						else {
							for (let errorLabelName in data) {
								if (data[errorLabelName].statusCode == 201) {
									$("#" + errorLabelName + "Error").text(data[errorLabelName].text);
								}
							}
						}
					} 
				});
			}
			else {
				alert('Please, fill one of the fields for parsing!');
			}
		});
	});
</script>
</body>
</html>
