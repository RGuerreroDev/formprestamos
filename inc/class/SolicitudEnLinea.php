<?php

require_once("SQLSrvBD.php");
require_once("SolicitudEnLineaCambio.php");

class SolicitudEnLinea
{
    //-------------------------------------------

    private $conn;

    public $solicitudEnLineaId;
    public $correlativo;
    public $nombres;
    public $apellidos;
    public $fechaNacimiento;
    public $tipoDocumentoId;
    public $documento;
    public $numeroDocumento;
    public $direccionDomicilio;
    public $telefono;
    public $correoElectronico;
    public $lugarDeTrabajo;
    public $direccionTrabajo;
    public $telefonoTrabajo;
    public $ingresoMensual;
    public $referenciaPersonal;
    public $telefonoReferenciaPersonal;
    public $imagenFirma;
    public $pdfConsentimiento;
    public $imagenDuiFrente;
    public $imagenDuiAtras;
    public $imagenRecibo;
    public $fechaHoraRecepcion;
    public $solicitudEstadoId;
    public $estado;
    public $fechaHoraCreacion;
    public $fechaHoraUltimaModificacion;
    public $cambios;

    public $mensajeError;

    //-------------------------------------------

    /**
     * Instancia un objeto SolicitudEnLinea
     * 
     * @param SQLSrvBD $conn Conexión a base de datos para realizar acciones sobre registros
     * 
     */
    // Constructor: Recibe conexión a base de datos
    // para realizar acciones sobre tabla
    public function __construct(SQLSrvBD $conn)
    {
        $this->conn = $conn;
        $this->resetPropiedades();
    }

    //-------------------------------------------

    /**
     * Obtener datos de un registro (SOLICITUDESENLINEA) por medio de ID
     * 
     * @param int $id ID del registro que será consultado
     * 
     * @return void No se retorna dato, pero se guardan los datos del registro en las propiedades del objeto
     * 
     */
    public function getById(int $id): void
    {
        $sentenciaSql = "
            SELECT
                 S.SOLICITUDENLINEAID
                ,S.CORRELATIVO
                ,S.FECHAHORARECEPCION
                ,S.NOMBRES
                ,S.APELLIDOS
                ,S.FECHANACIMIENTO
                ,S.TIPODOCUMENTOID
                ,D.DOCUMENTO
                ,S.NUMERODOCUMENTO
                ,S.DIRECCIONDOMICILIO
                ,S.TELEFONO
                ,S.CORREOELECTRONICO
                ,S.LUGARDETRABAJO
                ,S.DIRECCIONDETRABAJO
                ,S.TELEFONOTRABAJO
                ,S.INGRESOMENSUAL
                ,S.REFERENCIAPERSONAL
                ,S.TELEFONOREFERENCIAPERSONAL
                ,S.IMAGENFIRMA
                ,S.SOLICITUDESTADOID
                ,E.ESTADO
                ,S.FECHAHORACREACION
                ,S.FECHAHORAULTIMAMODIFICACION
                ,S.PDFCONSENTIMIENTO
                ,S.IMAGENDUIFRENTE
                ,S.IMAGENDUIATRAS
                ,S.IMAGENRECIBO
            FROM
                SOLICITUDESENLINEA S
                JOIN SOLICITUDESTADOS E ON E.SOLICITUDESTADOID=S.SOLICITUDESTADOID
                JOIN TIPOSDOCUMENTO D ON D.TIPODOCUMENTOID=S.TIPODOCUMENTOID
            WHERE
                S.SOLICITUDENLINEAID = ?
        ";
        $datos = $this->conn->select($sentenciaSql, [$id]);

        $this->resetPropiedades();
        foreach ($datos as $dato)
        {
            $this->solicitudEnLineaId = $dato["SOLICITUDENLINEAID"];
            $this->correlativo = $dato["CORRELATIVO"];
            $this->nombres = $dato["NOMBRES"];
            $this->apellidos = $dato["APELLIDOS"];
            $this->fechaNacimiento = $dato["FECHANACIMIENTO"];
            $this->tipoDocumentoId = $dato["TIPODOCUMENTOID"];
            $this->documento = $dato["DOCUMENTO"];
            $this->numeroDocumento = $dato["NUMERODOCUMENTO"];
            $this->direccionDomicilio = $dato["DIRECCIONDOMICILIO"];
            $this->telefono = $dato["TELEFONO"];
            $this->correoElectronico = $dato["CORREOELECTRONICO"];
            $this->lugarDeTrabajo = $dato["LUGARDETRABAJO"];
            $this->direccionTrabajo = $dato["DIRECCIONDETRABAJO"];
            $this->telefonoTrabajo = $dato["TELEFONOTRABAJO"];
            $this->ingresoMensual = $dato["INGRESOMENSUAL"];
            $this->referenciaPersonal = $dato["REFERENCIAPERSONAL"];
            $this->telefonoReferenciaPersonal = $dato["TELEFONOREFERENCIAPERSONAL"];
            $this->imagenFirma = $dato["IMAGENFIRMA"];
            $this->fechaHoraRecepcion = $dato["FECHAHORARECEPCION"];
            $this->solicitudEstadoId = $dato["SOLICITUDESTADOID"];
            $this->estado = $dato["ESTADO"];
            $this->fechaHoraCreacion = $dato["FECHAHORACREACION"];
            $this->fechaHoraUltimaModificacion = $dato["FECHAHORAULTIMAMODIFICACION"];
            $this->pdfConsentimiento = $dato["PDFCONSENTIMIENTO"];
            $this->imagenDuiFrente = $dato["IMAGENDUIFRENTE"];
            $this->imagenDuiAtras = $dato["IMAGENDUIATRAS"];
            $this->imagenRecibo = $dato["IMAGENRECIBO"];
        }

        if ($this->solicitudEnLineaId > -1)
        {
            $objCambios = new SolicitudEnLineaCambio($this->conn);
            $this->cambios = $objCambios->getAll($this->solicitudEnLineaId);
        }
    }

