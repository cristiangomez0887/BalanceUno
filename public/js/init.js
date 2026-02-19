$(document).ready(function () {
    // Obtener la fecha actual para configurar los datepickers
    const today = new Date();
    // Definir configuración i18n en una constante
    const es = {
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        cancel: 'Cancelar',
        clear: 'Limpiar',
        done: 'Aceptar'
    };

    // Configuración base centralizada
    const baseConfig = {
        format: 'dd/mm/yyyy',
        autoClose: true,
        todayHighlight: true,
        container: 'body',
        i18n: es
    };

    //inicializar selects
    $('select').formSelect({
        dropdownOptions: {
            coverTrigger: false,
            closeOnClick: true
        }
    });

    // Opcional: inicializar tooltips de Materialize si los usas
    $('.tooltipped').tooltip();

    // Ajuste para botones en móviles
    $('.action-btn').addClass('waves-effect waves-light');

    // Incomes DataTable
    $('#incomesTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'frtip', // sin selector de cantidad de registros
        order: [[0, 'desc']], // ordenar por fecha descendente
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columnDefs: [{
            responsivePriority: 1,
            targets: 0,
            className: 'dt-body-center'
        }, // Fecha
        {
            responsivePriority: 1,
            targets: 'col-monto',
            className: 'dt-body-right'
        },
        {
            responsivePriority: 3,
            targets: -1,
            orderable: false,
            searchable: false,
        } // Acciones
        ]
    });
    // Expenses DataTable
    $('#expensesTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'frtip', // sin selector de cantidad de registros
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columnDefs: [{
            responsivePriority: 1,
            targets: 0,
            className: 'dt-body-center'
        }, // Fecha
        {
            responsivePriority: 2,
            targets: 2,
            className: 'dt-body-right'
        }, // Monto
        {
            responsivePriority: 3,
            targets: -1,
            orderable: false,
            searchable: false,
        } // Acciones
        ]
    });
    // Balance DataTable
    $('#balanceTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'frtip',
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0, // Fecha
                className: 'dt-body-center'
            },
            {
                responsivePriority: 2,
                targets: 3, // Monto
                className: 'dt-body-right'
            }
        ]
    });
    //Reports DataTable
    $('#reportsTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'frtip',
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, // Fecha
            { responsivePriority: 2, targets: 3, className: 'dt-body-right' } // Monto
        ]
    });

    // Inicializar modales
    $('.modal').modal({
        onOpenStart: function (modal, trigger) {
            //evitar que los datos carguen al mismo tiempo que los labels, lo que hace que se oculten
            setTimeout(function () {
                M.updateTextFields();
            }, 100);

            if (modal.id === 'modalEditExpense') {
                // Obtener datos del botón
                var id = $(trigger).data('id');
                var date = $(trigger).data('date');
                var description = $(trigger).data('description');
                var amount = $(trigger).data('amount');
                var payment_method = $(trigger).data('payment_method');
                var code = $(trigger).data('code');

                // Rellenar el formulario
                $('#modalEditExpense input[name="id"]').val(id);
                $('#modalEditExpense input[name="date"]').val(date);
                $('#modalEditExpense input[name="description"]').val(description);
                $('#modalEditExpense input[name="amount"]').val(amount);
                // 👇 Truco: marcar el option correcto ANTES de refrescar
                $('#modal_payment_method option').prop('selected', false); // limpiar
                $('#modal_payment_method option[value="' + payment_method + '"]').prop('selected', true);

                // Refrescar Materialize
                $('#modal_payment_method').formSelect({
                    dropdownOptions: {
                        coverTrigger: false,
                        closeOnClick: true
                    }
                });

                $('#modalEditExpense input[name="code"]').val(code);
            }
            else if (modal.id === 'modalEditIncome') {
                // Obtener datos del botón
                var id = $(trigger).data('id');
                var date = $(trigger).data('date');
                var description = $(trigger).data('description');
                var amount = $(trigger).data('amount');
                var payment_method = $(trigger).data('payment_method');
                var code = $(trigger).data('code');

                // Rellenar el formulario
                $('#modalEditIncome input[name="id"]').val(id);
                $('#modalEditIncome input[name="date"]').val(date);
                $('#modalEditIncome input[name="description"]').val(description);
                $('#modalEditIncome input[name="amount"]').val(amount);
                // 👇 Truco: marcar el option correcto ANTES de refrescar
                $('#modal_payment_method option').prop('selected', false); // limpiar
                $('#modal_payment_method option[value="' + payment_method + '"]').prop('selected', true);

                // Refrescar Materialize
                $('#modal_payment_method').formSelect({
                    dropdownOptions: {
                        coverTrigger: false,
                        closeOnClick: true
                    }
                });

                $('#modalEditIncome input[name="code"]').val(code);
            }
        }
    });

    // Antes de enviar, copiar el valor del select al hidden
    $('#modalEditIncome .modal-content form').on('submit', function () {
        const val = $('#modal_payment_method').val();
        $('#payment_method_hidden').val(val);

    });

    // Antes de enviar, copiar el valor del select al hidden
    $('#modalEditExpense .modal-content form').on('submit', function () {
        const val = $('#modal_payment_method').val();
        $('#payment_method_hidden').val(val);
    });

    // Función para convertir dd/mm/yyyy a Date
    function parseDate(str) {
        if (!str) return null;
        const parts = str.split('/');
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }

    // Inicializar TODOS los datepickers genéricos
    $('.datepicker').each(function () {
        const val = $(this).val();
        const defaultDate = val ? parseDate(val) : today;

        $(this).datepicker({
            ...baseConfig,
            maxDate: today,
            defaultDate: defaultDate,
            setDefaultDate: !!defaultDate
        });
    });

    // Inicializar fecha inicial con lógica de rango
    $('#startDate').datepicker({
        ...baseConfig,
        maxDate: today,
        defaultDate: parseDate($('#startDate').val()) || today,
        setDefaultDate: true,
        onSelect: function (selectedDate) {
            const start = new Date(selectedDate);

            // Obtener instancia del endDate
            const endElem = document.getElementById('endDate');
            const endInstance = M.Datepicker.getInstance(endElem);

            if (endInstance) {
                endInstance.options.minDate = start; // actualizar restricción
                endInstance.gotoDate(start);         // mover calendario a esa fecha
            }
        }
    });

    // Inicializar fecha final con lógica de rango
    $('#endDate').datepicker({
        ...baseConfig,
        maxDate: today,
        defaultDate: parseDate($('#endDate').val()) || today,
        setDefaultDate: true,
        onSelect: function (selectedDate) {
            const end = new Date(selectedDate);

            // Obtener instancia del startDate
            const startElem = document.getElementById('startDate');
            const startInstance = M.Datepicker.getInstance(startElem);

            if (startInstance) {
                startInstance.options.maxDate = end; // actualizar restricción
                startInstance.gotoDate(end);         // mover calendario a esa fecha
            }
        }
    });

    // Gráfico de torta: ingresos y gastos separados por método de pago
    const cty = $('#reportChartPaymentMethod');
    if (cty.length && paymentSummary.length > 0) {
        const labels = paymentSummary.map(item => `${item.tipo} - ${item.payment_method}`);
        const values = paymentSummary.map(item => item.total);

        // Paleta de colores extendida
        const colors = [
            '#43a047', '#1e88e5', '#fb8c00', '#e53935',
            '#8e24aa', '#00acc1', '#fdd835', '#6d4c41'
        ];

        new Chart(cty, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors.slice(0, labels.length),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: true, text: 'Distribución por método de pago (Ingresos vs Gastos)' }
                }
            }
        });
    }


    // Inicializar Chart.js usando datos pasados desde PHP
    const ctx = $('#reportChart');
    if (ctx.length) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Ingresos', 'Gastos'],
                datasets: [{
                    data: [totalsData.incomes, totalsData.expenses],
                    backgroundColor: ['#fb8c00', '#e53935']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: true, text: 'Distribución General' }
                }
            }
        });
    }

    const $amountField = $('input[name="amount"]'); // ajusta al name/id real

    // Al escribir, formatear como moneda
    $amountField.on('input', function () {
        let val = $(this).val();

        // Eliminar todo lo que no sea número
        val = val.replace(/[^\d]/g, '');

        if (val) {
            // Convertir a número y formatear con separadores
            const num = parseInt(val, 10);
            $(this).val(num.toLocaleString('es-CO')); // ejemplo: "12.345"
        }
    });

    // Al cargar valor desde BD, formatear automáticamente
    const initialVal = $amountField.val();
    if (initialVal) {
        const num = parseFloat(initialVal);
        if (!isNaN(num)) {
            $amountField.val(num.toLocaleString('es-CO'));
        }
    }

});