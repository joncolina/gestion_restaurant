<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Template MODELO CLIENTE
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Template
{
	/*============================================================================
	 *
	 *	Iniciar
	 *
	============================================================================*/
    public static function Iniciar()
    {
        ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <title><?php echo SISTEMA_NOMBRE; ?></title>
                <link rel="shortcut icon" href="<?php echo HOST."recursos/core/img/logotipo.png"; ?>" type="image/png">

                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
                <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/font-awesome/css/all.css"; ?>">
                <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>

                <link rel="stylesheet" href="<?php echo HOST."recursos/public/css/template.css"; ?>">
                <script defer src="<?php echo HOST."recursos/public/js/template.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/core/css/core.css"; ?>">
                <script src="<?php echo HOST."recursos/core/js/core.js"; ?>"></script>

                <script>
                    <?php
                        echo 'const HOST = "'.HOST.'";';
                        echo 'const HOST_AJAX = "'.HOST_AJAX.'";';
                        echo 'const HOST_ADMIN = "'.HOST_ADMIN.'";';
                        echo 'const HOST_ADMIN_AJAX = "'.HOST_ADMIN_AJAX.'";';
                        echo 'const HOST_GERENCIAL = "'.HOST_GERENCIAL.'";';
                        echo 'const HOST_GERENCIAL_AJAX = "'.HOST_GERENCIAL_AJAX.'";';
                        
                        if(AUDITORIA) echo 'const AUDITORIA = true;';
                        else echo 'const AUDITORIA = false;';
                    ?>
                </script>
            </head>

            <body class="sb-nav-fixed">

                <div class="header sb-topnav navbar navbar-expand navbar-dark">
                    <?php require_once("encabezado.php"); ?>
                </div>

                <div id="layoutSidenav">
                    <?php require_once("menu_lateral.php"); ?>

                    <div id="layoutSidenav_content">
                        <main class="bg-light h-100 overflow-auto">
        <?php
    }

	/*============================================================================
	 *
	 *	Finalizar
	 *
	============================================================================*/
    public static function Finalizar()
    {
        ?>
                        </main>
                    </div>
                </div>

                <div class="modal fade" id="modal-cerrarSesion">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="mb-0">
                                    Cerrar Sesión
                                </h5>

                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <form id="form-cerrarSesion" onsubmit="event.preventDefault()">
                                    ¿Esta seguro que desea cerrar sesión?<br>
                                    <br>
                                    Para continuar introduzca la contraseña de la mesa
                                    <b><?php echo Sesion::getUsuario()->getAlias(); ?></b><br>

                                    <input type="password" class="form-control" required name="clave" placeholder="Contraseña...">
                                </form>
                            </div>

                            <div class="modal-footer bg-light">
                                <button class="btn btn-outline-secondary" data-dismiss="modal">
                                    Cancelar
                                </button>

                                <button class="btn btn-primary" id="boton-cerrarSesion">
                                    Confirmar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="consultar-pedidos-mesa">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="mb-0">Pedidos de la mesa</h5>
                            </div>

                            <div class="modal-body">
                                
                            </div>

                            <div class="modal-footer bg-light">
                                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </body>
            </html>
        <?php
    }
}