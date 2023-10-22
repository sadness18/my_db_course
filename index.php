<?php require_once 'include/database.php';
require_once 'include/functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Базы данных</title>
	<meta http-equiv = "Content-Type" content = "text/html; charset = UTF-8" />
	<link rel = "stylesheet" type = "text/css" href = "style.css" />
</head>
<body>
	<pre>

	████──████─███─████─████──████─███─███
	█──██─█──█──█──█──█─█──██─█──█─█───█
	█──██─████──█──████─████──████─███─███
	█──██─█──█──█──█──█─█──██─█──█───█─█
	████──█──█──█──█──█─████──█──█─███─███
	</pre>
	<div class = "bor"> <!-- block top menu -->
		<a href = "index.php">
			<div class = "menu_in">На главную</div>
		</a>
		<a href = "corr.php">
			<div class = "menu">Корректировка данных</div>
		</a>
		<a href = "select.php">
			<div class = "menu">Запрос</div>
		</a>
	</div>

	<div class = "example">
		Курсовую работу <br />
		по дисциплине: "Базы данных" <br />
		выполнил студент ФТИ, группы 21317 <br />
		Петров Даниил С. <br />
		Преподаватель: Виталий Борисович П.
	</div>
	<?php if (mysqli_errno($link) != 0){echo 'Ошибка SQL ('.mysqli_errno($link).'): '.mysqli_error($link);} ?>

</body>
</html>
