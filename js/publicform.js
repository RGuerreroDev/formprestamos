//-----------------------------------------------

$formPrestamo = document.querySelector("#formPrestamo");

//-----------------------------------------------

$formPrestamo.addEventListener("submit", fnSubmit);

async function fnSubmit(event)
{
    event.preventDefault();
    
    const firma = document.querySelector("#canvasFirma").toDataURL("image/png");
    
    const formData = new FormData($formPrestamo);
    formData.append("imagen", firma);

    await fetch("procs/formsubmit.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.log(error));
}

//-----------------------------------------------