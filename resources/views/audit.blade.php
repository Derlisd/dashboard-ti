@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1><a href="{{ route('home') }}" style="color: white;color: white;">Inicio</a></h1>
@stop

@section('content')
<meta charset="utf-8">
    
@if(Auth::user()->perfil === 'Admin')


<div class="container">
        <div class="form-row">
            <div class="col-md-3 form-group">
               <label for="company_id">Empresa</label>
               <input type="text" id="company_id" class="form-control" value="9999999">
                <div>
                    <ul class='list-group' id="lista_company" style="display: none;"></ul>
                </div>
            </div>
            <div class="col-md-3 form-group">
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" class="form-control">
            </div>
            <div class="col-md-3 form-group">
                <label for="fecha_fin">Fecha de fin:</label>
                <input type="date" id="fecha_fin" class="form-control">
            </div>
            <div class="col-md-1  form-group align-self-center">
                <label for="btn_buscar"></label>
                <button type="button" class="btn btn-primary form-control mt-0" id="btn_buscar">Buscar</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tablaDatos" class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>date</th>
                        <th>user</th>
                        <th>module</th>
                        <th>origin</th>
                        <th>companyId</th>
                        <th>approvedBy</th>
                        <th>data</th>
                       
                    </tr>
                </thead>
            </table>
        </div>`
    </div>
@else
    <p>No tienes permisos de administrador.</p>
@endif
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
     /* .data-cell {
        width: 10%; 
        white-space: nowrap;
        overflow: hidden;
            text-overflow: ellipsis;
        }

        .data-scroll {
            overflow-x: auto;
        } */
        .data-column {
            max-height: 100px; /* Ajusta la altura máxima según tus necesidades */
            overflow-x: auto;
            white-space: nowrap; /* Evita el ajuste de texto en la columna */
        }
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" ></script>
    <script src="{{ asset('js/util.js') }}"></script>

    <script>

        $(document).ready(async function() {
            var userPerfil = "{{ Auth::user()->perfil }}";
            validatePermission(userPerfil)

            // Obten la fecha actual
            var today = new Date();

            // Establece la fecha de inicio al primer día del mes actual
            var startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            $('#fecha_inicio').val(formatDate(startDate));

            // Establece la fecha de fin al último día del mes actual
            var endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            $('#fecha_fin').val(formatDate(endDate));
            
            $('#campoBusqueda').select2();
           await  loadTable()
        });
        // Función para formatear la fecha en formato "YYYY-MM-DD"
        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return year + '-' + month + '-' + day;
        }
        const loadTable = async () =>{
            let data = await getAudits()
            var table = $('#tablaDatos').DataTable();
            table.destroy();
            buildTableContacts(data)
        }
        const getAudits = async  ()=>{
            let fecha_inicio = $('#fecha_inicio').val();
            let fecha_fin = $('#fecha_fin').val();
            let company_id = $('#company_id').val();
            let result =   await  $.ajax({
                    url: `{{ route('get_audit')}}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                     data:{fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,company_id:company_id},
                    success: function (data) {
                        // Procesa los datos exitosos
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                     }
                });
            return result;
        }
        const buildTableContacts = (data) =>{
            TABLE = $('#tablaDatos').DataTable({
                processing: true,
                // serverSide: true, 
                responsive: true,
                searching: true,
                language:espanol,
                data:data,
                columns: [             
                    { data: 'id', name: 'id', width: '100px' , className: 'data-column'},
                    { data: 'date', name: 'date', width: '150px', className: 'data-column',
                    render: (data) =>{
                        let array = data.split(' ');
                        return array[0]
                    } },
                    { data: 'user', name: 'user', width: '100px' , className: 'data-column'},
                    { data: 'module', name: 'module', width: '100px' , className: 'data-column'},
                    { data: 'origin', name: 'origin', width: '100px', className: 'data-column' },
                    { data: 'company_id', name: 'company_id', width: '100px' , className: 'data-column' },
                    { data: 'approvedBy', name: 'approvedBy', width: '100px', className: 'data-column' },
                    { data: 'data', name: 'data', width: '100px' ,
                        render: (data) => {
                                return '<div class="data-cell">' + JSON.stringify(data) + '</div>';
                            },
                            className: 'data-column' 
                    },
                    
                ],
                order: [
                    [0, 'desc'] 
                ]

            });
        }
        const desactivarCampos = (row,tr) =>{
            // Recorre las celdas con campos de entrada (excepto las columnas 1 y 2)
            tr.find('td:not(:first-child):not(:nth-child(2)) input').each(function() {
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
                $(this).html(`<input type="text" class="form-control" name="${columnName}" value="${value}">`);
            });
            tr.find('.editar').hide();
            tr.find('.guardar').show();
            tr.find('.cancelar').show();
        }
        const selectedCompany =  (companyId) =>{
            cancelAllAjaxRequests();
            $('#company_id').val(companyId);
            $("#lista_company").css("display", "none");

        }
        function cancelAllAjaxRequests() {

            for (var i = 0; i < ajaxRequests.length; i++) {
                console.log('cancelando peticion')
                ajaxRequests[i].abort();
            }
            ajaxRequests = [];
        }
        //Manejador de eventos para el boton buscar
        $('#btn_buscar').click( async  (e) =>{
            e.preventDefault();
           await  loadTable()
        })
        // Manejador de eventos para el botón "Editar"
        $('#tablaDatos').on('click', '.editar', function() {
            var tr = $(this).closest('tr');
            var row = TABLE.row(tr);
            DATA_UPDATE['contactId'] = row.cell(tr.find('td:nth-child(3)')).data(); // Obtiene el valor de la segunda columna

            activarCampos(row,tr)
        });
        
        // Manejador de eventos para el botón "Cancelar"
        $('#tablaDatos').on('click','.cancelar', function () {
            var tr = $(this).closest('tr');
            var row = TABLE.row(tr);
            desactivarCampos(row,tr)
        })

        // Manejador de eventos para el botón "Guardar"
        $('#tablaDatos').on('click', '.guardar', function() {
            var tr = $(this).closest('tr');
            var row = TABLE.row(tr);
            // Obtener los valores actualizados de los campos de entrada
            tr.find('input').each(function() {
                var fieldName = $(this).attr('name');
                var value = $(this).val();
                DATA_UPDATE[fieldName] = value;
            });

            $.ajax({
                url: '{{ route('update_contact')}}', 
                method: 'POST', 
                data: JSON.stringify(DATA_UPDATE) ,
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-right');
                    if(response.status){
                        
                        desactivarCampos(row,tr)
                        alertify.success(response.message);
                        
                    }else{
                        alertify.error(response.message);

                    }
                },
                error: function(xhr, status, error) {
                    alertify.error("Error al enviar los datos");
                    console.error('Error al actualizar los datos:', error);
                }
            });

        });
        // Manejador de eventos input company_id
        $("#company_id").keyup((e) => {
            let filtro = $("#company_id").val();
            if (filtro.length >= 3) {
                var ajax =   $.ajax({
                    url: `{{ route('get_setting')}}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data:  {search:filtro.toLowerCase()},
                    beforeSend: (e) => {
                    //icono cargando
                        let plantilla = `
                                        <ul class='list-group'>
                                        <li class="list-group-item">
                                        <i class="fas fa-sync fa-spin fa-lg load" style="display:block" id="icon_load"></i>
                                        </li>
                                        </ul>
                                        `;
                        $("#lista_company").html(plantilla);
                        $("#lista_company").attr("style", "display:block; position:absolute; z-index:2000;");
                    },
                    success: (datos) => {
                        $("#lista_company").html("");
                        let plantilla = "";
                        datos.forEach((item) => {
                            plantilla += `
                                            <li class="list-group-item" onclick="selectedCompany('${item.companyId}');">
                                                ${item.companyId} - ${item.settingName}
                                            </li>
                                            `;
                        });
                        $("#lista_company").html(plantilla);
                        $("#lista_company").attr("style", "display:block; position:absolute; z-index:2000;");
                    },
                    error: (e) => {
                    console.log("error:");
                    },
                });
                ajaxRequests.push(ajax);
            }
        });

        

    </script>
@stop