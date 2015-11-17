<?php

namespace Application\Database;

class Connection {

    public $debug = false;
    private static $pdo;
    private $statement;

    public function __construct($host, $user, $pass, $name, $charset = "UTF8") {

        if (is_null(self::$pdo)) { // Se não existe nenhuma instância do PDO
            $dsn = "mysql:host={$host};dbname={$name};charset={$charset}";
            $conf = array(
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            );

            self::$pdo = new \PDO($dsn, $user, $pass, $conf);
        }
    }

    /**
     * Executa uma query sem retornar valores
     * utilizados em update e delete onde não se obtem retorno
     *
     * @param string $sql Comando SQL a ser executado
     * @param array $data Dados a serem passados no comando
     * @return bool
     */
    public function execute($sql, $data = null) {

        if ($this->debug) {
            var_dump($sql, $data);
        }

        $this->statement = self::$pdo->prepare($sql);

        try {
            $this->statement->execute($data);
            return true;
        } catch (\Exception $ex) {
            throw new Exception\SQLException($ex->getMessage());
        }
    }

    /**
     * Executa uma query e retorna um valor
     * utilizado em select onde se obtem retorno
     *
     * @param string $sql Comando SQL a ser executado
     * @param array $data Dados a serem passados no comando
     * @return ResultSet
     */
    public function query($sql, $data = null) {

        try {
            $this->execute($sql, $data);
            return new ResultSet($this->statement->fetchAll());
        } catch (\Exception $ex) {
            throw new Exception\SQLException($ex->getMessage());
        }
    }

}
