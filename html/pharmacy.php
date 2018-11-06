<?php
	require_once '../php/dbClass.php'; //подключаем файл с классом подключения к БД
	$connect = new DBConnection(); //создаём экземпляр класса подключения к БД
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Administration panel</title>

	<!-- Your custom styles (optional) -->
  <link href="../css/style.css" rel="stylesheet">
    <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="../css/mdb.min.css" rel="stylesheet">
  
</head>
		
<body class="grey lighten-2">

		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		 <div class="col-md-9">
		 	 <a class="navbar-brand" href="#">Administration panel</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		 </div>

		<div class="collapse navbar-collapse " id="navbarNavAltMarkup">
		    <div class="navbar-nav">
		      <a class="nav-item nav-link" href="medicine.php">Medicine</a>
		      <a class="nav-item nav-link active" href="#">Pharmacy</a>
		    </div>
		</div>
	</nav>

	<div class="shown-container">
		<div class="main-container container card mt-4 p-3">
			<div class="row">
				<div class="col-10">					
					<div  class="row p-2" >
						<div class="col-1 ml-2">ID</div>
						<div class="col-2 ml-2">Title</div>
						<div class="col-2 ml-2">Rating</div>
					</div>
				</div>
				<div class="col-2">
					<button id="addButton" type="button" class="btn-sm btn-primary center-block">
						<i class="fa fa-plus"></i>
					</button>
				</div>
			</div>

			<!-- <div class="row pt-3 input-container"> 
				 <div class="col-10">
					<input class="item col-1 ml-2" type="text" placeholder="ID" value='{$data[$i]['id_pharmacy']}'>
					<input class="item col-2 ml-2" type="text" placeholder="Title" value='{$data[$i]['title']}'>
					<input class="item col-2 ml-2" type="text" placeholder="Rating" value='{$data[$i]['average_rating_by_pharmacy']}>
				</div>
				<div class="col-1">
					<button id="editButton" type="button" class="btn-sm btn-primary">
						<i class="fa fa-edit"></i>
						<i class="fa fa-check"></i>
					</button>
				</div>
				<div class="col-1 meow">
					<button id="deleteButton" type="button" class="btn-sm btn-primary">
						<i class="fa fa-trash"></i>
						<i class="fa fa-close"></i>
					</button>
				</div> -->

				<?php
                  $query = "SELECT * FROM pharmacy"; //записываем запрос на выборку данных
                  $queryResult = $connect->makeUnpreparedQuery($query); //выполняем запрос записываем ответ MySQL в $queryResult
                  $data = $connect->fetch($queryResult); //данные полученные из MySQL преабоазовываем в ассоциативный массив
                  for($i = 0, $count = sizeof($data); $i < $count; $i++) // выводим данные в виде строк HTML-таблицы 
                  {
                  	echo "
                  	<div class='row pt-3 input-container'> 
	                  	<div class='col-10'>
							<input class='item col-1 ml-2 id_input' type='text' placeholder='ID' value='{$data[$i]['id_pharmacy']}'>
							<input class='item col-2 ml-2' type='text' placeholder='Title' value='{$data[$i]['title']}'>
							<input class='item col-2 ml-2' type='text' placeholder='Rating' value='{$data[$i]['average_rating_by_pharmacy']}'>
						</div>
						<div class='col-1'>
							<button id='editButton' type='button' class='btn-sm btn-primary'>
								<i class='fa fa-edit'></i>
								<i class='fa fa-check'></i>
							</button>
						</div>
						<div class='col-1'>
							<button id='deleteButton' type='button' class='btn-sm btn-primary'>
								<i class='fa fa-trash'></i>
								<i class='fa fa-close'></i>
							</button>
						</div>
					</div>
                  	";                  
                  }
                 ?>

			</div>
		</div>
	</div>

	<div class="hidden-container p-5">
		<form>
		<div class="form-group">
			<input type="number" class="form-control" placeholder="ID">
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Title">
		</div>
		<div class="form-group">
			<input type="number" class="form-control" placeholder="Rating">
		</div>
		<div class="row">
			<div class="col-8"></div>
			<div class="col-2">
				<button id="acceptButton" type="button" class="btn btn-primary">Accept</button>
			</div>
			<div class="col-2">
				<button id="cancelButton" type="button" class="btn btn-primary">Cancel</button>
			</div>
		</div>
		</form>
	</div>


   <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/mdb.min.js"></script> 

  <script type="text/javascript" src="../js/pharmacy/script.js"></script>
</body>
</html>