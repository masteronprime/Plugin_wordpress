<?php
/*
Plugin Name: Custom Button Alert
Plugin URI: https://tu-sitio-web.com
Description: Añade un botón que muestra una alerta al ser clickeado.
Version: 1.0
Author: Tu Nombre
Author URI: https://tu-sitio-web.com
License: GPL2
*/

// Agregar el código JavaScript necesario para mostrar la alerta
function custom_button_alert_script() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            // Seleccionar todos los botones con la clase 'custom-alert-button'
            $('.custom-alert-button').click(function() {
                // Mostrar una alerta cuando se haga clic en el botón
                alert('¡Hiciste clic en el botón!');
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_button_alert_script');

// Agregar un shortcode para insertar el botón en el contenido
function custom_button_shortcode() {
    return '<button class="custom-alert-button">Haz clic aquí</button>';
}
add_shortcode('custom_button', 'custom_button_shortcode');
