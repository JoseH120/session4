<?php if($this->session->flashdata('success')) : ?>
    <p class="success"><strong><?php echo $this->session->flashdata("success"); ?></strong></p>
<?php endif; ?>
<?php if($this->session->flashdata('error')) : ?>
    <p class="success"><strong><?php echo $this->session->flashdata("error"); ?></strong></p>
<?php endif; ?>

<div class="container-fluid mt-2">
    <div class="ml-md-4 mr-md-4">
        <div class="title">
            <div class="col-12">
                <h3><?php echo isset($grupo)?"Modificar":"Agregar";?></h3>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="ml-md-4 mr-md-4">
        <div class="row">
            <div class="offset-md-2 col-md-4 col-sm-12">
                <form action="<?=site_url("Grupos_controller");?>/<?= isset($grupo)?"update":"add";?>" class="form-ajax" method="POST">
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="PK_grupo" value="<?=isset($grupo) ? $grupo->idgrupo: "";?>">
                    </div>

                    <div class="form-group">
                        <label>Id Grupo</label>
                        <input class="form-control" type="text" name="idgrupo" value="<?=isset($grupo)?$grupo->idgrupo: "";?>" <?=isset($grupo)?"disabled":"";?>>
                    </div>

                    <div class="form-group">
                        <label>Num Grupo</label>
                        <input class="form-control" type="text" name="num_grupo" value="<?= isset($grupo)?$grupo->num_grupo : "";?>">
                    </div>

                    <div class="form-group">
                        <label>Año</label>
                        <input class="form-control" type="text" name="anio" value="<?=isset($grupo)?$grupo->anio: "";?>">
                    </div>

                    <div class="form-group">
                        <label for="">Ciclo</label>
                        <input type="text" class="form-control" name="ciclo" value="<?=isset($grupo)?$grupo->ciclo: "";?>">
                    </div>

                    <div class="form-group">
                        <label for="">Materia</label>
                        <select name="idmateria" class="form-control">
                        <?php foreach($materias as $item) : ?>
                            <option value="<?=$item->idmateria?>" <?=isset($grupo) && $item->idmateria == $grupo->idmateria ? "selected='selected'" : "";?>><?= $item->materia; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Profesor</label>
                        <select name="idprofesor" class="form-control">
                        <?php foreach($profesores as $item):?>
                            <option value="<?=$item->idprofesor?>" <?=isset($grupo) && $item->idprofesor == $grupo->idprofesor?"selected='selected'": "";?>><?=$item->nombre?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Guardar">
                        <a class="btn btn-success" href="<?=site_url("Grupos_controller")?>">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>