<?php

namespace App\Models;

use PDO;

class User extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'users');
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
