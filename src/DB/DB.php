<?php

	namespace Parser\DB;

	class DB {
		private static $link;
		private static DB $db;
		private function __construct(string $host, string $user, string $pass, string $name) {
			try {
				self::$link = mysqli_connect($host, $user, $pass, $name);
				if(!self::$link) {
					throw new \Exception("Cannot access to database!");
				}
				mysqli_query(self::$link, "SET NAMES 'utf8'");
			} catch (\Exception $e) {
				echo "Error occured: " . $e->getMessage() . "<br>";
			}
			
		}
		public static function createDB(string $host, string $user, string $pass, string $name) : DB {
			if (!isset(self::$db)) {
				self::$db = new DB($host, $user, $pass, $name);
			}
			return self::$db;
		}
		
		public function insertData(array $arrData) {
			try {
				if(!isset(self::$link)) {
					throw new \Exception("Cannot access to database!");
				} else {
					$result = mysqli_query(self::$link, "SHOW TABLES LIKE 'parse_data';");
					$sqlRow = mysqli_fetch_assoc($result);
					if (empty($sqlRow)) {
						$this->createTable();
					}
					foreach($arrData as $row) {
						
						$result = mysqli_query(self::$link, "INSERT INTO 
						`parser`.`parse_data` (`article`, `name`, `price`, `remains`) VALUES
						('" . $row[0] . "', '" . $row[1] . "', '" . $row[2] . "', '" . $row[3] . "');")
						or die(mysqli_error(self::$link));
						
					}
				}
			} catch (\Exception $e) {
				echo "Error occured: " . $e->getMessage() . "<br>";
			}
		}
		private function createTable() {
			try {
				if(!isset(self::$link)) {
					throw new \Exception("Cannot access to database!");
				} else {
					try {
						$result = mysqli_query(self::$link, "CREATE TABLE `parser`.`parse_data` ( 
							`id` INT NOT NULL AUTO_INCREMENT ,
							`article` VARCHAR(25) NOT NULL , 
							`name` VARCHAR(100) NULL , 
							`price` VARCHAR(11) NULL , 
							`remains` VARCHAR(11) NULL , 
							PRIMARY KEY (`id`)) ENGINE = InnoDB;"
						);
						if (!$result) {
							throw new \Exception(mysqli_error(self::$link));
						}
					} catch (\Exception $e) {
						echo "Error occured: " . $e->getMessage() . "<br>";
					}
				}
			} catch (\Exception $e) {
				echo "Error occured: " . $e->getMessage() . "<br>";
			}
		}
	}
?>
