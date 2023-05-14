<?php

require_once("SQLSrvBD.php");

class SolicitudEnLineaCambio
{
    //-------------------------------------------

    private $conn;

    public $solicitudEnLineaCambioId;
    public $solicitudEstadoId;
    public $estado;
    public $observaciones;
    public $fechaHoraActualizacion;

    public $mensajeError;

    //-------------------------------------------

    /**
     * Instancia un objeto SolicitudEnLineaCambio
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
     * Obtener datos de un registro (SOLICITUDENLINEACAMBIOS) por medio de ID
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
                C.SOLICITUDENLINEACAMBIOID
                ,C.SOLICITUDESTADOID
                ,E.ESTADO
                ,C.OBSERVACIONES
                ,C.FECHAHORAACTUALIZACION
            FROM
                SOLICITUDENLINEACAMBIOS C
                JOIN SOLICITUDESTADOS E ON E.SOLICITUDESTADOID=C.SOLICITUDESTADOID
            WHERE
                C.SOLICITUDENLINEACAMBIOID = ?
        ";
        $datos = $this->conn->select($sentenciaSql, [$id]);

        $this->resetPropiedades();
        foreach ($datos as $dato)
        {
            $this->solicitudEnLineaCambioId = $dato["SOLICITUDENLINEACAMBIOID"];
            $this->solicitudEstadoId = $dato["SOLICITUDESTADOID"];
            $this->estado = $dato["ESTADO"];
            $this->observaciones = $dato["OBSERVACIONES"];
            $this->fechaHoraActualizacion = $dato["FECHAHORAACTUALIZACION"];
        }
    }

    //-------------------------------------------

    /**
     * Obtener todos los registros de la tabla (SOLICITUDENLINEACAMBIOS)
     * 
     * @param int $solicitudEnLineaId Solicitud a la que se están tomando todos sus cambios
     * 
     * @return array Todos los registros encontrados en la tabla
     * 
     */
    public function getAll(int $solicitudEnLineaId): array
    {
        $this->resetPropiedades();

        $sentenciaSql = "
        SELECT
            C.SOLICITUDENLINEACAMBIOID
            ,C.SOLICITUDESTADOID
            ,E.ESTADO
            ,C.OBSERVACIONES
            ,C.FECHAHORAACTUALIZACION
        FROM
            SOLICITUDENLINEACAMBIOS C
            JOIN SOLICITUDESTADOS E ON E.SOLICITUDESTADOID=C.SOLICITUDESTADOID
        WHERE
            C.SOLICITUDENLINEAID = ?
        ORDER BY
            C.FECHAHORAACTUALIZACION DESC
        ";
        $datos = $this->conn->select($sentenciaSql, [$solicitudEnLineaId]);

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
        $this->solicitudEnLineaCambioId = -1;
        $this->solicitudEstadoId = null;
        $this->estado = null;
        $this->observaciones = null;
        $this->fechaHoraActualizacion = null;
    }

    //-------------------------------------------

    /**
     * Agregar un nuevo registro (SOLICITUDENLINEACAMBIOS)
     * 
     * @param string $solicitudEnLineaId Solicitud a la que pertenece el cambio
     * @param string $solicitudEstadoId Estado al que se está cambiando la solicitud
     * @param string $observaciones Texto ingresado por usuario que realizó cambio de estado de solicitud
     * 
     * @return bool Resultado de guardar registro: true: fue guardado, false: no fue guardado
     * 
     */
    public function agregarRegistro(string $solicitudEnLineaId, string $solicitudEstadoId, string $observaciones): bool
    {
        $this->resetPropiedades();

        $sentenciaSql = "
            INSERT INTO SOLICITUDENLINEACAMBIOS
                (SOLICITUDENLINEAID, SOLICITUDESTADOID, OBSERVACIONES,
                FECHAHORAACTUALIZACION)
            VALUES
                (?, ?, ?,
                GETDATE())
        ";
        $datoResultado = $this->conn->insert($sentenciaSql,
                                            [
                                                $solicitudEnLineaId, $solicitudEstadoId, $observaciones
                                            ],
                                            true);

        $agregado = !$this->conn->getExisteError();

        if ($agregado)
        {
            $this->solicitudEnLineaCambioId = $datoResultado[0]["ID"];
        }
        else
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $agregado;
    }

    //-------------------------------------------
}