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
            $loanId = $data['loan_id'];
            $amount = $data['amount'];

            // 0. Traer nombre del préstamo
            $stmt = $this->db->prepare("SELECT loan, amount FROM loans WHERE id = :loan_id AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $loanData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$loanData) {
                throw new Exception("El préstamo seleccionado no existe.");
            }

            $loanName = $loanData['loan'];
            $prestado = $loanData['amount'];

            // Construir la descripción
            $data['description'] = "Pago Préstamo " . $loanName;

            // 2. Obtener total pagado hasta ahora
            $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount), 0) 
                                      FROM expenses 
                                      WHERE loan_id = :loan_id 
                                      AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId]);
            $pagadoActual = $stmt->fetchColumn() ?? 0;

            // 3. Calcular saldo pendiente
            $pendiente = $prestado - $pagadoActual;

            // 4. Validar pago
            if ($amount > $pendiente + 0.01) { // Tolerancia por decimales
                throw new Exception("El pago ($amount) no puede ser superior al saldo pendiente ($pendiente).");
            }

            // 5. Registrar pago (Filtrando datos)
            $stmt = $this->db->prepare("INSERT INTO expenses (date, description, amount, payment_method, code, loan_id) 
                                      VALUES (:date, :description, :amount, :payment_method, :code, :loan_id)");
            
            $stmt->execute([
                ':date'           => $data['date'],
                ':description'    => $data['description'],
                ':amount'         => $data['amount'],
                ':payment_method' => $data['payment_method'],
                ':code'           => $data['code'] ?? null,
                ':loan_id'        => $loanId
            ]);

            // 6. Recalcular saldo total y actualizar estado
            $nuevoTotalPagado = $pagadoActual + $amount;
            $nuevoPendiente = $prestado - $nuevoTotalPagado;
            $nuevoEstado = ($nuevoPendiente <= 1) ? 'Pagado' : 'Pendiente'; // 1 peso de tolerancia

            $stmt = $this->db->prepare("UPDATE loans SET status = :status WHERE id = :loan_id");
            return $stmt->execute([
                ':status' => $nuevoEstado,
                ':loan_id' => $loanId
            ]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO expenses (date, description, amount, payment_method, code)
                                      VALUES (:date, :description, :amount, :payment_method, :code)");

            return $stmt->execute([
                ':date'           => $data['date'],
                ':description'    => $data['description'],
                ':amount'         => $data['amount'],
                ':payment_method' => $data['payment_method'],
                ':code'           => $data['code'] ?? null
            ]);
        }
    }

    // Actualizar gasto
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE expenses 
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
