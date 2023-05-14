//-----------------------------------------------

async function getTiposDocumento()
{
    await fetch("public/procs/getTiposDocumento.php", {
        method: "POST"
    })
        .then(response => response.json())
        .then(data => crearOptions(data.datos))
        .catch(error => console.error("Error: " + error.message));
}

function crearOptions(data)
{
    var select = document.querySelector("#tipoDocumento");

    for(var i = 0; i < data.length; i++)
    {
        let
            option = document.createElement("OPTION"),
            txt = document.createTextNode(data[i].DOCUMENTO);
        option.appendChild(txt);
        option.setAttribute("value", data[i].TIPODOCUMENTOID);
        select.add(option);
    }
}

getTiposDocumento();

//-----------------------------------------------

let checkAceptar = document.querySelector("#terminos");
checkAceptar.addEventListener("click", fnAceptar);

function fnAceptar(event)
{
    document.querySelector("#btnSolicitar").disabled = !checkAceptar.checked;
}

//-----------------------------------------------

let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formPrestamo = document.querySelector("#formPrestamo");

formPrestamo.addEventListener("submit", fnSubmit);

async function fnSubmit(event)
{
    event.preventDefault();
    
    const firma = document.querySelector("#canvasFirma").toDataURL("image/png");
    
    const formData = new FormData(formPrestamo);
    formData.append("imagen", firma);

    await fetch("public/procs/formsubmit.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => fnFinalizar(data))
        .catch(error => console.error("Error: " + error.message));
}

function fnFinalizar(data)
{
    if (data.agregado)
    {
        document.querySelector("#resultado").innerHTML = "Los datos fueron enviados.";
        formPrestamo.reset();
        document.querySelector("#btnSolicitar").disabled = true;
        limpiarCanvas();
    }
    else
    {
        document.querySelector("#resultado").innerHTML = "Error al enviar datos.";
    }

    resModal.show();
}

//-----------------------------------------------