<!DOCTYPE html>
<html lang="en">
<head>
    <title>RES-APP</title>
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

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            Area publica
        </div>

        <div class="card-body">

            <div class="alert alert-info">
                Sección en desarrollo, falta diseño.
                <hr>
                <a class="btn btn-info w-100px" href="<?php echo HOST_ADMIN."Login/"; ?>">
                    Admin
                </a>

                <a class="btn btn-info w-100px" href="<?php echo HOST_GERENCIAL."Login/"; ?>">
                    Gerencia
                </a>
            </div>

            <div class="alert alert-info mb-0">
                Core.js

                <hr>

                <h5>Alertas</h5>
                Alerta.Primary(mensaje);<br>
                Alerta.Secondary(mensaje);<br>
                Alerta.Success(mensaje);<br>
                Alerta.Danger(mensaje);<br>
                Alerta.Warning(mensaje);<br>
                Alerta.Dark(mensaje);<br>
                Alerta.Info(mensaje);<br>
                Alerta.Light(mensaje);<br>

                <hr>
                
                <h5>Formato</h5>
                Formato.Numerico(numero: number, decimales: number = 0);<br>
                Formato.bool2text(valor: boolean);<br>

                <hr>

                <h5>Loader</h5>
                Loader.Mostrar();<br>
                Loader.Ocultar();<br>

                <hr>

                <h5>Analizar Formulario</h5>
                AnalizarForm(idFormulario: string);<br>
            </div>

        </div>
    </div>
</div>
    
</body>
</html>