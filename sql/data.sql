USE balanceuno;

-- Ingresos con códigos para Nequi y Transferencia
INSERT INTO incomes (date, description, amount, payment_method, code) VALUES
('2026-01-01', 'Venta torta chocolate', 85000, 'Efectivo', NULL),
('2026-01-02', 'Pedido cupcakes', 120000, 'Nequi', 'NEQ123'),
('2026-01-03', 'Venta mostrador', 45000, 'Efectivo', NULL),
('2026-01-04', 'Pedido torta boda', 350000, 'Transferencia', 'TRF001'),
('2026-01-05', 'Venta brownies', 60000, 'Nequi', 'NEQ124'),
('2026-01-06', 'Pedido galletas', 40000, 'Efectivo', NULL),
('2026-01-07', 'Venta mostrador', 30000, 'Efectivo', NULL),
('2026-01-08', 'Pedido torta cumpleaños', 200000, 'Transferencia', 'TRF002'),
('2026-01-09', 'Venta cupcakes', 75000, 'Nequi', 'NEQ125'),
('2026-01-10', 'Venta mostrador', 50000, 'Efectivo', NULL),
('2026-01-11', 'Pedido torta personalizada', 280000, 'Transferencia', 'TRF003'),
('2026-01-12', 'Venta brownies', 65000, 'Nequi', 'NEQ126'),
('2026-01-13', 'Venta mostrador', 35000, 'Efectivo', NULL),
('2026-01-14', 'Pedido cupcakes', 90000, 'Nequi', 'NEQ127'),
('2026-01-15', 'Venta torta vainilla', 95000, 'Efectivo', NULL),
('2026-01-16', 'Pedido galletas', 40000, 'Transferencia', 'TRF004'),
('2026-01-17', 'Venta mostrador', 25000, 'Efectivo', NULL),
('2026-01-18', 'Pedido torta aniversario', 300000, 'Nequi', 'NEQ128'),
('2026-01-19', 'Venta brownies', 70000, 'Efectivo', NULL),
('2026-01-20', 'Pedido cupcakes', 110000, 'Transferencia', 'TRF005');

-- Gastos con códigos para Nequi y Transferencia
INSERT INTO expenses (date, description, amount, payment_method, code) VALUES
('2026-01-01', 'Compra harina', 50000, 'Efectivo', NULL),
('2026-01-02', 'Compra azúcar', 30000, 'Nequi', 'NEQ201'),
('2026-01-03', 'Pago servicios públicos', 120000, 'Transferencia', 'TRF101'),
('2026-01-04', 'Compra chocolate', 80000, 'Efectivo', NULL),
('2026-01-05', 'Compra mantequilla', 60000, 'Nequi', 'NEQ202'),
('2026-01-06', 'Pago arriendo local', 400000, 'Transferencia', 'TRF102'),
('2026-01-07', 'Compra leche', 45000, 'Efectivo', NULL),
('2026-01-08', 'Compra huevos', 70000, 'Nequi', 'NEQ203'),
('2026-01-09', 'Pago internet', 90000, 'Transferencia', 'TRF103'),
('2026-01-10', 'Compra frutas', 55000, 'Efectivo', NULL),
('2026-01-11', 'Compra empaques', 65000, 'Nequi', 'NEQ204'),
('2026-01-12', 'Pago publicidad', 150000, 'Transferencia', 'TRF104'),
('2026-01-13', 'Compra harina', 50000, 'Efectivo', NULL),
('2026-01-14', 'Compra azúcar', 30000, 'Nequi', 'NEQ205'),
('2026-01-15', 'Pago servicios públicos', 120000, 'Transferencia', 'TRF105'),
('2026-01-16', 'Compra chocolate', 80000, 'Efectivo', NULL),
('2026-01-17', 'Compra mantequilla', 60000, 'Nequi', 'NEQ206'),
('2026-01-18', 'Pago arriendo local', 400000, 'Transferencia', 'TRF106'),
('2026-01-19', 'Compra leche', 45000, 'Efectivo', NULL),
('2026-01-20', 'Compra huevos', 70000, 'Nequi', 'NEQ207');