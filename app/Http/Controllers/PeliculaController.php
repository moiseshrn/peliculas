<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeliculaController extends Controller
{
    // Borra una pelicula de la base de datos
    //
    // id : El id de la película que se desea borrar
    public function borrar($id) {
        $sql = " DELETE FROM pelicula WHERE id = ?";

        if (DB::delete($sql, [$id])) {
            $mensaje = ["mensaje" => "Pelicula borrada."];
            return response()->json($mensaje);
        }
        else {
            $error = ["error" => "Error interno. Contacte al administrador"];
            return response()->json($error, 500);
        }
    }

    // Guarda una película en la base de datos.
    public function crear() {

        $ruta_img = basename(request()->file('img')->store('/public/imagenes'));

        $sql = "
            INSERT INTO pelicula
              (titulo, fecha_estreno, id_genero, sinopsis, ruta_img)
            VALUES(?, ?, ?, ?, ?)
        ";

        $datos = [
            request()->titulo, request()->fecha_estreno, request()->id_genero,
            request()->sinopsis, $ruta_img 
        ];
        
        if (DB::insert($sql, $datos)) {
            $mensaje = ["mensaje" => "Pelicula agregada"];
            return response()->json($mensaje, 200);
        }
        else {
            $error = ["error" => "Error interno. Contacte al administrador"];
            return response()->json($error, 500);
        }
    }

    // Permite cambiar los datos de una pelicula
    //
    // id: id de la película a la que se desea cambiar datos.
    public function editar($id) {

        $campos = "";
        $datos = [];
        
        // Se agregan únicamente los campos que contienen valores
        foreach(request()->all() as $campo => $valor) {
            if ($valor) {
                $campos .= $campo . " = ?, ";
                array_push($datos, $valor);
            }
        }

        $campos = substr_replace($campos, "", -2);

        // Se agrega el id de pelicula al arreglo de datos
        array_push($datos, $id);

        $sql = "UPDATE pelicula SET " . $campos . " WHERE id = ?";

        if (DB::update($sql, $datos)) {
            $mensaje = ["mensaje" => "Datos de pelicula actualizados"];
            return response()->json($mensaje, 200);
        }
        else {
            $error = ["error" => "Error interno. Contacte al administrador"];
            return response()->json($error, 500);
        }
    }

    // Obtiene la información de todas las películas y las muestra en la página
    // principal
    public function index() {
        $sql = "
            SELECT  p.titulo, p.fecha_estreno, p.ruta_img,
              SUBSTRING(p.sinopsis, 0, 200) || '...' AS sinopsis,
              COUNT(c.comentario) AS total_comentarios, 
              AVG(c.puntuacion) AS puntuacion, p.id
            FROM pelicula p
            LEFT JOIN comentario c
              ON c.id_pelicula = p.id
            GROUP BY p.id
        ";

        $peliculas = DB::select($sql);

        return view(
            "index", 
            ["peliculas" => $peliculas, "titulo" => "Películas"]
        );
    }

    // Muestra información detallada sobre una película
    //
    // id : El id de una película
    public function mostrar($id) {

        $sql = "
            SELECT  p.titulo, p.fecha_estreno, p.sinopsis, p.ruta_img,
              COUNT(c.comentario) AS total_comentarios, 
              AVG(c.puntuacion) AS puntuacion, p.id,
              p.fecha_estreno, g.genero
            FROM pelicula p
            INNER JOIN genero g
              ON p.id_genero = g.id
            LEFT JOIN comentario c
              ON c.id_pelicula = p.id
            WHERE p.id = ?
            GROUP BY p.id, g.genero
        ";

        $pelicula = DB::select($sql, [$id]);

        $sql = "
            SELECT comentario, puntuacion,
            TO_CHAR(created_at, 'DD-MM-YYYY') AS fecha
            FROM comentario 
            WHERE id_pelicula = ?
        ";

        $comentarios = DB::select($sql, [$id]);

        return view(
            'detalle_pelicula', 
            ["pelicula" => $pelicula[0], "comentarios" => $comentarios,
             "titulo" => "Detalles de la película"]
        ); 
    }
}
