//-----------------------------------------------

// Definir el elemento para mostrar mensajes de error
let toastElement = document.getElementById('toastError');
let toastError = bootstrap.Toast.getOrCreateInstance(toastElement);

//-----------------------------------------------

// Acción de formulario
let frmInicioSesion = document.getElementById("frmInicioSesion");
frmInicioSesion.addEventListener("submit", frmInicioSesionSubmit);

function frmInicioSesionSubmit(event)
{
    event.preventDefault();

    document.getElementById("btnSubmit").setAttribute("disabled", "true");
    document.getElementById("btnAceptarSpinner").classList.remove("visually-hidden");

    let datos = new FormData(event.target);

    fetch(
        "./mods/login/procs/login.php",
        {
            method: "POST",
            body: datos
        }
    )
    .then(response => response.json())
    .then(data => resInicioSesion(data))
    .catch(error => console.warn(error));
}

//-----------------------------------------------

function resInicioSesion(data)
{
    if(!data.error)
    {
        window.location.replace("/");
    }
    else
    {
        toastError.show();
        document.getElementById("btnSubmit").removeAttribute("disabled");
        document.getElementById("btnAceptarSpinner").classList.add("visually-hidden");
    }
}

//-----------------------------------------------