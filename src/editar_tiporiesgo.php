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
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $idtiporiesgo = $_POST['id'];
        $nombretiporiesgo = $_POST['nombretiporiesgo'];
        $tiporiesgodescripcion = $_POST['tiporiesgodescripcion'];
 
            $sql_update = mysqli_query($conexion, "UPDATE tiporiesgo SET nombretiporiesgo = '$nombretiporiesgo' , tiporiesgodescripcion = '$tiporiesgodescripcion'  WHERE idtiporiesgo = $idtiporiesgo");

            if ($sql_update) {
                $alert = '<div class="alert alert-success" role="alert">Nivel de riesgo Actualizado correctamente</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al Actualizar Nivel Riesgo</div>';
            }
    }
}
// Mostrar Datos

// Id pendiente

if (empty($_REQUEST['id'])) {
    header("Location: tiporiesgos.php");
}
$idtiporiesgo = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM tiporiesgo WHERE idtiporiesgo = $idtiporiesgo");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: tiporiesgos.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $idtiporiesgo = $data['idtiporiesgo'];
        $nombretiporiesgo = $data['nombretiporiesgo'];
        $tiporiesgodescripcion = $data['tiporiesgodescripcion'];
      
    }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Tipo de Riesgos
                </div>

                <div class="card-body">
                    <form class="" action="" method="post">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $idtiporiesgo; ?>">

                        <div class="form-group">
                            <label for="nombretiporiesgo">Tipo de Riesgo</label>
                            <input type="text" placeholder="Ingrese Nivel de Riesgo" name="nombretiporiesgo" class="form-control" id="nombretiporiesgo" value="<?php echo $nombretiporiesgo; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tiporiesgodescripcion">Descripcion</label>
                            <input type="text" placeholder="Ingrese Nivel de Riesgo" name="tiporiesgodescripcion" class="form-control" id="tiporiesgodescripcion" value="<?php echo $tiporiesgodescripcion; ?>">
                        </div>
                     
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Nivel Riesgo</button>
                        <a href="tiporiesgos.php" class="btn btn-danger">Atras</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>