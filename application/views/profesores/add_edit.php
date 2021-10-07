<?php if($this->session->flashdata('success')) : ?>
    <p class="success">
        <strong>
            <?php echo $this->session->flashdata('success'); ?>
        </strong>
    </p>
<?php endif; ?>
<?php if($this->session->flashdata('error')) : ?>
    <p class="error">
        <strong>
            <?php echo $this->session->flashdata('error'); ?>
        </strong>
    </p>
<?php endif; ?>

<div class="container-fluid mt-2">
    <div class="ml-md-4 mr-md-4">
        <div class="title">
            <div class="col-12">
                <h3><?php echo isset($profesor)?"Modificar":"Agregar";?></h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid ">
    <div class="ml-md-4 mr-md-4">
        <div class="row">
            <div class="offset-md-2 col-md-4 col-sm-12">
                <form action="<?=site_url("Profesores_controller")?>/<?=isset($profesor)?"update": "add";?>" class="form-ajax" method="POST">
                    <div class="form">
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="PK_profesor" value="<?=isset($profesor)?$profesor->idprofesor : "";?>"/>
                        </div>
                        <div class="form-group">
                            <label>Id Profesor: </label>
                            <input type="text" class="form-control" name="idprofesor" value="<?=isset($profesor) ? $profesor->idprofesor: ""; ?>" readonly/>
                        </div>
                        <div class="form-group">
                            <label>Nombre: </label>
                            <input type="text" class="form-control" name="nombre" value="<?=isset($profesor) ? $profesor->nombre: ""; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Apellido: </label>
                            <input type="text" class="form-control" name="apellido" value="<?=isset($profesor) ? $profesor->apellido: ""; ?>">
                        </div>
                        <div class="form-group">
                            <label>Fecha Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?=isset($profesor) ? $profesor->fecha_nacimiento: ""; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Profesion: </label>
                            <input type="text" class="form-control" name="profesion" value="<?=isset($profesor) ? $profesor->profesion: ""; ?>">
                        </div>

                        <div class="form-group">
                            <label>Genero:</label>
                            <label class="radio-inline"><input type="radio" name="sexo" value="H"
                                <?=isset($profesor) && $profesor->genero == "H" ? "checked" : "";?> />Hombre</label>
                            <label class="radio-inline"><input type="radio" name="sexo" value="M"
                                <?=isset($profesor) && $profesor->genero == "M" ? "checked" : "";?> />Mujer</label>
                        </div>

                        <div class="form-group">
                            <label>Email: </label>
                            <input type="text" class="form-control" name="email" value="<?=isset($profesor) ? $profesor->email: ""; ?>">
                        </div>
                        <br/>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" value="Guardar">
                            <a class='btn btn-success' href="<?=site_url('Profesores_controller');?>">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>