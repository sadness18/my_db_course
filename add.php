<?php
	require_once 'include/database.php';
	require_once 'include/functions.php';
  $data = get_all($link);
	$show_img = get_photo($link);
	$count = get_count_personal($link);
	$chk = korr($link, $count, $data);
  $waiters = get_waiters($link);
  $chk_add = add_people($link, $data);
  $chk_sum = add_order($link);
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

  <div style = "text-align: center; font-size: 1.5em;"><strong>Добавление записей</strong></div>

  <div class = "left_select"> <!-- Поле добавления сотрудника -->
    <div style = "text-align: center; font-size: 1.3em;"><strong>Добавление сотрудника</strong></div><br />
    <form name = "add_people" id = "add_people" action = "add.php" method = "post" enctype = "multipart/form-data">
      <div style = "float: left;">
        <div style = "float: left; margin-right: 10px;">
          <lable for = "lname">Фамилия: </label><br /><input type = "text" maxlength = "30" name = "lname" id = "lname" placeholder = "Фамилия" style = "font-size: 0.9em; width: 140px;" /><br />
        </div>
        <lable for = "fname">Имя: </label><br /><input type = "text" maxlength = "30" name = "fname" id = "fname" placeholder = "Имя" style = "font-size: 0.9em; width: 140px;" /><br /><br />
        <div style = "float: left; margin-right: 10px;">
          <lable for = "money">Зарплата: </label><br /><input type = "text" maxlength = "11" name = "money" id = "money" placeholder = "Руб./день" style = "font-size: 0.9em; width: 140px;" /><br />
        </div>
        <lable for = "position">Должность: </label><br /><input type = "text" maxlength = "30" name = "position" id = "position" placeholder = "Должность" style = "font-size: 0.9em; width: 140px;" /><br /><br />
        <lable for = "age">Возраст: </label><input type = "text" maxlength = "11" name = "age" id = "age" style = "font-size: 0.9em; width: 70px;" /><br /><br />
        <lable for = "workphone">Телефон: </label><br /><input type = "text" maxlength = "11" name = "workphone" id = "workphone" placeholder = "7XXXXXXXXXX" style = "font-size: 0.9em; width: 140px;" /><br />
        <?php echo ("Загрузить фотографию: ") ?><input type = "file" name = "img" id = "img" style = "margin-top: 10px;" /><br /><br />
        <input type = "submit" name = "add_people_btn" id = "add_people_btn" value = "Добавить" style = "font-size: 1.0em;" /> <!-- кнопка добавления нового сотрудника в базу -->
      </div>
      <div>
        <div style = "font-size: 1.2em;"><strong>График смен</strong></div><br />
        <input type = "checkbox" name = "chkbox_1" id = "chkbox_1" /><label for = "mon">Понедельник</label><br />
        <input type = "checkbox" name = "chkbox_2" id = "chkbox_2" /><label for = "mon">Вторник</label><br />
        <input type = "checkbox" name = "chkbox_3" id = "chkbox_3" /><label for = "mon">Среда</label><br />
        <input type = "checkbox" name = "chkbox_4" id = "chkbox_4" /><label for = "mon">Четверг</label><br />
        <input type = "checkbox" name = "chkbox_5" id = "chkbox_5" /><label for = "mon">Пятница</label><br />
        <input type = "checkbox" name = "chkbox_6" id = "chkbox_6" /><label for = "mon">Суббота</label><br />
        <input type = "checkbox" name = "chkbox_7" id = "chkbox_7" /><label for = "mon">Воскресенье</label>
      </div>
    </form>
    <div style = "color: red;">
      <?php
        if (isset($_POST['add_people_btn']))
        {
          if ($chk_add == false)
          {
            echo ("Ошибка! Одно или несколько полей не заполнены!");
						if (mysqli_errno($link) != 0){echo 'Ошибка SQL ('.mysqli_errno($link).'): '.mysqli_error($link);}
          }
          else
          {
            echo ("Данные успешно добавлены!");
          }
        }
      ?>
    </div>
  </div>

  <div class = "right_select"> <!-- Поле добавления записи в историю заказов -->
    <div style = "text-align: center; font-size: 1.3em;"><strong>Добавление заказа</strong></div><br />
    <?php echo ("Сегодня: ").date("d.m.Y").(" Время: ").date("H:i:s"); ?>
    <form name = "add_order" id = "add_order" action = "add.php" method = "post">
      <br />
      <label for = "summa">Сумма: </label><input type = "text" maxlength = "11" name = "summa" id = "summa" placeholder = "денежки :D" style = "font-size: 0.9em; width: 140px;" /><?php echo (" руб.<br /><br />"); ?>
      <?php echo ("Обслуживал: ") ?>
      <select name = "select_waiter" id = "select_waiter" form = "add_order">
        <?php
          $j = 0;
          while ($waiters[$j][lname] != "")
          {
            $num = $j + 1;
            $val = $waiters[$j][id_personal];
            echo ("<option value = \"$val\">$num. ".$waiters[$j][lname]." ".$waiters[$j][fname]."</option>");
            $j++;
          }
        ?>
      </select><br /><br />
      <input type = "submit" name = "add_order_btn" id = "add_order_btn" value = "Добавить" style = "font-size: 1.0em;" /> <!-- кнопка добавления нового заказа в базу -->
    </form>
    <div style = "color: red;">
      <?php
        if (isset($_POST['add_order_btn']))
        {
          if ($chk_sum == false)
          {
            echo ("Ошибка! Одно или несколько полей не заполнены!");
          }
          else
          {
            echo ("Данные успешно добавлены!");
          }
        }
      ?>
    </div>
  </div>
</body>
</html>
