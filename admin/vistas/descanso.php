<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


//modificar//


require 'header.php';
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Descanso</h1> <small> Listado</small>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
<table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Nro. de Cédula </th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Departamento</th>
      <th>Tipo</th>
      <th>Estado</th>
    </thead>
    
  </table>
</div>


      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 

require 'footer.php';
 ?>
 <script src="scripts/descanso.js"></script>
 <?php 
}

ob_end_flush();
  ?>
