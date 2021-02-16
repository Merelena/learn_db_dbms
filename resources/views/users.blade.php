<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Пользователи</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
  <main style="display: flex; flex-direction: row;">  
    <div class="form" style="display: flex; flex-direction: column; width:30%;">
      <form action="{{ route('create_user') }}" method="post" style="display: flex; flex-direction: column;">
          @csrf
          <h4 style="margin-bottom: 1rem;">Создать пользователя</h4>
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
          <input type="submit" value="Создать">
        </form>
        <?php
          if (isset($_GET['create_success']))
          {
            echo "<tr><th><font color='blue'>{$_GET['create_success']}</font></th></tr>";
          }
        ?>
    </div>  
    <table class="table">     
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Фамилия</th>
          <th scope="col">Имя</th>
          <th scope="col">Отчество</th>
          <th scope="col">Роль</th>
          <th scope="col">Учреждение образования</th>
          <th scope="col">E-mail</th>
          <th scope="col">Пароль</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
        <?php
          if (isset($_GET['delete_success']))
          {
            echo "<tr><th><font color='red'>{$_GET['delete_success']}</font></th></tr>";
          }
        ?>
      </thead>
      <tbody>
        @foreach($users as $element)
        <tr>
          <td>{{ $element->id}}</td>
          <td>{{ $element->surname}}</td>
          <td>{{ $element->first_name}}</td>
          <td>{{ $element->middle_name}}</td>
          <td>{{ $element->role}}</td>
          <td>{{ $element->edu_institution}}</td>
          <td>{{ $element->email}}</td>
          <td>{{ $element->password}}</td>
          <td><a href="/admin/users/{{ $element->id }}/update">Редактировать</a></td>
          <td><a href="/admin/users/{{ $element->id }}/delete">Удалить</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>

</html>