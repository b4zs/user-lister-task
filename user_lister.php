<?php

class MysqliDatabaseDriver
{
    public function query($queryString, array $parameters): array
    {
        //...
        return [['id' => 1, 'username' => 'msqli-test']];
    }
}

class PdoDatabaseDriver
{
    function query($queryString, array $parameters): array
    {
        //...
        return [['id' => 2, 'username' => 'pdo-test']];
    }
}

class UserModel
{
    public $id;
    public $username;
}

class UserManager
{
    /** @var MysqliDatabaseDriver */
    public static $database;

    public function __construct()
    {
        self::$database = new MysqliDatabaseDriver();
    }

    public static function listUsers()
    {
        return array_map([new self(), 'hydrateUserRecord'], self::$database->query('SELECT * FROM users', []));
    }

    private function hydrateUserRecord(array $record): UserModel
    {
        $user = new UserModel();
        $user->id = $record['id'];
        $user->username = $record['username'];

        return $user;
    }
}

class UserController{
    public function listUsers()
    {
        return UserManager::listUsers();
    }
}

//main
$controller = new UserController();
var_dump($controller->listUsers());

