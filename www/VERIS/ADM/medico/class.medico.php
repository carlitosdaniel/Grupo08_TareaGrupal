<?php
class medicos
{
    private $IdMedico;
    private $Nombre;
    private $Especialidad;
    private $IdUsuario;
    private $con;

    function __construct($cn)
    {
        $this->con = $cn;
        //echo "EJECUTANDOSE EL CONSTRUCTOR MARCA<br><br>";
    }

    //******** 3.1 METODO update_consulta() *****************
    public function update_medicos()
    {
        $this->IdMedico = $_POST['id'];
        $this->Nombre = $_POST['Nombre'];
		$this->Especialidad = $_POST['Especialidad'];
		$this->IdUsuario = $_POST['IdUsuario'];

        $sql = "UPDATE medicos SET 
        Nombre='$this->Nombre',
		Especialidad='$this->Especialidad',
		IdUsuario='$this->IdUsuario'
		WHERE IdMedico=$this->IdMedico;";

        echo $sql;

        if ($this->con->query($sql)) {
            echo $this->_message_ok("modificó");
        } else {
            echo $this->_message_error("al modificar");
        }
    }



    //******** 3.2 METODO save_consulta() *****************	
    public function save_medicos()
    {
        $this->Nombre = $_POST['Nombre'];
		$this->Especialidad = $_POST['Especialidad'];
		$this->IdUsuario = $_POST['IdUsuario'];

        $sql = "INSERT INTO medicos (Nombre, Especialidad, IdUsuario) VALUES (
			'$this->Nombre',
			'$this->Especialidad',
			'$this->IdUsuario'
		);";
		

