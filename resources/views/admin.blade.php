<!DOCTYPE html>
<html lang="ru">
  <head>
    <title>Admin Panel</title>
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  </head>
  <body>
    <main align='center'>
      <div class='institutes'>
          <div class='themed-grid-col'><b>Учебные заведения</b></div>
          @foreach($edu_institutions as $element)
            <div class='themed-grid-col'>{{ $element->name}}</div>
          @endforeach
      </div>
    </main>
  </body>
</html>