<?php
class medicamento
{


	private $IDMedicamento;
	private $Nombre;
	private $Tipo;
	private $con;

	function __construct($cn)
	{
		$this->con = $cn;
		echo "EJECUTANDOSE";
	}


	//*********************** 3.1 METODO update_vehiculo() **************************************************	


	public function update_medicamento()
	{
		$this->IDMedicamento = isset($_POST['IDMedicamento']) ? $_POST['IDMedicamento'] : '';
		$this->Nombre = $_POST['Nombre'];
		$this->Tipo = $_POST['Tipo'];

		$sql = "UPDATE medicamentos SET IdMedicamento='$this->IDMedicamento',
									Nombre='$this->Nombre',
									Tipo='$this->Tipo'
				WHERE IdMedicamento=$this->IDMedicamento;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}

	}

	//*********************** 3.2 METODO save_vehiculo() **************************************************	

	public function save_medicamento()
	{
		$this->IDMedicamento = isset($_POST['IDMedicamento']) ? $_POST['IDMedicamento'] : '';
		$this->Nombre = $_POST['Nombre'];
		$this->Tipo = $_POST['Tipo'];


		//files ver los datos que ingresarte el id
		echo "<br> FILES <br>";
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";


		$sql = "INSERT INTO medicamentos VALUES(		'$this->IDMedicamento',
											'$this->Nombre',
											'$this->Tipo');";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("guardó");
		} else {
			echo $this->_message_error("guardar");
		}

	}



	//*********************** 3.3 METODO _get_name_File() **************************************************	

	private function _get_name_file($nombre_original, $tamanio)
	{
		$tmp = explode(".", $nombre_original); //Divido el nombre por el punto y guardo en un arreglo
		$numElm = count($tmp); //cuento el número de elemetos del arreglo
		$ext = $tmp[$numElm - 1]; //Extraer la última posición del arreglo.
		$cadena = "";
		for ($i = 1; $i <= $tamanio; $i++) {
			$c = rand(65, 122);
			if (($c >= 91) && ($c <= 96)) {
				$c = NULL;
				$i--;
			} else {
				$cadena .= chr($c);
			}
		}
		return $cadena . "." . $ext;
	}


	//************************************* PARTE II ****************************************************	



	public function get_form($id = NULL)
	{
		// Código agregado -- //
		if (($id == NULL) || ($id == 0)) {
			$this->IDMedicamento = NULL;
			$this->Nombre = NULL;
			$this->Tipo = NULL;

			$flag = NULL;
			$op = "new";
		} else {
			$sql = "SELECT * FROM medicamentos WHERE IdMedicamento=$id;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			$num = $res->num_rows;
			$bandera = ($num == 0) ? 0 : 1;

			if (!($bandera)) {
				$mensaje = "tratar de actualizar el medico con id= " . $id . "<br>";
				echo $this->_message_error($mensaje);

			} else {

				// ***** TUPLA ENCONTRADA *****
				/* echo "<br>REGISTRO A MODIFICAR: <br>";
														echo "<pre>";
															print_r($row);
														echo "</pre>"; */


				// ATRIBUTOS DE LA CLASE VEHICULO   
				$this->IDMedicamento = $row['IdMedicamento'];
				$this->Nombre = $row['Nombre'];
				$this->Tipo = $row['Tipo'];


				$flag = "enabled";
				$op = "update";
			}
		}



		$html = '
		<form name="Form_Consulta" method="POST" action="medicamentos.php" enctype="multipart/form-data">
            <!-- Agrego dos líneas -> hidden oculto -->
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" name="op" value="' . $op . '">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                DATOS DEL MEDICAMENTO
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label for="IDMedicamento" class="col-md-4 col-form-label">ID Medicamento:</label>
									<div class="col-md-8">
										<input type="text"  class="form-control" size="15" name="IDMedicamento" value="' . $this->IDMedicamento . '" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label for="Nombre" class="col-md-4 col-form-label">Medicamento:</label>
									<div class="col-md-8">
										<input type="text"  class="form-control" size="15" name="Nombre" value="' . $this->Nombre . '" required>
									</div>
                            	</div>
								<div class="form-group row">
									<label for="tipo" class="col-md-4 col-form-label">Tipo:</label>
									<div class="col-md-8">
										<input type="text"  class="form-control" size="15" name="Tipo" value="' . $this->Tipo . '" required>
									</div>
                            	</div>
								<div class="form-group row">
									<div class="col-md-8 offset-md-4">
										<input type="submit" class="btn btn-primary" name="Guardar" value="GUARDAR">
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>';
		return $html;
	}



	public function get_list()
	{
		$d_new = "new/0";                           //Línea agregada
		$d_new_final = base64_encode($d_new);       //Línea agregada

		$html = ' 
		<div class="container">
        <br>
            <table class="table table-bordered text-center table-striped" align="center">
                <thead class="thead-dark ">
                    <tr>
                        <th colspan="12">Lista de Medicamentos</th>
                    </tr>
                    <tr>
                        <th colspan="12"><a href="medicamentos.php?d=' . $d_new_final . '" class= "text-white">Nuevo</a></th>
                    </tr>
                    <tr>
						<th>Nombre</th>
                        <th>Tipo</th>
                        <th colspan="5">Acciones</th>
                    </tr>
                </thead>
            <tbody>
        </div>';


		$sql = "SELECT m.IdMedicamento, m.Nombre as Nombre, m.Tipo as Tipo  
                FROM medicamentos m;";
		$res = $this->con->query($sql);


		// VERIFICA si existe TUPLAS EN EJECUCION DEL Query
		$num = $res->num_rows;
		if ($num != 0) {

			while ($row = $res->fetch_assoc()) {
				// URL PARA BORRAR
				$d_del = "del/" . $row['IdMedicamento'];
				$d_del_final = base64_encode($d_del);

				// URL PARA ACTUALIZAR
				$d_act = "act/" . $row['IdMedicamento'];
				$d_act_final = base64_encode($d_act);

				// URL PARA EL DETALLE
				$d_det = "det/" . $row['IdMedicamento'];
				$d_det_final = base64_encode($d_det);

				$html .= '
					<tr>
						<td>' . $row['Nombre'] . '</td>
						<td>' . $row['Tipo'] . '</td>
						<td class="text-center"><button class="btn btn-danger"><a href="medicamentos.php?d=' . $d_del_final . '">Borrar</a></button></td>
						<td class="text-center"><button class="btn btn-warning"><a href="medicamentos.php?d=' . $d_act_final . '">Actualizar</a></button></td>
						<td class="text-center"><button class="btn btn-info"><a href="medicamentos.php?d=' . $d_det_final . '">Detalle</a></button></td>
					</tr>';
			}
		}
		$html .= '</table>';
		return $html;
	}





	//********************************************************************************************************
	/*
			  $tabla es la tabla de la base de datos
			  $valor es el nombre del campo que utilizaremos como valor del option
			  $etiqueta es nombre del campo que utilizaremos como etiqueta del option
			  $nombre es el nombre del campo tipo combo box (select)
			  * $defecto es el valor para que cargue el combo por defecto
			  */

	// _get_combo_db("marca","id","descripcion","marca",$this->marca)
	// _get_combo_db("color","id","descripcion","color", $this->color)

	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_combo_db($tabla, $valor, $etiqueta, $nombre, $defecto = NULL)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		//$num = $res->num_rows;


		while ($row = $res->fetch_assoc()) {

			/*
										echo "<br>VARIABLE ROW <br>";
												echo "<pre>";
													print_r($row);
												echo "</pre>";
									*/
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

	//_get_combo_anio("anio",1950,$this->anio)
	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_combo_anio($nombre, $anio_inicial, $defecto = NULL)
	{
		$html = '<select name="' . $nombre . '">';
		$anio_actual = date('Y');
		for ($i = $anio_inicial; $i <= $anio_actual; $i++) {
			$html .= ($defecto == $i) ? '<option value="' . $i . '" selected>' . $i . '</option>' . "\n" : '<option value="' . $i . '">' . $i . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}


	//_get_radio($combustibles, "combustible",$this->combustible) 
	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_radio($arreglo, $nombre, $defecto = NULL)
	{
		$html = '
		<table border=0 align="left">';
		foreach ($arreglo as $etiqueta) {
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';
			$html .= ($defecto == $etiqueta) ? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';

			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}


	//****************************************** NUEVO CODIGO *****************************************

	public function get_detail_medicamento($id)
	{
		$sql = "SELECT m.Nombre as Nombre, m.Tipo as Tipo  
				FROM medicamentos m
				WHERE m.IdMedicamento=$id";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();

		// VERIFICA SI EXISTE id
		$num = $res->num_rows;

		if ($num == 0) {
			$mensaje = "desplegar el detalle del consulta con id= " . $id . "<br>";
			echo $this->_message_error($mensaje);

		} else {

			/* echo "<br>TUPLA<br>";
								 echo "<pre>";
										 print_r($row);
								 echo "</pre>"; */

			$html = '
			<div class="container mt-4">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header bg-primary text-white">
							DATOS DEL MEDICAMENTO
						</div>
						<div class="card-body">
							<table class="table">
								<tr>
									<td>Usuario:</td>
									<td>' . $row['Nombre'] . '</td>
								</tr>
								<tr>
									<td>Paciente:</td>
									<td>' . $row['Tipo'] . '</td>
								</tr>
								<tr>
									<td colspan="2">
										<a href="medicamentos.php" class="btn btn-primary">Regresar</a>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>';
			return $html;
		}
	}



	public function delete_medicamento($id)
	{

		$sql = "DELETE FROM medicamentos WHERE IdMedicamento=$id;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("eliminó");
		} else {
			echo $this->_message_error("eliminar<br>");
		}
	}



	//***************************************************************************************	

	private function _calculo_matricula($avaluo)
	{
		return number_format(($avaluo * 0.10), 2);
	}

	//***************************************************************************************************************************

	private function _message_error($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . 'Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="medicamentos.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}


	private function _message_BD_Vacia($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th> NO existen registros en la ' . $tipo . 'Favor contactar a .................... </th>
			</tr>
	
		</table>';
		return $html;


	}

	private function _message_ok($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="medicamentos.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	//************************************************************************************************************************************************


}
?>