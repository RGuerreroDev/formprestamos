<?php

require_once("SQLSrvBD.php");

class Usuario
{
    //-------------------------------------------

    private $conn;

    public $usuarioId;
    public $nombreCompleto;
    public $usuario;
    public $activo;
    public $fechaCreacion;

    public $mensajeError;

    //-------------------------------------------

    /**
     * Instancia un objeto Usuario
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
     * Obtener datos de un registro (USUARIOS) por medio de ID
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
                USUARIOID
               ,NOMBRECOMPLETO
               ,USUARIO
               ,ACTIVO
               ,FECHACREACION
            FROM
                USUARIOS
            WHERE
                USUARIOID = ?
        ";
        $datos = $this->conn->select($sentenciaSql, [$id]);

        $this->resetPropiedades();
        foreach ($datos as $dato)
        {
            $this->usuarioId = $dato["USUARIOID"];
            $this->nombreCompleto = $dato["NOMBRECOMPLETO"];
            $this->usuario = $dato["USUARIO"];
            $this->activo = $dato["ACTIVO"];
            $this->fechaCreacion = $dato["FECHACREACION"];
        }
    }

    //-------------------------------------------

    /**
     * Obtener todos los registros de la tabla (USUARIOS)
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
            USUARIOID
           ,NOMBRECOMPLETO
           ,USUARIO
           ,ACTIVO
        FROM
            USUARIOS
        ORDER BY
            USUARIO ASC
        ";
        $datos = $this->conn->select($sentenciaSql, []);

        return $datos;
    }

    //-------------------------------------------

    /**
     * Obtener registros de la tabla (USUARIOS) con filtros
     * 
     * @param void
     * 
     * @return array Todos los registros encontrados en la tabla
     * 
     * Ejemplo de uso de filtro:
     * - $filtro = "CAMPO=0 AND CAMPO='ALGO'"
     * 
     */
    public function getWithFilters(string $filtro): array
    {
        $this->resetPropiedades();

        $sentenciaSql = "
        SELECT
            USUARIOID
           ,NOMBRECOMPLETO
           ,USUARIO
           ,ACTIVO
        FROM
            USUARIOS
        WHERE
            $filtro
        ORDER BY
            USUARIO ASC 
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
        $this->usuarioId = -1;
        $this->nombreCompleto = null;
        $this->usuario = null;
        $this->activo = null;
        $this->fechaCreacion = null;
    }

    //-------------------------------------------

    /**
     * Edita un registro (USUARIOS) existente
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
            UPDATE USUARIOS SET " . $updates . " WHERE USUARIOID = ?
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
     * Agregar un nuevo registro (USUARIOS)
     * 
     * @param string $nombreCompleto Nombre real del usuario
     * @param string $usuario Login o Alias
     * @param string $contrasena Contraseña de usuario
     * 
     * @return bool Resultado de guardar registro: true: fue guardado, false: no fue guardado
     * 
     */
    public function agregarRegistro(string $nombreCompleto, string $usuario, string $contrasena): bool
    {
        $this->resetPropiedades();

        $sentenciaSql = "
            INSERT INTO USUARIOS
                (NOMBRECOMPLETO, USUARIO, CONTRASENA, ACTIVO)
            VALUES
                (?, ?, ?, ?)
        ";
        $datoResultado = $this->conn->insert($sentenciaSql,
                                            [
                                                $nombreCompleto, $usuario, password_hash($contrasena, PASSWORD_DEFAULT), 1
                                            ],
                                            true);

        $agregado = !$this->conn->getExisteError();

        if ($agregado)
        {
            $this->usuarioId = $datoResultado[0]["ID"];
        }
        else
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $agregado;
    }

    //-------------------------------------------

    /**
     * Eliminar un registro (USUARIOS)
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
            DELETE FROM USUARIOS WHERE USUARIOID = ?
        ";
        $eliminado = $this->conn->delete($sentenciaSql, [$id]);
        
        if (!$eliminado)
        {
            $this->mensajeError = $this->conn->getMensajeError();
        }

        return $eliminado;
    }

    //-------------------------------------------

    // Para realizar inicio de sesión
    public function login($usuario, $contrasena)
    {
        $resultado = $this->conn->select(
            "SELECT * FROM USUARIOS WHERE USUARIO = ?",
            [$usuario, $contrasena]
        );

        if(count($resultado) && password_verify($contrasena, $resultado[0]["CONTRASENA"]))
        {
            $_SESSION["sesion"] = true;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["usuarioId"] = $resultado[0]["USUARIOID"];
            
            return true;
        }

        return false;
    }

    //-------------------------------------------
}