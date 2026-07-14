<?php

namespace App\Models;

use PDO;

class BaseModel
{
    protected $db;
    protected $table;
    protected ?int $companyId;

    public function __construct($db, $table)
    {
        $this->db = $db;
        $this->table = $table;
        $this->companyId = $_SESSION['company_id'] ?? null;
    }

    /**
     * Obtener el company_id de la sesión actual.
     * Lanza excepción si no hay empresa asociada.
     */
    protected function getCompanyId(): int
    {
        if (!$this->companyId) {
            throw new \RuntimeException('No hay empresa asociada a la sesión actual.');
        }
        return $this->companyId;
    }

    // Listar todos los registros (excepto eliminados) filtrados por empresa
    public function getAll()
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE company_id = :company_id AND deleted_at IS NULL ORDER BY date DESC"
        );
        $stmt->execute(['company_id' => $this->getCompanyId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Soft delete (validando empresa)
    public function softDelete($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id AND company_id = :company_id"
        );
        return $stmt->execute([
            'id' => $id,
            'company_id' => $this->getCompanyId()
        ]);
    }

    // Buscar registro por ID (validando empresa)
    public function findById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL"
        );
        $stmt->execute([
            'id' => $id,
            'company_id' => $this->getCompanyId()
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
