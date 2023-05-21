//-----------------------------------------------

let $table = $("#table");

//-----------------------------------------------

function llenarTabla(data) {
    $table.bootstrapTable({ data: data });
    $table.bootstrapTable('hideLoading');
}

async function obtenerUsuarios() {
    $table.bootstrapTable('destroy');
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

let usrModal = new bootstrap.Modal(document.querySelector("#usrModal"));

async function getUsuario(id) {
    const formData = new FormData();
    formData.append("id", id);

    await fetch("mods/usuarios/procs/getUsuario.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            for (let atributo in data.datos) {
                if (atributo == "activo")
                    document.querySelector("#" + atributo).checked = data.datos[atributo] == 1;
                else if (atributo == "fechaCreacion")
                    document.querySelector("#" + atributo).innerHTML = data.datos[atributo];
                else
                    document.querySelector("#" + atributo).value = data.datos[atributo];
            }

            document.querySelector("#contrasena").removeAttribute("required");
            document.querySelector("#usuario").setAttribute("readonly", "true");
            usrModal.show();
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
        document.querySelector("#usuarioTitle").innerHTML = row.usuario;
        getUsuario(row.id)
    }
}

document.querySelector("#usrModal").addEventListener('shown.bs.modal', () => {
    document.querySelector("#nombreCompleto").focus();
});

//-----------------------------------------------

function validarFormulario()
{
    let
        nombre = document.querySelector("#nombreCompleto"),
        usuario = document.querySelector("#usuario"),
        mensaje = "";

    nombre.value = nombre.value.trim();
    usuario.value = usuario.value.trim();

    if (nombre.value.length == 0)
        mensaje += "El nombre está vacío.\n";
    if (usuario.value.length == 0)
        mensaje += "El usuario está vacío";

    if (mensaje.length > 0)
    {
        alert("Error:\n" + mensaje);
        return false;
    }

    return true;
}

//-----------------------------------------------

let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formUsuario = document.querySelector("#formUsuario");

formUsuario.addEventListener("submit", fnSubmit);

async function fnSubmit(event) {
    event.preventDefault();

    if (!validarFormulario())
        return;

    const formData = new FormData(formUsuario);

    await fetch("mods/usuarios/procs/formsubmit.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => fnFinalizar(data))
        .catch(error => console.error("Error: " + error.message));
}

function fnFinalizar(data) {
    if (data.error == "") {
        document.querySelector("#resultado").innerHTML = data.mensaje;
        formUsuario.reset();

        obtenerUsuarios();
        usrModal.hide();
    }
    else {
        document.querySelector("#resultado").innerHTML = "Error al guardar datos: " + data.mensaje;
    }

    resModal.show();
}

//-----------------------------------------------

document.querySelector("#btnCrear").addEventListener("click", fnCrear);

async function fnCrear() {
    formUsuario.reset();
    document.querySelector("#usuarioTitle").innerHTML = "[Nuevo usuario]";
    document.querySelector("#usuario").removeAttribute("readonly");
    document.querySelector("#contrasena").setAttribute("required", "");
    document.querySelector("#id").value = -1;

    usrModal.show();
}

//-----------------------------------------------