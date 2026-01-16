<?php
require __DIR__ ."/../../vendor/autoload.php";
use Api\models\Basedatos;
function comprobarkey($key){
    if ($key==="" || $key===null) return null;
    $mibd=new Basedatos();
    $sql="SELECT * FROM api_keys WHERE key_hash=:key_hash";
    $key_hash=hash("SHA256",$key);
    $param=[":key_hash"=>$key_hash];

    $sentencia=$mibd->get_data($sql,$param);
    $registro=$sentencia->fetch(PDO::FETCH_ASSOC);
    if ($registro===false) {
        return null;
    }

    return $registro;

}
?>