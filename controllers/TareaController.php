<?php

namespace Controllers;

use Model\Proyecto;

class TareaController {

    public static function index() {

    }  

    public static function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $proyectoId = $_POST['proyectoId'];

            $proyecto = Proyecto::where('url', $proyectoId);

            /** @var \Model\Proyecto $proyecto  marcaba error en ->propietarioId*/
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al Agregar la Tarea'
                ];
                echo json_encode($respuesta);
                
            } else {
                $respuesta = [
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea Agregada Correctamente'
                ];
                echo json_encode($respuesta);

            }
        }
    }
        
    public static function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }

        
    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }
}

?>