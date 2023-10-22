<?php
	require_once 'include/database.php';
	require_once 'include/functions.php';
  $data = get_all($link);
	$show_img = get_photo($link);
	$count = get_count_personal($link);
	$chk = korr($link, $count, $data);
  $id_del = del_people ($link, $data);
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
  		<div class = "menu">Корректировка данных</div>
  	</a>
  	<a href = "select.php">
  		<div class = "menu">Запрос</div>
  	</a>
  </div>

  <!-------------------------------->

  <div style = "text-align: center; font-size: 1.5em;"><strong>Удаление записей</strong></div><br />
  <span style = "float: left; font-size: 1.1em;">Выберите сотрудника, данные о котором требуется удалить из базы: <?php echo " "; ?></span>

  <select name = "select_del" id = "select_del" form = "del_form" style = "float: left; margin-left: 5px; margin-top: 2px;">
    <?php
      for($i = 0; $i < $count[0][cnt]; $i++)
        {
          $num = $i + 1;
          echo ("<option value = \"$i\">$num. ".$data[$i][lname]." ".$data[$i][fname]."</option>");
        }
    ?>
  </select>

  <form name = "del_form" id = "del_form" action = "del.php" method = "post" style = "float: left; margin-left: 10px; margin-right: 10px;">
    <input type = "submit" name = "del_btn" id = "del_btn" value = "Удалить" style = "font-size: 1.0em;" /> <!-- кнопка удаления -->
  </form>

  <div style = "color: red;">
    <?php
      if (isset($_POST['del_btn'])) #Если нажата кнопка Удалить
      {
        echo ("Удаление выполненно успешно! ".$id_del);
				if (mysqli_errno($link) != 0){echo 'Ошибка SQL ('.mysqli_errno($link).'): '.mysqli_error($link);}
      }
    ?>
  </div>
</body>
</html>
