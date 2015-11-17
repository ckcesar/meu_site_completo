<?php

namespace Application\Model;

class Cliente extends AbstractModel {

    protected $table;

    public function __construct($table) {
        $this->table = $table;
    }

    public function listar($fields = " SQL_NO_CACHE *", $where = "", $orderby = "", $limit = null, $offset = null) {
        $con = $this->getConnection();
        $where = (!empty($where) ? (" WHERE {$where} ") : "");
        $orderby = (!empty($orderby) ? (" ORDER BY {$orderby} ") : "");
        $limit = (!is_null($limit) ? (" LIMIT {$limit} ") : "");
        $offset = (!is_null($offset) ? (" OFFSET {$offset} ") : "");

        $sql = "SELECT {$fields} FROM {$this->table} {$where} {$orderby} {$limit} {$offset}";
        //exit($sql);
        //echo $sql;

        return $con->query($sql);
    }

    public function insert(array $dados){
        $db = $this->getConnection();
        $campos = implode(", ", array_keys($dados) );
        $valores = "'".implode("', '" , array_values($dados))."'" ;
        $sql = " insert into `{$this->table}` ({$campos}) values ({$valores}) ";
        return $db->execute($sql);
    }

    public function update(Array $dados, $where){
        $ddup = $this->getConnection();
        foreach($dados as $ind => $val){
            $campos[] = "{$ind} = '{$val}'";
        }
        $campos = implode(", ", $campos);
        $up = " update `{$this->table}` set {$campos} where {$where} ";
        return $ddup->execute($up);

    }

    public function del($where){
        $del = $this->getConnection();
        $d = "delete from `{$this->table}` where {$where} ";
        return $del->execute($d);
    }

}