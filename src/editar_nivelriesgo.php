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
    if (empty($_POST['nombrenivelriesgo'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $idnivelriesgo = $_POST['id'];
        $nombrenivelriesgo = $_POST['nombrenivelriesgo'];
 
            $sql_update = mysqli_query($conexion, "UPDATE nivelriesgo SET nombrenivelriesgo = '$nombrenivelriesgo'  WHERE idnivelriesgo = $idnivelriesgo");

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
    header("Location: nivelriesgos.php");
}
$idnivelriesgo = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM nivelriesgo WHERE idnivelriesgo = $idnivelriesgo");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: nivelriesgos.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $idnivelriesgo = $data['idnivelriesgo'];
        $nombrenivelriesgo = $data['nombrenivelriesgo'];
      
    }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Nivel de Riesgos
                </div>

                <div class="card-body">
                    <form class="" action="" method="post">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $idnivelriesgo; ?>">

                        <div class="form-group">
                            <label for="nombrenivelriesgo">Nombre</label>
                            <input type="text" placeholder="Ingrese Nivel de Riesgo" name="nombrenivelriesgo" class="form-control" id="nombrenivelriesgo" value="<?php echo $nombrenivelriesgo; ?>">
                        </div>
                     
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Nivel Riesgo</button>
                        <a href="nivelriesgos.php" class="btn btn-danger">Atras</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>