<?php 
    $usuario = ($this->session->userdata['logged_in']['username']);
    $email = ($this->session->userdata['logged_in']['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <script src="<?php echo base_url();?>js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css">
     <!-- SCRIPT NECESARIO PARA USAR AJAX EN LOS FORMULARIOS -->
    <script src="<?php echo base_url();?>js/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css">

</head>
<body>
    <script src="<?php echo base_url();?>js/bootstrap.bundle.min.js"></script>
    <div id="info_user" style="text-align: right">
        <p><strong>Usuario: </strong><?=$usuario?>(<?=$email?>) | <a href="<?=site_url('user_authentication/logout')?>">Cerrar sesion</a> </p>
    </div>
    <?php /*
    <header>
        <nav>
            <ul>
                <li><a href="<?=site_url('Estudiantes_controller')?>">Estudiantes</a></li>
                <li><a href="<?=site_url('Carreras_controller')?>">Estudiantes</a></li>
                <li><a href="<?=site_url('Materias_controller')?>">Estudiantes</a></li>
                <li><a href="<?=site_url('Profesores_controller')?>">Estudiantes</a></li>
                <li><a href="<?=site_url('Grupos_controller')?>">Estudiantes</a></li>
            </ul>
        </nav>
    </header>
    */?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">USO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" arial-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"> 
                    <a class="nav-link" href="<?=site_url('Estudiantes_controller')?>">Estudiantes</a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" href="<?=site_url('Carreras_controller')?>">Carreras</a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" href="<?=site_url('Materias_controller')?>">Materias</a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" href="<?=site_url('Profesores_controller')?>">Profesores</a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" href="<?=site_url('Grupos_controller')?>">Grupos</a>
                </li>
            </ul>
        </div>
    </nav>

