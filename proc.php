<?php
	require_once 'include/database.php';
	require_once 'include/functions.php';
  $data = get_all($link);
	$show_img = get_photo($link);
	$count = get_count_personal($link);
	$graf = get_day_of_work($link, $count, $data);
	$count_graf = get_count_personal_day_of_work($link);
	$order = get_order_history($link);
	$order_count = count_order_history($link);
  $prc_mass = get_prize_inf($link, $count, $data);
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
		<a href = "proc.php">
	    <div class = "btn">Премии (хранимая процедура)</div>
	  </a>
  </div>

  <!------------------------------->

  <div class = "example">
    <span style = "float: left;">Выберите сотрудника, чтобы увидеть в каких месяцах он получал премию: <?php echo " "; ?></span>

    <select name = "select_personal" id = "select_personal" form = "prc_form" style = "margin-left: 5px;">
      <?php
				for($i = 0; $i < $count[0][cnt]; $i++)
	        {
	  				$num = $i + 1;
	  				echo ("<option value = \"$i\">$num. ".$data[$i][lname]." ".$data[$i][fname]."</option>");
	        }
      ?>
    </select>

    <form name = "prc_form" id = "prc_form" action = "proc.php" method = "post" style = "float: right; margin-left: 10px;">
      <input type = "submit" name = "prc_btn" id = "prc_btn" value = "Применить" /> <!-- кнопка запроса данных о премии -->
    </form>

    <?php
	    if (isset($_POST['prc_btn'])) #Если нажата кнопка Применить в Премии (процедура)
	    {
	      echo ("<div style = \"float: left; clear: both; margin-top: 10px; margin-bottom: 10px; font-size: 1.3em;\">".$prc_mass[0][lname]." ".$prc_mass[0][fname]."</div>");
				//вывод имени и фамилии выбранного сотрудника
	      $j = 0;
	      while($prc_mass[$j][prize_date] != "")
	      {
	        echo ("<div style = \"float: left; clear: both\">".$prc_mass[$j][prize_date]." "); //вывод даты
	        if ($prc_mass[$j][prize] == 1)
	        {
	          echo ("Да"."</div><br />"); //"Да", если в данном месяце сотруднику назначена премия
	        }
	        else
	        {
	          echo ("Нет"."</div><br />"); //"Нет", если в данном месяце сотруднику не назначена премия
	        }
	        $j++;
	      }
	    }
    ?>
  </div>
</body>
</html>
