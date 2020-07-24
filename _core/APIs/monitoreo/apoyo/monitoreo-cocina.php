<?php

/**
 * 
 */
class GestionMonitoreoCocina
{
    /**
     * 
     */
    public static function ActualizarTodo($clientes, $conn, $objJson)
    {
        if(isset($conn->idAreaMonitoreo) == FALSE) {
            $conn->idAreaMonitoreo = "1";
        }

        $objRestaurant = Peticion::getRestaurant();
        $idRestaurant = $objRestaurant->getId();
        $status = 1;
        $idAreaMonitoreo = $conn->idAreaMonitoreo;

        $condicional = "A.idRestaurant = '{$idRestaurant}'";
        if($condicional != "") $condicional .= " AND ";
        $condicional .= "B.status = '{$status}'";

        if($idAreaMonitoreo != 4) {
            if($condicional != "") $condicional .= " AND ";
            $condicional .= "idAreaMonitoreo = '{$idAreaMonitoreo}'";
        }

        $query = "SELECT *
        FROM pedidos A, pedidos_detalles B
        WHERE A.idPedido = B.idPedido AND ({$condicional})";
        $datos = Conexion::getSqlite()->Consultar($query);

        $data = [];
        foreach($datos as $fila)
        {
            $idPedido = $fila['idPedido'];
            $idPedidoDetalle = $fila['idPedidoDetalle'];
            $cantidad = (int) Formato::Numero( $fila['cantidad'] );
            $observaciones = $fila['nota'];
            $arrayAux = explode(" ", $fila['fecha_modificacion']);
            $fecha = Formato::FechaCorta($arrayAux[0]);
            $hora = $arrayAux[1];

            $objPlato = new PlatoModel($fila['idPlato']);
            $plato = [
                "id" => $objPlato->getId(),
                "nombre" => $objPlato->getNombre()
            ];

            $objCategoria = new CategoriaModel($objPlato->getIdCategoria());
            $categoria = [
                "id" => $objCategoria->getId(),
                "nombre" => $objCategoria->getNombre()
            ];

            if($fila['idCombo'] == "0") {
                $combo = ["id" => null, "nombre" => null];
            } else {
                $objCombo = new ComboModel($fila['idCombo']);
                $combo = [
                    "id" => $objCombo->getId(),
                    "nombre" => $objCombo->getNombre()
                ];
            }

            array_push($data, [
                "idPedido" => $idPedido,
                "idPedidoDetalle" => $idPedidoDetalle,
                "plato" => $plato,
                "combo" => $combo,
                "categoria" => $categoria,
                "cantidad" => $cantidad,
                "observaciones" => $observaciones,
                "fecha" => $fecha,
                "hora" => $hora
            ]);
        }

        $conn->send( json_encode([
            "accion" => "function",
            "contenido" => "MostrarPedidos",
            "parametro" => [
                "datos" => $data,
                "total" => sizeof($data)
            ]
        ]) );
    }

