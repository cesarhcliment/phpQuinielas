<?php

namespace phpQuinielas\controllers;

use phpQuinielas\models\Partidos;

class PartidosController {

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
                    $response = Partidos::getAll();
                    echo json_encode($response);
                } 
                else
                {
                    $response = Partidos::getById($id);
                    echo json_encode($response);
                }
                break;

            case 'POST':
                $data = array(
                    'jornada' => $_POST['jornada'],
                    'orden' => $_POST['orden'],
                    'fecha' => $_POST['fecha'],
                    'idlocal' => $_POST['idlocal'],
                    'idvisitante' => $_POST['idvisitante'],
                    'goleslocal' => $_POST['goleslocal'],
                    'golesvisitante' => $_POST['golesvisitante'],
                );
                if (count($data) == 0)
                {
                    $inputsdata = file_get_contents("php://input");
                    $data = json_decode($inputsdata, true);
                }
                $response = Partidos::insert($data);
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
                $response = Partidos::update($id, $data);
                echo json_encode($response);
                break;

            case 'DELETE':
                $response = Partidos::delete($id);
                echo json_encode($response);
                break;
        }
    }

}

?>