<?php

namespace App\Models;

use PDO;
use Exception;

class Expense extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'expenses');
    }

    // Crear gasto
    public function create($data)
    {

        if (isset($data['loan_id'])) {
            $loanId =  $data['loan_id'];
            $amount = $data['amount'];

            //0. Traer préstamo
            $stmt = $this->db->prepare("SELECT loan FROM loans WHERE id = :loan_id AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $loan = $stmt->fetchColumn() ?? null;

            // Construir la descripción con el código del préstamo
            if ($loan)
                $data['description'] = "Pago Préstamo " . $loan;
            else
                $data['description'] = "Pago Préstamo " . $loanId;

            // 1. Obtener total prestado
            $stmt = $this->db->prepare("SELECT amount FROM loans WHERE id = :loan_id AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $prestado = $stmt->fetchColumn() ?? 0;

            // 2. Obtener total pagado
            $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount),0) 
            FROM expenses 
            WHERE loan_id = :loan_id 
            AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $pagado = $stmt->fetchColumn() ?? 0;

            // 3. Calcular saldo pendiente
            $pendiente = $prestado - $pagado;

            // 4. Validar pago
            if ($amount > $pendiente) {
                throw new Exception("El pago ($amount) no puede ser superior al saldo pendiente ($pendiente).");
            }

            // 5. Registrar pago
            $stmt = $this->db->prepare("INSERT INTO expenses (date, description, amount, payment_method, code, loan_id) 
            VALUES (:date, :description, :amount, :payment_method, :code, :loan_id)");
            $stmt->execute($data);
            // 6. Recalcular saldo y actualizar estado
            $nuevoPagado = $pagado + $amount;
            $nuevoPendiente = $prestado - $nuevoPagado;

            $nuevoEstado = ($nuevoPendiente <= 0) ? 'Pagado' : 'Pendiente';

            $stmt = $this->db->prepare("UPDATE loans SET status = :status WHERE id = :loan_id");
            return $stmt->execute([
                ':status' => $nuevoEstado,
                ':loan_id' => $loanId
            ]);
        } else
            $stmt = $this->db->prepare("INSERT INTO expenses (date, description, amount, payment_method, code)
            VALUES (:date, :description, :amount, :payment_method, :code)");

        return $stmt->execute($data);
    }

    // Actualizar gasto
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE expenses 
            SET date = :date, description = :description, amount = :amount, payment_method = :payment_method, code = :code
            WHERE id = :id");
        $data['id'] = $id; // Agregar el ID al array de datos para la consulta
        return $stmt->execute($data);
    }

    public function getLoans()
    {
        $stmt = $this->db->prepare("SELECT l.id, l.loan, l.amount, l.payment_method, l.code,
        COALESCE(SUM(e.amount), 0) AS pagado,
        (l.amount - COALESCE(SUM(e.amount),0)) AS pendiente
        FROM loans l
        LEFT JOIN expenses e ON l.id = e.loan_id 
        AND e.deleted_at IS NULL
        WHERE l.deleted_at IS NULL 
        AND l.status = 'pendiente'
        GROUP BY l.id, l.loan, l.amount, l.payment_method, l.code
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
