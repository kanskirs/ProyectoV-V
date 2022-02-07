<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "tiporiesgos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombretiporiesgo']) || empty($_POST['tiporiesgodescripcion'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todo los campos son obligatorio
                                </div>';
    } else {
        $nombretiporiesgo = $_POST['nombretiporiesgo'];
        $tiporiesgodescripcion = $_POST['tiporiesgodescripcion'];

        $usuario_id = $_SESSION['idUser'];


        $result = 0;
        $query = mysqli_query($conexion, "SELECT * FROM tiporiesgo WHERE nombretiporiesgo = '$nombretiporiesgo'");
        $result = mysqli_fetch_array($query); //

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    El tipo de riesgo ya existe
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO tiporiesgo (nombretiporiesgo,tiporiesgodescripcion )  values ('$nombretiporiesgo','$tiporiesgodescripcion')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                                    Tipo de Riesgo Registrado
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al registrar Tipo
                            </div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_tiporiesgo"><i class="fas fa-plus"></i></button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Tipo de Riesgo</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Modificar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM tiporiesgo");
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
                        <td><?php echo $data['idtiporiesgo']; ?></td>
                        <td><?php echo $data['nombretiporiesgo']; ?></td>
                        <td><?php echo $data['tiporiesgodescripcion']; ?></td>                     
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['estado'] == 1) { ?>
                                <a href="editar_tiporiesgo.php?id=<?php echo $data['idtiporiesgo']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_tiporiesgo.php?id=<?php echo $data['idtiporiesgo']; ?>" method="post" class="confirmar d-inline">
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


<div id="nuevo_tiporiesgo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo tipo de Riesgo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nombretiporiesgo">Tipo de Riesgo</label>
                        <input type="text" placeholder="Ingrese Tipo de Riesgo" name="nombretiporiesgo" id="nombretiporiesgo" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tiporiesgodescripcion">Descripcion</label>
                        <input type="text" placeholder="Ingrese Descripcion de Riesgo" name="tiporiesgodescripcion" id="tiporiesgodescripcion" class="form-control">
                    </div>
 
                    <input type="submit" value="Guardar Tipo" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>