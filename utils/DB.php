<?php

class DB
{
    private $pdo;

    private static $instance = null;

    private function __construct($dsn, $user, $password)
    {
        try {
            $this->pdo = new \PDO($dsn, $user, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            // Handle connection error
            die("Connection failed: " . $e->getMessage());
        }
    }

	/**
	 * get instance
	 */
    public static function getInstance($dsn = 'mysql:dbname=phptest;host=127.0.0.1', $user = 'root', $password = 'pass')
    {
        if (null === static::$instance) {
            static::$instance = new static($dsn, $user, $password);
        }
        return static::$instance;
    }

	/**
	 * select query
	 */
    public function select($sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll();
    }

	/**
	 * execute query
	 */
    public function exec($sql)
    {
        return $this->pdo->exec($sql);
    }

	/**
	 * get last inserted id
	 */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

	/**
	 * close connection
	 */
    public function close()
    {
        $this->pdo = null;
    }
}