<?php
	
	namespace Parser\Output;

	class Output {
		public function outputData(array $filteredData) {
			echo "<thead>";
			echo "<tr>
					<th>Наименование артикула</th>
					<th>Наименование товара</th>
					<th>Интернет-цена</th>
					<th>Остатки</th>
				</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($filteredData as $row) {
				 echo "<tr>
					<td>" . $row[0] . "</td>
					<td>" . $row[1] . "</td>
					<td>" . $row[2] . "</td>
					<td>" . $row[3] . "</td>
				</tr>";
			}
			echo "</tbody>";
		}
	}
?>
