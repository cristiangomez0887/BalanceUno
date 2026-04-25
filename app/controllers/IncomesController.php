<?php

namespace App\Controllers;

use App\Models\Income;

class IncomesController
{

    private $model;

    public function __construct($db)
    {
        $this->model = new Income($db);
    }

    // Listar ingresos
    public function index()
    {
        $incomes = $this->model->getAll();
        include __DIR__ . '/../../views/incomes.php';
    }

    // Crear ingreso
    public function create($data)
    {
        if (empty($data['date'])) {
            $data['date'] = date('Y-m-d'); // formato ISO para la BD
        } else {
            // convertir de dd/mm/yyyy a yyyy-mm-dd
            $parts = explode('/', $data['date']);
            if (count($parts) === 3) {
                $data['date'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }

        // Recibir datos del formulario
        $amount = $data['amount'];

        // Normalizar: quitar puntos de miles y convertir coma en punto decimal
        $amount = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount);

        // Convertir a número
        $data['amount'] = (float) $amount;

        $this->model->create($data);
        header("Location: ?action=incomes");
        exit;
    }

    // Editar ingreso
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
            echo json_encode(['success' => true, 'message' => 'Ingreso actualizado correctamente']);
            exit;
        }

        header("Location: ?action=incomes");
        exit;
    }

    // Eliminar ingreso (soft delete)
    public function delete($id)
    {
        $this->model->softDelete($id);

        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'message' => 'Ingreso eliminado correctamente']);
            exit;
        }

        header("Location: ?action=incomes");
        exit;
    }

    private function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    // Exportar a Excel
    public function exportXls()
    {
        $incomes = $this->model->getAll();
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=incomes.xls");

        echo "Fecha\tDescripción\tMonto\tMétodo\tCódigo\n";
        foreach ($incomes as $income) {
            echo "{$income['date']}\t{$income['description']}\t{$income['amount']}\t{$income['payment_method']}\t{$income['code']}\n";
        }
        exit;
    }
}
