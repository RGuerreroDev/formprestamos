//-----------------------------------------------

const canvasFirma = document.querySelector("#canvasFirma");
const signaturePad = new SignaturePad(canvasFirma);

document.querySelector("#btnLimpiarFirma").addEventListener("click", (event) => {
    signaturePad.clear();
});

//-----------------------------------------------

// Modal de respuesta de datos guardados
let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formPrestamo = document.querySelector("#formPrestamo");

// Para eliminar espacios al inicio y final de campo observaciones
function trimCampos() {
    document.querySelector("#nombres").value = document.querySelector("#nombres").value.trim();
    document.querySelector("#apellidos").value = document.querySelector("#apellidos").value.trim();
    document.querySelector("#numeroDocumento").value = document.querySelector("#numeroDocumento").value.trim();
    document.querySelector("#correoElectronico").value = document.querySelector("#correoElectronico").value.trim();
    document.querySelector("#direccionDomicilio").value = document.querySelector("#direccionDomicilio").value.trim();
    document.querySelector("#telefono").value = document.querySelector("#telefono").value.trim();
    document.querySelector("#lugarDeTrabajo").value = document.querySelector("#lugarDeTrabajo").value.trim();
    document.querySelector("#telefonoTrabajo").value = document.querySelector("#telefonoTrabajo").value.trim();
    document.querySelector("#direccionTrabajo").value = document.querySelector("#direccionTrabajo").value.trim();
    document.querySelector("#referencia").value = document.querySelector("#referencia").value.trim();
    document.querySelector("#telefonoReferencia").value = document.querySelector("#telefonoReferencia").value.trim();
}

// Acción al enviar datos

formPrestamo.addEventListener("submit", fnSubmit);

async function fnSubmit(event) {
    event.preventDefault();

    trimCampos();

    if (!formPrestamo.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }

    formPrestamo.classList.add('was-validated');

    if (!formPrestamo.checkValidity()) {
        alert("Error:\nDebe llenar todos los campos obligatorios.");
        return;
    }

    // Validación en la que el correo y su confirmación sean iguales
    if (document.querySelector("#correoElectronico").value != document.querySelector("#correoElectronicoConfirm").value) {
        alert("El correo electrónico y su confirmación no coinciden");
        document.querySelector("#correoElectronico").focus();
        return;
    }

    // Validación para asegurar que se ha dibujado una firma
    if (signaturePad.isEmpty()) {
        alert("Debe agregar firma al formulario para enviar la solicitud.");
        return;
    }

    document.querySelector("#btnSolicitar").disabled = true;

    // Preparar firma para ser enviada como imagen adjunta
    const firma = document.querySelector("#canvasFirma").toDataURL("image/png");

    const formData = new FormData(formPrestamo);
    formData.append("imagen", firma);

    await fetch("procs/formsubmit.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => fnFinalizar(data))
        .catch(error => console.error("Error: " + error.message));
}

// Al recibir respuesta de proceso de guardado: se limpia formulario, se descarga el consentimiento y se muestra resultado
function fnFinalizar(data) {
    if (data.agregado) {
        document.querySelector("#resultado").innerHTML = "Los datos fueron enviados.<br>El consentimiento para consultar y compartir informaci&oacute;n se ha descargado.<br>";
        document.querySelector("#resultado").innerHTML += "[<a href='" + data.datos[3] + "' target='_blank' class='link-underline link-underline-opacity-0 link-underline-opacity-75-hover'>Descargar consentimiento</a>]";
        
        formPrestamo.classList.remove('was-validated');
        document.querySelector("#btnSolicitar").disabled = false;
        signaturePad.clear();
        downloadFile(data.datos[3], "consentimiento.pdf");

        setTimeout(function(){
            formPrestamo.reset();
        }, 1000);
    }
    else {
        document.querySelector("#resultado").innerHTML = "Error al enviar datos.";
    }

    resModal.show();
}

//-----------------------------------------------

// Para validar que se están subiendo solo archivos de tipo imagen

document.querySelectorAll(".uploadimage").forEach(fileInput => {
    fileInput.addEventListener("change", fnValidaImagen);
});

function fnValidaImagen(event) {
    var files = event.target.files;

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!file.type.startsWith("image/")) {
            alert("El archivo '" + file.name + "' no es una imagen válida.");
            event.target.value = null;
            return;
        }
    }
}

//-----------------------------------------------

// Para descargar de forma automática el consentimiento después que se ha enviado el formulario
async function downloadFile(url, filename) {
    try {
        const response = await fetch(url);
        const blob = await response.blob();

        // Download link
        const downloadLink = document.createElement("a");
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = filename;

        // Trigger the download
        document.body.appendChild(downloadLink);
        downloadLink.click();

        // Clean up
        setTimeout(() => {
            URL.revokeObjectURL(downloadLink.href);
            document.body.removeChild(downloadLink);
        }, 100);
    } catch (error) {
        console.error('Error al descargar el archivo:', error.message);
    }
}

//-----------------------------------------------

jQuery("#telefono").inputmask({"mask": "9999-9999"});
jQuery("#telefonoTrabajo").inputmask({"mask": "9999-9999"});
jQuery("#telefonoReferencia").inputmask({"mask": "9999-9999"});
jQuery("#numeroDocumento").inputmask({"mask": "99999999-9"});

//-----------------------------------------------