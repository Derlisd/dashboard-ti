

var TABLE = '';
var DATA_UPDATE = {};
var CONTACTID = '';
var USER_PERFIL = '';
let espanol = {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo:
    "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
    sFirst: "Primero",
    sLast: "Último",
    sNext: "Siguiente",
    sPrevious: "Anterior",
    },
    oAria: {
    sSortAscending: ": Activar para ordenar la columna de manera ascendente",
    sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
    buttons: {
    copy: "Copiar",
    colvis: "Visibilidad",
    },
};
const showLoading = () =>{
    $('#btn_ejecutar').attr('disabled',true);
    $('#btn_ejecutar').html('<i class="fas fa-spinner fa-lg spin"></i>');
}
const hideLoading = () =>{
    $('#btn_ejecutar').attr('disabled',false);
    $('#btn_ejecutar').html('Ejecutar');
}
const tableShowLoading = (elem) =>{
    $(elem).removeClass('fa-solid fa-floppy-disk');
    $(elem).html('<i class="fas fa-spinner fa-lg spin"></i>');
    $(elem).attr('disabled',true);
}
const tableHideLoading = (elem) =>{
    $(elem).addClass('fa-solid fa-floppy-disk');
    $(elem).html('');
    $(elem).attr('disabled',false);
}
const validatePermission = (userPerfil) =>{
    switch (userPerfil) {
        case 'Admin':
            // oculta el primer li
            $("#navbarCollapse ul.nav.navbar-nav li.nav-item:first").hide();
            break;
        case 'Desarrollador':
            //oculta el primer y segundo li
            $("#navbarCollapse ul.nav.navbar-nav li.nav-item:first, #navbarCollapse ul.nav.navbar-nav li.nav-item:eq(1)").hide();
            break;
        case 'Super_administrador':
             //oculta el segundo y tercer li
            // $("#navbarCollapse ul.nav.navbar-nav li.nav-item:eq(1), #navbarCollapse ul.nav.navbar-nav li.nav-item:eq(2)").hide();
            break;
        default:
            break;
    }
}
const  esJSON = (texto) => {
    try {
        if(esNumero(texto)){
            return false;
        }
        JSON.parse(texto);
        return true;
    } catch (error) {
        return false;
    }
}
function esNumero(texto) {
    return !isNaN(parseFloat(texto)) && isFinite(texto);
}