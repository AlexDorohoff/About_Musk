<?php

require_once("include/common.inc.php");

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if ($login == '') {
        echo json_encode("login" . $login);
        unset($login);
    }
} //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if ($password == '') {
        echo json_encode($password);
        unset($password);
    }
}
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{

   $info = "Вы ввели не всю информацию, вернитесь назад и заполните все поля!";
    echo json_encode($info);
   exit;
}
//если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);
// подключаемся к базе
//include("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь
// проверка на существование пользователя с таким же логином

$result = dbQueryResult("SELECT id FROM users WHERE login='$login'");
$myrow = mysqli_fetch_array($result);
if (!empty($myrow['id'])) {
    $info = "Извините, введённый вами логин уже зарегистрирован. Введите другой логин.";
    //echo json_encode($info);
} else {
// если такого нет, то сохраняем данные
    $query = "INSERT INTO users (login,password) VALUES('$login','$password')";

    $result2=dbQuery($query);
// Проверяем, есть ли ошибки
    if ($result2 == 'TRUE') {
        $info = "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. ";
       // echo json_encode($info);
    } else {
        $info = "Ошибка! Вы не зарегистрированы.";
       // echo json_encode($info);
    }
}
$info = array($info);
$info = array('inf' => $info);

echo json_encode($info);