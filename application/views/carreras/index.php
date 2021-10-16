<div class="container">
    <div class="mt-4">
        
        <?php if($this->session->flashdata('success')) : ?>
            <p class="success"><strong><?php echo $this->session->flashdata('success'); ?></strong></p>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')) : ?>
            <p class="error"><strong><?php echo $this->session->flashdata('error'); ?></strong></p>
        <?php endif; ?>
        
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h3>Listado de carreras</h3>
        </div>
        <div class="col-sm-6">
            <a class="btn btn-success d-block" href="<?= site_url('Carreras_controller/insertar')?>">Agregar</a>
        </div>
        <div class="col-sm-6">
            <a class="btn btn-success d-block" href="<?=site_url('Carreras_controller/report_todas_las_carreras')?>">Reporte en PDF(Todas las carreras)</a>
        </div>
    </div>
    
    <div class="row mt-4">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Id carrera</th>
                    <th>carrera</th>
                    <!-- <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellidos</th> -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $item) : ?>
                    <tr>
                        <td><?php echo $item->idcarrera; ?></td>
                        <td><?php echo $item->carrera; ?></td>
                        <?php /*<td><?php echo $item->usuario; ?></td>
                        <td><?php echo $item->nombre; ?></td>
                        <td><?php echo $item->apellido; ?></td> */?>
                        <td>
                            <a href="<?=site_url('Carreras_controller/modificar/'.$item->idcarrera)?>">Modificar</a>
                            <a href="<?=site_url('Carreras_controller/eliminar/'.$item->idcarrera)?>" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>