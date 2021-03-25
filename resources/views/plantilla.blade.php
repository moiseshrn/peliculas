<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $titulo  }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/estilos.css') }}">
</head>
<body>
   <div class="encabezado container-fluid">
   <a href="{{ request()->root() }}">
       <div class="row">
            <img 
                src="{{ asset('iconos/popcorn.svg')  }}" 
                alt="Palomitas y refresco"
                height="50"
                width="50"
                class="col-auto d-flex align-items-center"
            >
            <h1 class="col-auto d-flex align-items-center">Películas</h1>
       </div>
   </a>
   </div>
   <div class="container-md contenido">
       @yield('contenido')
   </div>
</body>
</html>
