<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Учебные заведения</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script>
    function del(name, token) {
      if (confirm("Вы действительно хотите удалить учебное заведение \"" + name + "\"? Все пользователи данного учреждения образования будут также удалены.")) {
          location.href="/admin/edu_institutions/" + name +"/delete?token=" + token;   
      }
    }
  </script>
</head>

<body>
  <main style="display: flex; flex-direction: row;">
    <div class="form" style="display: flex; flex-direction: column; width:25%;">
      <form action="/admin/edu_institutions/sort?token={{ $edu_institutions->token }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <select name="field">
          <option value="name">Название</option>
          <option value="city">Город</option>
          <option value="created_at">Дата добавления</option>
          <option value="updated_at">Дата обновления</option>
        </select>
        <select name="order">
          <option value='ASC'>По возрастанию</option>
          <option value='DESC'>По убыванию</option>
        </select>
        <input type='submit' value='Сортировать'>
      </form>
      <form action="/admin/edu_institutions/search?token={{ $edu_institutions->token }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <input type="text" name="search_term" placeholder="Поисковое значение" style="margin-top: 1rem;">
        <select name="field">
          <option value="name">Название</option>
          <option value="city">Город</option>
          <option value="created_at">Дата добавления</option>
          <option value="updated_at">Дата обновления</option>
        </select>
        <input type='submit' value='Поиск'>
      </form>
      <form action="/admin/edu_institutions/create?token={{ $edu_institutions->token }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <h4 style="margin-bottom: 1rem; margin-top: 1rem;">Добавить учреждение образования</h4>
        <input type="text" name="name" placeholder="Название" style="margin-bottom: 1rem;">
        <input type="text" name="city" placeholder="Город" style="margin-bottom: 1rem;">
        <input type="submit" value="Добавить">
      </form>
      <?php
        if (isset($_GET['create_success'])) {
          echo "<script>alert(\"".$_GET['create_success']."\"); </script>";
        }
      ?>
      <a href="/admin?token={{ $edu_institutions->token }}"><button>Назад</button></a>
    </div>
    <table class="table">
      <thead>
        <?php
        if (isset($_GET['delete_success'])) {
          echo "<script>alert(\"".$_GET['delete_success']."\"); </script>";
        }
        ?>
        <tr>
          <th scope="col">Название</th>
          <th scope="col">Город</th>
          <th scope="col">Дата добавления</th>
          <th scope="col">Дата обновления </th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($edu_institutions as $element)
        <tr>
          <td>{{ $element->name}}</td>
          <td>{{ $element->city}}</td>
          <td>{{ $element->created_at}}</td>
          <td>{{ $element->updated_at}}</td>
          <td><a href="/admin/edu_institutions/{{ $element->name }}/update?token={{ $edu_institutions->token }}">Редактировать</a></td>
          <td><a href="javascript:del('{{ $element->name }}',  '{{ $edu_institutions->token }}')">Удалить</a></td>
        </tr>
        @endforeach
      </tbody>              
      <caption>{!! $edu_institutions->render() !!}</caption>
    </table>    
  </main>  
</body>
</html>