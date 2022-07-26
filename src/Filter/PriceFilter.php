<?php
	namespace Parser\Filter;
	class PriceFilter {
		
		public function filterMin($value, string $filterValue) : bool {
			return intval($value) >= intval($filterValue) || empty($filterValue);
		}
		public function filterMax($value, string $filterValue) : bool {
			return intval($value) <= intval($filterValue) || empty($filterValue);
		}
		// $value может быть нулевым, поэтому тип не указывается.
		public function isMatch(
			$value, 
			string $filterValueMin, 
			string $filterValueMax
		) {
			return $this->filterMin($value, $filterValueMin) && 
			$this->filterMax($value, $filterValueMax);
		}
	}
?>