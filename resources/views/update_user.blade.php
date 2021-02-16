<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Пользователи</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
  <main align='center'>
     <?php
      if (!isset($data['id'])) 
      {
        $data = reset($data);
        $data = reset($data);
      }
     ?> 
  <form action="{{ route('update_user_submit', $data['id']) }}" method="post" style="display: flex; flex-direction: column; width:30%; margin: 0 auto;">
     @csrf
    <h4 align='center'>Редактировать пользователя</h4>
    <input type="text" name="id" value="{{ $data['id'] }}" style="margin-bottom: 1rem;" disabled>
    <input type="text" name="surname" value="{{ $data['surname'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="first_name" value="{{ $data['first_name'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="middle_name" value="{{ $data['middle_name'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="edu_institution" value="{{ $data['edu_institution'] }}" style="margin-bottom: 1rem;">
    <select name="role" value="{{ $data['role'] }}" style="margin-bottom: 1rem;">
      <option name="student">Учащийся</option>
      <option name="lecturer">Преподаватель</option>
      <option name="admin">Администратор</option>
    </select>
    <input type="text" name="email" value="{{ $data['email'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="password" value="{{ $data['password'] }}" style="margin-bottom: 1rem;">
    <input type="submit" value="Изменить">
    </form> 
    <?php
      if (!isset($success))
      {
        $success = '';
      }
      else
      {
        echo "<script>alert(\"".$success."\"); </script>";
      }
    ?>
    <button><a href="{{ route('users') }}" style="text-decoration: none;">Назад</a></button>
  </main>
</body>

</html>