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
        $existing = $this->findById($id);
        if (!$existing) {
            throw new \Exception("El ingreso no existe.");
        }

        if ($existing['loan_id']) {
            $loanId = $existing['loan_id'];
            $data['description'] = $existing['description']; // Mantener descripción original

            // Validar que el nuevo monto no sea inferior a lo ya pagado
            $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount), 0) FROM expenses WHERE loan_id = :loan_id AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $pagado = $stmt->fetchColumn() ?? 0;

            if ($data['amount'] < $pagado) {
                throw new \Exception("El nuevo monto del préstamo no puede ser menor a lo que ya se ha pagado ($pagado).");
            }

            // Reflejar en loans
            $stmt = $this->db->prepare("UPDATE loans 
                SET date = :date, amount = :amount, payment_method = :payment_method, code = :code
                WHERE id = :id");
            $stmt->execute([
                ':id'             => $loanId,
                ':date'           => $data['date'],
                ':amount'         => $data['amount'],
                ':payment_method' => $data['payment_method'],
                ':code'           => $data['code'] ?? null
            ]);
        }

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

    public function softDelete($id)
    {
        $existing = $this->findById($id);
        if (!$existing) {
            return false;
        }

        if ($existing['loan_id']) {
            $loanId = $existing['loan_id'];

            // Verificar si tiene pagos asociados
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM expenses WHERE loan_id = :loan_id AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $pagos = $stmt->fetchColumn();

            if ($pagos > 0) {
                throw new \Exception("No se puede eliminar el préstamo porque ya tiene pagos registrados. Elimine los pagos primero.");
            }

            // Eliminar de loans
            $stmt = $this->db->prepare("UPDATE loans SET deleted_at = NOW() WHERE id = :id");
            $stmt->execute([':id' => $loanId]);
        }

        return parent::softDelete($id);
    }
}
