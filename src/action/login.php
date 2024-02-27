<?php
require_once '../funcValidation.php';
//алгоритм дій : отримаели email -> шукаємо користувача в бд -> якщо знайшли, то перевіряємо пароль -> якщо пароль вірний, то авторизуємо користувача

//отримання даних з форми
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

//валідація даних
if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) //перевірка на пустоту і на валідність email
{
   oldValue('email', $email); //для зберігання старих даних які ввів користувач (при помилці валідації)
   setValidationError('email', 'Невірний формат email');
   setMessage('error', 'Помилка валідації');
   redirect('../../models/login.php');
}
if(!$password){
   setValidationError('password', 'Введіть пароль');
}
//пошук користувача в бд
$user = findUser($email); //функція, яка шукає користувача в бд за email

//якщо користувача не знайдено, то виводимо помилку
if(!$user){
   setMessage('error', 'Користувача з таким email не знайдено');
   redirect('../../models/login.php');
}
//якщо користувача знайдено, то перевіряємо пароль
if(!password_verify($password, $user['password'])) //це функція для перевірки паролю, яка приймає 2 аргументи: 1 - пароль, який ввів користувач, 2 - пароль, який зберігається в бд
{
   setMessage('error', 'Невірний пароль');
   redirect('../../models/login.php');
}

//якщо пароль вірний, то авторизуємо користувача
$_SESSION['user']['id'] = $user['id']; //зберігаємо id користувача в сесії

redirect('../../models/home.php'); //перенаправляємо користувача на сторінку home