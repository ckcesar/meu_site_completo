<?php

namespace Application\Model;

use Application\Database\Connection;

abstract class AbstractModel implements ModelInterface {

    protected static $connection;

    /**
     * Faz a conexão com a base de dados
     *
     * @return \Application\Database\Connection
     */
    public function connect() {

//        $this->db = new Connection("localhost", "root", "", "sistem_pro");
        return is_null(self::$connection) ? new Connection("localhost", "root", "", "gestor_web") : self::$connection;
        //return is_null(self::$connection) ? new Connection("mysql.hostinger.com.br", "u858834861_cesar", "cesark123", "u858834861_gd") : self::$connection;
    }

    /**
     * Retorna a conexão para uso
     *
     * @return \Application\Database\Connection
     */
    public function getConnection() {

        return $this->connect();
    }



}
