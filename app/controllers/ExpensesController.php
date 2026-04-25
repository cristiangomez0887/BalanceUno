<?php

namespace App\Controllers;

use App\Models\Expense;

class ExpensesController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new Expense($db);
    }

    private function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    private function respondError($message)
    {
        if ($this->isAjax()) {
            echo json_encode(['success' => false, 'message' => $message]);
        } else {
            die($message);
        }
        exit;
    }

    // Listar gastos
    public function index()
    {
        $expenses = $this->model->getAll();
        $loans = $this->model->getLoans();
        include __DIR__ . '/../../views/expenses.php';
    }

    // Crear gasto
    public function create($data)
    {
        // Validación estricta
        if (empty($data['description']) || empty($data['amount']) || empty($data['payment_method'])) {
            $this->respondError('Todos los campos obligatorios deben ser completados.');
        }

        if (empty($data['date'])) {
            $data['date'] = date('Y-m-d'); // formato ISO
        } else {
            $parts = explode('/', $data['date']);
            if (count($parts) === 3) {
                $data['date'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }

        // Normalizar: quitar puntos de miles y convertir coma en punto decimal
        $amount = str_replace('.', '', $data['amount']);
        $amount = str_replace(',', '.', $amount);

        // Convertir a número
        $data['amount'] = (float) $amount;

        if ($data['amount'] <= 0) {
            $this->respondError('El monto debe ser un valor positivo.');
        }

        $this->model->create($data);

        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'message' => 'Gasto creado correctamente']);
            exit;
        }

        header("Location: ?action=expenses");
        exit;
    }


    // Editar gasto
    public function update($id, $data)
    {
        if (!empty($data['date'])) {
            $parts = explode('/', $data['date']);
            if (count($parts) === 3) {
                $data['date'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }

        $amount = str_replace('.', '', $data['amount']);
        $amount = str_replace(',', '.', $amount);
        $data['amount'] = (float) $amount;

        $this->model->update($id, $data);

        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'message' => 'Gasto actualizado correctamente']);
            exit;
        }

        header("Location: ?action=expenses");
        exit;
    }

    // Eliminar gasto (soft delete)
    public function delete($id)
    {
        $this->model->softDelete($id);

        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'message' => 'Gasto eliminado correctamente']);
            exit;
        }

        header("Location: ?action=expenses");
        exit;
    }

    // Exportar a Excel
    public function exportXls()
    {
        $expenses = $this->model->getAll();
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=expenses.xls");

        echo "Fecha\tDescripción\tMonto\tMétodo\tCódigo\n";
        foreach ($expenses as $expense) {
            echo "{$expense['date']}\t{$expense['description']}\t{$expense['amount']}\t{$expense['payment_method']}\t{$expense['code']}\n";
        }
        exit;
    }
}
