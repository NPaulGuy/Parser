<?php
	namespace Parser\Validation;

	interface Validator {
		public function isValid(string $value) : bool;
	}

?>
