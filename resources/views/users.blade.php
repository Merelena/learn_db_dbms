<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Пользователи</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script>
    function del(id, token) {
      if (confirm("Вы действительно хотите удалить пользователя ID \"" + id + "\"?")) {
          location.href="/admin/users/" + id +"/delete?token=" + token;   
      }
    }
  </script>
</head>

<body>
  <main style="display: flex; flex-direction: row;">
    <div class="form" style="display: flex; flex-direction: column; width:25%;">
      <form action="/admin/users/sort?token={{ $users->token }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <select name="field">
          <option value="id">ID</option>
          <option value="surname">Фамилия</option>
          <option value="first_name">Имя</option>
          <option value="middle_name">Отчество</option>
          <option value="role">Роль</option>
          <option value="edu_institution">УО</option>
          <option value="email">E-mail</option>
          <option value="created_at">Дата добавления</option>
          <option value="updated_at">Дата обновления</option>
        </select>
        <select name="order">
          <option value='ASC'>По возрастанию</option>
          <option value='DESC'>По убыванию</option>
        </select>
        <input type='submit' value='Сортировать'>
      </form>
      <form action="/admin/users/search?token={{ $users->token }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <input type="text" name="search_term" placeholder="Поисковое значение" style="margin-top: 1rem;">
        <select name="field">
          <option value="id">ID</option>
          <option value="surname">Фамилия</option>
          <option value="first_name">Имя</option>
          <option value="middle_name">Отчество</option>
          <option value="role">Роль</option>
          <option value="edu_institution">УО</option>
          <option value="email">E-mail</option>
          <option value="created_at">Дата добавления</option>
          <option value="updated_at">Дата обновления</option>
        </select>
        <input type='submit' value='Поиск'>
      </form>
      <form action="/admin/users/create?token={{ $users->token }}" method="post" style="display: flex; flex-direction: column;">
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
      <?php
        if (isset($_GET['create_success'])) {
          echo "<script>alert(\"".$_GET['create_success']."\"); </script>";
        }
      ?>
      <a href="/admin?token={{ $users->token }}"><button>Назад</button></a>
    </div>
    <table class="table">        
      <thead>
        <?php
        if (isset($_GET['delete_success'])) {
          echo "<script>alert(\"".$_GET['delete_success']."\"); </script>";
        }
        ?>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Фамилия</th>
          <th scope="col">Имя</th>
          <th scope="col">Отчество</th>
          <th scope="col">Роль</th>
          <th scope="col">Учреждение образования</th>
          <th scope="col">E-mail</th>
          <th scope="col">Дата добавления</th>
          <th scope="col">Дата обновления</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $element)
        <tr>
          <td>{{ $element->id }}</td>
          <td>{{ $element->surname }}</td>
          <td>{{ $element->first_name }}</td>
          <td>{{ $element->middle_name }}</td>
          <td>{{ $element->role }}</td>
          <td>{{ $element->edu_institution }}</td>
          <td>{{ $element->email }}</td>
          <td>{{ $element->created_at }}</td>
          <td>{{ $element->updated_at }}</td>
          <td><a href="/admin/users/{{ $element->id }}/update?token={{ $users->token }}">Редактировать</a></td>
          <td><a href="javascript:del({{ $element->id }}, '{{ $users->token }}')">Удалить</a></td>
        </tr>
        @endforeach
      </tbody>              
      <caption>{!! $users->render() !!}</caption>
    </table>    
  </main>  
</body>
</html>