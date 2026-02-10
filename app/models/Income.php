<?php
class Income
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Listar todos los ingresos (excepto eliminados)
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM incomes WHERE deleted_at IS NULL ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Crear ingreso
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO incomes (date, description, amount, payment_method, code)
            VALUES (:date, :description, :amount, :payment_method, :code)");
        return $stmt->execute($data);
    }

    // Actualizar ingreso
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE incomes 
            SET date = :date, description = :description, amount = :amount, payment_method = :payment_method, code = :code
            WHERE id = :id");
        $data['id'] = $id; // Agregar el ID al array de datos para la consulta
        return $stmt->execute($data);
    }

    // Soft delete
    public function softDelete($id)
    {
        $stmt = $this->db->prepare("UPDATE incomes SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Buscar Ingreso por ID
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM incomes WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
