<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
  <main>
    <table class="table">
        <h4 align="top" style="display: inline; margin-right: 2rem;">Учебные заведения</h4>
        <a href="{{ route('edu_institutions') }}"><input type="submit" value="Перейти" style="margin-right: 2rem;"></a>
      <thead>
        <tr>
          <th scope="col">Название</th>
          <th scope="col">Город</th>
        </tr>
      </thead>
      <tbody>
        @foreach($edu_institutions as $element)
        <tr>
          <td>{{ $element->name}}</td>
          <td>{{ $element->city}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <table class="table">
      <h4 align="top" style="display: inline; margin-right: 2rem;">Пользователи</h4>
      <a href="{{ route('users') }}"><input type="submit" value="Перейти" style="margin-right: 2rem;"></a>
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Фамилия</th>
          <th scope="col">Имя</th>
          <th scope="col">Отчество</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $element)
        <tr>
          <td>{{ $element->id}}</td>
          <td>{{ $element->surname}}</td>
          <td>{{ $element->first_name}}</td>
          <td>{{ $element->middle_name}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <table class="table">    
      <h4 align="top" style="display: inline; margin-right: 2rem;">Учебные матриалы</h4>
      <a href="{{ route('edu_aids') }}"><input type="submit" value="Перейти" style="margin-right: 2rem;"></a>
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Названия</th>
          <th scope="col">Авторы</th>
        </tr>
      </thead>
      <tbody>
        @foreach($edu_aids as $element)
        <tr>
          <td>{{ $element->id}}</td>
          <td>{{ $element->name}}</td>
          <td>{{ $element->authors}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>

</html>