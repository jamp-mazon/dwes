<?php
namespace App\models;
require __DIR__. "/../../vendor/autoload.php";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class log{
    private Logger $log;

    public function __construct(string $archivo_destino)
    {
        $this->log=new Logger("miLog");
        $this->log->pushHandler(new StreamHandler((__DIR__."/../../$archivo_destino.log")));

    }
    

    /**
     * Get the value of log
     */ 
    public function getLog()
    {
        return $this->log;
    }
}


?>