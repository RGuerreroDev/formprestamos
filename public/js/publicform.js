//-----------------------------------------------

let
    resModal = new bootstrap.Modal(document.querySelector("#resModal")),
    formPrestamo = document.querySelector("#formPrestamo");

formPrestamo.addEventListener("submit", fnSubmit);

async function fnSubmit(event) {
    event.preventDefault();

    document.querySelector("#btnSolicitar").disabled = true;

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

function fnFinalizar(data) {
    if (data.agregado) {
        document.querySelector("#resultado").innerHTML = "Los datos fueron enviados.<br>El consentimiento para consultar y compartir informaci&oacute;n se ha descargado.<br>";
        document.querySelector("#resultado").innerHTML += "[<a href='" + data.datos[3] + "' target='_blank' class='link-underline link-underline-opacity-0 link-underline-opacity-75-hover'>Descargar consentimiento</a>]";
        formPrestamo.reset();
        document.querySelector("#btnSolicitar").disabled = false;
        limpiarCanvas();
        downloadFile(data.datos[3], "consentimiento.pdf");
    }
    else {
        document.querySelector("#resultado").innerHTML = "Error al enviar datos.";
    }

    resModal.show();
}

//-----------------------------------------------

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

    var maxFileSizeInBytes = 1024 * 1024; // 1MB

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (file.size > maxFileSizeInBytes) {
            alert("El archivo '" + file.name + "' excede el tamaño máximo permitido.");
            event.target.value = null;
            return;
        }
    }
}

//-----------------------------------------------

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