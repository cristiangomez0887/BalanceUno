-- Crear base de datos
CREATE DATABASE balanceuno CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE balanceuno;

-- Tabla de ingresos
CREATE TABLE incomes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  payment_method ENUM('Efectivo','Nequi','Transferencia') NOT NULL,
  code VARCHAR(50) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabla de gastos (similar a ingresos)
CREATE TABLE expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  payment_method ENUM('Efectivo','Nequi','Transferencia') NOT NULL,
  code VARCHAR(50) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);