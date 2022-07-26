<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require __DIR__ . '/vendor/autoload.php';

session_start();
if(isset($_SESSION['hasFilteredData'])) {
	include "src/html/parseReady.php"; 
}
else {
	include "src/html/main.php";
}