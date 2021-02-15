<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Пользователи</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
  <main>    
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
      </thead>
      <tbody>
        @foreach($data as $element)
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
          <td><a href="/admin/users/delete/{{ $element->id }}/delete">Удалить</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>

</html>