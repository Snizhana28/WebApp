<?php
require_once '../funcValidation.php';

//тут ми видаляємо дані з сесії, які зберігаються при авторизації
//перевірка якщо _SERVER == POST, то видаляємо дані з сесії
if($_SERVER['REQUEST_METHOD'] === 'POST'){
   logout();
}
redirect('../../models/home.php');