{{-- 
Página principal
Muestra una lista con la información de todas las películas.
Permite buscar películas por calificación.
--}}

@extends('plantilla')

@section("contenido")
<div class="filtro">
    <p>Filtrar por calificación</p>
    <form action="" class="forma row gy-3 row-cols-auto needs-validation"
          method="post" novalidate
    >
        @csrf
        <div class="col-sm-3">
            <label for="min">Mínimo</label>
            <input 
                type="number" name="min" placeholder="Min" 
                min="0" step="0.1" class="form-control form-control-sm"
                required
            >
            <div class="invalid-feedback">
                Ingrese un valor mayor o igual a 0 
            </div>
        </div>
        <div class="col-sm-3">
            <label for="min">Máximo</label>
            <input 
                type="number" name="max" placeholder="Max" 
                max="10" step="0.1" class="form-control form-control-sm"
                required
            >
            <div class="invalid-feedback">
                Ingrese un valor menor o igual a 10
            </div>
        </div>
        <div class="col align-self-end">
            <input class="btn btn-primary" type="submit" value="Filtrar">
        </div>
    </form>
</div>
<div class="lista">
@foreach ($peliculas as $pelicula)
    <a 
      href="{{ request()->root() . '/detalles/' . $pelicula->id  }}"
      class="enlace_pelicula"
    >
    <div class="row pelicula">
        <div class="col-2 d-flex align-items-center">
            <img 
              src="{{ asset('/img/' . $pelicula->ruta_img) }}" 
              alt="imagen_pelicula"
              class="img-fluid"
            >
        </div>
        <div class="col datos">
            <div class="row align-items-center">
                <span class="col-sm-10 titulo">
                    {{ $pelicula->titulo  }}
                </span>
            </div>
            @if ($pelicula->total_comentarios)
                <div class="puntuacion">
                    @if ($pelicula->puntuacion >= 8)
                        <span class="buena">✓
                    @elseif ($pelicula->puntuacion >= 6)
                        <span class="regular">
                    @else
                        <span class="mala">❌ 
                    @endif
                    {{ "  ". $pelicula->puntuacion }} / 10
                    </span>
                    <span class="total_comentarios">
                        👥 {{ $pelicula->total_comentarios }}
                    </span>
                </div>
            @else
                <div class="puntuacion">
                    <p>Sin evaluar</p>
                </div>
            @endif
            <p class="sinopsis">{{ $pelicula->sinopsis }}</p>
        </div>
    </div>
    </a>
@endforeach
</div>

<script
	src="{{ asset('/js/validar_forma.js')  }}"
	rel="text/javascript"
>
</script>
@endsection
