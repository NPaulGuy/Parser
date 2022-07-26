<?php
	
	namespace Parser\Parser;
	
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	use \Parser\DB\DB;
	use \Parser\Validation\ArticleValidator;
	use \Parser\Validation\NameValidator;
	use \Parser\Validation\PriceValidator;
	use \Parser\Filter\ArticleFilter;
	use \Parser\Filter\NameFilter;
	use \Parser\Filter\PriceFilter;

	class Parser {
		private function getSpreadSheet(string $inputFileName) : SpreadSheet {
			$reader					=	new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			$reader->setReadDataOnly(true);
			$spreadsheet			=	$reader->load($inputFileName);
			return $spreadsheet;
		}
		private function getWorkSheet(SpreadSheet $spreadsheet) : WorkSheet {
			return $spreadsheet->getActiveSheet();
		}
		private function getArrayData(string $inputFileName) : array {
			$worksheet = $this->getWorkSheet(
				$this->getSpreadSheet($inputFileName)
			);
			$rows = [];
			foreach ($worksheet->getRowIterator() as $row) {
				$cellIterator = $row->getCellIterator();
    			$cellIterator->setIterateOnlyExistingCells(FALSE);
				$buffRow = [];
				// Счётчик для определения столбца.
				$columnPos = 0;
				foreach ($cellIterator as $cell) {
					if (empty($cell->getValue()) && $columnPos == 0) {
						continue;
					}
					$buffRow[] = $cell->getValue();
					$columnPos++;
				}
				if (count($buffRow) == 4) {
					$rows[] = $buffRow;
				}
			}
			// Удаляем заголовки столбцов.
			array_shift($rows);
			return $rows;
		}
		private function isDataCorrect(array $arrInfo) : bool {
			$isValid = true;
			foreach ($arrInfo as $fieldName => $fieldInfo) {
				if ( $fieldInfo['statusCode'] == 201 ) {
					$isValid = false;
					break;
				}
			}
			return $isValid;
		}
		private function getSearchInfo(array $formData) : array {
			$_SESSION['article']		=	trim( $formData['productArticle'] );
			$_SESSION['name']			=	trim( $formData['productName'] );
			$_SESSION['articleBegin']	=	trim( $formData['productBeginArticle'] );
			$_SESSION['articleEnd']		=	trim( $formData['productEndArticle'] );
			$_SESSION['priceLeft']		=	trim( $formData['productLeftPrice'] );
			$_SESSION['priceRight']		=	trim( $formData['productRightPrice'] );
			$arrInfo					=	[
				'article'				=>	[
					'statusCode'		=>	(new ArticleValidator)->isValid($_SESSION['article']) ? 200 : 201, 
					'text'				=>	'Invalid article!'
				],
				'name'					=>	[
					'statusCode'		=>	(new NameValidator)->isValid($_SESSION['name']) ? 200 : 201, 
					'text'				=>	'Invalid name!'
				],
				'articleBegin'			=>	[
					'statusCode'		=>	(new ArticleValidator)->isValid($_SESSION['articleBegin']) ? 200 : 201, 
					'text'				=>	'Invalid begin article!'
				],
				'articleEnd'			=>	[
					'statusCode'		=>	(new ArticleValidator)->isValid($_SESSION['articleEnd']) ? 200 : 201, 
					'text'				=>	'Invalid end article!'
				],
				'priceLeft'				=>	[
					'statusCode'		=>	(new PriceValidator)->isValid($_SESSION['priceLeft']) ? 200 : 201, 
					'text'				=>	'Invalid min price!'
				],
				'priceRight'			=>	[
					'statusCode'		=>	(new PriceValidator)->isValid($_SESSION['priceRight']) ? 200 : 201, 
					'text'				=>	'Invalid max price!'
				],
			];
			return $arrInfo;
		}
		private function getFilteredData(array $excelRows) : array {
			$filteredData = [];
			$count = 0;
			foreach ($excelRows as $row) {
				if (
					(new ArticleFilter)->isMatch(
						$row[0], 
						$_SESSION['article'],
						$_SESSION['articleBegin'],
						$_SESSION['articleEnd']
						) &&
					(new NameFilter)->isMatch(
						$row[1], 
						$_SESSION['name']
						) &&
					(new PriceFilter)->isMatch(
						$row[2], 
						$_SESSION['priceLeft'],
						$_SESSION['priceRight']
						)
				) {
					$filteredData[] = $row;
				}
			}
			//var_dump($filteredData);
			return $filteredData;
		}
		public function parseData(array $formData) {
			$arrInfo = $this->getSearchInfo($formData);
			if (!$this->isDataCorrect($arrInfo)) {
				return json_encode($arrInfo);
			} else {
				$excelRows = $this->getArrayData("../products.xls");
				$filteredRows = $this->getFilteredData($excelRows);
				$_SESSION['hasFilteredData'] = true;
				$_SESSION['filteredData'] = $filteredRows;
				return json_encode(array("statusCode" => 200));
				//echo json_encode(array("statusCode" => 200));
			}
		}
	}
?>
