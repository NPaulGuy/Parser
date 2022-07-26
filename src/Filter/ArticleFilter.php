<?php
	namespace Parser\Filter;
	class ArticleFilter {
		
		public function filter(string $value, string $filterValue) : bool {
			return $value == $filterValue || empty($filterValue);
		}
		public function filterBegin(string $value, string $filterValue) : bool {
			return strripos($value, $filterValue) === 0 
			|| $value == $filterValue || empty($filterValue);
		} 
		public function filterEnd(string $value, string $filterValue) : bool {
			return strripos($value, $filterValue) === strlen($value) - strlen($filterValue) 
			|| $value == $filterValue || empty($filterValue);
		}
		public function isMatch(
			string $value, 
			string $filterValue, 
			string $filterValueBegin, 
			string $filterValueEnd
		) {
			return $this->filter($value, $filterValue) &&
			$this->filterBegin($value, $filterValueBegin) && 
			$this->filterEnd($value, $filterValueEnd);
		}
	}
?>