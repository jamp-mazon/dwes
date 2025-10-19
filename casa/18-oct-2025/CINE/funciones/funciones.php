<?php
    function recogerDato($var){
        if(isset($_REQUEST[$var]) && $_REQUEST[$var]!=""){
            $campo=trim(htmlspecialchars(strip_tags($_POST[$var])));
                return $campo;
        }
        return null;
    }
    function recogerEmail($var){
        if(isset($_REQUEST[$var]) && $_REQUEST[$var]!=""){
            $email=filter_var($_REQUEST[$var], FILTER_VALIDATE_EMAIL);
            return $email;
        }
        return null;
    }
    function existe_email($email){
        $lista_usuarios=[];
        $ruta="bbdd/data.json";
        $data=file_get_contents($ruta,DEFAULT_INCLUDE_PATH);
        $lista_usuarios=json_decode($data);
        foreach ($lista_usuarios as $user) {
            if ($user->email===$email) {
                return true;
            }
        }
        return false;
    }
    function recogerPass($var){
        if(isset($_REQUEST[$var]) && $_REQUEST[$var]!=""){
            $campo=trim($_POST[$var]);
                return $campo;
        }
        return null;
        
    }    
    function comprobar_login($email,$password){
        $emailOK=false;
        $passwordOK=false;
        $lista_usuarios=[];
        $ruta="bbdd/data.json";
        $data=file_get_contents($ruta,DEFAULT_INCLUDE_PATH);//cojo el contenido del data.
        $lista_usuarios=json_decode($data,true);//lo meto dentro del array vacio

        foreach ($lista_usuarios as $usuario) {
        $emailOK=false;//despues de cada usuario formateo los booleanos por seguridad
        $passwordOK=false;            
            foreach ($usuario as $llave => $valor) {
                if ($llave==="email") {
                    if ($email===$valor) {
                        $emailOK=true;
                    }
                }
                if ($llave==="password") {
                    if (password_verify($password,$valor)) {
                        $passwordOK=true;
                    }
                }

            }//salida del foreach interno
                if ($emailOK && $passwordOK) {//despues de comprobar al usuario si el email y pass son ok he encontrado al user
                    return true;
                }
        }
        return false;
    }

    

?>
