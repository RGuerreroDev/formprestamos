<?php

require_once("SQLSrvBD.php");

class Estado
{
    //-------------------------------------------

    private $conn;

    public $estadoId;
    public $estado;
    public $colorFuente;

    public $mensajeError;

    //-------------------------------------------

    /**
     * Instancia un objeto Estado
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
     * Obtener datos de un registro (SOLICITUDESTADOS) por medio de ID
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
                SOLICITUDESTADOID
               ,ESTADO
               ,COLORFUENTEHEX
            FROM
                SOLICITUDESTADOS
            WHERE
                SOLICITUDESTADOID = ?
        ";
        $datos = $this->conn->select($sentenciaSql, [$id]);

        $this->resetPropiedades();
        foreach ($datos as $dato)
        {
            $this->estadoId = $dato["SOLICITUDESTADOID"];
            $this->estado = $dato["DOCUMENTO"];
        }
    }

    //-------------------------------------------

    /**
     * Obtener todos los registros de la tabla (SOLICITUDESTADOS)
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
            SOLICITUDESTADOID
           ,ESTADO
           ,COLORFUENTEHEX
        FROM
            SOLICITUDESTADOS
        ORDER BY
            ORDEN ASC
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
        $this->estadoId = null;
        $this->estado = null;
    }

    //-------------------------------------------
}