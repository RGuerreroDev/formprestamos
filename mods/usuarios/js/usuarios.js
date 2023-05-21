//-----------------------------------------------

// Tabla en la que se va a mostrar lista de usuarios
let $table = $("#table");

//-----------------------------------------------

// Para llenar tabla de lista de usuarios, se recibe un arreglo con la lista de usuarios
function llenarTabla(data) {
    $table.bootstrapTable({ data: data });
    $table.bootstrapTable('hideLoading');
}

// Para obtener la lista de usuarios y ubicarlos en tabla
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

// Modal para crear usuario o mostrar detalle de usuario que va a ser editado
let usrModal = new bootstrap.Modal(document.querySelector("#usrModal"));

// Para obtener los datos de un usuario en modal para editarlo
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
                // Los campos obtenidos tienen el mismo nombre que los inputs en formulario, se ubican en cada uno
                if (atributo == "activo")
                    document.querySelector("#" + atributo).checked = data.datos[atributo] == 1;
                else if (atributo == "fechaCreacion")
                    document.querySelector("#" + atributo).innerHTML = data.datos[atributo];
                else
                    document.querySelector("#" + atributo).value = data.datos[atributo];
            }

            // Se está editando un usuario: la contraseña no es obligatoria, ya que si no se edita no se cambia
            // El usuario es solamente de lectura, no se puede cambiar
            document.querySelector("#contrasena").removeAttribute("required");
            document.querySelector("#usuario").setAttribute("readonly", "true");
            usrModal.show();
        })
        .catch(error => console.error("Error: " + error.message));
}

// Para agregar acciones a cada fila de usuario que se muestra en tabla
function operateFormatter(value, row, index) {
    return [
        '<a class="abrir" href="javascript:void(0)" title="Abrir">',
        '<i class="bi bi-pencil-square"></i>',
        '</a>  '
    ].join('')
}

// Para definir la acción al dar clic sobre un usuario que se muestra en tabla (obtener datos y mostrar en modal)
window.operateEvents = {
    'click .abrir': function (e, value, row, index) {
        document.querySelector("#usuarioTitle").innerHTML = row.usuario;
        getUsuario(row.id)
    }
}

// Para poner foco en input de nombre completo cuando se abre la modal para crear o editar un usuario
document.querySelector("#usrModal").addEventListener('shown.bs.modal', () => {
    document.querySelector("#nombreCompleto").focus();
});

//-----------------------------------------------

function trimCampos()
{
    let
        nombre = document.querySelector("#nombreCompleto"),
        usuario = document.querySelector("#usuario");

    nombre.value = nombre.value.trim();
    usuario.value = usuario.value.trim();
}

// Para eliminar espacios al inicio y final de campos de nombre completo y usuario
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

// Modal de resultado de guardar datos
let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formUsuario = document.querySelector("#formUsuario");

// Acción al guardar datos de usuario

formUsuario.addEventListener("submit", fnSubmit);

async function fnSubmit(event) {
    event.preventDefault();

    trimCampos();

    let formValido = formUsuario.checkValidity();
    if(!formValido) {
        formUsuario.reportValidity();
        return;
    }

    const formData = new FormData(formUsuario);

    await fetch("mods/usuarios/procs/formSubmit.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => fnFinalizar(data))
        .catch(error => console.error("Error: " + error.message));
}

// Si se ha recibido respuesta al guardar datos, finalizar mostrando mensaje de error o de éxito
function fnFinalizar(data) {
    if (data.error == "") {
        document.querySelector("#resultado").innerHTML = data.mensaje;

        obtenerUsuarios();
        usrModal.hide();

        setTimeout(function(){
            formUsuario.reset();
        }, 1000);
    }
    else {
        document.querySelector("#resultado").innerHTML = "Error al guardar datos: " + data.mensaje;
    }

    resModal.show();
}

//-----------------------------------------------

// Al dar clic en botón de crear usuario: se muestra modal con formulario vacío y acá sí es obligatoria la contraseña

document.querySelector("#btnCrear").addEventListener("click", fnCrear);

async function fnCrear() {
    formUsuario.reset();
    document.querySelector("#usuarioTitle").innerHTML = "[Nuevo usuario]";
    document.querySelector("#usuario").removeAttribute("readonly");
    document.querySelector("#contrasena").setAttribute("required", "");
    document.querySelector("#fechaCreacion").innerHTML = "";
    document.querySelector("#id").value = -1;

    usrModal.show();
}

//-----------------------------------------------