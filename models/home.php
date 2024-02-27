<?php
require_once '../src /funcValidation.php';
checkAuth(); //функція, яка перевіряє чи користувач залогінений
$user = currentUser(); //функція, яка повертає користувача, який зараз залогінений
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
   <meta charset="UTF-8">
   <title>Авторизація та реєстрація</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
   <link rel="stylesheet" href="../assets/app.css">
</head>

<body>

   <div class="card home">
      <h1>Привіт, <?php echo $user['name'] ?>!</h1>
      <form action="../src/action/logout.php" method="post">
         <button role="button">Вийти з акаунта</button>
   </div>
   <div style="text-align: center;">
      <p>Повернутись на <a href="../index.html">головну сторінку</a></p>
   </div>
   <script src="assets/app.js"></script>
</body>

</html>