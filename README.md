# UpTask (Nombre en Proceso)

![Estado del Proyecto](https://img.shields.io/badge/Estado-En_Desarrollo-yellow)

## 📖 Descripción

Esta es una aplicación web de gestión de tareas estilo Trello. El sistema permite a los usuarios organizar sus actividades diarias visualizando el progreso a través de un tablero interactivo.

El proyecto se centra en ofrecer una experiencia CRUD (Crear, Leer, Actualizar, Eliminar) completa y segura, implementando un sistema de autenticación de usuarios con verificación por correo electrónico.

## 🚀 Características

* **Tablero de Tareas:** Organización visual del flujo de trabajo.
* **Estados:** Clasificación en *Pendiente*, *Completado* y *Eliminado*.
* **CRUD Completo:** Gestión total de las tareas.
* **Seguridad:**
    * Login y Registro de usuarios.
    * Validación de cuenta vía Token/Email.
    * Hasheo de contraseñas.
    * Protección de sesiones.
* **Diseño:** Interfaz responsiva y amigable construida con SASS.

## 🛠️ Stack Tecnológico

* **Backend:** PHP (Vanilla / MVC)
* **Frontend:** HTML5, JavaScript, SASS
* **Base de Datos:** MySQL
* **Herramientas:** Composer, Gulp/Webpack, Git.

## 🔧 Instalación

1.  **Clonar repositorio:**
    ```bash
    git clone https://github.com/FacuLedesmaBertalot/UpTask_MVC
    cd [nombre-carpeta]
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install
    ```

3.  **Base de Datos:**
    * Importa el archivo `database.sql` en tu gestor SQL.
    * Configura la conexión en tu archivo de variables de entorno o config (ej. `includes/database.php`).

4.  **Correo (SMTP):**
    * Configura tus credenciales SMTP (Mailtrap/Gmail) para el envío de correos de confirmación.

5.  **Iniciar:**
    * Compila los estilos: `npm run build`
    * Abre en el navegador: `http://localhost/[ruta-proyecto]`

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor, abre un Issue primero para discutir lo que te gustaría cambiar o realiza un Fork y envía un Pull Request.

---

