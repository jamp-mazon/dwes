<?php
function generarIdPersistente() {
    static $contador = null;
    $ruta = 'bbdd/peliculas.json';

    if ($contador === null) {
        $pelis = file_exists($ruta) ? json_decode(file_get_contents($ruta), true) : [];
        $contador = 0;
        foreach ($pelis as $p) {
            if ($p['id'] > $contador) $contador = $p['id'];
        }
    }

    $contador++;
    return $contador;
}
function obtener_usuarios(){
    $lista_user=[];
    $ruta="bbdd/usuarios.json";
    $user_json=file_get_contents($ruta,FILE_USE_INCLUDE_PATH);
    $lista_user=json_decode($user_json);
    return $lista_user;
}
function validar_usuario($email,$password){
    $lista_user=obtener_usuarios();
    foreach ($lista_user as  $usuario) {
        if ($usuario->email===$email && password_verify($password,$usuario->password)) {
            return $usuario;
        }
    }
    return null;
}
function devolverUsuario($email){
    $lista_user=obtener_usuarios();
    foreach ($lista_user as $user) {
        if ($user->email ===$email) {
            return $user;
        }
    }
    return null;
}
function obtener_peliculas(){
    $lista_peliculas=[];
    $ruta_bbdd="bbdd/peliculas.json";
    $peli_json=file_get_contents($ruta_bbdd,FILE_USE_INCLUDE_PATH);
    $lista_peliculas=json_decode($peli_json);
    return $lista_peliculas;
}
function devolverPelicula($titulo){
    $lista_peliculas=obtener_peliculas();
    foreach ($lista_peliculas as $pelicula) {
        if ($pelicula->titulo===$titulo) {
            return $pelicula;
        }
    }
    return null;
}
function borrarPelicula($titulo){
    $lista_peliculas=obtener_peliculas();
    $nueva_lista_peliculas=[];
    $pelicula_a_borrar=null;
    foreach ($lista_peliculas as $pelicula) {
        if ($pelicula->titulo===$titulo) {
            $pelicula_a_borrar=$pelicula;
            break;
        }
    }
    if (is_null($pelicula_a_borrar)) {
        return false;
    }
    else{
        foreach ($lista_peliculas as $pelicula) {
            if ($pelicula_a_borrar->titulo!==$pelicula->titulo) {
                array_push($nueva_lista_peliculas,$pelicula);
            }
        }
        $ruta_bbdd="bbdd/peliculas.json";
        $peli_json=json_encode($nueva_lista_peliculas,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($ruta_bbdd,$peli_json);
        return true;
    }
}


?>