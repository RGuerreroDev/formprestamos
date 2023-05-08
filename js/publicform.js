//-----------------------------------------------

$formPrestamo = document.querySelector("#formPrestamo");

//-----------------------------------------------

$formPrestamo.addEventListener("submit", fnSubmit);

async function fnSubmit(event)
{
    event.preventDefault();
    
    const firma = document.querySelector("#canvasFirma").toDataURL("image/png");
    
    const formData = new FormData();
    formData.append("imagen", firma);


}

//-----------------------------------------------