        if ($this->con->query($sql)) {
            echo $this->_message_ok("guardó");
        } else {
            echo $this->_message_error("guardar");
        }
    }

    //******** 3.3 METODO _get_name_File() *****************	

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
    //TODO VA IGUAL EN ESTA PARTE

    //************* PARTE I ********************
    //Aquí se agregó el parámetro:  $defecto/
    private function _get_combo_db($tabla, $valor, $etiqueta, $nombre, $defecto)
    {
        $html = '<select name="' . $nombre . '">';
        $sql = "SELECT $valor, $etiqueta FROM $tabla;";
        $res = $this->con->query($sql);

        while ($row = $res->fetch_assoc()) {
            $html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
        }

        $html .= '</select>';
        return $html;
    }

    /*Aquí se agregó el parámetro:  $defecto
private function _get_combo_anio($nombre,$anio_inicial,$defecto){
    $html = '<select name="' . $nombre . '">';
    $anio_actual = date('Y');
    for($i=$anio_inicial;$i<=$anio_actual;$i++){
        $html .= ($i == $defecto)? '<option value="' . $i . '" selected>' . $i . '</option>' . "\n":'<option value="' . $i . '">' . $i . '</option>' . "\n";
    }
    $html .= '</select>';
    return $html;
}*/

    //Aquí se agregó el parámetro:  $defecto*
    private function _get_radio($arreglo, $nombre, $defecto)
    {

        $html = '
		<table border=0 align="left">';

        //CODIGO NECESARIO EN CASO QUE EL USUARIO NO SE ESCOJA UNA OPCION

        foreach ($arreglo as $etiqueta) {
            $html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';

            if ($defecto == NULL) {
                // OPCION PARA GRABAR UN NUEVO consulta (id=0)
                $html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';

            } else {
                // OPCION PARA MODIFICAR UN consulta EXISTENTE
                $html .= ($defecto == $etiqueta) ? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
            }

            $html .= '</tr>';
        }
        $html .= '
		</table>';
        return $html;
    }
    //************* PARTE II ******************	

    public function get_form($id = NULL)
    {

        if ($id == NULL) {
            $this->Nombre = NULL;
			$this->Especialidad = NULL;
			$this->IdUsuario = NULL;

            // $flag = NULL;  //VARIABLES AUXILIARES
            $op = "new";
        } else {

            $sql = "SELECT * FROM medicos WHERE IdMedico=$id;";
            $res = $this->con->query($sql);
            $row = $res->fetch_assoc();

            $num = $res->num_rows;
            if ($num == 0) {
                $mensaje = "tratar de actualizar la consulta con id= " . $id;
                echo $this->_message_error($mensaje);
            } else {

                // ** TUPLA ENCONTRADA **
                echo "<br>TUPLA <br>";
                echo "<pre>";
                print_r($row);
                echo "</pre>";

                $this->Nombre = $row['Nombre'];
				$this->Especialidad = $row['Especialidad'];
				$this->IdUsuario = $row['IdUsuario'];
                //$flag = "enabled";
                $op = "update";
            }
        }

        $html = '        
        <form name="Form_Consulta" method="POST" action="medico.php" enctype="multipart/form-data">
            <!-- Agrego dos líneas -> hidden oculto -->
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" name="op" value="' . $op . '">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                DATOS MEDICO
                            </div>
                            <div class="card-body">
                            <div class="form-group row">
                                <label for="Nombre" class="col-md-4 col-form-label">Nombre del Medico:</label>
                                <div class="col-md-8">
                                    <input type="text"  class="form-control" size="15" name="Nombre" value="' . $this->Nombre . '" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="especialiad" class="col-md-4 col-form-label">Especialidad:</label>
                                <div class="col-md-8">
										' . $this->_get_combo_db("especialidades", "IdEsp", "Descripcion", "Especialidad", $this->Especialidad) . '
                                </div>
                            </div>
							<div class="form-group row">
                                <label for="especialiad" class="col-md-4 col-form-label">Usuario:</label>
                                <div class="col-md-8">
										' . $this->_get_combo_db("usuarios", "IdUsuario", "Nombre", "IdUsuario", $this->IdUsuario) . '
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
    </form>';
        return $html;
    }

    public function get_list()
    {
        $d_new = "new/0";
        $d_new_final = base64_encode($d_new);
        $html = '
        <div class="container">
<br>
            <table class="table table-bordered text-center table-striped" align="center">
                <thead class="thead-dark ">
                    <tr>
                        <th colspan="12">Lista de Medicos</th>
                    </tr>
                    <tr>
                        <th colspan="12"><a href="medico.php?d=' . $d_new_final . '" class= "text-white">Nuevo</a></th>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Usuario</th>
                        <th colspan="5">Acciones</th>
                    </tr>
                </thead>
            <tbody>
        </div>';
        $sql = "SELECT M.IdMedico, M.Nombre, E.Descripcion AS Especialidad, U.Nombre AS NombreUsuario
		FROM medicos M
		JOIN especialidades E ON M.Especialidad = E.IdEsp
		JOIN usuarios U ON M.IdUsuario = U.IdUsuario;";

        $res = $this->con->query($sql);

        if (!$res) {
            die('Error in query: ' . $this->con->error);
        }

        while ($row = $res->fetch_assoc()) {
            $d_del = "del/" . $row['IdMedico'];
            $d_del_final = base64_encode($d_del);
            $d_act = "act/" . $row['IdMedico'];
            $d_act_final = base64_encode($d_act);
            $d_det = "det/" . $row['IdMedico'];
            $d_det_final = base64_encode($d_det);
            $html .= '
            <tr>
                <td>' . $row['Nombre'] . '</td>
                <td>' . $row['Especialidad'] . '</td>
                <td>' . $row['NombreUsuario'] . '</td>
                <td class="text-center"><button class="btn btn-danger"><a href="medico.php?d=' . $d_del_final . '">Borrar</a></button></td>
                <td class="text-center"><button class="btn btn-warning"><a href="medico.php?d=' . $d_act_final . '">Actualizar</a></button></td>
                <td class="text-center"><button class="btn btn-info"><a href="medico.php?d=' . $d_det_final . '">Detalle</a></button></td>
            </tr>';
        }
        $html .= '</table>';
        return $html;
    }

    public function get_detail_medicos($id)
    {
        $sql = "SELECT M.IdMedico, M.Nombre, E.Descripcion AS Especialidad, U.Nombre AS NombreUsuario
        FROM medicos M
        JOIN especialidades E ON M.Especialidad = E.IdEsp
        JOIN usuarios U ON M.IdUsuario = U.IdUsuario
        WHERE M.IdMedico=$id;";


        $res = $this->con->query($sql);
        $row = $res->fetch_assoc();

        $num = $res->num_rows;


        //Si es que no existiese ningun registro debe desplegar un mensaje 
        //$mensaje = "tratar de eliminar el consulta con id= ".$id;
        //echo $this->_message_error($mensaje);
        //y no debe desplegarse la tablas

        if ($num == 0) {
            $mensaje = "tratar de editar el consulta con id= " . $id;
            echo $this->_message_error($mensaje);
        } else {
            $html = '
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                DATOS DEL MEDICO
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td>Nombre del Medico:</td>
                                        <td>' . $row['Nombre'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Especialidad:</td>
                                        <td>' . $row['Especialidad'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Usuario:</td>
                                        <td>' . $row['NombreUsuario'] . '</td>
									</tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="medico.php" class="btn btn-primary">Regresar</a>
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

    public function delete_medicos($id)
    {
        $sql = "DELETE FROM medicos WHERE IdMedico=$id;";
        if ($this->con->query($sql)) {
            echo $this->_message_ok("ELIMINÓ");
        } else {
            echo $this->_message_error("eliminar");
        }
    }

    //*************************	

    private function _message_error($tipo)
    {
        $html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="medico.php">Regresar</a></th>
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
				<th><a href="medico.php">Regresar</a></th>
			</tr>
		</table>';
        return $html;
    }

    //**************************	

} // FIN SCRPIT