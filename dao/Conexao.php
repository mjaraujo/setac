<?php

class Conexao {
    public static $instance;

    private static $localbd = 'localhost';
    private static $nomebd = 'setac';
    private static $usuario = 'root';
    private static $senhabd = 'utfprsh';

    private function __construct(){}

    public static function getInstance(){
        if (!isset(self::$instance)){
            self::$instance = new PDO('mysql:host='.self::$localbd.';dbname='.self::$nomebd.';charset=utf8', self::$usuario, self::$senhabd);
        }
        return self::$instance;
    }

}