    //-------------------------------------------

    /**
     * Obtener todos los registros de la tabla (SOLICITUDESENLINEA)
     * 
     * @param void
     * 
     * @return array Todos los registros encontrados en la tabla
     * 
     */
    public function getAll(): array
    {
        $this->resetPropiedades();

        $sentenciaSql = "
        SELECT
             S.SOLICITUDENLINEAID
            ,S.CORRELATIVO
            ,S.FECHAHORARECEPCION
            ,S.NOMBRES
            ,S.APELLIDOS
            ,S.FECHANACIMIENTO
            ,S.TIPODOCUMENTOID
            ,D.DOCUMENTO
            ,S.NUMERODOCUMENTO
            ,S.DIRECCIONDOMICILIO
            ,S.TELEFONO
            ,S.CORREOELECTRONICO
            ,S.LUGARDETRABAJO
            ,S.DIRECCIONDETRABAJO
            ,S.TELEFONOTRABAJO
            ,S.INGRESOMENSUAL
            ,S.REFERENCIAPERSONAL
            ,S.TELEFONOREFERENCIAPERSONAL
            ,S.IMAGENFIRMA
            ,S.SOLICITUDESTADOID
            ,E.ESTADO
            ,S.FECHAHORACREACION
            ,S.FECHAHORAULTIMAMODIFICACION
            ,S.PDFCONSENTIMIENTO
            ,S.IMAGENDUIFRENTE
            ,S.IMAGENDUIATRAS
            ,S.IMAGENRECIBO
        FROM
            SOLICITUDESENLINEA S
            JOIN SOLICITUDESTADOS E ON E.SOLICITUDESTADOID=S.SOLICITUDESTADOID
            JOIN TIPOSDOCUMENTO D ON D.TIPODOCUMENTOID=S.TIPODOCUMENTOID
        ORDER BY
            FECHAHORARECEPCION DESC
        ";
        $datos = $this->conn->select($sentenciaSql, []);

        return $datos;
    }
    
    //-------------------------------------------
    /**
     * Resetear a valores neutros las propiedades del objeto
     * 
     * @param void No necesita parámetros
     * 
     * @return void No retorna valor sino que quedan actualizadas las propiedades del objeto
     * 
     */
    // Resetear a valores neutros las propiedades del objeto
    private function resetPropiedades(): void
    {
        $this->solicitudEnLineaId = -1;
        $this->correlativo = null;
        $this->nombres = null;
        $this->apellidos = null;
        $this->fechaNacimiento = null;
        $this->tipoDocumentoId = null;
        $this->documento = null;
        $this->numeroDocumento = null;
        $this->direccionDomicilio = null;
        $this->telefono = null;
        $this->correoElectronico = null;
        $this->lugarDeTrabajo = null;
        $this->direccionTrabajo = null;
        $this->telefonoTrabajo = null;
        $this->ingresoMensual = null;
        $this->referenciaPersonal = null;
        $this->telefonoReferenciaPersonal = null;
        $this->imagenFirma = null;
        $this->fechaHoraRecepcion = null;
        $this->solicitudEstadoId = null;
        $this->estado = null;
        $this->fechaHoraCreacion = null;
        $this->fechaHoraUltimaModificacion = null;
        $this->pdfConsentimiento = null;
        $this->imagenDuiFrente = null;
        $this->imagenDuiAtras = null;
        $this->imagenRecibo = null;
        $this->cambios = array();
    }

