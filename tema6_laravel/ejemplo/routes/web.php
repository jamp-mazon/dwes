<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/hola",function(){
    return view("holamundo");
});

Route::get("/cv",function(){
    return view("otros.curriculum");
})->name("curriculum");

//Ruta para listado
Route::get("/listado",function(){
    return view("libros.listado");
})->name("listadolibros");

//Ruta para alta de supuesto nuevo libro
Route::get("/alta",function(){
    return view("libros.alta");
})->name("altalibros");
