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
<html lang="en">
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
<body>




<div class="header sb-topnav navbar navbar-expand navbar-dark">
    <div class="w-100 m-0">
        <div class="text-left logo">
            <a href="<?php echo HOST."Inicio/"; ?>">
                <img src="<?php echo $objRestaurant->getLogo(); ?>">

                <label class="d-none d-sm-inline-block">
                    <?php echo $objRestaurant->getNombre(); ?>
                </label>
            </a>
        </div>

        <div class="p-2 opciones-contenedor">
            <div class="opciones">
                <button class="btn btn-sm order-1 order-lg-0">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main class="bg-light h-100 overflow-auto">

            <div class="m-2 p-2">
                <div class="row row-col-2 row-col-md-3 row-col-lg-4">
                    
                    <div class="col mb-3">
                        <div class="card mb-3" style="max-width: 540px;">
                            <img src="" class="card-img-top">
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>





</body>
</html>