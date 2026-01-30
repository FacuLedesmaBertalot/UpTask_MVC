<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla ='usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;


    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }


    // Validar el Login de Usuarios
    public function validarLogin() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email No Válido';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password No Puede ir Vacío';
        }
        return self::$alertas;
    }


    // Validación para cuentas nuevas
    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password No Puede ir Vacío';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password Debe Contener al Menos 6 Caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los Password son Diferentes';
        }

        return self::$alertas;
    }


    // Valida un Email
    public function validarEmail() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email No Válido';
        }
        return self::$alertas;
    }


    // Valida el password
    public function validarPassword() {       
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password No Puede ir Vacío';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password Debe Contener al Menos 6 Caracteres';
        }
        return self::$alertas;
    }


    public function validar_perfil() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }


    // Hashea password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    // Generar token
    public function crearToken() {
        $this->token = uniqid();
    }

}
?>