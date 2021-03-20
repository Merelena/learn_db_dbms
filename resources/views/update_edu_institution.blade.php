<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Учреждения образования</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
  <main align='center'>
     <?php
      if (!isset($data['name'])) 
      {
        $data = reset($data);
        $data = reset($data);
      }
     ?> 
  <form action="/admin/edu_institutions/{{ $data['name'] }}/update?token={{ $token }}" method="post" style="display: flex; flex-direction: column; width:30%; margin: 0 auto;">
     @csrf
    <h4 align='center'>Редактировать учреждение образования</h4>
    <input type="text" name="name" value="{{ $data['name'] }}" style="margin-bottom: 1rem;">
    <input type="text" name="city" value="{{ $data['city'] }}" style="margin-bottom: 1rem;">
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
    <button><a href="/admin/edu_institutions?token={{ $token }}" style="text-decoration: none;">Назад</a></button>
  </main>
</body>

</html>