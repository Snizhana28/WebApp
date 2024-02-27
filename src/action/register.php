<?php //це для реєстрації
//підключаємо файл з функціями валідації
require_once '../funcValidation.php';

//отримання даних з форми
//виносимо дані з post в окремі змінні
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirmation = $_POST['password_confirmation'] ?? '';

//валідація даних
if (empty($name))
{
   setValidationError('name', 'Неправильне імя');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL))// filter_var - стандартна функція, яка перевіряє чи є введена пошта валідною. приймає два аргументи: пошту і тип валідації - константу FILTER_VALIDATE_EMAIL, яка перевіряє чи є введена пошта валідною
{
   setValidationError('email', 'Зазначено неправильну пошту');
}

if (empty($password)) {
   setValidationError('password', 'Пароль порожній');
}

if ($password !== $password_confirmation) {
   setValidationError('password', 'Паролі не збігаються');
}
//якщо наша сесія не є пустою, тобто містить помилки валідації
if (!empty($_SESSION['validation'])) {
   oldValue('name', $name); //для зберігання старих даних які ввів користувач (при помилці валідації)
   oldValue('email', $email);
   //перенаправляємо користувача на сторінку реєстрації
   redirect('../../models/register.php');
}

//підключення до бази даних
$pdo = getPDO();

//занести користувача  в бд
//підготовка запиту
$query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"; //тому що використовуємо pdo з підготовленими запитами
$params = [
   'name' => $name,
   'email' => $email,
   'password' => password_hash($password, PASSWORD_DEFAULT) //шифруємо пароль
];
$stmt = $pdo->prepare($query);

try {
   $stmt->execute($params);
} catch(\PDOException $e) {
   die("Connection error" . $e->getMessage());
}
redirect('../../models/login.php'); //перенаправляємо користувача на сторінку логіну
?>