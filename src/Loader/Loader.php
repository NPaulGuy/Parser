<?php
	
	namespace Parser\Loader;

	use \Parser\DB\DB;

	class Loader {
		public function loadData(array $filteredData) {
			$db = DB::createDB('localhost', 'root','root','parser');
			$db->insertData($filteredData);
			return json_encode(array("statusCode" => 200));

		}
	}
?>
