<?php
require_once '../src /funcValidation.php';
isAuth(); //функція, яка перевіряє чи користувач залогінений
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

   <form class="card" action="../src/action/login.php" method="post" >
      <h2>Вхiд</h2>
      <?php if(hasMessage('error')): ?>
         <div class="notice error">
            <?php echo getMessage('error'); ?>
         </div>
      <?php endif; ?>
      <label for="email">
         E-mail
         <input
            type="text"
            id="email"
            name="email"
            placeholder="електронна адреса"
            value="<?php echo old('email') ?>"
            <?php echo validationErrorAttr('email'); ?>
         >
         <?php if(hasValidationError('email')): ?>
            <small><?php echo validationErrorMessage('email'); ?></small>
         <?php endif; ?>
      </label>

      <label for="password">
         Пароль
         <input type="password" id="password" name="password" placeholder="******" required>
      </label>

      <button type="submit" id="submit">Продовжити</button>
   </form>

   <p>У мене ще немає <a href="register.php">облікового запису</a></p>

   <script src="assets/app.js"></script>
</body>

</html>