//-----------------------------------------------

// Tablas que muestran datos
let $table = $("#table");
let $tableCambios = $("#tableCambios");

// Para poner por defecto que se muestren solicitudes de un mes anterior a fecha actual
let hoy = new Date();
let desde = hoy.setMonth(hoy.getMonth() - 1);
document.querySelector("#fechaDesde").valueAsDate = new Date(desde);

//-----------------------------------------------

// Para llenar tabal con solicitudes, se recibe el arreglo con los datos
function llenarTabla(data) {
    $table.bootstrapTable({ data: data });
    $table.bootstrapTable('hideLoading');
}

// Para obtener datos de solicitudes, se obtiene un arreglo para llenar tabla
async function obtenerSolicitudes() {
    $table.bootstrapTable('destroy')
    $table.bootstrapTable('showLoading');

    let filtros = new FormData();
    filtros.append("desde", document.querySelector("#fechaDesde").value);
    filtros.append("estado", document.querySelector("#filtroEstado").value);

    await fetch("mods/solicitudes/procs/getsolicitudes.php", {
        method: "POST",
        body: filtros
    })
        .then(response => response.json())
        .then(data => llenarTabla(data.datos))
        .catch(error => console.error("Error: " + error.message));
}

//-----------------------------------------------

// Modal en la que se muestra el detalle de una solicitud
let solModal = new bootstrap.Modal(document.querySelector("#solModal"));

// Para obtener los detalles de una solicitud y mostrarlos en una modal
async function getSolicitud(id) {
    const formData = new FormData();
    formData.append("id", id);

    await fetch("mods/solicitudes/procs/getsolicitud.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            for (let atributo in data.datos) {
                if (document.querySelector("#" + atributo) == null)
                    continue;

                // Cada campo tiene el mismo nombre de los controles en el html, se ubican según su tipo
                if (atributo == "cambiarEstado")
                    document.querySelector("#cambiarEstado").value = data.datos[atributo];
                else if (atributo.startsWith("link"))
                    document.querySelector("#" + atributo).href = data.datos[atributo];
                else if (atributo != "cambios")
                    document.querySelector("#" + atributo).innerHTML = data.datos[atributo];

                // Para poner el color del estado
                if (atributo == "estado")
                {
                    document.querySelector("#estado").style.color = "#ffffff";
                    document.querySelector("#estado").style.backgroundColor = getEstadoColor(data.datos[atributo]);
                }
            }

            // Recargar tabla de solicitudes con datos obtenidos
            $tableCambios.bootstrapTable('destroy')
            $tableCambios.bootstrapTable({ data: data.datos["cambios"] });

            // Para poner foco en primer pestaña de datos en modal
            const triggerFirstTabEl = document.querySelector('#tabDatos li:first-child button')
            bootstrap.Tab.getInstance(triggerFirstTabEl).show() // Select first tab

            solModal.show();
        })
        .catch(error => console.error("Error: " + error.message));
}

// Para agregar acciones a cada solicitud en tabla de datos
function operateFormatter(value, row, index) {
    return [
        '<a class="abrir" href="javascript:void(0)" title="Abrir">',
        '<i class="bi bi-pencil-square"></i>',
        '</a>  '
    ].join('')
}

// Para definir la acción de obtener detalle de una solicitud al dar clic en una de ellas
window.operateEvents = {
    'click .abrir': function (e, value, row, index) {
        document.querySelector("#correlativoTitulo").innerHTML = row.correlativo;
        getSolicitud(row.id)
    }
}

// Para cambiar color de fuente de estado
function estadoFormatter(value) {
    let color = getEstadoColor(value);

    return '<div style="color: #ffffff; background-color: ' + color + '"><strong>&nbsp;' +
        value +
        '</strong></div>';
}

//-----------------------------------------------

// Para obtener el color de fondo o fuente según estado de solicitud
function getEstadoColor(estado)
{
    color = "#000000";

    switch (estado) {
        case "NUEVA":
            color = "#ffc107";
            break;
        case "EN PROCESO":
            color = "#0d6efd";
            break;
        case "APROBADA":
            color = "#198754";
            break;
        case "RECHAZADA":
            color = "#dc3545";
            break;
        default:
            break;
    }

    return color;
}

//-----------------------------------------------

// Para llenar los combos de estados: el de filtro para mostrar solicitudes y el de cambio de estado en una de ellas
function crearOptions(data) {
    var select = document.querySelector("#cambiarEstado");
    var filtroSelect = document.querySelector("#filtroEstado");

    // Combo de cambio de estado en una solicitud
    for (var i = 0; i < data.length; i++) {
        let
            option = document.createElement("OPTION"),
            txt = document.createTextNode(data[i].ESTADO);
        option.appendChild(txt);
        option.setAttribute("value", data[i].SOLICITUDESTADOID);

        select.add(option);
    }

    // Combo de filtro para tabla de solicitudes
    for (var i = 0; i < data.length; i++) {
        let
            option = document.createElement("OPTION"),
            txt = document.createTextNode(data[i].ESTADO);
        option.appendChild(txt);
        option.setAttribute("value", data[i].SOLICITUDESTADOID);

        filtroSelect.add(option);
    }

    let
        option = document.createElement("OPTION"),
        txt = document.createTextNode("TODAS");
    option.appendChild(txt);
    option.setAttribute("value", "TOD");
    filtroSelect.add(option);
    filtroSelect.value = "TOD";

    // Es hasta que se carga este combo que se obtienen las solicitudes, para enviarle el filtro de TODAS
    obtenerSolicitudes();
}

// Para obtener la lista de estados y ubicarlos en combos de filtro y de cambio de estado en una solicitud
async function getEstados() {
    await fetch("mods/solicitudes/procs/getEstados.php", {
        method: "POST"
    })
        .then(response => response.json())
        .then(data => crearOptions(data.datos))
        .catch(error => console.error("Error: " + error.message));
}

getEstados();

//-----------------------------------------------

// Modal para mostrar resultado de guardar datos
let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formSolicitud = document.querySelector("#formSolicitud");

formSolicitud.addEventListener("submit", fnSubmit);

//-----------------------------------------------

// Para eliminar espacios al inicio y final de campo observaciones
function trimCampos() {
    let observaciones = document.querySelector("#observaciones");
    observaciones.value = observaciones.value.trim();
}

// Para definir acción al guardar datos
async function fnSubmit(event) {
    event.preventDefault();

    trimCampos();

    let formValido = formSolicitud.checkValidity();
    if (!formValido) {
        formSolicitud.reportValidity();
        return;
    }

    const formData = new FormData(formSolicitud);
    formData.append("id", document.querySelector("#id").innerHTML);

    await fetch("mods/solicitudes/procs/formsubmit.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => fnFinalizar(data))
        .catch(error => console.error("Error: " + error.message));
}

// Si se ha obtenido respuesta al guardar datos, recargar solicitud y mostrarla su cambio de estado en tabla
function fnFinalizar(data) {
    if (data.error == "") {
        document.querySelector("#resultado").innerHTML = "Los cambios fueron guardados.";
        formSolicitud.reset();
        getSolicitud(data.id);

        obtenerSolicitudes();
    }
    else {
        document.querySelector("#resultado").innerHTML = "Error al guardar cambios.";
    }

    resModal.show();
}

//-----------------------------------------------

// Acción del botón que aplica filtro para obtener lista de solicitudes

document.querySelector("#btnFiltrar").addEventListener("click", fnFiltrar);

async function fnFiltrar(event) {
    obtenerSolicitudes();
}

//-----------------------------------------------