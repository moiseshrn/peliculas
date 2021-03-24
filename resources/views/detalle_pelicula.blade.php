{{--
Muestra información detallada de una película y permite agregar comentarios.
--}}

@extends("plantilla")

@section("contenido")
<div class="detalles_pelicula">
    <div class="row">
        <div class="col-auto">
            <img 
              src="{{ asset('/img/' . $pelicula->ruta_img) }}" 
              alt="imagen_pelicula"
              height="172" width="120"
            >
        </div>
        <div class="col datos">
            <h1 class="titulo">{{ $pelicula->titulo  }}</h1>
            <p class="estreno">
                <span class="etiqueta">Fecha de Estreno:</span>
                {{ " " . $pelicula->fecha_estreno  }}
            </p>
            <p class="genero">
                <span class="etiqueta">Genero:</span>
                {{ " ". $pelicula->genero }}
            </p>
            @if ($pelicula->puntuacion)
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
        </div>
    </div>
    <div class="row sinopsis">
        <p>{{ $pelicula->sinopsis }}</p>
    </div>
</div>

@if (session("estado"))
    <!-- Avisa al usuario que su comentario ha sido agregado -->
    <div class="alert alert-success col-auto">
        {{ session("estado") }}
    </div>
@endif

@if ($errors->any())
    <!-- 
        Solo en caso de que Javascript este desabilitado. De lo contrario, 
        la validación se realiza en el cliente.
    -->
	<div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> 
@endif

<form 
  action="{{ request()->root() . '/comentario/' . $pelicula->id}}" 
  class="forma row gy-3 row-cols-auto needs-validation" 
  novalidate method="post"
>
  @csrf
  <div class="col-sm-4">
    <label for="comentario" class="form-label">Comentario</label>
    <select 
      class="form-select form-select-sm" id="comentario" required
      name="comentario"
    >
      <option selected disabled value="">Seleccione uno...</option>
      <option>Graciosa</option>
	  <option>Aburrida</option>
	  <option>Terrorífica</option>
	  <option>Triste</option>
	  <option>Divertida</option>
    </select>
    <div class="invalid-feedback">
		Seleccione uno.
    </div>
  </div>
  <div class="col-sm-3">
    <label for="calificacion" class="form-label">Calificación</label>
    <input 
        type="number" name="calificacion" id="calificacion" 
        class="form-control form-control-sm" required min="0" max="10" 
        placeholder="0 - 10" step="0.1"
    >
    <div class="invalid-feedback">
		Ingrese un valor de 0-10.
    </div>
  </div>
  <div class="col align-self-end">
    <button class="btn btn-primary" type="submit">Agregar</button>
  </div>
</form>
<div class="comentarios">
<h2>Comentarios</h2>
@if ($comentarios)
    @foreach($comentarios as $comentario)
        <div class="row">
            <p class="col">
            @if ($comentario->puntuacion >= 8)
                <span 
                  class="punt_comen text-center" 
                  style="background-color: #2E8D35"
                >
            @elseif ($comentario->puntuacion >= 6)
                <span 
                  class="punt_comen text-center" 
                  style="background-color: #E8AD00"
                >
            @else
                <span 
                  class="punt_comen text-center" 
                  style="background-color: #c41a20"
                > 
            @endif
            {{ "  ". $comentario->puntuacion . " " }}</span>
            <span class="comentario">{{ $comentario->comentario }}</span>
            <span>{{ $comentario->fecha . " " }}</span>
            </p>
        </div>
    @endforeach
@else
    <p>No hay comentarios</p>
@endif

</div>

<script
	src="{{ asset('/js/validar_forma.js')  }}"
	rel="text/javascript"
>
</script>

@endsection
