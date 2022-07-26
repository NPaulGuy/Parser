<?php
	namespace Parser\Validation;
	use \Parser\Validation\Validator;
	
	class ArticleValidator implements Validator {
		
		public function isValid(string $value) : bool {
			// Проверяем на ТОЛЬКО буквы и цифры + дефис
			return preg_match("#^[a-zA-Z0-9-]*$#", $value);
		}
	}
?>
