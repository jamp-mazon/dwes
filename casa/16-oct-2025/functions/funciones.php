<?php
    function recoger_valor($var){
        if (isset($_REQUEST[$var]) && $_REQUEST[$var]!="") {
            $devolver_valor=trim(htmlspecialchars(strip_tags($_REQUEST[$var])));
            return $devolver_valor;
        }
        return null;
    }
    function recoger_email($var){
        if (isset($_REQUEST[$var]) && $_REQUEST[$var]!="") {
            if (filter_var($_REQUEST[$var],FILTER_VALIDATE_EMAIL)) {//si el formato es correcto
                $devolver_correo=trim($_REQUEST[$var]);
                return $devolver_correo;                
            }
        }
        return null;
    }
    function recoger_password($var){
        if (isset($_REQUEST[$var]) && $_REQUEST[$var]!="") {
            $devolver_pass=trim($_REQUEST[$var]);
            return $devolver_pass;
        }
        return null;
    }
?>