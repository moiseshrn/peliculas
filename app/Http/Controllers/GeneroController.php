<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneroController extends Controller
{
    //Permite agregar un género de película
    public function crear() {

        $sql = "
            INSERT INTO genero(genero)
            VALUES(?)
        "; 
        
        if(DB::insert($sql, [request()->genero])) {
            $mensaje = "El generó se registro.";
            return response()->json(["mensaje" => $mensaje]);
        }
        else {
            return redirect('/api/error', 500);
        }
    }

    // Obtiene una lista de todos los generos registrados.
    public function index() {

        $sql = "SELECT id, genero FROM genero"; 

        $resultado =  DB::select($sql);

        if($resultado) {
            return ["generos" => $resultado];
        }
        else {
            return redirect('/api/error', 500);
        }
    }

    // Permite editar el género
    public function editar($id) {

        $sql = "UPDATE genero SET genero = ? WHERE id = ?"; 

        if(DB::delete($sql, [request()->genero, $id])) {
            $mensaje = "El generó se ha editado.";
            return response()->json(["mensaje" => $mensaje]);
        }
        else {
            return redirect('/api/error', 500);
        }
    }

    // Borra un género de la base de datos.
    public function borrar($id) {

        $sql = "DELETE FROM genero WHERE id = ?"; 

        if(DB::delete($sql, [$id])) {
            $mensaje = "El generó se ha borrado.";
            return response()->json(["mensaje" => $mensaje]);
        }
        else {
            return redirect('/api/error', 500);
        }

    }
}
