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
                <h3><?php echo isset($materia) ? "Modificaar" : "Agregar";?></h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="ml-md-4 mr-md-4">
        <div class="row">
            <div class="offset-md-2 col-md-4 col-sm-12">
                <form action="<?=site_url("Materias_controller");?>/<?= isset($materia)?"update" : "add"; ?>" method="POST" class="form-ajax">
                    <div class="form">
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="PK_materia"
                            value="<?= isset($materia) ? $materia->idmateria : "";?>" />
                        </div>

                        <div class="form-group">
                            <label>Id Materia:</label>
                            <input type="text" class="form-control" name="idmateria" value="<?=isset($materia) ? $materia->idmateria : ""; ?>"/>
                        </div>

                        <div class="form-group">
                            <label>Materia:</label>
                            <input class="form-control" type="text" name="materia" value="<?=isset($materia) ? $materia->materia :""; ?>" />
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Guardar">
                            <a class="btn btn-success" href="<?=site_url('Materias_controller');?>">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>