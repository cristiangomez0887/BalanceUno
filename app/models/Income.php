<?php
require_once __DIR__ . '/BaseModel.php';

class Income extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'incomes');
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
}
