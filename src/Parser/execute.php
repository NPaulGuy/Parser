<?php
	require  __DIR__ . '/../../vendor/autoload.php';
	use \Parser\Parser\Parser;
	session_start();
	// Проверка на AJAX-запрос
	try {
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
			throw new \Exception("Bad request!");
		} else if($_POST['success'] == true) {
			// Выполнение парсинга
			$parser = new Parser();
			echo $parser->parseData($_POST);
		}
	} catch (\Exception $e) {
		echo "Error occured: " . $e->getMessage() . "<br>";
		die;
	}
	
?>