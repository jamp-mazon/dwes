<?php
session_start();
if (!isset($_SESSION["pulsaciones"])) {
    setcookie("pulsaciones",0,time()+(7*24*60*60),"/");
   
}

$pulsaciones=$_COOKIE["pulsaciones"];
setcookie("pulsaciones",++$pulsaciones,time()+(7*24*60*60),"/");
$boton=$_POST["boton"];

if ($boton==="bajar" && $_SESSION["numero"]>0) {
   $_SESSION["numero"]--;
   //setcookie("pulsaciones",$pulsaciones++,time()+(7*24*60*60),"/");

}
elseif ($boton==="subir" && $_SESSION["numero"]<9) {
    $_SESSION["numero"]++;
    //setcookie("pulsaciones",$pulsaciones++,time()+(7*24*60*60),"/");


}
elseif ($boton==="cero") {
    $_SESSION["numero"]=0;
    setcookie("pulsaciones",0,time()+(7*24*60*60),"/");
    
}
header("Location:index.php");
?>