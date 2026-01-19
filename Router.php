<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];
    

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }


    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }


    public function comprobarRutas() {
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptDir = dirname($scriptName);

        if (strpos($currentUrl, '?') !== false) $currentUrl = explode('?', $currentUrl)[0];
        $scriptDir = str_replace('\\', '/', $scriptDir);
        if ($scriptDir !== '/' && strpos($currentUrl, $scriptDir) === 0) {
            $currentUrl = substr($currentUrl, strlen($scriptDir));
        }
        if (strpos($currentUrl, '/index.php') === 0) {
            $currentUrl = str_replace('/index.php', '', $currentUrl);
        }
        if ($currentUrl === '' || $currentUrl === false) $currentUrl = '/';
        // ------------------------------------------

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ($fn) {
            // ESTA LÍNEA ES LA QUE CARGA TU PÁGINA
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }


    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include_once __DIR__ . '/views/layout.php';
    }
}
