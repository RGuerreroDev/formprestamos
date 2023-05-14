<?php

require_once("SQLSrvBD.php");

class TipoDocumento
{
    //-------------------------------------------

    private $conn;

    public $tipoDocumentoId;
    public $documento;

    public $mensajeError;

    //-------------------------------------------

    /**
     * Instancia un objeto TipoDocumento
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
     * Obtener datos de un registro (TIPOSDOCUMENTO) por medio de ID
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
                TIPODOCUMENTOID
               ,DOCUMENTO
            FROM
                TIPOSDOCUMENTO
            WHERE
                TIPODOCUMENTOID = ?
        ";
        $datos = $this->conn->select($sentenciaSql, [$id]);

        $this->resetPropiedades();
        foreach ($datos as $dato)
        {
            $this->tipoDocumentoId = $dato["TIPODOCUMENTOID"];
            $this->documento = $dato["DOCUMENTO"];
        }
    }

    //-------------------------------------------

    /**
     * Obtener todos los registros de la tabla (TIPOSDOCUMENTO)
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
            TIPODOCUMENTOID
           ,DOCUMENTO
        FROM
            TIPOSDOCUMENTO
        ORDER BY
            DOCUMENTO ASC
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
        $this->tipoDocumentoId = null;
        $this->documento = null;
    }

    //-------------------------------------------
    /**
     * Edita un registro (TIPOSDOCUMENTO) existente
     * 
     * @param int $id El id del registro a editar
     * @param string $nombreDocumento El nombre del tipo de documento que va a ser actualizado
     * 
     * @return bool Resultado de actualizar el registro: true: fue editado, false: no fue editado
     * 
     */
    public function editarRegistro(int $id, string $nombreDocumento): bool
    {
        $this->resetPropiedades();

        $sentenciaSql = "
            UPDATE TIPOSDOCUMENTO SET DOCUMENTO = ? WHERE TIPODOCUMENTOID = ?
        ";
        $editado = $this->conn->update($sentenciaSql, [$nombreDocumento, $id]);

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
     * Agregar un nuevo registro (TIPOSDOCUMENTO)
     * 
     * @param string $nombre El contenido del campo nombre del nuevo registro
     * 
     * @return bool Resultado de guardar registro: true: fue guardado, false: no fue guardado
     * 
     */
    public function agregarRegistro(string $id, string $nombreDocumento): bool
    {
        $this->resetPropiedades();

        $sentenciaSql = "
            INSERT INTO TIPOSDOCUMENTO
                (TIPODOCUMENTOID, DOCUMENTO)
            VALUES
                (?, ?)
        ";
        $datoResultado = $this->conn->insert($sentenciaSql,
                                            [
                                                $id, $nombreDocumento
                                            ],
                                            true);

        $agregado = !$this->conn->getExisteError();

        if ($agregado)
        {
            $this->tipoDocumentoId = $datoResultado[0]["ID"];
        }
        else
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $agregado;
    }

    //-------------------------------------------

    /**
     * Eliminar un registro (TIPOSDOCUMENTO)
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
            DELETE FROM TIPOSDOCUMENTO WHERE DOCUMENTOID = ?
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