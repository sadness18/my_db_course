<?php
	require_once 'include/database.php';
	require_once 'include/functions.php';
  $data = get_all($link);
	$show_img = get_photo($link);
	$count = get_count_personal($link);
	$chk = korr($link, $count, $data);
?>
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
	<div class = "bor">
    <a href = "index.php">
  		<div class = "menu">На главную</div>
  	</a>
  	<a href = "corr.php">
  		<div class = "menu_in">Корректировка данных</div>
  	</a>
  	<a href = "select.php">
  		<div class = "menu">Запрос</div>
  	</a>
  </div>

  <!-------------------------------->

  <a href = "add.php">
    <div class = "btn">Добавить запись</div>
  </a>
  <a href = "del.php">
    <div class = "btn">Удалить запись</div>
  </a>
	<!-- <a href = "index.php">
    <div class = "btn">Премии</div>
  </a> -->

  <div class = "kor_1"> <!-- Блок поиска по фамилии и\или имени -->
    <form name = "kor1" action = "" method = "post">
			<?php echo "Введите фамилию и\или имя: " ?>
      <input type = "text" maxlength = "30" placeholder = "Фамилия" name = "lname_s" id = "lname_s" title = "Введите фамилию" />
      <input type = "text" maxlength = "30" placeholder = "Имя" name = "fname_s" id = "fname_s" title = "Введите имя" />
      <input type = "submit" value = "Поиск" name = "btn_search" id = "btn_search" />
			<?php
				if (isset($_POST['btn_search']))
				{
					$data = search($link);
					$count = count_search($link);
				}
			?>
    </form>
  </div>

	<form name = "kor2" id = "kor2" action = "corr.php" method = "post" enctype = "multipart/form-data">
		<div class = "main_kor"> <!-- Блок, отвечающий за вывод всех записей -->
			<?php for ($i = 0; $i < $count[0][cnt]; $i++) { ?>
				<div class = "kor_2">
					<?php $n = $i + 1; echo "$n. "; ?>
		      <label for = <?php echo "lname_$i"; ?>>Фамилия: </label><input type = "text" maxlength = "30" name = "<?php echo "lname_$i"; ?>" id = "<?php echo "lname_$i"; ?>" placeholder = "Фамилия" value = '<?php echo $data[$i][lname]; ?>' style = "font-size: 0.9em; width: 140px;" />
					<label for = "<?php echo "fname_$i"; ?>">Имя: </label><input type = "text" maxlength = "30" name = "<?php echo "fname_$i"; ?>" id = "<?php echo "fname_$i"; ?>" placeholder = "Имя" value = "<?php echo $data[$i][fname]; ?>" style = "font-size: 0.9em; width: 140px;" />
					<label for = "<?php echo "money_$i"; ?>">Руб./день: </label><input type = "text" maxlength = "11" name = "<?php echo "money_$i"; ?>" id = "<?php echo "money_$i"; ?>" placeholder = "Зарплата" value = "<?php echo $data[$i][money]; ?>" style = "font-size: 0.9em; width: 140px;"/>
					<label for = "<?php echo "position_$i"; ?>">Должность: </label><input type = "text" maxlength = "30" name = "<?php echo "position_$i"; ?>" id = "<?php echo "position_$i"; ?>" placeholder = "Должность" value = "<?php echo $data[$i][position]; ?>" style = "font-size: 0.9em; width: 140px;"/>
					<label for = "<?php echo "age_$i"; ?>">Возраст: </label><input type = "text" maxlength = "11" name = "<?php echo "age_$i"; ?>" id = "<?php echo "age_$i"; ?>" value = "<?php echo $data[$i][age]; ?>" style = "font-size: 0.9em; width: 40px;"/>
					<label for = "<?php echo "workphone_$i"; ?>">Тел.: </label><input type = "text" maxlength = "11" name = "<?php echo "workphone_$i"; ?>" id = "<?php echo "workphone_$i"; ?>" placeholder = "7XXXXXXXXXX" value = "<?php echo $data[$i][workphone]; ?>" style = "font-size: 0.9em; width: 140px;"/>
					<img src = "data:image/jpeg;base64, <?php echo $show_img[$i]; ?>" alt = "" style = "width: 118px; height: 157px; float: left; margin-right: 10px; border: 1px solid black;" />
					<input type = "file" name = "<?php echo "img_$i"; ?>" id = "<?php echo "img_$i"; ?>" style = "margin-top: 40px;" />
					<?php if (mysqli_errno($link) != 0){echo 'Ошибка SQL ('.mysqli_errno($link).'): '.mysqli_error($link);} ?>
				</div>
			<?php } ?>
		</div>
		<div class = "button_ok"> <!-- Блок, отвечающий за вывод кнопки и результатов обработки (успешно или нет) -->
			<?php
				if (isset($_POST['upload']))
				{
					if($chk == true)
					{
						echo "Данные успешно изменены!";
					}
					else
					{
						echo "Ошибка! Одно или несколько полей не заполнены!";
					}
				}
			?>
			<input type = "submit" name = "upload" id = "upload" value = "Применить" style = "font-size: 1.0em;" /> <!-- кнопка обработки корректировки данных -->
		</div>
  </form>

</body>
</html>
