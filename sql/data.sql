-- ============================================================
-- BalanceUno — Datos de Prueba Multi-Tenant
-- Ejecutar DESPUÉS de schema.sql: mysql -u root < data.sql
-- ============================================================
-- CONTRASEÑAS DE PRUEBA:
--   admin   → admin123
--   maria   → maria123
--   carlos  → carlos123
-- ============================================================

USE balanceuno;

-- ============================================================
-- EMPRESAS
-- ============================================================
INSERT INTO companies (id, name, nit, address, phone, tax_rate) VALUES
(1, 'Dulce Hogar Repostería', '900123456-1', 'Calle 45 #12-30, Medellín', '3001234567', NULL),
(2, 'TechFix Soluciones', '901987654-3', 'Carrera 70 #8-15, Medellín', '3109876543', NULL);

-- ============================================================
-- USUARIOS
-- ============================================================
INSERT INTO users (company_id, username, password, name) VALUES
(1, 'admin', '$2y$10$DhKeJ8Xoe2Y7DbBefBQkjuPwAHDc0C5cWUpkVboVmkHdRnpMWbWoy', 'Administrador'),
(1, 'maria', '$2y$10$gznjaBTG5TiBQ9rCJupSoOUVy5yslH3UX2uUZd9fNZDA8.Ymdf4cS', 'María López'),
(2, 'carlos', '$2y$10$tpWaWotkRBjatzKPFysd0uZWVU18.tQZIeFEfBeFC6rkllhDflKly', 'Carlos Ramírez');

-- ============================================================
-- CATEGORÍAS — Empresa 1: Repostería
-- ============================================================
INSERT INTO categories (company_id, name, type) VALUES
-- Categorías de ingreso
(1, 'Ventas Mostrador', 'ingreso'),
(1, 'Pedidos Especiales', 'ingreso'),
(1, 'Delivery', 'ingreso'),
-- Categorías de gasto
(1, 'Materia Prima', 'gasto'),
(1, 'Servicios Públicos', 'gasto'),
(1, 'Arriendo', 'gasto'),
(1, 'Publicidad', 'gasto'),
(1, 'Transporte', 'gasto'),
(1, 'Empaques', 'gasto'),
-- Categorías ambas
(1, 'Otros', 'ambos');

-- CATEGORÍAS — Empresa 2: TechFix
INSERT INTO categories (company_id, name, type) VALUES
(2, 'Reparaciones', 'ingreso'),
(2, 'Venta Accesorios', 'ingreso'),
(2, 'Repuestos', 'gasto'),
(2, 'Herramientas', 'gasto'),
(2, 'Arriendo', 'gasto'),
(2, 'Servicios', 'gasto'),
(2, 'Otros', 'ambos');

