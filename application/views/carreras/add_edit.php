<?php if($this->session->flashdata('success')) : ?>
    <p class="success"><strong><?php echo $this->session->flashdata('success');?></strong></p>
<?php endif; ?>
<?php if($this->session->flashdata('error')) : ?>
    <p class="error"><strong><?php echo $this->session->flashdata('error');?></strong></p>
<?php endif; ?>

<div class="container-fluid mt-2">
    <div class="ml-md-4 mr-md-4">
        <div class="title">
            <div class="col-12">
                <h3><?php echo isset($carrera) ? "Modificar" : "Agregar"; ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="ml-md-4 mr-md-4">
        <div class="row">
            <div class="offset-md-2 col-md-4 col-sm-12">
                <form action="<?=site_url("Carreras_controller");?>/<?=isset($carrera)? "update" : 'add'; ?>" method="POST">
                    <div class="form">
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="PK_carrera" value="<?=isset($carrera) ? $carrera->idcarrera : ""; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Id carrera:</label>
                            <input class="form-control" type="text" name="idcarrera" value="<?=isset($carrera) ? $carrera->idcarrera : "" ;?>" />
                        </div>
                        
                        <div class="form-group">
                            <label>Carrera :</label>
                            <input class="form-control" type="text" name="carrera" value="<?=isset($carrera) ? $carrera->carrera : "" ;?>" />
                        </div>
                        <?php /*
                        <div class="form-group">
                            <label>Apellido :</label>
                            <input class="form-control" type="text" name="apellido" value="<?=isset($estudiante) ? $estudiante->apellido : "" ;?>" />
                        </div>
                        
                        <div class="form-group">
                            <label>Email :</label>
                            <input class="form-control" type="text" name="email" value="<?=isset($estudiante) ? $estudiante->email : "" ;?>" />
                        </div>
                        
                        <div class="form-group">
                            <label>Usuario :</label>
                            <input class="form-control" type="text" name="usuario" value="<?=isset($estudiante) ? $estudiante->usuario : "" ;?>" />
                        </div>
                        
                        <div class="form-group">
                            <label>Carrera :</label>
                            <select class="form-control" name="idcarrera">
                                <?php foreach($carreras as $item) :?>
                                    <option value="<?=$item->idcarrera?>" <?=isset($estudiante) && $item->idcarrera == $estudiante->idcarrera ? "selected='selected'" : "" ; ?>>
                                    <?=$item->carrera?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        */?>
                        <br/>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" value="Guardar">
                            <a class='btn btn-success' href="<?= site_url('Carreras_controller');?>">Volver</a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>