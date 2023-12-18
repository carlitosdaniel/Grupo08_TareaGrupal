<?php
class roles
{
    private $IdRol;
    private $Nombre;
    private $Accion;
    private $con;

    function __construct($cn)
    {
        $this->con = $cn;
        //echo "EJECUTANDOSE EL CONSTRUCTOR MARCA<br><br>";
    }

    //******** 3.1 METODO update_consulta() *****************
    public function update_roles()
    {
        // Check if the 'id', 'Nombre', and 'Accion' keys are set in $_POST
        if (isset($_POST['id'], $_POST['Nombre'], $_POST['Accion'])) {
            $this->IdRol = $_POST['id'];
            $this->Nombre = $_POST['Nombre'];
            $this->Accion = $_POST['Accion'];

            $sql = "UPDATE roles SET 
                    Nombre='$this->Nombre',
                    Accion='$this->Accion'
                    WHERE IdRol = $this->IdRol;";

            echo $sql;

            if ($this->con->query($sql)) {
                echo $this->_message_ok("modificó");
            } else {
                echo $this->_message_error("al modificar");
            }
        } else {
            echo $this->_message_error("al modificar - datos insuficientes");
        }
    }




    //******** 3.2 METODO save_consulta() *****************	

    public function save_roles()
    {
        $this->IdRol = $_POST['id'];
        $this->Nombre = $_POST['Nombre'];
        $this->Accion = $_POST['Accion'];

        $sql = "INSERT INTO roles VALUES(
                    '$this->IdRol',
                    '$this->Nombre',
                    '$this->Accion'
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
                // OPCION PARA GRABAR UN NUEVO VEHICULO (id=0)
                $html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';
            } else {
                // OPCION PARA MODIFICAR UN VEHICULO EXISTENTE
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
        // Código agregado -- //
        if (($id == NULL) || ($id == 0)) {
            $this->Nombre = NULL;
            $this->Accion = NULL;

            $op = "new";
        } else {
            $sql = "SELECT * FROM roles WHERE IdRol=$id;";
            $res = $this->con->query($sql);
            $row = $res->fetch_assoc();
            $num = $res->num_rows;
            $bandera = ($num == 0) ? 0 : 1;

            if (!($bandera)) {
                $mensaje = "tratar de actualizar el rol con id= " . $id . "<br>";
                echo $this->_message_error($mensaje);

            } else {

                // ***** TUPLA ENCONTRADA *****



                // ATRIBUTOS DE LA CLASE VEHICULO   
                $this->Nombre = $row['Nombre'];
                $this->Accion = $row['Accion'];


                $flag = "enabled";
                $op = "update";
            }
        }

        $IdRol = [
            "Administrador",
            "Medico",
            "Paciente",
        ];



        $html = '
        <form name="Form_Consulta" method="POST" action="roles.php" enctype="multipart/form-data">
            <!-- Agrego dos líneas -> hidden oculto -->
            <input type="hidden" name="id" value="' . htmlspecialchars($id) . '">
            <input type="hidden" name="op" value="' . htmlspecialchars($op) . '">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                DATOS ROLES
                            </div>
                            <div class="card-body">
                            <div class="form-group row">
                                <label for="rol" class="col-md-4 col-form-label">ROL:</label>
                                <div class="col-md-8">
                                <input type="text" class="form-control" name="Nombre" id="Nombre" value="' . htmlspecialchars($this->Nombre) . '" disabled></td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rol" class="col-md-4 col-form-label">Accion:</label>
                                <div class="col-md-8">
                                <input type="text" class="form-control" name="Accion" id="Accion" value="' . htmlspecialchars($this->Accion) . '" required>
                                </div>
                            </div><div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" class="btn btn-primary" name="Guardar" value="GUARDAR">
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
                    <th colspan="12">Lista de Roles</th>
                </tr>
                <tr>
                    <th colspan="12"><a href="roles.php?d=' . $d_new_final . '" class= "text-white">Nuevo</a></th>
                </tr>
                <tr>
                    <th>Rol</th>
                    <th>Acciones</th>
                    <th colspan="5">Acciones</th>
                </tr>
            </thead>
        <tbody>
    </div>';
        $sql = "SELECT r.IdRol, r.Nombre , r.Accion FROM roles r
		;";
        $res = $this->con->query($sql);
        // Sin codificar <td><a href="roles.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
        while ($row = $res->fetch_assoc()) {
            $d_del = "del/" . $row['IdRol'];
            $d_del_final = base64_encode($d_del);
            $d_act = "act/" . $row['IdRol'];
            $d_act_final = base64_encode($d_act);
            $d_det = "det/" . $row['IdRol'];
            $d_det_final = base64_encode($d_det);
            $html .= '
            <tr>
                <td>' . $row['Nombre'] . '</td>
                <td>' . $row['Accion'] . '</td>
                <td class="text-center"><button class="btn btn-danger"><a href="roles.php?d=' . $d_del_final . '">Borrar</a></button></td>
                <td class="text-center"><button class="btn btn-warning"><a href="roles.php?d=' . $d_act_final . '">Actualizar</a></button></td>
                <td class="text-center"><button class="btn btn-info"><a href="roles.php?d=' . $d_det_final . '">Detalle</a></button></td>
            </tr>';
        }
        $html .= '</table>';
        return $html;
    }

    public function get_detail_roles($id)
    {
        $sql = "SELECT r.Nombre , r.Accion
            FROM roles r
            WHERE IdRol = $id;";

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
            $html = '<div class="container mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        DATOS ROLES	
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <td>ROL:</td>
                                                <td>' . $row['Nombre'] . '</td>
                                            </tr>
                                            <tr>
                                                <td>Acción:</td>
                                                <td>' . $row['Accion'] . '</td>
                                            </tr>                                                               
                                            <tr>
                                                <td colspan="2">
                                                    <a href="roles.php" class="btn btn-primary">Regresar</a>
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

    public function delete_roles($id)
    {
        $sql = "DELETE FROM roles WHERE IdRol=$id;";
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
				<th><a href="roles.php">Regresar</a></th>
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
				<th><a href="roles.php">Regresar</a></th>
			</tr>
		</table>';
        return $html;
    }

    //**************************	

} // FIN SCRPIT