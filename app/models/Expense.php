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

    // Obtener todos los pagos de un préstamo específico
    public function getPaymentsByLoanId($loanId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM expenses WHERE loan_id = :loan_id AND company_id = :company_id AND deleted_at IS NULL ORDER BY date DESC, id DESC"
        );
        $stmt->execute([':loan_id' => $loanId, ':company_id' => $this->getCompanyId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear gasto
    public function create($data)
    {

        if (isset($data['loan_id'])) {
            $loanId = $data['loan_id'];
            $amount = $data['amount'];
            $companyId = $this->getCompanyId();

            // 0. Traer nombre del préstamo
            $stmt = $this->db->prepare(
                "SELECT loan, amount FROM loans WHERE id = :loan_id AND company_id = :company_id AND deleted_at IS NULL"
            );
            $stmt->execute([':loan_id' => $loanId, ':company_id' => $companyId]);
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
                                      AND company_id = :company_id
                                      AND deleted_at IS NULL");
            $stmt->execute([':loan_id' => $loanId, ':company_id' => $companyId]);
            $pagadoActual = $stmt->fetchColumn() ?? 0;

            // 3. Calcular saldo pendiente
            $pendiente = $prestado - $pagadoActual;

            // 4. Validar pago
            if ($amount > $pendiente + 0.01) { // Tolerancia por decimales
                throw new Exception("El pago ($amount) no puede ser superior al saldo pendiente ($pendiente).");
            }

            // 5. Registrar pago (Filtrando datos)
            $stmt = $this->db->prepare("INSERT INTO expenses (company_id, date, description, amount, payment_method, code, loan_id, payment_status) 
                                      VALUES (:company_id, :date, :description, :amount, :payment_method, :code, :loan_id, :payment_status)");
            
            $stmt->execute([
                ':company_id'      => $companyId,
                ':date'            => $data['date'],
                ':description'     => $data['description'],
                ':amount'          => $data['amount'],
                ':payment_method'  => $data['payment_method'],
                ':code'            => $data['code'] ?? null,
                ':loan_id'         => $loanId,
                ':payment_status'  => 'Pagado'
            ]);

            // 6. Recalcular saldo total y actualizar estado
            $nuevoTotalPagado = $pagadoActual + $amount;
            $nuevoPendiente = $prestado - $nuevoTotalPagado;
            $nuevoEstado = ($nuevoPendiente <= 1) ? 'Pagado' : 'Pendiente'; // 1 peso de tolerancia

            $stmt = $this->db->prepare("UPDATE loans SET status = :status WHERE id = :loan_id AND company_id = :company_id");
            return $stmt->execute([
                ':status' => $nuevoEstado,
                ':loan_id' => $loanId,
                ':company_id' => $companyId
            ]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO expenses (company_id, date, description, amount, payment_method, code, category_id, payment_status)
                                      VALUES (:company_id, :date, :description, :amount, :payment_method, :code, :category_id, :payment_status)");

            return $stmt->execute([
                ':company_id'      => $this->getCompanyId(),
                ':date'            => $data['date'],
                ':description'     => $data['description'],
                ':amount'          => $data['amount'],
                ':payment_method'  => $data['payment_method'],
                ':code'            => $data['code'] ?? null,
                ':category_id'     => !empty($data['category_id']) ? $data['category_id'] : null,
                ':payment_status'  => $data['payment_status'] ?? 'Pagado'
            ]);
        }
    }

    // Actualizar gasto
    public function update($id, $data)
    {
        $existing = $this->findById($id);
        if (!$existing) {
            throw new Exception("El gasto no existe.");
        }

        $companyId = $this->getCompanyId();
        $oldLoanId = $existing['loan_id'];
        $newLoanId = $data['loan_id'] ?? $oldLoanId;

        if ($oldLoanId) { // Era un pago de préstamo
            $newAmount = $data['amount'];
            
            if ($newLoanId != $oldLoanId) {
                // Se cambió a otro préstamo
                $stmt = $this->db->prepare(
                    "SELECT loan, amount FROM loans WHERE id = :loan_id AND company_id = :company_id AND deleted_at IS NULL"
                );
                $stmt->execute([':loan_id' => $newLoanId, ':company_id' => $companyId]);
                $newLoanData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$newLoanData) {
                    throw new Exception("El nuevo préstamo seleccionado no existe.");
                }
                
                $data['description'] = "Pago Préstamo " . $newLoanData['loan'];
                
                $prestado = $newLoanData['amount'];
                $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount), 0) FROM expenses 
                                          WHERE loan_id = :loan_id AND company_id = :company_id AND deleted_at IS NULL");
                $stmt->execute([':loan_id' => $newLoanId, ':company_id' => $companyId]);
                $pagado = $stmt->fetchColumn() ?? 0;
                
                $pendiente = $prestado - $pagado;
                if ($newAmount > $pendiente + 0.01) {
                    throw new Exception("El nuevo monto ($newAmount) no puede ser superior al saldo restante del nuevo préstamo.");
                }

            } else {
                // Sigue siendo el mismo préstamo
                $data['description'] = $existing['description']; // Mantener descripción original

                $stmt = $this->db->prepare(
                    "SELECT amount FROM loans WHERE id = :loan_id AND company_id = :company_id AND deleted_at IS NULL"
                );
                $stmt->execute([':loan_id' => $oldLoanId, ':company_id' => $companyId]);
                $prestado = $stmt->fetchColumn();

                $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount), 0) FROM expenses 
                                          WHERE loan_id = :loan_id AND id != :id AND company_id = :company_id AND deleted_at IS NULL");
                $stmt->execute([':loan_id' => $oldLoanId, ':id' => $id, ':company_id' => $companyId]);
                $pagadoOtros = $stmt->fetchColumn() ?? 0;

                $pendienteSinEstePago = $prestado - $pagadoOtros;

                if ($newAmount > $pendienteSinEstePago + 0.01) {
                    throw new Exception("El nuevo monto ($newAmount) no puede ser superior al saldo restante del préstamo.");
                }
            }
        }

        // Actualizar
        if ($oldLoanId) {
            $stmt = $this->db->prepare("UPDATE expenses 
                SET date = :date, description = :description, amount = :amount, payment_method = :payment_method, code = :code, loan_id = :loan_id
                WHERE id = :id AND company_id = :company_id");
                
            $result = $stmt->execute([
                ':id'             => $id,
                ':company_id'     => $companyId,
                ':date'           => $data['date'],
                ':description'    => $data['description'],
                ':amount'         => $data['amount'],
                ':payment_method' => $data['payment_method'],
                ':code'           => $data['code'] ?? null,
                ':loan_id'        => $newLoanId
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE expenses 
                SET date = :date, description = :description, amount = :amount, payment_method = :payment_method, 
                    code = :code, category_id = :category_id, payment_status = :payment_status
                WHERE id = :id AND company_id = :company_id");
                
            $result = $stmt->execute([
                ':id'             => $id,
                ':company_id'     => $companyId,
                ':date'           => $data['date'],
                ':description'    => $data['description'],
                ':amount'         => $data['amount'],
                ':payment_method' => $data['payment_method'],
                ':code'           => $data['code'] ?? null,
                ':category_id'    => !empty($data['category_id']) ? $data['category_id'] : null,
                ':payment_status' => $data['payment_status'] ?? 'Pagado'
            ]);
        }

        if ($oldLoanId) {
            $this->updateLoanStatus($oldLoanId);
            if ($newLoanId != $oldLoanId) {
                $this->updateLoanStatus($newLoanId);
            }
        }

        return $result;
    }

    // Soft delete de gasto
    public function softDelete($id)
    {
        $existing = $this->findById($id);
        if (!$existing) {
            return false;
        }

        $result = parent::softDelete($id);

        if ($existing['loan_id'] && $result) {
            $this->updateLoanStatus($existing['loan_id']);
        }

        return $result;
    }

    private function updateLoanStatus($loanId)
    {
        $companyId = $this->getCompanyId();

        $stmt = $this->db->prepare("SELECT amount FROM loans WHERE id = :loan_id AND company_id = :company_id");
        $stmt->execute([':loan_id' => $loanId, ':company_id' => $companyId]);
        $prestado = $stmt->fetchColumn();

        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(amount), 0) FROM expenses WHERE loan_id = :loan_id AND company_id = :company_id AND deleted_at IS NULL"
        );
        $stmt->execute([':loan_id' => $loanId, ':company_id' => $companyId]);
        $pagado = $stmt->fetchColumn() ?? 0;

        $nuevoPendiente = $prestado - $pagado;
        $nuevoEstado = ($nuevoPendiente <= 1) ? 'Pagado' : 'Pendiente';

        $stmt = $this->db->prepare("UPDATE loans SET status = :status WHERE id = :loan_id AND company_id = :company_id");
        $stmt->execute([':status' => $nuevoEstado, ':loan_id' => $loanId, ':company_id' => $companyId]);
    }

    public function getLoans()
    {
        $stmt = $this->db->prepare("SELECT l.id, l.loan, l.amount, l.payment_method, l.code,
        COALESCE(SUM(e.amount), 0) AS pagado,
        (l.amount - COALESCE(SUM(e.amount),0)) AS pendiente
        FROM loans l
        LEFT JOIN expenses e ON l.id = e.loan_id 
        AND e.deleted_at IS NULL AND e.company_id = :company_id2
        WHERE l.deleted_at IS NULL 
        AND l.company_id = :company_id
        AND l.status = 'pendiente'
        GROUP BY l.id, l.loan, l.amount, l.payment_method, l.code
    ");
        $stmt->execute([
            ':company_id' => $this->getCompanyId(),
            ':company_id2' => $this->getCompanyId()
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
