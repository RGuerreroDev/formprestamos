//-----------------------------------------------

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

const limpiarCanvas = () => {
    contexto.fillStyle = COLOR_FONDO;
    contexto.fillRect(0, 0, $canvasFirma.width, $canvasFirma.height);
    haFirmado = false;
};

limpiarCanvas();
$btnLimpiarFirma.onclick = limpiarCanvas;

//-----------------------------------------------

function canvasEstaVacia() {
    return !haFirmado;
}

//-----------------------------------------------