<?php

namespace App\Models;

use PDO;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct($db, $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    // Listar todos los registros (excepto eliminados)
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Soft delete
    public function softDelete($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Buscar registro por ID
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
