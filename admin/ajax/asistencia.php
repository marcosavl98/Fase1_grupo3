<?php 
require_once "../modelos/Asistencia.php";
if (strlen(session_id())<1) 
	session_start();
$asistencia=new Asistencia();

$codigo_persona=isset($_POST["codigo_persona"])? limpiarCadena($_POST["codigo_persona"]):"";
$iddepartamento=isset($_POST["iddepartamento"])? limpiarCadena($_POST["iddepartamento"]):"";

//funcion listar solucionada

switch ($_GET["op"]) {
	case 'guardaryeditar':
		$result=$asistencia->verificarcodigo_persona($codigo_persona);

      	if($result > 0) {
	date_default_timezone_set('America/Asuncion');
      		$fecha = date("Y-m-d");
			$hora = date("H:i:s");

			

		$result2=$asistencia->seleccionarcodigo_persona($codigo_persona);
			   
     		$par = abs($result2%2);

          if ($par == 0){ 
                              
                $entrada = "Entrada";
        		$rspta=$asistencia->registrar_entrada($codigo_persona,$entrada);
    			//$movimiento = 0;
    			echo $rspta ? '<h3><strong>Nombres: </strong> '. $result['nombre'].' '.$result['apellidos'].'</h3><div class="alert alert-success"> Ingreso registrado '.$hora.'</div>' : 'No se pudo registrar el ingreso';
   		  }else{ 
                $salida = "Salida";
         		$rspta=$asistencia->registrar_salida($codigo_persona,$salida);
     			//$movimiento = 1;
     			echo $rspta ? '<h3><strong>Nombres: </strong> '. $result['nombre'].' '.$result['apellidos'].'</h3><div class="alert alert-danger"> Salida registrada '.$hora.'</div>' : 'No se pudo registrar la salida';             
        } 
        } else {
		         echo '<div class="alert alert-danger">
                       <i class="icon fa fa-warning"></i> No hay empleado registrado con ese Nro. de Cedula!
                         </div>';
        }


	break;


	case 'mostrar':
		$rspta=$asistencia->mostrar($idasistencia);
		echo json_encode($rspta);
	break;


	
	case 'listar':
		$rspta=$asistencia->listar();
		//declaramos un array
		$data=Array();


		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>$reg->idusuario,
				"1"=>$reg->nombre,
				"2"=>$reg->apellidos,
				"3"=>$reg->login,
				"4"=>$reg->fechacreado,
				"5"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
				);
		}
		

		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

	break;



	case 'listaru':
    $idusuario=$_SESSION["idusuario"];
		$rspta=$asistencia->listaru($idusuario);
		//declaramos un array
		$data=Array();


		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>'<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->apellidos,
				"3"=>$reg->departamento,
				"4"=>$reg->fecha,
				"5"=>$reg->entrada,
				"5"=>$reg->iniciob,
				"7"=>$reg->finalb,
				"8"=>$reg->salida
				);
		}

		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

	break;

	case 'listar_asistencia':
    $fecha_inicio=$_REQUEST["fecha_inicio"];
    $fecha_fin=$_REQUEST["fecha_fin"];
    $codigo_persona=$_REQUEST["idcliente"]; 
		$rspta=$asistencia->listar_asistencia($fecha_inicio,$fecha_fin,$codigo_persona);
		//declaramos un array
		$data=Array();


		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>$reg->fecha,
				"1"=>$reg->nombre,
				"2"=>$reg->entrada,
				"3"=>$reg->iniciob,
				"4"=>$reg->finalb,
				"5"=>$reg->salida,
				"6"=>$reg->fecha_hora,
				"7"=>$reg->codigo_persona
				);
		}

		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

	break;
	case 'listar_asistenciau':
    $fecha_inicio=$_REQUEST["fecha_inicio"];
    $fecha_fin=$_REQUEST["fecha_fin"];
    $codigo_persona=$_SESSION["idusuario"]; 
		$rspta=$asistencia->listar_asistencia($fecha_inicio,$fecha_fin,$codigo_persona);
		//declaramos un array
		$data=Array();


		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>$reg->fecha,
				"1"=>$reg->nombre,
				"2"=>$reg->entrada,
				"3"=>$reg->iniciob,
				"4"=>$reg->finalb,
				"5"=>$reg->salida,
				"6"=>$reg->fecha_hora,
				"7"=>$reg->codigo_persona
				);
		}

		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

	break;

		case 'selectPersona':
			require_once "../modelos/Usuario.php";
			$usuario=new Usuario();

			$rspta=$usuario->listar();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->codigo_persona.'>'.$reg->nombre.' '.$reg->apellidos.'</option>';
			}
			break;

}
?>