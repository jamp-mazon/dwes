<?php

namespace App\Http\Controllers;
use App\Models\Libro;

use Illuminate\Http\Request;

class LibroController extends Controller
{
    //listar todos los libros
        public function listar_libros(){
        $nombre_biblioteca = "FloriBIBLIO";

        $libros = Libro::all();
        return view('libros.listado',["nombre_biblioteca" => $nombre_biblioteca,
                                    "libros" => $libros]);

    }
    // Listar libros
    public function index()
    {
        return "Listado de libros";
    }

    // Mostrar formulario de creación
    public function create()
    {
        return "Formulario para crear libro";
    }

    // Mostrar un libro concreto
    public function show($id)
    {
        return "Mostrando el libro con ID: " . $id;
    }

}
