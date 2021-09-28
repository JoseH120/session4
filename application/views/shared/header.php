<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css">
</head>
<body>
<script src="<?php echo base_url();?>js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-3.5.1.slim.min.js"></script>
    <!-- <header>
    </header> -->
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
            </ul>
        </div>
    </nav>

