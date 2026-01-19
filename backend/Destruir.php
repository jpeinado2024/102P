<?php
// Función para manejar la destrucción de la sesión por inactividad
function verificar_inactividad($tiempoInactividad = 1 * 60)
{   // Iniciar la sesión si no se ha iniciado
    if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['Email'])) {
        // Verificar si existe la variable de última actividad
        if (!isset($_SESSION['ultima_actividad'])) {
            $_SESSION['ultima_actividad'] = time(); // Inicializar la última actividad
        } else {
            // Calcular el tiempo transcurrido desde la última actividad
            $tiempoTranscurrido = time() - $_SESSION['ultima_actividad'];

            // Si el tiempo de inactividad supera el límite, destruir la sesión
            if ($tiempoTranscurrido > $tiempoInactividad) {
                echo "
           <script>alert('Sesión cerrada por inactividad');
           window.location.href='cerrarSesion.php';
           </script>";
                exit();
            }
        }


        // Actualizar la marca de tiempo de la última actividad
        $_SESSION['ultima_actividad'] = time();
    }
}