<div class="container">
    <div class="mt-4">
        <?php if($this->session->flashdata('success')): ?>
            <p class="success"><strong><?php echo $this->session->flashdata('success');?></strong></p>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <p class="error"><strong><?php echo $this->session->flashdata('error');?></strong></p>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h3>Listado de profesores</h3>
        </div>
        <div class="col-sm-6">
            <a class="btn btn-success d-block" href="<?=site_url('Profesores_controller/insertar')?>">Agregar</a>
        </div>
    </div>

    <div class="row mt-4">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Id Profesor</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>FechaNacimiento</th>
                    <th>Profesion</th>
                    <th>Sexo</th>
                    <th>email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $item): ?>
                    <tr>
                        <td><?php echo $item->idprofesor; ?></td>
                        <td><?php echo $item->nombre; ?></td>
                        <td><?php echo $item->apellido; ?></td>
                        <td><?php echo $item->fecha_nacimiento; ?></td>
                        <td><?php echo $item->profesion?></td> 
                        <td><?php echo $item->genero; ?></td>
                        <td><?php echo $item->email; ?></td>
                        <td>
                            <a href="<?=site_url('Profesores_controller/modificar/'.$item->idprofesor)?>">Modificar</a>
                            <a href="<?=site_url('Profesores_controller/eliminar/'.$item->idprofesor)?>" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>