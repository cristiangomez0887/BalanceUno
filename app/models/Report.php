<?php

namespace App\Models;

use PDO;

class Report
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getIncomes($startDate, $endDate)
    {
        $stmt = $this->db->prepare("SELECT * FROM incomes WHERE date BETWEEN ? AND ? AND deleted_at IS NULL");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExpenses($startDate, $endDate)
    {
        $stmt = $this->db->prepare("SELECT * FROM expenses WHERE date BETWEEN ? AND ? AND deleted_at IS NULL");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotals($startDate, $endDate)
    {
        $stmt = $this->db->prepare("SELECT 
                (SELECT COALESCE(SUM(amount),0) FROM incomes WHERE date BETWEEN ? AND ? AND deleted_at IS NULL) AS totalIncomes,
                (SELECT COALESCE(SUM(amount),0) FROM expenses WHERE date BETWEEN ? AND ? AND deleted_at IS NULL) AS totalExpenses
        ");
        $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPaymentSummary($startDate, $endDate)
    {
        $stmt = $this->db->prepare("SELECT payment_method, SUM(amount) as total, 'Ingreso' as tipo
            FROM incomes WHERE date BETWEEN ? AND ? AND deleted_at IS NULL GROUP BY payment_method
            UNION ALL
            SELECT payment_method, SUM(amount) as total, 'Gasto' as tipo
            FROM expenses WHERE date BETWEEN ? AND ? AND deleted_at IS NULL GROUP BY payment_method
        ");
        $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
