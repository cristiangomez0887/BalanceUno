<?php

namespace App\Models;

use PDO;

class User extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'users');
    }

    /**
     * Buscar usuario por username con datos de empresa.
     * No filtra por company_id porque el login es global.
     */
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare(
            "SELECT u.*, c.name AS company_name, c.tax_rate AS company_tax_rate
             FROM users u
             INNER JOIN companies c ON u.company_id = c.id
             WHERE u.username = :username
             LIMIT 1"
        );
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
