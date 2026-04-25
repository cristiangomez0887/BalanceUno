<?php

namespace App\Models;

use PDO;

class Loan extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'loans');
    }

    // Listar todos los préstamos con sus pagos (Personalizado)
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT l.id, l.loan, l.amount, l.date, l.payment_method, l.code, l.status,
               COALESCE(SUM(e.amount), 0) AS pagado,
               (l.amount - COALESCE(SUM(e.amount),0)) AS saldo
        FROM loans l
        LEFT JOIN expenses e 
               ON l.id = e.loan_id AND e.deleted_at IS NULL
        WHERE l.deleted_at IS NULL
        GROUP BY l.id, l.loan, l.amount, l.payment_method, l.code, l.status
        ORDER BY l.created_at DESC;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear préstamo
    public function create($data)
    {
        //registrar en loans
        $description = $data['description'];
        unset($data['description']);
        $stmt = $this->db->prepare("INSERT INTO loans (loan, date, amount, payment_method, code) 
        VALUES (:loan, :date, :amount, :payment_method, :code)");
        $stmt->execute($data);

        $loanId = $this->db->lastInsertId();
        $data['loan_id'] = $loanId;
        $data['description'] = $description;
        unset($data['loan']);

        // Registrar también en incomes
        $stmt = $this->db->prepare("INSERT INTO incomes (date, description, amount, payment_method, code, loan_id) 
        VALUES (:date, :description, :amount, :payment_method, :code, :loan_id);");
        return $stmt->execute($data);
    }

    // Actualizar préstamo
    public function update($id, $data)
    {
        $data['id'] = $id; // Agregar el ID al array de datos para la consulta
        $stmt = $this->db->prepare("UPDATE loans 
            SET date = :date, loan = :loan, amount = :amount, payment_method = :payment_method, code = :code
            WHERE id = :id");
        return $stmt->execute($data);
    }

    public function loanPayment($data)
    {
        $stmt = $this->db->prepare("INSERT INTO expenses (date, description, amount, payment_method, code, loan_id) 
        VALUES (:date, :description, :amount, :payment_method, :code, :loan_id)");
        $stmt->execute($data);
    }
}
