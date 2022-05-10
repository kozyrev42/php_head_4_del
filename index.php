<meta charset="UTF-8">

<?php
   $host = '127.0.0.1';    // адрес сервера БД
   $user = 'root';         // пользователь БД
   $password = '';         // пароль > пустая строка
   $db_name = 'my_php';    // имя БД
?>

<?php
   if (isset($_POST['submit'])) {      // если с $_POST прилетают данные, выполняем блок{}
      $dbConnect = mysqli_connect($host, $user, $password, $db_name)
      or die('Ошибка соединения с Сервером');

      // циклом foreach обрабатываем данные массива "list_delete" - который прилетит из input'a 
      foreach ($_POST['list_delete'] as $element_mas) {     // цикл в каждой итерации назначает переменной $element_mas последовательно новое значение из массива
         $query_del = "DELETE FROM email_list WHERE id='$element_mas'";
         mysqli_query($dbConnect, $query_del);
      }

      mysqli_close($dbConnect);
   };
?>



<h3> Установите чекбокс для выбора удаляемой записи </h3>



<form method="post" action="index.php">

<?php

   $dbConnect = mysqli_connect($host, $user, $password, $db_name)
      or die('Ошибка соединения с Сервером');

   $query = "SELECT * FROM email_list";

   $result = mysqli_query($dbConnect, $query)         //  в переменную сохраняется результат вызова функции (результат запроса $query)
      or die('Ошибка при выполнении запроса к БД')    //  mysqli_query - принимает 2 аругумента:
   ;

   while ($rowww = mysqli_fetch_array($result)) {
      $id = $rowww['id'];
      $first_name = $rowww['first_name'];
      $last_name = $rowww['last_name'];
      $email = $rowww['email']; 

      echo '<input type="checkbox" value="'. $id .'" name="list_delete[]"/>' ; // массив "list_delete[]" получит от каждого отрисованного чекбокса > id каждой записи отрисованной циклом
      echo $first_name . ' ' . $last_name . ' ' . $email . '<br/>';
   };
   mysqli_close($dbConnect);
?>

<input name="submit" type="submit" value="Удалить запись" />


</form>