-- ============================================================
-- INGRESOS — Empresa 1 (Repostería) Ene-Jun 2026
-- ============================================================
INSERT INTO incomes (company_id, date, description, amount, payment_method, code, category_id, payment_status) VALUES
-- Enero 2026
(1, '2026-01-05', 'Venta torta chocolate', 85000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-01-08', 'Pedido cupcakes x24', 120000, 'Nequi', 'NEQ1001', 2, 'Pagado'),
(1, '2026-01-10', 'Venta mostrador galletas', 45000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-01-14', 'Pedido torta boda 3 pisos', 450000, 'Transferencia', 'TRF1001', 2, 'Pagado'),
(1, '2026-01-18', 'Venta brownies x12', 60000, 'Nequi', 'NEQ1002', 1, 'Pagado'),
(1, '2026-01-22', 'Pedido galletas corporativas', 180000, 'Transferencia', 'TRF1002', 2, 'Pendiente'),
(1, '2026-01-25', 'Venta mostrador variado', 35000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-01-28', 'Delivery cupcakes', 75000, 'Nequi', 'NEQ1003', 3, 'Pagado'),
-- Febrero 2026
(1, '2026-02-02', 'Venta torta vainilla', 95000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-02-05', 'Pedido San Valentín x3 tortas', 380000, 'Transferencia', 'TRF1003', 2, 'Pagado'),
(1, '2026-02-10', 'Venta mostrador brownies', 40000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-02-14', 'Pedido cupcakes San Valentín', 200000, 'Nequi', 'NEQ1004', 2, 'Pagado'),
(1, '2026-02-18', 'Delivery torta cumpleaños', 130000, 'Transferencia', 'TRF1004', 3, 'Pagado'),
(1, '2026-02-22', 'Venta mostrador galletas', 55000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-02-26', 'Pedido torta personalizada', 280000, 'Nequi', 'NEQ1005', 2, 'Pagado'),
-- Marzo 2026
(1, '2026-03-03', 'Venta mostrador variado', 65000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-03-07', 'Pedido brownies evento', 150000, 'Transferencia', 'TRF1005', 2, 'Pagado'),
(1, '2026-03-12', 'Venta torta chocolate', 90000, 'Nequi', 'NEQ1006', 1, 'Pagado'),
(1, '2026-03-15', 'Delivery galletas decoradas', 70000, 'Efectivo', NULL, 3, 'Pagado'),
(1, '2026-03-20', 'Pedido torta primera comunión', 320000, 'Transferencia', 'TRF1006', 2, 'Pagado'),
(1, '2026-03-25', 'Venta mostrador cupcakes', 48000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-03-28', 'Pedido corporativo galletas', 220000, 'Transferencia', 'TRF1007', 2, 'Pendiente'),
-- Abril 2026
(1, '2026-04-02', 'Venta mostrador variado', 52000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-04-06', 'Pedido torta cumpleaños', 160000, 'Nequi', 'NEQ1007', 2, 'Pagado'),
(1, '2026-04-10', 'Delivery brownies', 85000, 'Transferencia', 'TRF1008', 3, 'Pagado'),
(1, '2026-04-15', 'Venta torta red velvet', 110000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-04-20', 'Pedido cupcakes bautizo', 190000, 'Nequi', 'NEQ1008', 2, 'Pagado'),
(1, '2026-04-25', 'Venta mostrador galletas', 38000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-04-28', 'Pedido torta empresarial', 350000, 'Transferencia', 'TRF1009', 2, 'Pagado'),
-- Mayo 2026
(1, '2026-05-03', 'Venta mostrador variado', 72000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-05-08', 'Pedido Día de la Madre x5', 500000, 'Transferencia', 'TRF1010', 2, 'Pagado'),
(1, '2026-05-10', 'Delivery torta Día Madre', 140000, 'Nequi', 'NEQ1009', 3, 'Pagado'),
(1, '2026-05-15', 'Venta torta chocolate', 88000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-05-20', 'Pedido cupcakes graduación', 175000, 'Transferencia', 'TRF1011', 2, 'Pagado'),
(1, '2026-05-25', 'Venta mostrador brownies', 42000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-05-30', 'Pedido torta grado', 300000, 'Nequi', 'NEQ1010', 2, 'Pendiente'),
-- Junio 2026
(1, '2026-06-02', 'Venta mostrador variado', 58000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-06-06', 'Pedido brownies evento', 125000, 'Transferencia', 'TRF1012', 2, 'Pagado'),
(1, '2026-06-12', 'Delivery cupcakes', 95000, 'Nequi', 'NEQ1011', 3, 'Pagado'),
(1, '2026-06-16', 'Venta torta vainilla', 98000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-06-20', 'Pedido torta aniversario', 260000, 'Transferencia', 'TRF1013', 2, 'Pagado'),
(1, '2026-06-25', 'Venta mostrador galletas', 44000, 'Efectivo', NULL, 1, 'Pagado'),
(1, '2026-06-28', 'Pedido corporativo cupcakes', 240000, 'Nequi', 'NEQ1012', 2, 'Pagado');

-- ============================================================
-- INGRESOS — Empresa 2 (TechFix) Ene-Jun 2026
-- ============================================================
INSERT INTO incomes (company_id, date, description, amount, payment_method, code, category_id, payment_status) VALUES
(2, '2026-01-06', 'Reparación pantalla iPhone 14', 180000, 'Efectivo', NULL, 11, 'Pagado'),
(2, '2026-01-12', 'Venta cargador universal', 35000, 'Nequi', 'NEQ2001', 12, 'Pagado'),
(2, '2026-01-20', 'Reparación laptop Lenovo', 250000, 'Transferencia', 'TRF2001', 11, 'Pagado'),
(2, '2026-02-04', 'Reparación batería Samsung S23', 120000, 'Efectivo', NULL, 11, 'Pagado'),
(2, '2026-02-15', 'Venta cable USB-C x5', 75000, 'Nequi', 'NEQ2002', 12, 'Pagado'),
(2, '2026-02-28', 'Reparación pantalla iPad', 220000, 'Transferencia', 'TRF2002', 11, 'Pagado'),
(2, '2026-03-10', 'Reparación placa madre PC', 300000, 'Efectivo', NULL, 11, 'Pagado'),
(2, '2026-03-22', 'Venta accesorios varios', 95000, 'Nequi', 'NEQ2003', 12, 'Pagado'),
(2, '2026-04-05', 'Reparación pantalla Samsung S24', 200000, 'Transferencia', 'TRF2003', 11, 'Pagado'),
(2, '2026-04-18', 'Reparación laptop HP', 180000, 'Efectivo', NULL, 11, 'Pagado'),
(2, '2026-05-02', 'Venta cargadores x10', 280000, 'Transferencia', 'TRF2004', 12, 'Pagado'),
(2, '2026-05-20', 'Reparación iPhone 15 Pro', 350000, 'Nequi', 'NEQ2004', 11, 'Pagado'),
(2, '2026-06-08', 'Reparación tablet Samsung', 150000, 'Efectivo', NULL, 11, 'Pagado'),
(2, '2026-06-22', 'Venta cables y accesorios', 110000, 'Transferencia', 'TRF2005', 12, 'Pendiente');

-- ============================================================
-- GASTOS — Empresa 1 (Repostería) Ene-Jun 2026
-- ============================================================
INSERT INTO expenses (company_id, date, description, amount, payment_method, code, category_id, payment_status) VALUES
-- Enero 2026
(1, '2026-01-03', 'Compra harina x10 bultos', 85000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-01-03', 'Compra azúcar x5 bultos', 45000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-01-05', 'Pago servicios públicos enero', 120000, 'Transferencia', 'TRF3001', 5, 'Pagado'),
(1, '2026-01-08', 'Compra chocolate cobertura', 110000, 'Nequi', 'NEQ3001', 4, 'Pagado'),
(1, '2026-01-10', 'Pago arriendo enero', 800000, 'Transferencia', 'TRF3002', 6, 'Pagado'),
(1, '2026-01-15', 'Compra mantequilla y leche', 95000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-01-20', 'Compra empaques y cajas', 65000, 'Nequi', 'NEQ3002', 9, 'Pagado'),
(1, '2026-01-25', 'Pago publicidad Instagram', 80000, 'Transferencia', 'TRF3003', 7, 'Pagado'),
(1, '2026-01-28', 'Compra huevos y frutas', 70000, 'Efectivo', NULL, 4, 'Pagado'),
-- Febrero 2026
(1, '2026-02-02', 'Compra harina y azúcar', 130000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-02-05', 'Pago servicios públicos febrero', 125000, 'Transferencia', 'TRF3004', 5, 'Pagado'),
(1, '2026-02-08', 'Compra decoraciones San Valentín', 90000, 'Nequi', 'NEQ3003', 9, 'Pagado'),
(1, '2026-02-10', 'Pago arriendo febrero', 800000, 'Transferencia', 'TRF3005', 6, 'Pagado'),
(1, '2026-02-15', 'Compra chocolate y vainilla', 85000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-02-20', 'Servicio domicilios Rappi', 60000, 'Nequi', 'NEQ3004', 8, 'Pagado'),
(1, '2026-02-25', 'Compra mantequilla y crema', 75000, 'Efectivo', NULL, 4, 'Pagado'),
-- Marzo 2026
(1, '2026-03-03', 'Compra harina x8 bultos', 68000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-03-05', 'Pago servicios públicos marzo', 118000, 'Transferencia', 'TRF3006', 5, 'Pagado'),
(1, '2026-03-10', 'Pago arriendo marzo', 800000, 'Transferencia', 'TRF3007', 6, 'Pagado'),
(1, '2026-03-13', 'Compra chocolate y frutas', 95000, 'Nequi', 'NEQ3005', 4, 'Pagado'),
(1, '2026-03-18', 'Pago publicidad Facebook', 100000, 'Transferencia', 'TRF3008', 7, 'Pagado'),
(1, '2026-03-22', 'Compra empaques premium', 85000, 'Efectivo', NULL, 9, 'Pagado'),
(1, '2026-03-28', 'Compra azúcar y leche', 58000, 'Efectivo', NULL, 4, 'Pagado'),
-- Abril 2026
(1, '2026-04-02', 'Compra harina y mantequilla', 92000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-04-05', 'Pago servicios públicos abril', 122000, 'Transferencia', 'TRF3009', 5, 'Pagado'),
(1, '2026-04-10', 'Pago arriendo abril', 800000, 'Transferencia', 'TRF3010', 6, 'Pagado'),
(1, '2026-04-14', 'Compra chocolate importado', 140000, 'Nequi', 'NEQ3006', 4, 'Pagado'),
(1, '2026-04-20', 'Servicio transporte mercancía', 55000, 'Efectivo', NULL, 8, 'Pagado'),
(1, '2026-04-25', 'Compra empaques y cintas', 48000, 'Nequi', 'NEQ3007', 9, 'Pagado'),
-- Mayo 2026
(1, '2026-05-02', 'Compra harina y azúcar extra', 110000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-05-05', 'Pago servicios públicos mayo', 130000, 'Transferencia', 'TRF3011', 5, 'Pagado'),
(1, '2026-05-08', 'Compra decoraciones Día Madre', 95000, 'Nequi', 'NEQ3008', 9, 'Pagado'),
(1, '2026-05-10', 'Pago arriendo mayo', 800000, 'Transferencia', 'TRF3012', 6, 'Pagado'),
(1, '2026-05-15', 'Compra chocolate y vainilla', 88000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-05-22', 'Pago publicidad Google Ads', 120000, 'Transferencia', 'TRF3013', 7, 'Pagado'),
(1, '2026-05-28', 'Compra frutas frescas', 65000, 'Efectivo', NULL, 4, 'Pagado'),
-- Junio 2026
(1, '2026-06-02', 'Compra harina x10', 82000, 'Efectivo', NULL, 4, 'Pagado'),
(1, '2026-06-05', 'Pago servicios públicos junio', 115000, 'Transferencia', 'TRF3014', 5, 'Pagado'),
(1, '2026-06-10', 'Pago arriendo junio', 800000, 'Transferencia', 'TRF3015', 6, 'Pagado'),
(1, '2026-06-14', 'Compra chocolate y mantequilla', 105000, 'Nequi', 'NEQ3009', 4, 'Pagado'),
(1, '2026-06-20', 'Compra empaques ecológicos', 72000, 'Efectivo', NULL, 9, 'Pagado'),
(1, '2026-06-25', 'Pago publicidad redes', 90000, 'Transferencia', 'TRF3016', 7, 'Pendiente'),
(1, '2026-06-28', 'Compra azúcar y huevos', 55000, 'Efectivo', NULL, 4, 'Pagado');

-- ============================================================
-- GASTOS — Empresa 2 (TechFix) Ene-Jun 2026
-- ============================================================
INSERT INTO expenses (company_id, date, description, amount, payment_method, code, category_id, payment_status) VALUES
(2, '2026-01-05', 'Compra pantallas iPhone repuesto', 450000, 'Transferencia', 'TRF4001', 13, 'Pagado'),
(2, '2026-01-10', 'Pago arriendo local enero', 600000, 'Transferencia', 'TRF4002', 15, 'Pagado'),
(2, '2026-01-18', 'Compra herramientas precisión', 180000, 'Nequi', 'NEQ4001', 14, 'Pagado'),
(2, '2026-02-05', 'Compra baterías Samsung lote', 320000, 'Transferencia', 'TRF4003', 13, 'Pagado'),
(2, '2026-02-10', 'Pago arriendo local febrero', 600000, 'Transferencia', 'TRF4004', 15, 'Pagado'),
(2, '2026-02-20', 'Pago internet y servicios', 95000, 'Transferencia', 'TRF4005', 16, 'Pagado'),
(2, '2026-03-05', 'Compra repuestos varios', 280000, 'Nequi', 'NEQ4002', 13, 'Pagado'),
(2, '2026-03-10', 'Pago arriendo local marzo', 600000, 'Transferencia', 'TRF4006', 15, 'Pagado'),
(2, '2026-04-05', 'Compra pantallas Samsung', 380000, 'Transferencia', 'TRF4007', 13, 'Pagado'),
(2, '2026-04-10', 'Pago arriendo local abril', 600000, 'Transferencia', 'TRF4008', 15, 'Pagado'),
(2, '2026-05-05', 'Compra cables y accesorios lote', 220000, 'Nequi', 'NEQ4003', 13, 'Pagado'),
(2, '2026-05-10', 'Pago arriendo local mayo', 600000, 'Transferencia', 'TRF4009', 15, 'Pagado'),
(2, '2026-06-05', 'Compra repuestos laptops', 350000, 'Transferencia', 'TRF4010', 13, 'Pagado'),
(2, '2026-06-10', 'Pago arriendo local junio', 600000, 'Transferencia', 'TRF4011', 15, 'Pagado');

-- ============================================================
-- PRÉSTAMOS — Empresa 1 (Repostería)
-- ============================================================
INSERT INTO loans (company_id, date, loan, amount, payment_method, code, status) VALUES
(1, '2026-01-15', 'PR-A1B2', 500000, 'Transferencia', 'TRF5001', 'Pendiente'),
(1, '2026-03-10', 'PR-C3D4', 300000, 'Nequi', 'NEQ5001', 'Pagado'),
(1, '2026-05-20', 'PR-E5F6', 400000, 'Transferencia', 'TRF5002', 'Pendiente');

-- Registrar préstamos como ingresos (loan_id vinculado)
INSERT INTO incomes (company_id, date, description, amount, payment_method, code, loan_id, payment_status) VALUES
(1, '2026-01-15', 'Préstamo PR-A1B2', 500000, 'Transferencia', 'TRF5001', 1, 'Pagado'),
(1, '2026-03-10', 'Préstamo PR-C3D4', 300000, 'Nequi', 'NEQ5001', 2, 'Pagado'),
(1, '2026-05-20', 'Préstamo PR-E5F6', 400000, 'Transferencia', 'TRF5002', 3, 'Pagado');

-- Pagos de préstamo PR-A1B2 (parcial: 300k de 500k)
INSERT INTO expenses (company_id, date, description, amount, payment_method, code, loan_id, payment_status) VALUES
(1, '2026-02-15', 'Pago Préstamo PR-A1B2', 150000, 'Transferencia', 'TRF5003', 1, 'Pagado'),
(1, '2026-03-15', 'Pago Préstamo PR-A1B2', 150000, 'Nequi', 'NEQ5002', 1, 'Pagado');

-- Pagos de préstamo PR-C3D4 (completo: 300k)
INSERT INTO expenses (company_id, date, description, amount, payment_method, code, loan_id, payment_status) VALUES
(1, '2026-04-10', 'Pago Préstamo PR-C3D4', 150000, 'Transferencia', 'TRF5004', 2, 'Pagado'),
(1, '2026-05-10', 'Pago Préstamo PR-C3D4', 150000, 'Transferencia', 'TRF5005', 2, 'Pagado');

-- Pagos de préstamo PR-E5F6 (parcial: 100k de 400k)
INSERT INTO expenses (company_id, date, description, amount, payment_method, code, loan_id, payment_status) VALUES
(1, '2026-06-20', 'Pago Préstamo PR-E5F6', 100000, 'Transferencia', 'TRF5006', 3, 'Pagado');

-- ============================================================
-- PRÉSTAMOS — Empresa 2 (TechFix)
-- ============================================================
INSERT INTO loans (company_id, date, loan, amount, payment_method, code, status) VALUES
(2, '2026-02-01', 'PR-G7H8', 800000, 'Transferencia', 'TRF6001', 'Pendiente');

INSERT INTO incomes (company_id, date, description, amount, payment_method, code, loan_id, payment_status) VALUES
(2, '2026-02-01', 'Préstamo PR-G7H8', 800000, 'Transferencia', 'TRF6001', 4, 'Pagado');

INSERT INTO expenses (company_id, date, description, amount, payment_method, code, loan_id, payment_status) VALUES
(2, '2026-03-01', 'Pago Préstamo PR-G7H8', 200000, 'Transferencia', 'TRF6002', 4, 'Pagado'),
(2, '2026-04-01', 'Pago Préstamo PR-G7H8', 200000, 'Transferencia', 'TRF6003', 4, 'Pagado');

-- ============================================================
-- PRODUCTOS — Empresa 1 (Repostería)
-- ============================================================
INSERT INTO products (company_id, name, sku, description, current_stock, min_stock, cost_price, sale_price) VALUES
(1, 'Torta Chocolate Grande', 'TORT-CHOC-G', 'Torta de chocolate para 20 personas', 8, 3, 35000, 90000),
(1, 'Torta Chocolate Mediana', 'TORT-CHOC-M', 'Torta de chocolate para 12 personas', 12, 5, 22000, 55000),
(1, 'Torta Vainilla Grande', 'TORT-VAIN-G', 'Torta de vainilla para 20 personas', 6, 3, 30000, 85000),
(1, 'Torta Vainilla Mediana', 'TORT-VAIN-M', 'Torta de vainilla para 12 personas', 10, 5, 18000, 50000),
(1, 'Torta Red Velvet', 'TORT-RV', 'Torta red velvet para 15 personas', 4, 2, 40000, 110000),
(1, 'Cupcakes x12', 'CUP-12', 'Caja de 12 cupcakes decorados', 20, 8, 15000, 45000),
(1, 'Cupcakes x6', 'CUP-06', 'Caja de 6 cupcakes decorados', 25, 10, 8000, 25000),
(1, 'Brownies x6', 'BRW-06', 'Caja de 6 brownies', 18, 8, 10000, 30000),
(1, 'Brownies x12', 'BRW-12', 'Caja de 12 brownies', 10, 5, 18000, 55000),
(1, 'Galletas Decoradas x10', 'GAL-10', 'Bolsa de 10 galletas decoradas', 30, 10, 8000, 25000),
(1, 'Galletas Decoradas x20', 'GAL-20', 'Caja de 20 galletas decoradas', 15, 5, 14000, 42000),
(1, 'Torta Personalizada', 'TORT-PERS', 'Torta personalizada (precio base)', 2, 1, 50000, 150000);

-- PRODUCTOS — Empresa 2 (TechFix)
INSERT INTO products (company_id, name, sku, description, current_stock, min_stock, cost_price, sale_price) VALUES
(2, 'Pantalla iPhone 14', 'PANT-IP14', 'Pantalla OLED iPhone 14 original', 5, 2, 85000, 180000),
(2, 'Pantalla iPhone 15', 'PANT-IP15', 'Pantalla OLED iPhone 15 original', 3, 2, 110000, 220000),
(2, 'Pantalla Samsung S23', 'PANT-S23', 'Pantalla AMOLED Samsung S23', 4, 2, 95000, 200000),
(2, 'Pantalla Samsung S24', 'PANT-S24', 'Pantalla AMOLED Samsung S24', 3, 2, 120000, 250000),
(2, 'Batería Samsung S23', 'BAT-S23', 'Batería original Samsung S23', 8, 3, 30000, 70000),
(2, 'Batería iPhone 14', 'BAT-IP14', 'Batería original iPhone 14', 6, 3, 35000, 75000),
(2, 'Cargador Universal USB-C', 'CARG-USBC', 'Cargador rápido 25W USB-C', 20, 8, 12000, 35000),
(2, 'Cable USB-C 1m', 'CAB-USBC-1', 'Cable USB-C a USB-C 1 metro', 30, 10, 5000, 15000),
(2, 'Cable Lightning 1m', 'CAB-LIGHT-1', 'Cable Lightning certificado', 25, 10, 7000, 18000),
(2, 'Mica Vidrio Templado Universal', 'MICA-UNI', 'Mica de vidrio templado genérica', 50, 15, 2000, 8000);

-- ============================================================
-- MOVIMIENTOS DE STOCK — Empresa 1 (entradas iniciales)
-- ============================================================
INSERT INTO stock_movements (company_id, product_id, type, quantity, reference_type, notes, created_at) VALUES
(1, 1, 'entrada', 10, 'compra', 'Stock inicial torta choc grande', '2026-01-02 08:00:00'),
(1, 2, 'entrada', 15, 'compra', 'Stock inicial torta choc mediana', '2026-01-02 08:00:00'),
(1, 3, 'entrada', 8, 'compra', 'Stock inicial torta vainilla grande', '2026-01-02 08:00:00'),
(1, 4, 'entrada', 12, 'compra', 'Stock inicial torta vainilla mediana', '2026-01-02 08:00:00'),
(1, 5, 'entrada', 5, 'compra', 'Stock inicial red velvet', '2026-01-02 08:00:00'),
(1, 6, 'entrada', 25, 'compra', 'Stock inicial cupcakes x12', '2026-01-02 08:00:00'),
(1, 7, 'entrada', 30, 'compra', 'Stock inicial cupcakes x6', '2026-01-02 08:00:00'),
(1, 8, 'entrada', 20, 'compra', 'Stock inicial brownies x6', '2026-01-02 08:00:00'),
(1, 9, 'entrada', 12, 'compra', 'Stock inicial brownies x12', '2026-01-02 08:00:00'),
(1, 10, 'entrada', 35, 'compra', 'Stock inicial galletas x10', '2026-01-02 08:00:00'),
(1, 11, 'entrada', 18, 'compra', 'Stock inicial galletas x20', '2026-01-02 08:00:00'),
(1, 12, 'entrada', 3, 'compra', 'Stock inicial torta personalizada', '2026-01-02 08:00:00'),
-- Ventas (salidas)
(1, 1, 'salida', 2, 'venta', 'Venta mostrador enero', '2026-01-15 10:00:00'),
(1, 6, 'salida', 5, 'venta', 'Pedidos cupcakes enero-feb', '2026-02-10 11:00:00'),
(1, 8, 'salida', 2, 'venta', 'Venta brownies febrero', '2026-02-20 14:00:00'),
(1, 10, 'salida', 5, 'venta', 'Venta galletas marzo', '2026-03-15 09:00:00'),
(1, 3, 'salida', 2, 'venta', 'Venta torta vainilla abril', '2026-04-10 16:00:00'),
(1, 5, 'salida', 1, 'venta', 'Venta red velvet abril', '2026-04-15 12:00:00'),
(1, 4, 'salida', 2, 'venta', 'Venta torta vainilla med mayo', '2026-05-12 10:00:00'),
(1, 2, 'salida', 3, 'venta', 'Ventas torta choc med mayo-jun', '2026-06-05 11:00:00'),
(1, 11, 'salida', 3, 'venta', 'Pedido galletas x20 junio', '2026-06-15 14:00:00'),
(1, 12, 'salida', 1, 'venta', 'Torta personalizada junio', '2026-06-20 10:00:00');

-- MOVIMIENTOS DE STOCK — Empresa 2 (TechFix)
INSERT INTO stock_movements (company_id, product_id, type, quantity, reference_type, notes, created_at) VALUES
(2, 13, 'entrada', 8, 'compra', 'Lote pantallas iPhone 14', '2026-01-05 09:00:00'),
(2, 14, 'entrada', 5, 'compra', 'Lote pantallas iPhone 15', '2026-01-05 09:00:00'),
(2, 15, 'entrada', 6, 'compra', 'Lote pantallas Samsung S23', '2026-01-05 09:00:00'),
(2, 16, 'entrada', 4, 'compra', 'Lote pantallas Samsung S24', '2026-02-10 09:00:00'),
(2, 17, 'entrada', 10, 'compra', 'Lote baterías Samsung', '2026-02-10 09:00:00'),
(2, 18, 'entrada', 8, 'compra', 'Lote baterías iPhone', '2026-02-10 09:00:00'),
(2, 19, 'entrada', 25, 'compra', 'Lote cargadores USB-C', '2026-01-10 09:00:00'),
(2, 20, 'entrada', 35, 'compra', 'Lote cables USB-C', '2026-01-10 09:00:00'),
(2, 21, 'entrada', 30, 'compra', 'Lote cables Lightning', '2026-01-10 09:00:00'),
(2, 22, 'entrada', 60, 'compra', 'Lote micas vidrio templado', '2026-01-10 09:00:00'),
-- Salidas por reparaciones y ventas
(2, 13, 'salida', 3, 'venta', 'Reparaciones iPhone 14', '2026-03-01 10:00:00'),
(2, 14, 'salida', 2, 'venta', 'Reparaciones iPhone 15', '2026-04-15 11:00:00'),
(2, 15, 'salida', 2, 'venta', 'Reparaciones Samsung S23', '2026-03-20 14:00:00'),
(2, 16, 'salida', 1, 'venta', 'Reparación Samsung S24', '2026-04-05 16:00:00'),
(2, 17, 'salida', 2, 'venta', 'Cambios batería Samsung', '2026-05-10 09:00:00'),
(2, 18, 'salida', 2, 'venta', 'Cambios batería iPhone', '2026-05-20 10:00:00'),
(2, 19, 'salida', 5, 'venta', 'Venta cargadores', '2026-04-01 12:00:00'),
(2, 20, 'salida', 5, 'venta', 'Venta cables USB-C', '2026-05-15 13:00:00'),
(2, 21, 'salida', 5, 'venta', 'Venta cables Lightning', '2026-06-01 15:00:00'),
(2, 22, 'salida', 10, 'venta', 'Venta micas', '2026-06-10 11:00:00');

-- ============================================================
-- PEDIDOS — Empresa 1 (Repostería)
-- ============================================================
INSERT INTO orders (company_id, order_number, customer_name, status, subtotal, tax_amount, total, notes, created_at) VALUES
(1, 'PED-0001', 'Ana García', 'Entregado', 180000, 0, 180000, 'Pedido para fiesta infantil', '2026-02-10 09:00:00'),
(1, 'PED-0002', 'Luis Martínez', 'Entregado', 135000, 0, 135000, 'Pedido cumpleaños', '2026-03-05 10:00:00'),
(1, 'PED-0003', 'Empresa ABC S.A.S', 'Confirmado', 310000, 0, 310000, 'Pedido evento corporativo', '2026-05-15 14:00:00'),
(1, 'PED-0004', 'Carolina Ruiz', 'Borrador', 175000, 0, 175000, 'Pedido boda - pendiente confirmar', '2026-06-20 11:00:00'),
(1, 'PED-0005', 'Pedro Gómez', 'Cancelado', 90000, 0, 90000, 'Cliente canceló por cambio de planes', '2026-04-12 16:00:00');

INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price, subtotal) VALUES
-- PED-0001: Fiesta infantil
(1, 6, 'Cupcakes x12', 2, 45000, 90000),
(1, 1, 'Torta Chocolate Grande', 1, 90000, 90000),
-- PED-0002: Cumpleaños
(2, 5, 'Torta Red Velvet', 1, 110000, 110000),
(2, 7, 'Cupcakes x6', 1, 25000, 25000),
-- PED-0003: Corporativo
(3, 6, 'Cupcakes x12', 3, 45000, 135000),
(3, 11, 'Galletas Decoradas x20', 2, 42000, 84000),
(3, 2, 'Torta Chocolate Mediana', 1, 55000, 55000),
(3, 8, 'Brownies x6', 1, 30000, 30000),
(3, 7, 'Cupcakes x6', 1, 6000, 6000),
-- PED-0004: Boda (borrador)
(4, 12, 'Torta Personalizada', 1, 150000, 150000),
(4, 7, 'Cupcakes x6', 1, 25000, 25000),
-- PED-0005: Cancelado
(5, 1, 'Torta Chocolate Grande', 1, 90000, 90000);

-- PEDIDOS — Empresa 2 (TechFix)
INSERT INTO orders (company_id, order_number, customer_name, status, subtotal, tax_amount, total, notes, created_at) VALUES
(2, 'PED-0001', 'María Fernanda', 'Entregado', 215000, 0, 215000, 'Reparación + accesorios', '2026-03-15 10:00:00'),
(2, 'PED-0002', 'Oficina Creativa SAS', 'Confirmado', 195000, 0, 195000, 'Lote cables y cargadores', '2026-06-01 09:00:00'),
(2, 'PED-0003', 'Andrés Mejía', 'Borrador', 250000, 0, 250000, 'Reparación Samsung S24', '2026-06-25 14:00:00');

INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price, subtotal) VALUES
-- TechFix PED-0001
(6, 13, 'Pantalla iPhone 14', 1, 180000, 180000),
(6, 19, 'Cargador Universal USB-C', 1, 35000, 35000),
-- TechFix PED-0002
(7, 20, 'Cable USB-C 1m', 5, 15000, 75000),
(7, 21, 'Cable Lightning 1m', 5, 18000, 90000),
(7, 19, 'Cargador Universal USB-C', 1, 30000, 30000),
-- TechFix PED-0003
(8, 16, 'Pantalla Samsung S24', 1, 250000, 250000);