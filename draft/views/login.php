<h1>Вход</h1>
<form method="POST" action="?login">
  <div class="row">
    <label for="email">Email:</label>
    <input name="email" id="email" autocomplete="off" />
  </div>
  <div class="row">
    <label for="pass">Пароль:</label>
    <input type="password" name="pass" id="pass" />
  </div>
  <div class="row">
    <a href="?recovery">Забыли пароль?</a> |
    <a href="?signup">Регистрация</a>
  </div>
  <div class="row">
    <input type="submit" />
  </div>  
</form>