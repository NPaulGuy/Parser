<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \Parser\DB\DB;

//$db = DB::createDB('localhost', 'root','root','parser');

session_start();
if(isset($_SESSION['hasFilteredData'])) {
	include "src/html/parseReady.php"; 
}
else {
	include "src/html/main.php";
}