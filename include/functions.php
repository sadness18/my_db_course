<?php
  function get_all($link) #запись всех значений таблицы personal в массив data
  {
    $sql = "SELECT * FROM personal";

    $result = mysqli_query($link, $sql);

    $data = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $data[] = $row;
    }
    return $data;
  }

  function get_photo($link) #запись всех фото из таблицы personal в массив show_img
  {
    $sql = "SELECT photo FROM personal";
    $result = mysqli_query($link, $sql);

    $show_img = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $show_img[] = base64_encode($row['photo']);# base64_decode($row['photo']);
      #mb_detect_encoding($row, mb_detect_order(), true) === 'UTF-8' ? $row : mb_convert_encoding($row, 'UTF-8');
    }
    return $show_img;
  }

  function get_count_personal($link) #подсчет количества записей в таблице personal и запись его в переменную count
  {
    $sql = "SELECT COUNT(id_personal) AS cnt FROM personal";
    $result = mysqli_query($link, $sql);

    $count = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $count[] = $row;
    }
    return $count;
  }

  function search($link) #обработка кнопки "поиск" (корректировка)
  {
    if (isset($_POST['btn_search']))
    {
      $chksrch = true;
      $ln = $_POST['lname_s'];
      $fn = $_POST['fname_s'];

      if (!empty($ln))
      {
        if (!empty($fn))
        {
          $sql = "SELECT * FROM personal WHERE lname = ('$ln') AND fname = ('$fn')";
          $result = mysqli_query($link, $sql);
        }
        else
        {
          $sql = "SELECT * FROM personal WHERE lname = ('$ln')";
          $result = mysqli_query($link, $sql);
        }
      }
      else
      {
        if(!empty($fn))
        {
          $sql = "SELECT * FROM personal WHERE fname = ('$fn')";
          $result = mysqli_query($link, $sql);
        }
      }

      $data = array();
      while($row = mysqli_fetch_assoc($result))
      {
        $data[] = $row;
      }
      return $data;
    }
  }

  function count_search($link) #подсчет кол-ва записей при поиске (корректировка)
  {
    if (isset($_POST['btn_search']))
    {
      $chksrch = true;
      $ln = $_POST['lname_s'];
      $fn = $_POST['fname_s'];

      if (!empty($ln))
      {
        if (!empty($fn))
        {
          $sql = "SELECT COUNT(id_personal) AS cnt FROM personal WHERE lname = ('$ln') AND fname = ('$fn')";
          $result = mysqli_query($link, $sql);
        }
        else
        {
          $sql = "SELECT COUNT(id_personal) AS cnt FROM personal WHERE lname = ('$ln')";
          $result = mysqli_query($link, $sql);
        }
      }
      else
      {
        if(!empty($fn))
        {
          $sql = "SELECT COUNT(id_personal) AS cnt FROM personal WHERE fname = ('$fn')";
          $result = mysqli_query($link, $sql);
        }
      }

      $count = array();
      while($row = mysqli_fetch_assoc($result))
      {
        $count[] = $row;
      }
      return $count;
    }
  }

  $data = get_all($link);
	$show_img = get_photo($link);
  if ($chksrch = true)
  {
    $count = count_search($link);
  }
  else
  {
    $count = get_count_personal($link);
  }

  function korr($link, $count, $data) #обработка кнопки "Применить" (корректировка)
  {
    if (isset($_POST['upload']))
    {
      for ($i = 0; $i < $count[0][cnt]; $i++)
      {
        if (!empty($_POST["lname_$i"]) && !empty($_POST["fname_$i"]) && !empty($_POST["money_$i"]) && !empty($_POST["position_$i"]) && !empty($_POST["age_$i"]) && !empty($_POST["workphone_$i"]))
        {
          $chk = true;
          continue;
        }
        else
        {
          $chk = false;
          break;
        }
      }

      if ($chk == true)
      {
        for ($i = 0; $i < $count[0][cnt]; $i++)
        {
          $schet = $data[$i][id_personal];

          $lname = $_POST["lname_$i"];
          $sql = "UPDATE personal SET lname = ('$lname') WHERE id_personal = ('$schet')";
          $result = mysqli_query($link, $sql);

          $fname = $_POST["fname_$i"];
          $sql = "UPDATE personal SET fname = ('$fname') WHERE id_personal = ('$schet')";
          $result = mysqli_query($link, $sql);

          $money = $_POST["money_$i"];
          $sql = "UPDATE personal SET money = ('$money') WHERE id_personal = ('$schet')";
          $result = mysqli_query($link, $sql);

          $position = $_POST["position_$i"];
          $sql = "UPDATE personal SET position = ('$position') WHERE id_personal = ('$schet')";
          $result = mysqli_query($link, $sql);

          $age = $_POST["age_$i"];
          $sql = "UPDATE personal SET age = ('$age') WHERE id_personal = ('$schet')";
          $result = mysqli_query($link, $sql);

          $workphone = $_POST["workphone_$i"];
          $sql = "UPDATE personal SET workphone = ('$workphone') WHERE id_personal = ('$schet')";
          $result = mysqli_query($link, $sql);

          if(!empty($_FILES["img_$i"]['tmp_name']))
          {
            $img = addslashes(file_get_contents($_FILES["img_$i"]['tmp_name']));
            $sql = "UPDATE personal SET photo = ('$img') WHERE id_personal = ('$schet')";
            $result = mysqli_query($link, $sql);
          }
        }
        $chksrch = false;
      }
    }

    return $chk;
  }

  $count = get_count_personal($link);
  $data = get_all($link);

  function get_day_of_work($link, $count, $data) #Получение всего графика работы
  {
    $sql = "SELECT lname, fname, day FROM
            personal INNER JOIN personal_day_of_work ON
            personal.id_personal = personal_day_of_work.id_personal INNER JOIN day_of_work ON
            personal_day_of_work.id_day = day_of_work.id_day ORDER BY personal_day_of_work.id_personal";

    $result = mysqli_query($link, $sql);

    $graf = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $graf[] = $row;
    }
    return $graf;
  }

  function get_count_personal_day_of_work($link) #подсчет количества записей в таблице personal_day_of_work и запись его в массив count_graf
  {
    $sql = "SELECT COUNT(lname) AS cnt FROM
            personal INNER JOIN personal_day_of_work ON
            personal.id_personal = personal_day_of_work.id_personal INNER JOIN day_of_work ON
            personal_day_of_work.id_day = day_of_work.id_day";
    $result = mysqli_query($link, $sql);

    $count_graf = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $count_graf[] = $row;
    }
    return $count_graf;
  }

  function get_order_history($link) #получение всей истории заказов и запись ее в массив order
  {
    $sql = "SELECT order_date, summa, lname, fname FROM personal INNER JOIN order_history ON personal.id_personal = order_history.id_personal";

    $result = mysqli_query($link, $sql);

    $order = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $order[] = $row;
    }
    return $order;
  }

  function count_order_history($link) #получение количества заказов и запись его в массив order
  {
    $sql = "SELECT COUNT(id_order) AS cnt FROM order_history;";

    $result = mysqli_query($link, $sql);

    $order_count = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $order_count[] = $row;
    }
    return $order_count;
  }

  function get_prize_inf($link, $count, $data) #Вызов хранимой процедуры
  {
    if (isset($_POST['prc_btn'])) #Если нажата кнопка Применить в Премии (процедура)
    {
      $number = $_POST["select_personal"]; //отлавливаем номер выбранного сотрудника
      for($i = 0; $i < $count[0][cnt]; $i++)
      {
        if($i == $number)
        {
          $ln = $data[$i][lname]; //присваиваем переменной ln значение фамилии сотрудника под выбранным номером
          $fn = $data[$i][fname]; //присваиваем переменной fn значение имени сотрудника под выбранным номером
        }
      }
    }
    $sql = "CALL prc ('$ln', '$fn');"; //непосредственный вызов хранимой процедуры с передачей ей параметров (переменных) ln и fn, объявленных ранее

    $result = mysqli_query($link, $sql);

    $prc_mass = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $prc_mass[] = $row;
    }
    return $prc_mass;
  }

  function get_waiters($link) #запись всех официантов в массив waiters
  {
    $sql = "SELECT id_personal, lname, fname, position FROM personal WHERE position = ('Официант')";

    $result = mysqli_query($link, $sql);

    $waiters = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $waiters[] = $row;
    }
    return $waiters;
  }

  function add_people($link, $data) #Добавление нового пользователь в базу
  {
    if (isset($_POST['add_people_btn']))
    {
      if (!empty($_POST["lname"]) && !empty($_POST["fname"]) && !empty($_POST["money"]) && !empty($_POST["position"]) && !empty($_POST["age"]) && !empty($_POST["workphone"]))
      {
        $chk_add = true;
      }
      else
      {
        $chk_add = false;
      }

      if ($chk_add == true)
      {
        if(!empty($_FILES["img"]['tmp_name']))
        {
          $img = base64_encode(addslashes(file_get_contents($_FILES["img"]['tmp_name'])));
          $lname = $_POST["lname"];
          $fname = $_POST["fname"];
          $money = $_POST["money"];
          $position = $_POST["position"];
          $age = $_POST["age"];
          $workphone = $_POST["workphone"];
          $sql = "INSERT INTO personal VALUES (('$lname'), ('$fname'), ('$money'), ('$position'), ('$age'), ('$workphone'), ('$img'))";
          $result = mysqli_query($link, $sql);
        }
        else
        {
          $lname = $_POST["lname"];
          $fname = $_POST["fname"];
          $money = $_POST["money"];
          $position = $_POST["position"];
          $age = $_POST["age"];
          $workphone = $_POST["workphone"];
          $sql = "INSERT INTO personal VALUES (('$lname'), ('$fname'), ('$money'), ('$position'), ('$age'), ('$workphone'), NULL)";
          $result = mysqli_query($link, $sql);
        }

        $sql = "SELECT * FROM personal";

        $result = mysqli_query($link, $sql);

        $data = array();
        while($row = mysqli_fetch_assoc($result))
        {
          $data[] = $row;
        }
        $j = 0;
        while ($data[$j][lname] != "")
        {
          $id_gr = $data[$j][id_personal];
          $j++;
        }
        for ($i = 1; $i <= 7; $i++)
        {
          if ($_POST["chkbox_$i"] == "on")
          {
            $day = $i;
            $sql = "INSERT INTO personal_day_of_work VALUES (('$id_gr'), ('$day'))";
            $result = mysqli_query($link, $sql);
          }
        }
      }
    }
    return $chk_add;
  }

  function add_order($link) #функция добавления заказа в базу
  {
    if (isset($_POST['add_order_btn']))
    {
      $now = date("Y-m-d\TH:i:s");
      if (!empty($_POST["summa"]))
      {
        $chk_sum = true;
      }
      else
      {
        $chk_sum = false;
      }

      if ($chk_sum == true)
      {
        $summa = $_POST["summa"];
        $id = $_POST["select_waiter"];
        $sql = "INSERT INTO order_history VALUES (('$now'), ('$summa'), ('$id'))";
        $result = mysqli_query($link, $sql);
      }
    }
    return $chk_sum;
  }

  function del_people ($link, $data) #Функция удаления сотрудника
  {
    if (isset($_POST['del_btn']))
    {
      $number = $_POST["select_del"];
      $id_del = $data[$number][id_personal];

      $sql = "DELETE FROM personal_day_of_work WHERE id_personal = ('$id_del')";
      $result = mysqli_query($link, $sql);

      $sql = "DELETE FROM personal WHERE id_personal = ('$id_del')";
      $result = mysqli_query($link, $sql);
    }
    return $id_del;
  }

?>
