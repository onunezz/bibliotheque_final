<?php
class MessageController
{
    // Función para mostrar mensajes de verificación o éxito
    function successMessage($type, $message)
    {
        // Comprueba si existe un parámetro en la URL con el nombre especificado en tipo y su valor es 'correcto'
        if (isset($_GET[$type]) && $_GET[$type] == 'success') {
            // Si se cumple la condición, muestra un div con la clase 'mensaje_correcto' y muestra el mensaje especificado en mensaje
            echo "<div class='alert alert-success w-75 mx-auto text-center'role='alert'>$message</div>";
        }
    }

    // Función para mostrar mensajes de error
    function errorMessage($type, $message)
    {
        // Co$mprueba si existe un parámetro en la URL con el nombre especificado en tipo y su valor es 'error'
        if (isset($_GET[$type]) && $_GET[$type] == 'error') {
            // Si se cumple la condición, muestra un div con la clase 'mensaje_error' y muestra el mensaje especificado en mensaje
            echo "<div class='alert alert-danger w-75 mx-auto text-center'role='alert'>$message</div>";
        }
    }
}
