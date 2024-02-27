<?php
require_once '../src/funcValidation.php';
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
      <form class="card" action="../src/action/register.php" method="post">
         <h2>Реєстрація</h2>
         <label for="name">
            Ім'я
            <input
               type="text"
               id="name"
               name="name"
               placeholder="Прізвище Ім'я"
               value="<?php echo old('name') ?>"
               <?php echo validationErrorAttr('name'); ?>
            >
            <?php if(hasValidationError('name')): ?>
               <small><?php echo validationErrorMessage('name'); ?></small>
            <?php endif; ?>
         </label>

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

         <div class="grid">
            <label for="password">
               Пароль
               <input
                  type="password"
                  id="password"
                  name="password"
                  placeholder="******"
                  <?php echo validationErrorAttr('password'); ?>
               >
               <?php if(hasValidationError('password')): ?>
                  <small><?php echo validationErrorMessage('password'); ?></small>
               <?php endif; ?>
            </label>

            <label for="password_confirmation">
               Підтвердження
               <input type="password" id="password_confirmation" name="password_confirmation" placeholder="******">
            </label>
         </div>

         <fieldset>
            <label for="terms">
               <input type="checkbox" id="terms" name="terms">
               Я приймаю всі умови користування
            </label>
         </fieldset>
         <button type="submit" id="submit" disabled>Продовжити</button>
      </form>
   <p>У мене вже є <a href="../models/login.php">обліковий запис</a></p>
   <script src="../assets/app.js"></script>
</body>

</html>