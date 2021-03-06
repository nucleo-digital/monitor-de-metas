<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package     WordPress
 * @subpackage  Timber
 * @since       Timber 0.1
 */


if (empty($api_address)) {
    wp_die("Você precisa configurar o tema antes de usá-lo. Vá nas <a href=\"/wp-admin/themes.php?page=front-page-elements\">configurações</a>.");
}


if (!class_exists('Timber')) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
}
$context = Pdm\PaginaInicial::get_context();
$templates = array('index.twig');

if (is_home()) {
    array_unshift($templates, 'home.twig');
}

Timber::render($templates, $context);
