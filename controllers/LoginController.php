<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }


    public static function logut() {
        echo "Desde Logout";
    }


    public static function crear(Router $router) {

    $alertas = [];
    $usuario = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            
            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'Usuario Ya Registrado');
                    $alertas = Usuario::getAlertas();

                } else {
                    // Hashear Password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();

                    // Crear un Nuevo Usuario
                    $resultado = $usuario->guardar();

                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();



                    if ($resultado) {
                        header('Location: /mensaje');
                    }

                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu Cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                
            }
        }

        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }


    public static function reestablecer(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Muestra la Vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password'
        ]);
    }


    public static function mensaje(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Muestra la Vista
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    
    public static function confirmar(Router $router) {
        
    $token = s($_GET['token']);
    
    if (!$token) header('Location: /');

    // Encontrar al Usuario con este token
    $usuario = Usuario::where('token', $token);

    if (empty($usuario)) {
        // No se encontro un usuario con ese token
        Usuario::setAlerta('error', 'Token No Válido');
    } else {

        /** @var \Model\Usuario $usuario */

        // Confirmar la cuenta
        $usuario->confirmado = 1;
        $usuario->token = null;
        unset($usuario->password2);
        
        // Guardar en la DB
        $usuario->guardar();

        Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');


    }

    $alertas = Usuario::getAlertas();

    // Muestra la Vista
    $router->render('auth/confirmar', [
        'titulo' => 'Confirma tu Cuenta UpTask',
        'alertas' => $alertas
        ]);
    }


}