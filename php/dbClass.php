<?php

class DBConnection {
	protected $conn; //поле класса, которые создано для хранения подключения к MySQL
	protected $defaults = [ //ассоциативный массив параметров используемых при настройке подключения к БД
		'host' => 'localhost', //на локальном сервере адрес хоста - localhost
		'user' => 'root', //пользователь в БД (root по умолчанию)
		'pass' => '', //пароль пользователя БД (по умолчанию у root'a не установлен)
		'db' => 'test', //название вашей БД в phpMyAdmin (MySQL)
		'charset' => 'utf8', //используемая в БД кодировка символом
	];
	const FETCH_MODE = MYSQLI_ASSOC; //константа, которая хранит вид массива, в который попадут данные из результата запроса к MySQL
	public function __construct() { //конструктор класса, вызывается при создании экземпляра класса
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

	public function makePreparedQuery($table, $operationType, $rowId = "", $valuesTypes = "", $fields = "", $values = ""){
		@$idTable = $_POST['id_table'];
		$placeholders = []; //создаём массив, где будем хранить знаки вопроса, количество которых зависит от количества полей (смотрите статью про то, как выглядит подготовленный запрос)
		for ($i=0; $i < @sizeof($fields); $i++) //цикл для записи знаков вопроса в $placeholders
		{ 
			array_push($placeholders, '?');
		}
		@$impPlaceholders = implode(",", $placeholders); //формируем строку из знаков вопроса разделённых запятой
		@$impFields = implode(",", $fields); //формируем строку из полей разделённых запятой
		$impValues = implode(",", $placeholders); //формируем строку из значений полей разделённых запятой
		// далее в зависимости от типа операции выполняются определенные действия
		if ($operationType == 'insert')
		{
			$query = "INSERT INTO $table ($impFields) VALUES ($impPlaceholders)";
			$stmt = $this->conn->prepare($query); //подготавливается запроc
			var_dump($this->conn->error);
			//var_dump('Values: '.$values);	
			$stmt->bind_param($valuesTypes, ...$values);
		}
		if ($operationType == 'update')
		{
			$query = "UPDATE $table SET ";
			$valuesAssoc = array_combine($fields, $values);
			$valuesAssoc['id'] = $rowId; //создаётся ассоциативный массив вида поля => значения
			foreach ($valuesAssoc as $key => $value) {
				if ($key != 'id')
				{
					$query .= "$key=?,"; //формируется строка запроса
				}
			}
			$query = substr($query, 0, -1); //убирается лишняя запятая в конце
			$query .= " WHERE id_$table=?";
			array_push($values, $rowId); //добавляется условие определяющее какую строку мы обновляем
			$stmt = $this->conn->prepare($query); //запрос подготавливается после того, как был сформирован
			var_dump('QUERY: '.$query);
			var_dump($this->conn->error);
			$valuesTypes .= 'i';
			$stmt->bind_param($valuesTypes, ...$values);
		}
		if ($operationType == 'delete') {
			$query = "DELETE FROM $table WHERE `$idTable`='$rowId'";
			var_dump($idTable);
			$stmt = $this->conn->prepare($query);
		}
		 //bind_param привязывает значения полей к параметрам подготавливаемого запроса
		$stmt->execute(); //запрос выполняется
	}
	public function fetch($result) { //данная функция позволяет преобразовать результат полученный из MySQL в ассоциативный массив, принимает на вход результат запроса к MySQL
		return $result->fetch_all($mode = self::FETCH_MODE);
	}
}