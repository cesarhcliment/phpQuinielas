<?php

namespace phpQuinielas\controllers;

use phpQuinielas\models\Equipos;

class EquiposController {

    static public function procesar() 
    {
        $requestURI = explode("/", $_SERVER['REQUEST_URI']);
        $requestURI = array_filter($requestURI);

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (count($requestURI) == 1)
        {
            $id = 0;
        }
        else
        {
            $id = $requestURI[2] ?? 0;
        }

        switch ($requestMethod) {
            case 'GET':
                if ($id == 0) 
                {
                    // echo "gelAll";
                    $response = Equipos::getAll();
                    echo json_encode($response);
                } 
                else
                {
                    $response = Equipos::getById($id);
                    echo json_encode($response);
                }
                break;

            case 'POST':
                $data = array(
                    'nombre' => $_POST['nombre']
                );
                if (count($data) == 0)
                {
                    $inputsdata = file_get_contents("php://input");
                    $data = json_decode($inputsdata, true);
                }
                $response = Equipos::insert($data);
                echo json_encode($response);
                break;

            case 'PUT':
                $data = array();
                parse_str(file_get_contents('php://input'), $data);
            
                $columnas = array();
                foreach (array_keys($data) as $key => $value)
                {
                    array_push($columnas, $value);
            
                }
                $response = Equipos::update($id, $data);
                echo json_encode($response);
                break;

            case 'DELETE':
                $response = Equipos::delete($id);
                echo json_encode($response);
                break;
        }
    }
}

?>