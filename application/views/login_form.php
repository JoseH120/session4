<html>
<?php
    if(isset($this->session->userdata['logged_in'])){
        redirect("/estudiantes_controller");
    }
?>
<head>
    <title>Inicio de sesion</title>
    <!-- https://stackoverflow.com/questions/4320820/fatal-error-call-to-undefined-function-site-url -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/login.css">
</head>
<body>
    <?php if($this->session->flashdata('message_logout')):?>
        <div class="message">
            <?=$this->session->flashdata('message_logout'); ?>
        </div>
        <br/>
    <?php endif; ?>
    <div id="main">
        <div id="login">
            <h2>Inicio de sesion</h2>
            <hr>
            <form action="<?=site_url('user_authentication/user_login_process')?>" method="post">
                <?php if($this->session->flashdata('message_display')): ?>
                    <div style="text-align: center; color:darkgreen;">
                        <?=$this->session->flashdata('message_display');?>
                    </div>
                <?php endif; ?>

                <div class='error_msg'>
                    <?php if($this->session->flashdata('message_error')):?>
                        <div><?=$this->session->flashdata('message_error')?></div>
                        <br>
                    <?php endif; ?>
                    <?=validation_errors()?>
                </div>
                <label>Usuario: </label>
                <input type="text" name="username" id="name" placeholder="username"/><br><br>
                <label>Contraseña: </label>
                <input type="password" name="password" id="password" placeholder="********"><br><br>
                <input type="submit" value="Iniciar sesion" name="submit"/><br>
                <a href="<?=site_url('/User_Authentication/user_registration_show')?>">Registrarse</a>
            </form>
        </div>
    </div>
</body>
</html>
