<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

    $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

            // --- ESTA LÍNEA ES LA SOLUCIÓN AL ERROR ROJO !$usuario->confirmado---
            /** @var \Model\Usuario $usuario */
                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El Usuario No Existe o No Está Confirmado');
                } else {
                    // El Usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // Iniciar la sesión del usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /proyectos');
                        
                    } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                        
                    }
                }


            }

        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
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
                // Buscar el Usuario
                $usuario = Usuario::where('email', $usuario->email);

                /** @var \Model\Usuario $usuario */
                if ($usuario && $usuario->confirmado) {
                    // Generar un Nuevo Token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el Usuario
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();


                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos Enviado las Instrucciones a tu Email');
                } else {
                    Usuario::setAlerta('error', 'El Usuario No Existe o No está Confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }


    public static function reestablecer(Router $router) {
        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location: /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
        
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
            $mostrar = false;
        }

        $alertas = Usuario::getAlertas();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password

            // --- ESTA LÍNEA ES LA SOLUCIÓN AL ERROR ROJO validarPassword---
            /** @var \Model\Usuario $usuario */
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el token
                $usuario->token = null;

                // Guardar el usuario en la DB
                $resultado = $usuario->guardar();

                // Redireccionar
                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        // Muestra la Vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
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