<?php
session_start(); //запускаємо сесію для обробки даних,зберігає набір зручних функцій для валідації даних

require_once 'config.php'; //підключаємо файл з конфігурацією
//функція перенаправлення на іншу сторінку, яка приймає аргументом шлях
function redirect(string $path)
{
   header("Location: $path");
   die(); //для того, щоб скрипт завершив роботу
}
// функція для зберігання помилок валідації
function setValidationError(string $field, string $message)
{
   $_SESSION['validation'][$field] = $message; //звертається до відповідного поля форми і виводить помилку
}
//функція на перевірку чи є таке поле
function hasValidationError(string $field) : bool
{
   return isset($_SESSION['validation'][$field]);
}
//функція валідації даних, приймаємо поле і відмальовуємо червоний бордер
function validationErrorAttr(string $field): string
{
   //зберігаємо помилку в сесії
   return isset($_SESSION['validation'][$field]) ? 'aria-invalid="true"' : ''; // якщо в нашій сесії є помилка, то повертаємо атрибут aria-invalid="true"
}
//функція для виводу помилки валідації
function validationErrorMessage(string $field): string
{
   $message = $_SESSION['validation'][$field] ?? ''; //отримуємо значення з сесії в окрему змінну і перевіряємо чи воно не null
   unset($_SESSION['validation'][$field]); //видаляємо дані з сесії
   return $message; //повертаємо значення
}
//функція для збереження старих даних введених в форму користувачем
function oldValue(string $key, $value): void
{
   $_SESSION['old'][$key] = $value; //в old під ключем key зберігаємо значення value
}
//функція old яка приймає ключ і повертає значення з сесії
function old(string $key)
{
   //отримуємо значення в окрему змінну
   $value = $_SESSION['old'][$key] ?? ''; //+ перевірка на null
   //між ними робимо очистку
   unset($_SESSION['old'][$key]); //видаляємо дані з сесії і тоді нам не прийдеться old кожний раз
   return $value; //повертаємо значення
}

//функція для перевірки чи є зараз якесь повідомлення в сесії
function hasMessage(string $key) : bool
{
   return isset($_SESSION['message'][$key]); //перевіряємо чи є в сесії повідомлення за допомогою ключа
}

//set message для авторизації користувача
function setMessage(string $key, string $message): void
{
   $_SESSION['message'][$key] = $message; //зберігаємо повідомлення в сесії
}
//функція для виводу повідомлення
function getMessage(string $key): string
{
   $message = $_SESSION['message'][$key] ?? ''; //отримуємо значення з сесії в окрему змінну і перевіряємо чи воно не null
   unset($_SESSION['message'][$key]); //видаляємо дані з сесії
   return $message; //повертаємо значення
}


//підключення до бази даних
//ініціалізація через драйвер PDO
function getPDO(): PDO//функція для підключення до бази даних
{
   //підключення до бази даних
   try{
      return new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
   } catch (PDOException $e) {
      die($e->getMessage());
   }
}

//пошук користувача в бд
function findUser(string $email): array
{
   //отримання користувача з бд
   $pdo = getPDO();
   //запит до бд, де шукаємо користувача з введеним email
   $smtm = $pdo->prepare("SELECT * FROM users WHERE email = :email");
   $smtm->execute(['email' => $email]);
   return $smtm->fetch();
}

//після авторизації пошук поточного користувача
function currentUser(): array
{
   //якщо в сесії немає користувача, виводимо повідомлення
   if(!isset($_SESSION['user']['id'])){
      return [];
   }
   $user_id = $_SESSION['user']['id'] ?? ''; //отримуємо id користувача з сесії
   //якщо користувач авторизований, то шукаємо його в бд
   $pdo = getPDO();
   $smtm = $pdo->prepare("SELECT * FROM users WHERE id = :id");
   $smtm->execute(['id' => $user_id]);
   return $smtm->fetch();
}

//функція для виходу з аккаунта
function logout():void
{
   unset($_SESSION['user']['id']); //видаляємо дані про користувача з сесії
   redirect('../../models/login.php'); //перенаправляємо користувача на сторінку входу
}

//функція для захисту, якщо користувач не авторизований то не може зайти на сторінку home
function checkAuth():void
{
   if(!isset($_SESSION['user']['id'])){
      redirect('../../models/login.php');
   }
}
//функція для перевірки чи користувач авторизований
function isAuth():void
{
   if(isset($_SESSION['user']['id'])) //якщо ми знаходимо користовуча, то перенаправляємо його на сторінку home
   {
      redirect('../../models/home.php');
   }
}