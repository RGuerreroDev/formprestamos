//-----------------------------------------------

let $table = $("#table");

//-----------------------------------------------

function llenarTabla(data) {
    $table.bootstrapTable({ data: data });
    $table.bootstrapTable('hideLoading');
}

async function obtenerUsuarios() {
    $table.bootstrapTable('showLoading');

    await fetch("mods/usuarios/procs/getUsuarios.php", {
        method: "POST"
    })
        .then(response => response.json())
        .then(data => llenarTabla(data.datos))
        .catch(error => console.error("Error: " + error.message));
}

obtenerUsuarios();

//-----------------------------------------------

let solModal = new bootstrap.Modal(document.querySelector("#solModal"));

async function getUsuario(id)
{
    const formData = new FormData();
    formData.append("id", id);

    await fetch("mods/usuarios/procs/getUsuario.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            for (let atributo in data.datos)
            {
                if (atributo == "activo")
                    document.querySelector("#" + atributo).checked = data.datos[atributo] == 1;
                else if (atributo == "fechaCreacion")
                    document.querySelector("#" + atributo).innerHTML = data.datos[atributo];
                else
                    document.querySelector("#" + atributo).value = data.datos[atributo];
            }

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
        //document.querySelector("#correlativoTitulo").innerHTML = row.correlativo;
        getUsuario(row.id)
    }
}

//-----------------------------------------------

let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formUsuario = document.querySelector("#formUsuario");

    formUsuario.addEventListener("submit", fnSubmit);

async function fnSubmit(event)
{
    event.preventDefault();
    
    const formData = new FormData(formUsuario);
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