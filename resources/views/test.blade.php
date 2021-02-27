<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Test</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<form action="/api/v5/new_user" method="post" style="display: flex; flex-direction: column;">
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
        <input type="text" name="email" placeholder="E-mail" style="margin-bottom: 1rem;">
        <input type="text" name="password_1" placeholder="Пароль" style="margin-bottom: 1rem;">
        <input type="text" name="password_2" placeholder="Подтвердите пароль" style="margin-bottom: 1rem;">
        <input type="submit" value="Добавить">
      </form>
</body>