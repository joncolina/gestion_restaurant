<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Template del PUBLIC
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Template
{
    /*============================================================================
	 *
	 * Iniciar
	 *
	============================================================================*/
    public static function Iniciar( $title = SISTEMA_NOMBRE )
    {
        ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <title><?php echo $title; ?></title>
                <link rel="shortcut icon" href="<?php echo HOST."recursos/core/img/logotipo.png"; ?>" type="image/png">

                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
                <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.js"; ?>"></script>
                <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>
                
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
            <body>
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
            </body>
            </html>
        <?php
    }
}