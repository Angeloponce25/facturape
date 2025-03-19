<?php
namespace Conect;

 date_default_timezone_set('America/Lima'); 
 class Conexion{
        const HOST = 'localhost';
        const USER = 'root';
        const PASSWORD = '';
        const BDNAME = 'simvetec_billing';
    public static function conectar() {
        $link = new \PDO("mysql:host=".self::HOST."; dbname=".self::BDNAME.";",self::USER, self::PASSWORD);
        $link->exec("set names utf8");
        return $link;
    }
}
