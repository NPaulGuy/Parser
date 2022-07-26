<?php
	require  __DIR__ . '/../../vendor/autoload.php';
	use \Parser\Loader\Loader;
	session_start();
	// Проверка на AJAX-запрос
	try {
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
			throw new \Exception("Bad request!");
		} else if($_POST['success'] == true) {
			// Выполнение загрузки
			$loader = new Loader();
			echo $loader->loadData($_SESSION['filteredData']);
		}
	} catch (\Exception $e) {
		echo "Error occured: " . $e->getMessage() . "<br>";
		die;
	}
?>