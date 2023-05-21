//-----------------------------------------------

let $table = $("#table");
let $tableCambios = $("#tableCambios");

let hoy = new Date();
let desde = hoy.setMonth(hoy.getMonth() - 1);
document.querySelector("#fechaDesde").valueAsDate = new Date(desde);

//-----------------------------------------------

function llenarTabla(data) {
    $table.bootstrapTable({ data: data });
    $table.bootstrapTable('hideLoading');
}

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

let solModal = new bootstrap.Modal(document.querySelector("#solModal"));

async function getSolicitud(id)
{
    const formData = new FormData();
    formData.append("id", id);

    await fetch("mods/solicitudes/procs/getsolicitud.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            for (let atributo in data.datos)
            {
                if (document.querySelector("#" + atributo) == null)
                    continue;

                if (atributo == "firma")
                    document.querySelector("#firma").src = "public/imgs/" + data.datos[atributo];
                else if (atributo == "estadoId")
                    document.querySelector("#cambiarEstado").value = data.datos[atributo];
                else if (atributo.startsWith("link"))
                document.querySelector("#" + atributo).href = data.datos[atributo];
                else if (atributo != "cambios")
                    document.querySelector("#" + atributo).innerHTML = data.datos[atributo];
            }

            $tableCambios.bootstrapTable('destroy')
            $tableCambios.bootstrapTable({ data: data.datos["cambios"] });

            const triggerFirstTabEl = document.querySelector('#tabDatos li:first-child button')
            bootstrap.Tab.getInstance(triggerFirstTabEl).show() // Select first tab
            
            solModal.show();
        })
        .catch(error => console.error("Error: " + error.message));
}

function operateFormatter(value, row, index) {
    return [
        '<a class="abrir" href="javascript:void(0)" title="Abrir">',
        '<i class="bi bi-pencil-square"></i>',
        '</a>  '
    ].join('')
}

window.operateEvents = {
    'click .abrir': function (e, value, row, index) {
        document.querySelector("#correlativoTitulo").innerHTML = row.correlativo;
        getSolicitud(row.id)
    }
}

//-----------------------------------------------

function crearOptions(data)
{
    var select = document.querySelector("#cambiarEstado");
    var filtroSelect = document.querySelector("#filtroEstado");

    for(var i = 0; i < data.length; i++)
    {
        let
            option = document.createElement("OPTION"),
            txt = document.createTextNode(data[i].ESTADO);
        option.appendChild(txt);
        option.setAttribute("value", data[i].SOLICITUDESTADOID);
        
        select.add(option);
    }

    for(var i = 0; i < data.length; i++)
    {
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
        filtroSelect.value = "NUE";
    
    obtenerSolicitudes();
}

async function getEstados()
{
    await fetch("mods/solicitudes/procs/getEstados.php", {
        method: "POST"
    })
        .then(response => response.json())
        .then(data => crearOptions(data.datos))
        .catch(error => console.error("Error: " + error.message));
}

getEstados();

//-----------------------------------------------

let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formSolicitud = document.querySelector("#formSolicitud");

formSolicitud.addEventListener("submit", fnSubmit);

async function fnSubmit(event)
{
    event.preventDefault();
    
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

function fnFinalizar(data)
{
    if (data.error == "")
    {
        document.querySelector("#resultado").innerHTML = "Los cambios fueron guardados.";
        formSolicitud.reset();
        getSolicitud(data.id);
     
        $table.bootstrapTable('updateCellByUniqueId', {
            id: data.id,
            field: 'estado',
            value: data.estado,
            reinit: false
          })
    }
    else
    {
        document.querySelector("#resultado").innerHTML = "Error al guardar cambios.";
    }

    resModal.show();
}

//-----------------------------------------------

document.querySelector("#btnFiltrar").addEventListener("click", fnFiltrar);

async function fnFiltrar(event)
{
    obtenerSolicitudes();
}

//-----------------------------------------------