<?php

namespace App\Models;

use PDO;

class User
{
    public static function where($column, $value)
    {
        $stmt = self::getConnection()->prepare("SELECT * FROM users WHERE $column = :value");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetchObject(self::class);

        return $result ? $result : false;
    }

    public static function find($id)
    {
        $stmt = self::getConnection()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchObject(self::class);

        return $result ? $result : false;
    }

    public function save()
    {
        $stmt = self::getConnection()->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute(['email' => $this->email, 'password' => $this->password]);
        $this->id = self::getConnection()->lastInsertId();
    }

    private static function getConnection()
    {
        static $connection;

        if (!$connection) {
            $connection = new PDO('mysql:host=localhost;dbname=practice', 'root', '');
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $connection;
    }
}
