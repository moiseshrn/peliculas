<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentarioController extends Controller
{
    // Registra un comentario de una película
    //
    // id_pelicula : El id de la película sobre la que se hizó el comentario
    public function guardar(Request $request, $id_pelicula) {
        
        $validado = $request->validate([
            "comentario" => "required|string",
            "calificacion" => "required|numeric"
        ]);

        $estado = DB::insert(
            "
              INSERT INTO 
                comentario(comentario, created_at, id_pelicula, puntuacion)
              VALUES(?, CURRENT_TIMESTAMP, ?, ?) 
            ",
            [
                $request->input('comentario'),
                $id_pelicula, $request->input("calificacion")
            ]
        );

        if($estado) {
            return back()->with('estado', 'Comentario agregado');
        }
        else {
            return response()->view("error.error500", [], 500);
        }
    }
}
