<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Incluimos los archivos necesarios
 *
 *--------------------------------------------------------------------------------
================================================================================*/
IncluirCarpeta(BASE_DIR."_core/utils");
IncluirCarpeta(BASE_DIR."_core/modelos");
require_once(BASE_DIR."_core/APIs/database/mysql.php");

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Iniciamos clases escenciales
 *
 *--------------------------------------------------------------------------------
================================================================================*/
Conexion::Iniciar();

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Test
 *
 *--------------------------------------------------------------------------------
================================================================================*/
$objRestaurant = new RestaurantModel(1);
?>





<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo $objRestaurant->getNombre(); ?></title>
    <link rel="shortcut icon" href="<?php echo $objRestaurant->getLogo(); ?>" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
    <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
    <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.js"; ?>"></script>
    <link rel="stylesheet" href="<?php echo HOST."recursos/font-awesome/css/all.css"; ?>">
    <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>

    <link rel="stylesheet" href="<?php echo HOST."recursos/core/css/core.css"; ?>">
    <script src="<?php echo HOST."recursos/core/js/core.js"; ?>"></script>

    <link rel="stylesheet" href="<?php echo HOST."recursos/public/css/panel.css"; ?>">
    <script src="<?php echo HOST."recursos/public/js/panel.js"; ?>"></script>

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
    <div class="w-100 m-0">
        <div class="text-left logo">
            <a href="<?php echo HOST; ?>">
                <img src="<?php echo $objRestaurant->getLogo(); ?>">

                <label class="d-none d-sm-inline-block">
                    <?php echo $objRestaurant->getNombre(); ?>
                </label>
            </a>
        </div>

        <div class="text-right p-2 opciones-contenedor">
            <div class="opciones">
                <button class="btn btn-sm order-1 order-lg-0" onclick="MenuLateral()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="layoutSidenav">
    <!-- MENU LATERAL -->
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion menu-lateral" id="sidenavAccordion">
            <div class="sb-sidenav-menu">

                <div class="panel-usuario">
                    <div>
                        MESA 5
                    </div>

                    <div>
                        1234-7895
                    </div>
                </div>

                <div class="nav">
                    <a class="nav-link border-bottom" active href="#">                                    
                        General
                    </a>

                    <?php
                        $categorias = CategoriasModel::Listado( $objRestaurant->getId() );
                        $cantidad = sizeof( $categorias );
                        for($I=0; $I<$cantidad; $I++)
                        {
                            $objCategoria = new CategoriaModel( $categorias[$I]['idCategoria'] );
                            $active = "";
                            $link = "";

                            ?>
                                <a class="nav-link border-bottom" <?php echo $active; ?> href="<?php echo $link; ?>">                                    
                                    <?php echo $objCategoria->getNombre(); ?>
                                </a>
                            <?php
                        }
                    ?>
                </div>

            </div>
        </nav>
    </div>
    <!-- FIN MENU LATERAL -->

    <div id="layoutSidenav_content">
        <main class="bg-light h-100 overflow-auto">

            <div class="m-2 p-2">
                <div class="w-100 px-0 mb-3">
                    <div class="card">
                        <div class="card-body p-3 bg-white text-dark rounded">
                            <h5 class="mb-0">Menú: General</h5>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2">

                    <?php
                        $platos = PlatosModel::ListadoCliente( $objRestaurant->getId() );
                        foreach($platos as $plato)
                        {
                            $objPlato = new PlatoModel( $plato['idPlato'] );
                            $objCategoria = new CategoriaModel( $objPlato->getIdCategoria() );

                            ?>
                                <div class="mb-4 d-flex justify-content-center px-2">
                                    <div class="card card-especial" tabindex="0">
                                        <img src="<?php echo $objPlato->getImagen(); ?>" class="card-img-top border-bottom">

                                        <div class="card-body">
                                            <p class="card-text mb-1">
                                                <?php echo $objPlato->getNombre(); ?>
                                            </p>

                                            <h5 class="card-title mb-0">
                                                BsS. <?php echo Formato::Numero( $objPlato->getPrecioVenta() ); ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>

                </div>
            </div>

        </main>
    </div>
</div>




</body>
</html>