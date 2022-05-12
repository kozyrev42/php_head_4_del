<meta charset="UTF-8">

<!-- сценарий для удаления записей из БД средством type="checkbox"  -->
<?php
  $host = '127.0.0.1';    // адрес сервера БД
  $user = 'root';         // пользователь БД
  $password = '';         // пароль > пустая строка
  $db_name = 'my_php';    // имя БД
?>

<?php /* асинхронный сценарий */
  if (isset($_POST['submit'])) {      // если с $_POST прилетают данные, выполняем блок{}
    $dbConnect = mysqli_connect($host, $user, $password, $db_name)
      or die('Ошибка соединения с Сервером');

    // циклом foreach обрабатываем данные массива "list_delete" - который прилетит из input'a 
    // цикл в каждой итерации назначает переменной $element_mas последовательно новое значение из массива
    // циклом быстро удаляем нужное количество записей в базе данных 
    foreach ($_POST['list_delete'] as $element_mas) {     
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
      or die('Ошибка при выполнении запроса к БД');    //  mysqli_query - принимает 2 аругумента:

    // циклом рендерим записи из таблицы
    // около каждой Записи таблицы, создаем привязанный к ней чекбокс
    while ($rowww = mysqli_fetch_array($result)) {
      $id = $rowww['id'];
      $first_name = $rowww['first_name'];
      $last_name = $rowww['last_name'];
      $email = $rowww['email']; 
      
      // при добавлении в input атрибута name="list_delete[]" > в глабальном $_POST создаётся массив 'list_delete'
      // при активации чекбокса значение атрибута value="" помещается в массив "list_delete"
      // массив "list_delete[]" получит от каждого отрисованного чекбокса >> id каждой записи, отрисованной циклом
      // в массив записывается только выбранные id (по средствам чекбокса)
      echo '<input type="checkbox" value="'. $id .'" name="list_delete[]"/>' ;   /* рендер чекбокса */
      echo ' - ';                                                                
      echo $first_name . ' ' . $last_name . ' ' . $email . '<br/>';   /* рендер данных */
    };
    mysqli_close($dbConnect);
  ?>

  <input name="submit" type="submit" value="Удалить запись" />
</form>