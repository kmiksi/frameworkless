<?php

class Model {

    private static $db = null;

    public function __construct() {
        try {
            $datasoursename = DBConfig::TYPE . ':host=' . DBConfig::HOST . ';dbname=' . DBConfig::NAME;
            $options = array(
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            );

            self::db = new PDO($datasoursename, DBConfig::USER, DBConfig::PASS, $options);
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function db() {
        return self::$db;
    }

    public function query($sql, $named_params = array()) {
        $query = $this->db()->prepare($sql);
        $query->execute($named_params);

        return $query->fetchAll();
    }

}
