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

    // Listar ingresos
    public function index()
    {
        $incomes = $this->model->getAll();
        include __DIR__ . '/../../views/incomes.php';
    }

    // Crear ingreso
    public function create($data)
    {
        // Validación estricta
        if (empty($data['description']) || empty($data['amount']) || empty($data['payment_method'])) {
            $this->respondError('Todos los campos obligatorios deben ser completados.');
        }

        if (empty($data['date'])) {
            $data['date'] = date('Y-m-d'); // formato ISO para la BD
        } else {
            // convertir de dd/mm/yyyy a yyyy-mm-dd
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
            echo json_encode(['success' => true, 'message' => 'Ingreso creado correctamente']);
            exit;
        }

        header("Location: ?action=incomes");
        exit;
    }

    // Editar ingreso
    public function update($id, $data)
    {
        // Recuperar el registro actual
        $existing = $this->model->findById($id);

        // Si viene fecha en el formulario, convertirla al formato ISO
        if (!empty($data['date'])) {
            $parts = explode('/', $data['date']);
            if (count($parts) === 3) {
                $data['date'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        } else {
            // Si no viene fecha, conservar la original
            $data['date'] = $existing['date'];
        }

        // Recibir datos del formulario
        $amount = $data['amount'];

        // Normalizar: quitar puntos de miles y convertir coma en punto decimal
        $amount = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount);

        // Convertir a número
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
