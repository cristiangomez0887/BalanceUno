# BalanceUno

BalanceUno es un sistema de control financiero para pequeños negocios, diseñado con un **estándar visual tipo app** usando MaterializeCSS. Permite gestionar ingresos, gastos y ahora también préstamos con historial de pagos.

## 🚀 Tecnologías
- PHP 8
- MySQL
- MaterializeCSS
- jQuery
- DataTables
- Chart.js (para reportes)

## 📌 Funcionalidades
- **Dashboard** minimalista con botones grandes e íconos.
- **CRUD** de Ingresos, Gastos y Préstamos con modales (crear, editar, eliminar con soft delete).
- **Tablas responsive** con DataTables.
- **Reportes** semanales y mensuales (estructura lista para implementar).
- **Gestión de Préstamos**
  - Crear, editar y eliminar (soft delete) préstamos.
  - **Historial de pagos**: vista de pagos asociados a cada préstamo mediante una llamada AJAX que muestra los datos en un modal.
  - **Exportar a Excel** la lista de préstamos/gastos.
  - Estado del préstamo (`Pendiente` / `Pagado`) actualizado automáticamente al registrar pagos.
- Footer personalizado: © 2026 BalanceUno — Hecho con 💙

## 📂 Estructura del proyecto
- `/public` → HTML, CSS, JS.
- `/views` → Vistas (dashboard, ingresos, gastos, préstamos, reportes).
- `/app` → Controladores y modelos PHP.
- `/sql` → Script de base de datos.
- `README.md` → Documentación.

## ❤️ Propósito
BalanceUno busca ayudar a pequeños negocios (ejemplo: repostería, tiendas locales) a llevar sus finanzas de forma clara y profesional, con una interfaz que se siente como una app.