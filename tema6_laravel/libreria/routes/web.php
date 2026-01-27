<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get("/hola",function(){
//     $ciudad="Murcia";

//     return view("holamundo",[
//         "nombre"=> "Pepito",
//         "Apellidos"=> "Perez",
//         "localidad"=>$ciudad
//     ]);
// });

// Route::get("/cv",function(){
//     return view("otros.curriculum");
// })->name("curriculum");

// //Ruta para listado
// Route::get("/listado",function(){

//     $nombre_biblioteca= "FloriBIBLIO";

//     $libros = [
//             [
//                 'nombre' => 'Gabriel García Márquez',
//                 'titulo' => 'Cien años de soledad',
//                 'genero' => 'Realismo mágico'
//             ],
//             [
//                 'nombre' => 'George Orwell',
//                 'titulo' => '1984',
//                 'genero' => 'Distopía'
//             ],
//             [
//                 'nombre' => 'J.R.R. Tolkien',
//                 'titulo' => 'El Señor de los Anillos',
//                 'genero' => 'Fantasía'
//             ]
//     ];
//     return view('libros.listado',["nombre_biblioteca" => $nombre_biblioteca,
//                                              "libros" => $libros]);
// })->name("listadolibros");


// Vista para pasar un id /libro/X

// Route::get("/libro/{id?}",function($id=0)){
    
// return view("libros.libro",[
//         "id"=>$id
//     ]);
// })->name("libro");

// Route::get("/libro",function(){
    
// return view("libros.libro",[
//         "id"=>request("id","666")
//     ]);  
// })->name("libro");

// //Ruta para alta de supuesto nuevo libro
// Route::get("/alta",function(){
//     return view("libros.alta");
// })->name("altalibros");

//========= RUTAS DE LIBROS
Route::get('/libros', [LibroController::class, 'listar_libros'])->name('listado');
Route::get('/libros/{id}', [LibroController::class, 'mostrar_libro']); //-> where('id', '[0-9]+');