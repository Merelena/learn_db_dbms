<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Учебные материалы</title>
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
  <form action="{{ route('update_edu_aid_submit', $data['id']) }}" method="post" style="display: flex; flex-direction: column; width:30%; margin: 0 auto;">
     @csrf
    <h4 align='center'>Редактировать материал</h4>
    <input type="text" name="id" value="{{ $data['id'] }}" style="margin-bottom: 1rem;" disabled>
    <input type="text" name="name" value="{{ $data['name'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="authors" value="{{ $data['authors'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="edu_institution" value="{{ $data['edu_institution'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="public_year" value="{{ $data['public_year'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="description" value="{{ $data['description'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="number_of_pages" value="{{ $data['number_of_pages'] }}" style="margin-bottom: 1rem;">
    <p>Документ:</p>
    <input type="file" name="document">
    <p>Изображение:</p>
    <input type="file" name="image" multiple accept="image/*,image/jpeg">
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
    <button><a href="{{ route('edu_aids') }}" style="text-decoration: none;">Назад</a></button>
  </main>
</body>

</html>