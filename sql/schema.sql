-- ============================================================
-- BalanceUno — Schema Multi-Tenant
-- Ejecutar: mysql -u root < schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS balanceuno
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE balanceuno;

-- Eliminar tablas si existen (orden inverso de FKs)
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS stock_movements;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS loans;
DROP TABLE IF EXISTS expenses;
DROP TABLE IF EXISTS incomes;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS companies;

-- ============================================================
-- 1. EMPRESAS
-- ============================================================
CREATE TABLE companies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  nit VARCHAR(20) DEFAULT NULL,
  address VARCHAR(255) DEFAULT NULL,
  phone VARCHAR(20) DEFAULT NULL,
  tax_rate DECIMAL(5,2) DEFAULT NULL COMMENT 'Porcentaje de impuesto (NULL = sin impuesto)',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- 2. USUARIOS (vinculados a empresa)
-- ============================================================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_username (username),
  FOREIGN KEY (company_id) REFERENCES companies(id)
) ENGINE=InnoDB;

-- ============================================================
-- 3. CATEGORÍAS (por empresa)
-- ============================================================
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  date DATE NULL DEFAULT NULL,
  name VARCHAR(100) NOT NULL,
  type ENUM('ingreso','gasto','ambos') NOT NULL DEFAULT 'ambos',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  INDEX idx_company (company_id)
) ENGINE=InnoDB;

-- ============================================================
-- 4. INGRESOS
-- ============================================================
CREATE TABLE incomes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  date DATE NOT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(12, 2) NOT NULL,
  payment_method ENUM('Efectivo', 'Nequi', 'Transferencia') NOT NULL,
  code VARCHAR(50) DEFAULT NULL,
  category_id INT DEFAULT NULL,
  payment_status ENUM('Pagado', 'Pendiente') DEFAULT 'Pagado',
  loan_id INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  INDEX idx_company_deleted (company_id, deleted_at)
) ENGINE=InnoDB;

-- ============================================================
-- 5. GASTOS
-- ============================================================
CREATE TABLE expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  date DATE NOT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(12, 2) NOT NULL,
  payment_method ENUM('Efectivo', 'Nequi', 'Transferencia') NOT NULL,
  code VARCHAR(50) DEFAULT NULL,
  category_id INT DEFAULT NULL,
  payment_status ENUM('Pagado', 'Pendiente') DEFAULT 'Pagado',
  loan_id INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  INDEX idx_company_deleted (company_id, deleted_at)
) ENGINE=InnoDB;

-- ============================================================
-- 6. PRÉSTAMOS
-- ============================================================
CREATE TABLE loans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  date DATE NOT NULL,
  loan VARCHAR(50) NOT NULL,
  amount DECIMAL(12, 2) NOT NULL,
  payment_method ENUM('Efectivo', 'Nequi', 'Transferencia') NOT NULL,
  code VARCHAR(50) DEFAULT NULL,
  status ENUM('Pendiente', 'Pagado') DEFAULT 'Pendiente',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  UNIQUE KEY uk_company_loan (company_id, loan),
  INDEX idx_company_deleted (company_id, deleted_at)
) ENGINE=InnoDB;

-- ============================================================
-- 7. PRODUCTOS (Inventario)
-- ============================================================
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  date DATE NULL DEFAULT NULL,
  name VARCHAR(150) NOT NULL,
  sku VARCHAR(50) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  current_stock INT NOT NULL DEFAULT 0,
  min_stock INT NOT NULL DEFAULT 0,
  cost_price DECIMAL(12, 2) NOT NULL DEFAULT 0,
  sale_price DECIMAL(12, 2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  UNIQUE KEY uk_company_sku (company_id, sku),
  INDEX idx_company_deleted (company_id, deleted_at)
) ENGINE=InnoDB;

-- ============================================================
-- 8. MOVIMIENTOS DE STOCK
-- ============================================================
CREATE TABLE stock_movements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  product_id INT NOT NULL,
  type ENUM('entrada', 'salida') NOT NULL,
  quantity INT NOT NULL,
  reference_type VARCHAR(50) DEFAULT NULL COMMENT 'compra, venta, ajuste, pedido',
  reference_id INT DEFAULT NULL,
  notes VARCHAR(255) DEFAULT NULL,
  date DATE NULL DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  FOREIGN KEY (product_id) REFERENCES products(id),
  INDEX idx_product (product_id)
) ENGINE=InnoDB;

-- ============================================================
-- 9. PEDIDOS / VENTAS
-- ============================================================
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  order_number VARCHAR(20) NOT NULL,
  customer_name VARCHAR(150) DEFAULT NULL,
  status ENUM('Borrador', 'Confirmado', 'Entregado', 'Cancelado') DEFAULT 'Borrador',
  subtotal DECIMAL(12, 2) NOT NULL DEFAULT 0,
  tax_amount DECIMAL(12, 2) NOT NULL DEFAULT 0,
  total DECIMAL(12, 2) NOT NULL DEFAULT 0,
  notes TEXT DEFAULT NULL,
  date DATE NULL DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  UNIQUE KEY uk_company_order (company_id, order_number),
  INDEX idx_company_deleted (company_id, deleted_at)
) ENGINE=InnoDB;

-- ============================================================
-- 10. DETALLE DE PEDIDOS
-- ============================================================
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  product_name VARCHAR(150) NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(12, 2) NOT NULL,
  subtotal DECIMAL(12, 2) NOT NULL,
  date DATE NULL DEFAULT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;