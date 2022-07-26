<?php
	namespace Parser\Filter;
	class NameFilter {
		
		public function filter(string $value, string $filterValue) : bool {
			return strripos($value, $filterValue) !== false || empty($filterValue);
		}
		public function isMatch(string $value, string $filterValue) {
			return $this->filter($value, $filterValue);
		}
	}
?>