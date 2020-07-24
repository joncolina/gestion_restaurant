<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Monitoreo
 */
class Monitoreo implements MessageComponentInterface
{
    /**
     * Atributos
     */
    protected $clients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "Servidor iniciado\n";
    }

    /**
     * Inicio de conexión
     */
    public function onOpen(ConnectionInterface $conn)
    {
        /**
         * Defecto
         * echo "New connection! ({$conn->resourceId})\n";
         */
        $this->clients->attach($conn);

        /**
         * Abrimos conexión con la base de datos
         */
        Conexion::Iniciar();

        /**
         * Analizamos el PATH de la conexión
         */
        try { Peticion::Iniciar($conn); } catch(Exception $e) {
            echo "{$e->getMessage()}\n";
            $body = ["accion" => "error", "contenido" => $e->getMessage()];
            $conn->send( json_encode($body) );
            $conn->close();
            return;
        }

        /**
         * Tomamos las variables del path
         */
        $area = Peticion::getArea();
        $archivo = Peticion::getArchivo();
        $objUsuario = Peticion::getUsuario();
        $objRestaurant = Peticion::getRestaurant();

        /**
         * Notificamos la conexión
         */
        echo "Nueva conexión: [{$area}][{$archivo}][{$objRestaurant->getNombre()}] {$objUsuario->getNombre()}\n";

        /**
         * 
         */
        $conn->area = $area;
        $conn->archivo = $archivo;
        $conn->objRestaurant = $objRestaurant;
        $conn->objUsuario = $objUsuario;

        /**
         * Cerramos la conexión con la base de datos
         */
        Conexion::getMysql()->Cerrar();
    }

    /**
     * Mensaje recibido
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        Conexion::Iniciar();
        Conexion::IniciarSQLite(Peticion::getRestaurant()->getRutaDB());
        
        Peticion::Iniciar($from);
        $area = Peticion::getArea();
        $archivo = Peticion::getArchivo();

        $objJson = json_decode($msg);

        if( isset($objJson->accion) )
        {
            /**
             * 
             */
            if($area == AREA_GERENCIAL && $archivo == "monitoreo-cocina")
            {
                if(method_exists("GestionMonitoreoCocina", $objJson->accion))
                {
                    $metodo = $objJson->accion;
                    GestionMonitoreoCocina::$metodo($this->clients, $from, $objJson);
                }
                else
                {
                    $from->send(json_encode(["accion" => "error", "contenido" => "Acción no valida para el archivo actual."]));
                }
            }
            /**
             * 
             */
            elseif($area == AREA_GERENCIAL && $archivo == "monitoreo-camarero")
            {
                $from->send(json_encode(["accion" => "console", "contenido" => "En desarrollo..."]));
            }
            /**
             * 
             */
            elseif($area == AREA_GERENCIAL && $archivo == "monitoreo-caja")
            {
                $from->send(json_encode(["accion" => "console", "contenido" => "En desarrollo..."]));
            }
            /**
             * 
             */
            elseif($area == AREA_GERENCIAL && $archivo == "mesas-servicio")
            {
                if(method_exists("GestionServicio", $objJson->accion))
                {
                    $metodo = $objJson->accion;
                    GestionServicio::$metodo($this->clients, $from, $objJson);
                }
                else
                {
                    $from->send(json_encode(["accion" => "error", "contenido" => "Acción no valida para el archivo actual."]));
                }
            }
            /**
             * 
             */
            elseif($area == "PUBLIC")
            {
                if(method_exists("GestionAccionesCliente", $objJson->accion))
                {
                    $metodo = $objJson->accion;
                    GestionAccionesCliente::$metodo($this->clients, $from, $objJson);
                }
                else
                {
                    $from->send(json_encode(["accion" => "error", "contenido" => "Acción no valida para el archivo actual."]));
                }
            }
            /**
             * 
             */
            else
            {
                $from->send(json_encode(["accion" => "error", "contenido" => "Caso no previsto."]));
            }
        }
        else
        {
            $from->send(json_encode(["accion" => "error", "contenido" => "No se envio la acción."]));
        }

        Conexion::getSqlite()->Cerrar();
        Conexion::getMysql()->Cerrar();
    }

    /**
     * Conexión cerrada
     */
    public function onClose(ConnectionInterface $conn)
    {
        /**
         * Defecto
         * The connection is closed, remove it, as we can no longer send it messages
         * echo "Connection {$conn->resourceId} has disconnected\n";
         */
        $this->clients->detach($conn);

        /**
         * Abrimos conexión con la base de datos
         */
        Conexion::Iniciar();

        /**
         * Analizamos el PATH de la conexión
         */
        try { Peticion::Iniciar($conn); } catch(Exception $e) {
            Conexion::getMysql()->Cerrar();
            return;
        }

        /**
         * Tomamos las variables del path
         */
        $area = Peticion::getArea();
        $archivo = Peticion::getArchivo();
        $objUsuario = Peticion::getUsuario();
        $objRestaurant = Peticion::getRestaurant();
        
        /**
         * Notificamos la conexión cerrada
         */
        echo "Desconexión: [{$area}][{$archivo}][{$objRestaurant->getNombre()}] {$objUsuario->getNombre()}\n";
        
        /**
         * Cerramos la conexión con la base de datos
         */
        Conexion::getMysql()->Cerrar();
    }

    /**
     * Error
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        /**
         * Notificamos y cerramos
         */
        echo "Ocurrio un error en el sistema: {$e->getMessage()}.\n";
        $conn->close();
    }
}