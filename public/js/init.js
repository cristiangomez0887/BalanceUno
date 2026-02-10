$(document).ready(function () {

    // Incomes DataTable
    $('#incomesTable').DataTable({
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
                $('#modal_payment_method').formSelect();

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
                $('#modal_payment_method').formSelect();

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

    // Ajuste para botones en móviles
    $('.action-btn').addClass('waves-effect waves-light');

    // Opcional: inicializar tooltips de Materialize si los usas
    $('.tooltipped').tooltip();

    //inicializar selects
    $('select').formSelect();

    // Inicializar datepicker
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoClose: true,
        container: 'body',
        i18n: {
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            cancel: 'Cancelar',
            clear: 'Limpiar',
            done: 'Aceptar'
        }
    });
});