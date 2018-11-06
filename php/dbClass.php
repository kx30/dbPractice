<?php

/*
	Создание класса подключения к базе данных
*/
class DBConnection
{
	protected $conn; //поле класса, которые создано для хранения подключения к MySQL

	protected $defaults = [ //ассоциативный массив параметров используемых при настройке подключения к БД
		'host' => 'localhost', //на локальном сервере адрес хоста - localhost
		'user' => 'root', //пользователь в БД (root по умолчанию)
		'pass' => '', //пароль пользователя БД (по умолчанию у root'a не установлен)
		'db' => 'test', //название вашей БД в phpMyAdmin (MySQL)
		'charset' => 'utf8', //используемая в БД кодировка символом
	];

	const FETCH_MODE = MYSQLI_ASSOC; //константа, которая хранит вид массива, в который попадут данные из результата запроса к MySQL

	public function __construct() //конструктор класса, вызывается при создании экземпляра класса
	{
		$opt = [];
		$opt = array_merge($this->defaults, $opt); //опции записанные в поле класса defaults записываются в $opt для удобства работы
		$this->conn = new mysqli($opt['host'], $opt['user'], $opt['pass'], $opt['db']); //в поле класса $conn записывается подключение к БД и хранится там
		if (!$this->conn) exit('Lost DB connection'); //если подключение false, то происходит выход из скрипта с ошибкой
		$this->conn->set_charset($opt['charset']); //подключению задаётся определённая нами кодировка для избежания ошибок при работе с данными, которые записываем и получаем из БД
	}

	public function makeUnpreparedQuery($myQuery) //функция, которая позволяет выполнить неподготовленный запрос, на вход принимает обычный SQL-запрос
	{
		$q=$this->conn->query($myQuery); //обращаемся к нащему подключению к БД и вызываем query(), который выполняет запрос и возвращает результирующий набор полученный от БД, который дальше надо обработать, если в запросе ошибка, то вернёт false
		if($q) return $q;
		else return null;
	}

	/*
		Данная функция собирает и выполняет подготовленный запрос (http://php.net/manual/ru/mysqli.quickstart.prepared-statements.php) в зависимости от типа операции (INSERT, UPDATE, DELETE)
		Принимает на вход таблицу, тип операции, id строки с которой производятся манипуляции, типы значений в виде строки (напр. "sssi"), поля таблицы и значения этих полей
		первые два параметра являются обязательными, остальные являются параметрами по умолчанию (http://php.net/manual/ru/functions.arguments.php), по умолчанию во всех параметрах по умолчанию пустая строка
	*/
	public function makePreparedQuery($table, $operationType, $rowId = "", $valuesTypes = "", $fields = "", $values = "")
	{
		// $placeholders = []; //создаём массив, где будем хранить знаки вопроса, количество которых зависит от количества полей (смотрите статью про то, как выглядит подготовленный запрос)
		// for ($i=0; $i < sizeof($fields); $i++) //цикл для записи знаков вопроса в $placeholders
		// { 
		// 	array_push($placeholders, '?');
		// }
		// $impPlaceholders = implode(",", $placeholders); //формируем строку из знаков вопроса разделённых запятой
		// $impFields = implode(",", $fields); //формируем строку из полей разделённых запятой
		// $impValues = implode(",", $placeholders); //формируем строку из значений полей разделённых запятой
		// // далее в зависимост ) {
		if ($operationType == 'insert' && $table == 'pharmacy'){
				$query = "INSERT INTO `pharmacy`(`id_pharmacy`, `title`, `average_rating_by_pharmacy`, `search_by_pharmacy`) VALUES (NULL, '$values[1]', '$values[2]', 'NULL')";
				$stmt = $this->conn->prepare($query); //подготавливается запроc
				$stmt->execute();
		} else if ($operationType == 'insert' && $table == "medicine") {
			$query = "INSERT INTO `medicine`(`id_medicine`, `title`, `cost`, `available_in_warehouse`, `amount`, `average_rating_by_medicine`, `search_by_medicine`) 
			VALUES (NULL, '$values[1]', '$values[2]', '$values[3]', '$values[4]', '$values[5]', 'NULL')";
				$stmt = $this->conn->prepare($query); //подготавливается запроc
				$stmt->execute();
		}

		if ($operationType == 'update' && $table == 'pharmacy') {

			$arr = json_decode($values, true);

			var_dump($arr);

			$id = $arr[0];
			$title = $arr[1];
			$rating = $arr[2];
			var_dump('Id: '.$id);
			var_dump('Title: '.$title);
			var_dump('Rating: '.$rating);


			$query = "UPDATE `pharmacy` SET `id_pharmacy`='$id',`title`='$title',`average_rating_by_pharmacy`='$rating',`search_by_pharmacy`='NULL' WHERE `id_pharmacy`= '$rowId'";
			$stmt = $this->conn->prepare($query); //запрос подготавливается после того, как был сформирован
			$stmt->execute();
		} else if ($operationType == 'update' && $table == 'medicine') {
			$arr = json_decode($values, true);

			var_dump($arr);

			$id = $arr[0];
			$title = $arr[1];
			$cost = $arr[2];
			$available = $arr[3];
			$amount = $arr[4];
			$rating = $arr[5];
			var_dump('Id: '.$id);
			var_dump('Title: '.$title);
			var_dump('Rating: '.$rating);


			$query = "UPDATE `medicine` SET `id_medicine`='$id',`title`='$title',`cost`='$cost',`available_in_warehouse`='$available', `amount`='$amount', 
			`average_rating_by_medicine`='$average_rating_by_medicine', `search_by_medicine`='NULL' WHERE `id_medicine`='$rowId'";
			$stmt = $this->conn->prepare($query); //запрос подготавливается после того, как был сформирован
			$stmt->execute();
		}

		if ($operationType == 'delete' && $table == 'pharmacy') { 
			$stmt = $this->conn->query("DELETE FROM `pharmacy` WHERE `id_pharmacy` = '$rowId'");
			$stmt->execute();
		} else if ($operationType == 'delete' && $table == 'medicine') {
			$stmt = $this->conn->query("DELETE FROM `medicine` WHERE `id_medicine` = '$rowId'");
			$stmt->execute();
		}
		// $stmt->bind_param($valuesTypes, ...$values); //bind_param привязывает значения полей к параметрам подготавливаемого запроса
		// $stmt->execute(); //запрос выполняется
	}
	
	public function fetch($result) //данная функция позволяет преобразовать результат полученный из MySQL в ассоциативный массив, принимает на вход результат запроса к MySQL
	{
		return mysqli_fetch_all($result, $mode = self::FETCH_MODE);
	}
}
