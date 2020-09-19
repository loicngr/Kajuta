<?php
/**
 * Plugin Name: Kajuta Shelter
 * Description: Manage your shelters
 * Author: Loïc NOGIER
 * Author URI: https://loicnogier.fr
 * Version: 1.0.4
 * Requires PHP: 7.4
 * Text Domain: kajuta_shelter
 * Domain Path: /languages
 */

// Si le fichier est appelé directement, alors on stop.
if (!defined('WPINC')) {
    die();
}

/**
 * Version actuelle du plugin.
 */
define('KAJUTA_SHELTER_VERSION', '1.0.4');

/**
 * Code qui s'exécute lors de l'activation du plugin.
 */
function activate_kajuta_shelter()
{
    require_once plugin_dir_path(__FILE__) .
        'includes/class-kajuta-shelter-activator.php';
    Kajuta_Shelter_Activator::activate();
}

/**
 * Code qui s'exécute lors de la désactivation du plugin.
 */
function deactivate_kajuta_shelter()
{
    require_once plugin_dir_path(__FILE__) .
        'includes/class-kajuta-shelter-deactivator.php';
    Kajuta_Shelter_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_kajuta_shelter');
register_deactivation_hook(__FILE__, 'deactivate_kajuta_shelter');

/**
 * Classe principal du plugin
 */
require plugin_dir_path(__FILE__) . 'includes/class-kajuta-shelter.php';

/**
 * Début de l'exécution du plugin.
 */
function run_kajuta_shelter()
{
    $plugin = new Kajuta_Shelter();
    $plugin->run();
}
run_kajuta_shelter();
