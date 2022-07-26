<?php
	namespace Parser\Validation;
	use \Parser\Validation\Validator;
	
	class PriceValidator implements Validator {
		public function isValid(string $value) : bool {
			// Проверяем ТОЛЬКО цифры
			return preg_match("#^\d*$#", $value);
		}
	}
?>
