<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Test</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
 <?php 
    #ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']))."/sessions");
    #ini_set('session.cookie_lifetime', 259200);
    #if (!isset($_SESSION))
   # {
    #  session_start();
    #  session_regenerate_id(true);
   # } 
  ?>
  <form action="api/auth/registration" method="post" style="display: flex; flex-direction: column;">
    @csrf
    <h4 style="margin-bottom: 1rem; margin-top: 1rem;">Добавить пользователя</h4>
    <input type="text" name="surname" placeholder="Фамилия" style="margin-bottom: 1rem;">
    <input type="text" name="first_name" placeholder="Имя" style="margin-bottom: 1rem;">
    <input type="text" name="middle_name" placeholder="Отчество" style="margin-bottom: 1rem;">
    <input type="text" name="edu_institution" placeholder="Учреждение образования" style="margin-bottom: 1rem;">
    <select name="role" placeholder="Роль" style="margin-bottom: 1rem;">
      <option name="student">Учащийся</option>
      <option name="lecturer">Преподаватель</option>
      <option name="admin">Администратор</option>
    </select>
    <input type="email" name="email" placeholder="E-mail" style="margin-bottom: 1rem;">
    <input type="text" name="password_1" placeholder="Пароль" style="margin-bottom: 1rem;">
    <input type="text" name="password_2" placeholder="Подтвердите пароль" style="margin-bottom: 1rem;">
    <input type="submit" value="Добавить">
  </form>
  <form action="api/auth/login" method="post" style="display: flex; flex-direction: column;">
    @csrf
    <input type="email" name="email" placeholder="E-mail" style="margin-bottom: 1rem;">
    <input type="text" name="password" placeholder="Пароль" style="margin-bottom: 1rem;">    
    <input type="submit" value="Войти">
  </form>
  <form action="api/auth/logout" method="post" style="display: flex; flex-direction: column;">
    @csrf
    <input type="submit" value="Выйти">
  </form>
  </form>
  <form action="api/auth/me" method="post" style="display: flex; flex-direction: column;">
    @csrf
    <input type="submit" value="Me">
  </form>
</body>