    /**
     * 
     */
    public static function CambiarFiltro($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idAreaMonitoreo)) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se envio el ID del area del monitoreo."]) );
            return;
        }

        $conn->idAreaMonitoreo = $objJson->idAreaMonitoreo;
        self::ActualizarTodo($clientes, $conn, $objJson);
    }

    /**
     * 
     */
    public static function CambiarStatus($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedidoDetalle)) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se envio el ID del detalle pedido."]) );
            return;
        }
        
        try { $objPedidoDetalle = new PedidoDetallesClienteModel($objJson->idPedidoDetalle); } catch(Exception $e) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "El ID del detalle pedido es invalido."]) );
            return;
        }
        
        $objPedido = new PedidoClienteModel( $objPedidoDetalle->getIdPedido() );

        if($objPedido->getIdRestaurant() != $conn->objRestaurant->getId()) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se puede modificar los datos de otros restaurantes."]) );
            return;
        }

        if($objPedidoDetalle->getStatus() != "1") {
            $conn->send( json_encode(["accion" => "error", "contenido" => "El detalle del pedido debe ser igual a 'CONFIRMADO' para realizar este proceso."]) );
            return;
        }

        $objPedidoDetalle->setStatus("2");
        Conexion::getSqlite()->Commit();

        self::QuitarPedido($clientes, $conn, $objJson);
    }
    
    /**
     * 
     */
    public static function AgregarPedido($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedido)) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se envio el ID del pedido."]) );
            return;
        }

        try { $objPedido = new PedidoClienteModel($objJson->idPedido); } catch(Exception $e)
        {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se encontro el pedido {$objJson->idPedido}."]) );
            return;
        }

        $detalles = $objPedido->getDetalles();

        $detallesGeneral = [];
        $detallesCocina = [];
        $detallesBar = [];
        $detallesPostres = [];

        foreach($detalles as $detalle)
        {
            $objPlato = new PlatoModel($detalle['idPlato']);
            $plato = ["id" => $objPlato->getId(), "nombre" => $objPlato->getNombre()];

            $objCategoria = new PlatoModel($objPlato->getIdCategoria());
            $categoria = ["id" => $objCategoria->getId(), "nombre" => $objCategoria->getNombre()];

            if($detalle['idCombo'] == 0) {
                $combo = ["id" => NULL, "nombre" => NULL];
            } else {
                $objCombo = new ComboModel($detalle['idCombo']);
                $combo = ["id" => $objCombo->getId(), "nombre" => $objCombo->getNombre()];
            }

            $cantidad = (int) Formato::Numero($detalle['cantidad']);
            $observaciones = $detalle['nota'];
            $arrayFecha = explode(" ", $detalle['fecha_modificacion']);
            $fecha = $arrayFecha[0];
            $hora = $arrayFecha[1];

            $detalleActual = [
                "idPedido" => $detalle['idPedido'],
                "idPedidoDetalle" => $detalle['idPedidoDetalle'],
                "plato" => $plato,
                "combo" => $combo,
                "categoria" => $categoria,
                "cantidad" => $cantidad,
                "observaciones" => $observaciones,
                "fecha" => $fecha,
                "hora" => $hora
            ];

            array_push($detallesGeneral, $detalleActual);
            if($detalle['idAreaMonitoreo'] == 1) array_push($detallesCocina, $detalleActual);
            if($detalle['idAreaMonitoreo'] == 2) array_push($detallesBar, $detalleActual);
            if($detalle['idAreaMonitoreo'] == 3) array_push($detallesPostres, $detalleActual);
        }

        foreach($clientes as $cliente)
        {
            Peticion::Iniciar($cliente);
            if($cliente->area != AREA_GERENCIAL) continue;
            if($cliente->archivo != "monitoreo-cocina") continue;
            if($objPedido->getIdRestaurant() != $cliente->objRestaurant->getId()) continue;

            if(!isset($cliente->idAreaMonitoreo)) $cliente->idAreaMonitoreo = "1";

            if($cliente->idAreaMonitoreo == "1") $cliente->send(json_encode(["accion" => "function", "contenido" => "NuevosPlatos", "parametro" => $detallesCocina]));
            if($cliente->idAreaMonitoreo == "2") $cliente->send(json_encode(["accion" => "function", "contenido" => "NuevosPlatos", "parametro" => $detallesBar]));
            if($cliente->idAreaMonitoreo == "3") $cliente->send(json_encode(["accion" => "function", "contenido" => "NuevosPlatos", "parametro" => $detallesPostres]));
            if($cliente->idAreaMonitoreo == "4") $cliente->send(json_encode(["accion" => "function", "contenido" => "NuevosPlatos", "parametro" => $detallesGeneral]));
        }
    }
    
    /**
     * 
     */
    public static function QuitarPedido($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedidoDetalle)) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se envio el ID del detalle pedido."]) );
            return;
        }
        
        try { $objPedidoDetalle = new PedidoDetallesClienteModel($objJson->idPedidoDetalle); } catch(Exception $e) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "El ID del detalle pedido es invalido."]) );
            return;
        }
        
        $objPedido = new PedidoClienteModel( $objPedidoDetalle->getIdPedido() );

        if($objPedido->getIdRestaurant() != $conn->objRestaurant->getId()) {
            $conn->send( json_encode(["accion" => "error", "contenido" => "No se puede modificar los datos de otros restaurantes."]) );
            return;
        }

        foreach($clientes as $cliente)
        {
            Peticion::Iniciar($cliente);

            if($cliente->area != AREA_GERENCIAL) continue;
            if($cliente->archivo != "monitoreo-cocina") continue;
            if($objPedido->getIdRestaurant() != $cliente->objRestaurant->getId()) continue;

            $cliente->send(
                json_encode(
                    ["accion" => "function", "contenido" => "QuitarPedido", "parametro" => $objPedidoDetalle->getId()]
                )
            );
        }
    }
}