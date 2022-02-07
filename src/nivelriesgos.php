<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "nivelriesgos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombrenivelriesgo']) ) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                </div>';
    } else {
        
        $nombrenivelriesgo = $_POST['nombrenivelriesgo'];
        $usuario_id = $_SESSION['idUser'];


        $result = 0;
        $query = mysqli_query($conexion, "SELECT * FROM nivelriesgo WHERE nombrenivelriesgo = '$nombrenivelriesgo'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    El Nivel ya existe
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO nivelriesgo (nombrenivelriesgo) values ('$nombrenivelriesgo')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                                    Nivel de Riesgo Registrado
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al registrar Nivel
                            </div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_nivelriesgo"><i class="fas fa-plus"></i></button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>NIvel Riesgo</th>
                <th>Estado</th>
                <th>Modificar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM nivelriesgo");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    if ($data['estado'] == 1) {
                        $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                    } else {
                        $estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                    }
            ?>
                    <tr>
                        <td><?php echo $data['idnivelriesgo']; ?></td>
                        <td><?php echo $data['nombrenivelriesgo']; ?></td>
                       
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['estado'] == 1) { ?>
                                <a href="editar_nivelriesgo.php?id=<?php echo $data['idnivelriesgo']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_nivelriesgo.php?id=<?php echo $data['idnivelriesgo']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>

    </table>
</div>


<div id="nuevo_nivelriesgo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Nivel de Riesgo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nombrenivelriesgo">Nivel de Riesgo</label>
                        <input type="text" placeholder="Ingrese Nivel de Riesgo" name="nombrenivelriesgo" id="nombrenivelriesgo" class="form-control">
                    </div>
 
                    <input type="submit" value="Guardar Nivel" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>