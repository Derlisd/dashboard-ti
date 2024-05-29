@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1><a href="{{ route('home') }}" style="color: white;color: white;">Inicio</a></h1>
@stop

@section('content')
<meta charset="utf-8">

<div class="container">
        <div class="form-row mb-2">
            <div class="col-10">
                <textarea cols="30" rows="1" class="form-control" name="query" id="query"> SELECT * FROM transaction limit 100;</textarea>
            </div>
            <button type="button" class="btn btn-primary" id="btn_ejecutar" name="btn_ejecutar">Ejecutar</button>
        </div>
        <div class="table-responsive">
           <table id="tablaDatos" class="table">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>transactionId</th>
                        <th>transactionDate</th>
                        <th>transactionDiscount</th>
                        <th>transactionTax</th>
                        <th>transactionTotal</th>
                        <th>transactionDetails</th>
                        <th>transactionUnitsSold</th>
                        <th>transactionPaymentType</th>
                        <th>transactionType</th>
                        <th>transactionName</th>
                        <th>transactionNote</th>
                        <th>transactionParentId</th>
                        <th>transactionComplete</th>
                        <th>transactionLocation</th>
                        <th>transactionDueDate</th>
                        <th>transactionStatus</th>
                        <th>transactionUID</th>
                        <th>transactionCurrency</th>
                        <th>fromDate</th>
                        <th>toDate</th>
                        <th>invoiceNo</th>
                        <th>invoicePrefix</th>
                        <th>tags</th>
                        <th>tableno</th>
                        <th>timestamp</th>
                        <th>packageId</th>
                        <th>categoryTransId</th>
                        <th>customerId</th>
                        <th>registerId</th>
                        <th>userId</th>
                        <th>responsibleId</th>
                        <th>supplierId</th>
                        <th>outletId</th>
                        <th>companyId</th>
                        <!-- <th>orderLastUpdate</th> -->
                    </tr>
                </thead>
            </table>
        </div>`
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .spin {
            animation: spin 1s infinite linear;
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


    </style>
@stop

@section('js')
    
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.js" integrity="sha512-eOUPKZXJTfgptSYQqVilRmxUNYm0XVHwcRHD4mdtCLWf/fC9XWe98IT8H1xzBkLL4Mo9GL0xWMSJtgS5te9rQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/util.js') }}"></script>

    <script>
        $(document).ready(async function() {
            USER_PERFIL = "{{ Auth::user()->perfil }}";
            validatePermission(USER_PERFIL)

            alertify.set('notifier', 'position', 'top-right');
            // $('#campoBusqueda').select2();
            loadTable()

        })
        const loadTable = async () =>{
            showLoading()
            let transactions = await getTransactions();
            hideLoading()
            $('#tablaDatos').DataTable().destroy()
            buildTableTransactions(transactions)
        }
        const getTransactions = async  ()=>{
            let query = $('#query').val();
            let result =   await  $.ajax({
                    url: `{{ route('get_transactions')}}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data:{campo_query:query},
                    error: function (xhr, status, error) {
                        console.log(error)
                     }
                });
            return result;
        }
        const buildTableTransactions = (transactions) =>{
            TABLE = $('#tablaDatos').DataTable({
                processing: true,
                serverSide: false, 
                responsive: true,
                searching: true,
                language:espanol,
                data:transactions,
                columns: [
                    {
                        data: 'transactionId',
                        name: 'transactionId',
                        render: function (data, type, item, meta) {
                            let html = '';
                            if(USER_PERFIL !== 'Desarrollador'){
                                html =  `
                                    <button class="btn btn-primary fa-solid fa-pen-to-square editar" data-id="${data}" title="Editar"></button>
                                    <div class="row"> 
                                        &nbsp;<button class="btn btn-success  fa-solid fa-floppy-disk guardar" data-id="${data}" title="Guardar" style="display: none;" ></button>
                                        &nbsp;</button> <button class="btn btn-danger fa-solid fa-ban cancelar" data-id="${data}" title="Cancelar" style="display: none;" ></button>
                                    </div>
                                `;  
                            }
                            return html;                       
                        }
                    },                    
                    { data: 'transactionId', name: 'transactionId' },
                    { data: 'transactionDate', name: 'transactionDate' },
                    { data: 'transactionDiscount', name: 'transactionDiscount' },
                    { data: 'transactionTax', name: 'transactionTax' },
                    { data: 'transactionTotal', name: 'transactionTotal' },
                    { data: 'transactionDetails', name: 'transactionDetails' },
                    { data: 'transactionUnitsSold', name: 'transactionUnitsSold' },
                    { data: 'transactionPaymentType', name: 'transactionPaymentType' },
                    { data: 'transactionType', name: 'transactionType' },
                    { data: 'transactionName', name: 'transactionName' },
                    { data: 'transactionNote', name: 'transactionNote' },
                    { data: 'transactionParentId', name: 'transactionParentId' },
                    { data: 'transactionComplete', name: 'transactionComplete' },
                    { data: 'transactionLocation', name: 'transactionLocation' },
                    { data: 'transactionDueDate', name: 'transactionDueDate' },
                    { data: 'transactionStatus', name: 'transactionStatus' },
                    { data: 'transactionUID', name: 'transactionUID' },
                    { data: 'transactionCurrency', name: 'transactionCurrency' },
                    { data: 'fromDate', name: 'fromDate' },
                    { data: 'toDate', name: 'toDate' },
                    { data: 'invoiceNo', name: 'invoiceNo' },
                    { data: 'invoicePrefix', name: 'invoicePrefix' },
                    { data: 'tags', name: 'tags' },
                    { data: 'tableno', name: 'tableno' },
                    { data: 'timestamp', name: 'timestamp' },
                    { data: 'packageId', name: 'packageId' },
                    { data: 'categoryTransId', name: 'categoryTransId' },
                    { data: 'customerId', name: 'customerId' },
                    { data: 'registerId', name: 'registerId' },
                    { data: 'userId', name: 'userId' },
                    { data: 'responsibleId', name: 'responsibleId' },
                    { data: 'supplierId', name: 'supplierId' },
                    { data: 'outletId', name: 'outletId' },
                    { data: 'companyId', name: 'companyId' },
                    // { data: 'orderLastUpdate', name: 'orderLastUpdate' },
                ]
            });
        }
        const desactivarCampos = (row,tr) =>{
            // Recorre las celdas con campos de entrada (excepto las columnas 1 y 2)
            tr.find('td:not(:first-child):not(:nth-child(2)) input, textarea').each(function() {
                var columnName = $(this).attr('name'); // Nombre de la columna
                var inputValue = $(this).val(); // Valor del campo de entrada
                // Reemplaza el contenido de la celda con el valor del campo de entrada
                row.cell($(this).closest('td')).data(inputValue); // Reemplaza el valor en la celda actual
            });
            tr.find('.editar').show();
            tr.find('.guardar').hide();
            tr.find('.cancelar').hide();
        }
        const activarCampos = (row,tr) => {
            // Habilitar la edición en línea para todas las columnas excepto la primera y la segunda
            row.nodes().to$().find('td:not(:first-child):not(:nth-child(2))').each(function() {
                var cell = row.cell($(this));
                var value = cell.data() != null ? cell.data() : ''
               
                var columnName = cell.settings()[0].aoColumns[cell.index().column].data; // Obtiene el nombre de la columna
                // value = '[{"itemId":"neZD","uId":"Negro","name":"Cuerina","uniPrice":110,"count":2,"discount":9.09090909091,"discAmount":0,"totalDiscount":10,"price":110,"tax":15,"note":"","type":"product","total":200}]'
                if(esJSON(value)){
                    $(this).html(`<textarea cols="30" rows="1" class="form-control" name="${columnName}" id="${columnName}">${value}</textarea>`);
                }else{
                    $(this).html(`<input type="text" class="form-control" name="${columnName}" value="${value}">`);
                }

          
            });
            tr.find('.editar').hide();
            tr.find('.guardar').show();
            tr.find('.cancelar').show();
        }
        const validateOperacion= async (query) =>{
            let result;
            try {
                result = await $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                method: 'POST',
                data:{'campo_query' : query, 'modulo':'transaction'},
                url: '{{ route('get_operacion') }}',
                dataType: "json",
                });
                return result;
            } catch (error) {
                console.error(error);
            }

        }
        //Manejador de eventos para el boton ejecutar
        $('#btn_ejecutar').click(async (e) =>{
            let query = $('#query').val();
            showLoading()
            let response = await validateOperacion(query);
            hideLoading()
            if(response.status == true){
                alertify.success(response.message);
            }else{
                console.log('error');
                alertify.notify(response.message, 'error', 10); // Duración de 5 segundos
            }
            loadTable();
        })
        const updateData = async (data) =>{
            let result;
            try {
                result = await $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                method: 'POST',
                data:JSON.stringify(data) ,
                url: '{{ route('update_transaction')}}', 
                contentType: 'application/json',
                });
                return result;
            } catch (error) {
                console.error(error);
            }
        }
        // Manejador de eventos para el botón "Editar"
        $('#tablaDatos').on('click', '.editar', function() {
            var tr = $(this).closest('tr');
            var row = TABLE.row(tr);
            DATA_UPDATE['transactionId'] = row.cell(tr.find('td:nth-child(2)')).data(); // Obtiene el valor de la segunda columna
            
            activarCampos(row,tr)
        
        });

        // Manejador de eventos para el botón "Cancelar"
        $('#tablaDatos').on('click','.cancelar', function () {
            var tr = $(this).closest('tr');
            var row = TABLE.row(tr);
            desactivarCampos(row,tr)
        })

        // Manejador de eventos para el botón "Guardar"
        $('#tablaDatos').on('click', '.guardar',async  function() {
            var tr = $(this).closest('tr');
            var row = TABLE.row(tr);
            // Obtener los valores actualizados de los campos de entrada
            tr.find('input,textarea').each(function() {
                var fieldName = $(this).attr('name');
                var value = $(this).val();
                DATA_UPDATE[fieldName] = value;
            });

            tableShowLoading(this)
            let response = await updateData(DATA_UPDATE)
            tableHideLoading(this)

            if(response.status){
                desactivarCampos(row,tr)
                alertify.success(response.message);
            }else{
                alertify.error(response.message);
            }

        });

    </script>
@stop