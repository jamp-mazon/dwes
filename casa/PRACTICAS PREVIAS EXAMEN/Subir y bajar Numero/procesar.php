<?php
session_start();
if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:index.php");
    die;
}
else{
    $pulsaciones=$_COOKIE["pulsaciones"]??0;
    setcookie("pulsaciones",++$pulsaciones,time()+(7*24*60*60),"/");
    $boton_pulsado=$_POST["accion"]??"";
    if (empty($boton_pulsado)) {
        header("Location:index.php");
        die;
    }
    else{
        $_SESSION["numero"]=$_SESSION["numero"]??0;
        if ($boton_pulsado==="bajar") {
            $_SESSION["numero"]--;
            if ($_SESSION["numero"]<0) {
                $_SESSION["numero"]=0;
            }
            header("Location:index.php");
            die;
        }
        elseif ($boton_pulsado==="subir"){
            $_SESSION["numero"]++;
            if ($_SESSION["numero"]>9) {
                $_SESSION["numero"]=9;
            }
            header("Location:index.php");
            die;            
        }
        elseif ($boton_pulsado==="cero") {
            $_SESSION["numero"]=0;
            setcookie("pulsaciones",0,time()+(7*24*60*60),"/");
            header("Location:index.php");
            die;            
        }
    }
       
    
}

?>