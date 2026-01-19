<?php

namespace Controllers;

class LoginController {
    public static function login() {
        echo "Desde Login";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }


    public static function logut() {
        echo "Desde Logout";
    }


    public static function crear() {
        echo "Desde Crear";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }

    public static function olvide() {
        echo "Desde Olvide";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }


    public static function reestablecer() {
        echo "Desde Reestablecer";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }


    public static function mensaje() {
        echo "Desde Mensaje";
    }

    
    public static function confirmar() {
        echo "Desde Confirmar";

    }
}