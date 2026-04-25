<?php

namespace App\Models;

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

        return $stmt->execute([
            ':date'           => $data['date'],
            ':description'    => $data['description'],
            ':amount'         => $data['amount'],
            ':payment_method' => $data['payment_method'],
            ':code'           => $data['code'] ?? null
        ]);
    }

    // Actualizar ingreso
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE incomes 
            SET date = :date, description = :description, amount = :amount, payment_method = :payment_method, code = :code
            WHERE id = :id");

        return $stmt->execute([
            ':id'             => $id,
            ':date'           => $data['date'],
            ':description'    => $data['description'],
            ':amount'         => $data['amount'],
            ':payment_method' => $data['payment_method'],
            ':code'           => $data['code'] ?? null
        ]);
    }
}
