<?php
  /*$db_user = 'std-39';
  $db_pass = 'dssp5481';
  $link = mssql_connect('sql-206', 'std-39', 'dssp5481');
  mssql_select_db('std-39', $link);*/

  $link = mysqli_connect('localhost', 'root', '', 'my_db_course');

  if (mysqli_connect_errno())
  {
    echo 'Ошибка в подключении к базе данных ('.mysqli_connect_errno().'): '.mysqli_connect_error();
    exit;
  }
/*
    #изменение набора символов на utf8
  if (!mysqli_set_charset($link, "utf8")) {
      #printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($link));
      exit();
  } else {
      #printf("Текущий набор символов: %s\n", mysqli_character_set_name($link));
  }*/
?>