    //-------------------------------------------
    /**
     * Edita un registro (SOLICITUDESENLINEA) existente
     * 
     * @param int $id El id del registro a editar
     * @param array $camposValores Array que contiene campos y valores a ser actualizados [campo, valor, campo, valor...]
     * 
     * @return bool Resultado de actualizar el registro: true: fue editado, false: no fue editado
     * 
     */
    public function editarRegistro(int $id, array $camposValores): bool
    {
        $this->resetPropiedades();

        $updates = "";
        $valores = array();
        for ($i=0; $i < count($camposValores); $i++)
        {
            $updates .= $i % 2 == 0 ? $camposValores[$i] . " = " : "?, ";
            if ($i % 2 == 1)
            {
                array_push($valores, $camposValores[$i]);
            }
        }
        $updates = rtrim($updates, ", ");

        array_push($valores, $id);

        $sentenciaSql = "
            UPDATE SOLICITUDESENLINEA SET " . $updates . " WHERE SOLICITUDENLINEAID = ?
        ";
        $editado = $this->conn->update($sentenciaSql, $valores);

        if ($editado)
        {
            // TODO: poner en propiedades los datos del registro
        }
        else
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $editado;
    }

    //-------------------------------------------

    /**
     * Agregar un nuevo registro (SOLICITUDESENLINEA)
     * 
     * @param string $nombre El contenido del campo nombre del nuevo registro
     * 
     * @return bool Resultado de guardar registro: true: fue guardado, false: no fue guardado
     * 
     */
    public function agregarRegistro(string $nombres, string $apellidos, string $fechaNacimiento, string $tipoDocumentoId,
                                    string $numeroDocumento, string $direccionDomicilio, string $telefono, string $correoElectronico,
                                    string $lugarDeTrabajo, string $direccionTrabajo, string $telefonoTrabajo,
                                    float $ingresoMensual, string $referenciaPersonal, string $telefonReferenciaPersonal,
                                    string $imagenFirma, string $pdfConsentimiento, string $imagenDuiFrente, string $imagenDuiAtras,
                                    string $imagenRecibo): bool
    {
        $this->resetPropiedades();

        $estadoInicial = "NUE";

        $sentenciaSql = "
            INSERT INTO SOLICITUDESENLINEA
                (CORRELATIVO, FECHAHORARECEPCION,
                NOMBRES, APELLIDOS, FECHANACIMIENTO, TIPODOCUMENTOID, NUMERODOCUMENTO,
                DIRECCIONDOMICILIO, TELEFONO, CORREOELECTRONICO, LUGARDETRABAJO, DIRECCIONDETRABAJO,
                TELEFONOTRABAJO, INGRESOMENSUAL, REFERENCIAPERSONAL, TELEFONOREFERENCIAPERSONAL,
                IMAGENFIRMA, SOLICITUDESTADOID, PDFCONSENTIMIENTO, IMAGENDUIFRENTE,
                IMAGENDUIATRAS, IMAGENRECIBO)
            VALUES
                (DBO.FNSIGUIENTECORRELATIVOSOLICITUDESENLINEA(), GETDATE(),
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?)
        ";
        $datoResultado = $this->conn->insert($sentenciaSql,
                                            [
                                                $nombres, $apellidos, $fechaNacimiento, $tipoDocumentoId, $numeroDocumento,
                                                $direccionDomicilio, $telefono, $correoElectronico, $lugarDeTrabajo, $direccionTrabajo,
                                                $telefonoTrabajo, $ingresoMensual, $referenciaPersonal, $telefonReferenciaPersonal,
                                                $imagenFirma, $estadoInicial, $pdfConsentimiento, $imagenDuiFrente,
                                                $imagenDuiAtras, $imagenRecibo
                                            ],
                                            true);

        $agregado = !$this->conn->getExisteError();

        if ($agregado)
        {
            $this->solicitudEnLineaId = $datoResultado[0]["ID"];
        }
        else
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $agregado;
    }

    //-------------------------------------------

    /**
     * Eliminar un registro (SOLICITUDESENLINEA)
     * 
     * @param int $id ID del registro a ser eliminado
     * 
     * @return bool Estado final de eliminación: true: fue eliminado, false: no fue eliminado
     * 
     */
    public function eliminarRegistro(int $id): bool
    {
        $this->resetPropiedades();

        $sentenciaSql = "
            DELETE FROM SOLICITUDESENLINEA WHERE SOLICITUDENLINEAID = ?
        ";
        $eliminado = $this->conn->delete($sentenciaSql, [$id]);
        
        if (!$eliminado)
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $eliminado;
    }

    //-------------------------------------------
}