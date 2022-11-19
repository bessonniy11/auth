<?php
$email = '';
$pass1 = '';
$pass2 = '';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
$email = filter_input(
  INPUT_POST,
  'email',
  FILTER_VALIDATE_EMAIL 
);

$pass1= $_POST['pass1'] ?? '';
$pass2= $_POST['pass2'] ?? '';

$_SESSION['message'] = [];
if( !$email ) {
  $_SESSION['message'][] = 'Задайте корректный емейл';  
  header('Location: /?signup');
  exit;
}
if( !$pass1 || !$pass2 ) {
  $_SESSION['message'][] = 'Задайте пароль и подтверждение';
  header('Location: /?signup');
  exit;
}
if( $pass1 != $pass2 ) {
  $_SESSION['message'][] = 'Укажите одинаковые пароли';
  header('Location: /?signup');
  exit;
}

$stmt = mysqli_stmt_init($db);
if (mysqli_stmt_prepare($stmt, 'SELECT idusers FROM users WHERE email=?')) {
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $idusers);
  mysqli_stmt_fetch($stmt);
  if( $idusers ){
    $_SESSION['message'][] = 'Email уже занят';
    header('Location: /?signup');
    exit;
  }
  
}

$pass = password_hash($pass1, PASSWORD_BCRYPT, ['cost' => 12,]);
$confirmation_token = bin2hex(random_bytes(40));
$query = "INSERT INTO `users` (`idusers`, `email`, `pass`, `verified`, `created_at`, `confirmation_token`) VALUES (NULL, ?, '$pass', 'N', NOW(), '$confirmation_token')";

$stmt = mysqli_stmt_init($db);
if (mysqli_stmt_prepare($stmt, $query)) {
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $_SESSION['message'][] = 'Проверьте емейл и подтвердите регистрацию';

  
  $subject = "Подтверждение регистрации {$_SERVER['SERVER_NAME']}";
  $msg = "Нажмите на <a href=\"http://{$_SERVER['SERVER_NAME']}?confirmation_token=" . $confirmation_token . "\">ссылку</a> для подтверждения email";  
  $headers = "From: no-reply@{$_SERVER['SERVER_NAME']}";
  mail($to, $subject, $msg, $headers);

  header('Location: /');
}

}