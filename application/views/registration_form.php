<html>
<?php
    //VALIDAMOS SI EL USUARIO ESTA LOGEADO
    // SI ESTA LOGUEADO ENTONCES LE REDIRECCIONAMOS A LA PANTALLA PRINCIPAL
    // EN NUESTRO CASO ES LA PANTALLA ESTUDIANTES
    if(isset($this->session->userdata['logged_in'])){
        redirect("/estudiantes");
    }
?>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>css/login.css">
</head>
<body>
    <div class="main">
        <div id="login">
            <h2>Registro</h2>
            <hr>
            <div class="error_msg">
                <?=validation_errors()?>
            </div>
            <form action="<?=site_url('user_authentication/new_user_registration')?>" method="post">
                <div class="error_msg">
                    <?php if(isset($message_display)):?>
                        <?=$message_display;?>
                    <?php endif; ?>
                </div>
                <label>Usuario:</label>
                <input type="text" name="username"/>
                <br>
                <br>
                <label>Email:</label>
                <input type="email" name="email_value"/>
                <br>
                <br>
                <label>Contraseña</label>
                <input type="password" name="password">
                <br>
                <br>
                <input type="submit" value="Registrarse">
            </form>
            <a href="<?php echo base_url()?>">Iniciar sesion</a>
        </div>
    </div>
</body>
</html>