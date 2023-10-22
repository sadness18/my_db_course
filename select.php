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
  		<div class = "menu_in">Запрос</div>
  	</a>
		<a href = "proc.php">
	    <div class = "btn">Премии (хранимая процедура)</div>
	  </a>
  </div>

  <!------------------------------->

	<div class = "left_select"> <!-- Блок вывода сотрудников и рабочего графика -->
		<?php for($i = 0; $i < $count[0][cnt]; $i++) { ?>
		<div class = "sel_1">
			<img src = "data:image/jpeg;base64, <?php echo $show_img[$i]; ?>" alt = "" style = "width: 118px; height: 157px; float: left; margin-right: 10px; border: 1px solid black;" />
			<?php
				$num = $i + 1;
				echo "<strong>$num. ".$data[$i][lname]." ".$data[$i][fname]."</strong><br /><br />";
				echo "Зарплата: ".$data[$i][money]." руб./день <br />";
				echo "Должность: ".$data[$i][position]."<br />";
				echo "Возраст: ".$data[$i][age]."<br />";
				echo "Телефон: ".$data[$i][workphone];
			?>
		</div>
		<div class = "sel_2">
			<?php
				echo "<strong>График смен</strong><br /><br />";
				for($j = 0; $j < $count_graf[0][cnt]; $j++)
				{
					if($graf[$j][lname] == $data[$i][lname] && $graf[$j][fname] == $data[$i][fname])
					{
						echo $graf[$j][day]."<br />";
					}
				}
			?>
		</div>
		<?php } ?>
	</div>

	<div class = "right_select"> <!-- Блок вывода истории заказов -->
		<?php for($i = 0; $i < $order_count[0][cnt]; $i++)
			{
				$num = $i + 1;
				echo "<strong>$num. ".$order[$i][order_date]."</strong><br />";
				echo "Сумма: ".$order[$i][summa]." руб.<br />";
				echo "Обслуживал: ".$order[$i][lname]." ".$order[$i][fname]."<br /><br />";
			}
		?>
	</div>
</body>
</html>
