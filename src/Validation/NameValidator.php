<?php
	namespace Parser\Validation;
	use \Parser\Validation\Validator;
	
	class NameValidator implements Validator {

		public function isValid(string $value) : bool {
			// Проверяем всё "вводимое"
			return preg_match("#^([ -~])*|[а-яА-Я]*$#", $value);
		}
	}
?>
