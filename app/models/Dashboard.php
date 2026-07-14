<?php

namespace App\Models;

class Dashboard extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'incomes');
    }

    public function getData()
    {
        $companyId = $this->getCompanyId();

        // Ingresos Totales
        $stmt = $this->db->prepare("SELECT SUM(amount) AS total FROM incomes WHERE company_id = :company_id AND deleted_at IS NULL");
        $stmt->execute([':company_id' => $companyId]);
        $incomes = $stmt->fetchColumn() ?? 0;

        // Gastos Totales
        $stmt = $this->db->prepare("SELECT SUM(amount) AS total FROM expenses WHERE company_id = :company_id AND deleted_at IS NULL");
        $stmt->execute([':company_id' => $companyId]);
        $expenses = $stmt->fetchColumn() ?? 0;

        // Totales
        $balance = $incomes - $expenses;

        return [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'balance' => $balance,
        ];
    }
}
