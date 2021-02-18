<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Учебные материалы</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script>
    function del(id) {
      if (confirm("Вы действительно хотите удалить материал ID \"" + id + "\"?")) {
          location.href="/admin/edu_aids/" + id +"/delete";   
      }
    }
  </script>
</head>

<body>
  <main style="display: flex; flex-direction: row;">
    <div class="form" style="display: flex; flex-direction: column; width:25%;">
      <form action="{{ route('sort_edu_aids') }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <select name="field">
          <option value="id">ID</option>
          <option value="name">Название</option>
          <option value="authors">Автор/Авторы</option>
          <option value="edu_institution">Учреждение образовния</option>
          <option value="public_year">Год издания</option>
          <option value="description">Описание</option>
          <option value="created_at">Дата добавления</option>
          <option value="updated_at">Дата обновления</option>
        </select>
        <select name="order">
          <option value='ASC'>По возрастанию</option>
          <option value='DESC'>По убыванию</option>
        </select>
        <input type='submit' value='Сортировать'>
      </form>
      <form action="{{ route('search_edu_aids') }}" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <input type="text" name="search_term" placeholder="Поисковое значение" style="margin-top: 1rem;">
        <select name="field">
          <option value="id">ID</option>
          <option value="name">Название</option>
          <option value="authors">Автор/Авторы</option>
          <option value="edu_institution">Учреждение образования</option>
          <option value="public_year">Год издания</option>
          <option value="description">Описание</option>
          <option value="created_at">Дата добавления</option>
          <option value="updated_at">Дата обновления</option>
        </select>
        <input type='submit' value='Поиск'>
      </form>
      <form action="{{ route('create_edu_aid') }}" enctype="multipart/form-data" method="post" style="display: flex; flex-direction: column;">
        @csrf
        <h4 style="margin-bottom: 1rem; margin-top: 1rem;">Добавить материал</h4>
        <input type="text" name="name" placeholder="Название" style="margin-bottom: 1rem;">
        <input type="text" name="authors" placeholder="Автор/Авторы" style="margin-bottom: 1rem;">
        <input type="text" name="edu_institution" placeholder="Учреждение образования" style="margin-bottom: 1rem;">
        <input type="text" name="public_year" placeholder="Год издания" style="margin-bottom: 1rem;">
        <input type="text" name="description" placeholder="Описание" style="margin-bottom: 1rem;">
        <input type="text" name="number_of_pages" placeholder="Количество страниц" style="margin-bottom: 1rem;">
        <p>Документ:</p>
        <input type="file" name="document">
        <p>Изображение:</p>
        <input type="file" name="title_image" accept="image/*,image/jpeg">
        <input type="submit" value="Добавить">
      </form>
      <?php
        if (isset($_GET['create_success'])) {
          echo "<script>alert(\"".$_GET['create_success']."\"); </script>";
        }
      ?>
      <a href="{{ route('admin') }}"><button>Назад</button></a>
    </div>
    <table class="table">        
      <caption>{!! $edu_aids->render() !!}</caption>
      <thead>
        <?php
        if (isset($_GET['delete_success'])) {
          echo "<script>alert(\"".$_GET['delete_success']."\"); </script>";
        }
        ?>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Название</th>
          <th scope="col">Автор/Авторы</th>
          <th scope="col">Учреждение образования</th>
          <th scope="col">Год издания</th>
          <th scope="col">Описание</th>
          <th scope="col">Количество страниц</th>
          <th scope="col">Документ</th>
          <th scope="col">Изображение</th>
          <th scope="col">Дата добавления</th>
          <th scope="col">Дата обновления</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($edu_aids as $element)
        <tr>
          <td>{{ $element->id}}</td>
          <td>{{ $element->name}}</td>
          <td>{{ $element->authors}}</td>
          <td>{{ $element->edu_institution}}</td>
          <td>{{ $element->public_year}}</td>
          <td>{{ $element->description}}</td>
          <td>{{ $element->number_of_pages}}</td>
          <td>{{ $element->document}}</td>
          <td>{{ $element->title_image}}</td>
          <td>{{ $element->created_at}}</td>
          <td>{{ $element->updated_at}}</td>
          <td><a href="/admin/edu_aids/{{ $element->id }}/update">Редактировать</a></td>
          <td><a href="javascript:del({{ $element->id }})">Удалить</a></td>
        </tr>
        @endforeach
      </tbody>              
      <caption>{!! $edu_aids->render() !!}</caption>
    </table>    
  </main>  
</body>
</html>