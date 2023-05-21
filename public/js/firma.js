//-----------------------------------------------

// Variables para definir canvas en la que se va a dibujar una firma

const
    $canvasFirma = document.querySelector("#canvasFirma"),
    $btnLimpiarFirma = document.querySelector("#btnLimpiarFirma");
const
    contexto = $canvasFirma.getContext("2d"),
    COLOR_PINCEL = "black",
    COLOR_FONDO = "white";
GROSOR = 2;
let
    xAnterior = 0,
    yAnterior = 0,
    xActual = 0,
    yActual = 0;
const
    obtenerXReal = (clientX) => clientX - $canvasFirma.getBoundingClientRect().left,
    obtenerYReal = (clientY) => clientY - $canvasFirma.getBoundingClientRect().top;
let
    haComenzadoDibujo = false,
    haFirmado = false;

//-----------------------------------------------

// Al iniciar a dibujar en el canvas se muestra la línea trazada
$canvasFirma.addEventListener("mousedown", evento => {
    xAnterior = xActual;
    yAnterior = yActual;
    xActual = obtenerXReal(evento.clientX);
    yActual = obtenerYReal(evento.clientY);
    contexto.beginPath();
    contexto.fillStyle = COLOR_PINCEL;
    contexto.fillRect(xActual, yActual, GROSOR, GROSOR);
    contexto.closePath();

    haComenzadoDibujo = true;
    haFirmado = true;
});

// Cuando se mueve dentro de canvas y se está dibujando, se muestra la traza
$canvasFirma.addEventListener("mousemove", (evento) => {
    if (!haComenzadoDibujo) {
        return;
    }

    xAnterior = xActual;
    yAnterior = yActual;
    xActual = obtenerXReal(evento.clientX);
    yActual = obtenerYReal(evento.clientY);
    contexto.beginPath();
    contexto.moveTo(xAnterior, yAnterior);
    contexto.lineTo(xActual, yActual);
    contexto.strokeStyle = COLOR_PINCEL;
    contexto.lineWidth = GROSOR;
    contexto.stroke();
    contexto.closePath();
});
["mouseup", "mouseout"].forEach(nombreDeEvento => {
    $canvasFirma.addEventListener(nombreDeEvento, () => {
        haComenzadoDibujo = false;
    });
});

//-----------------------------------------------

// Para dejar en blanco el canvas
const limpiarCanvas = () => {
    contexto.fillStyle = COLOR_FONDO;
    contexto.fillRect(0, 0, $canvasFirma.width, $canvasFirma.height);
    haFirmado = false;
};

limpiarCanvas();
$btnLimpiarFirma.onclick = limpiarCanvas;

//-----------------------------------------------

// Para poder establecer si el canvas está vacío (no se ha firmado)
function canvasEstaVacia() {
    return !haFirmado;
}

//-----------------------------------------------