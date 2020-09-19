<?php

/**
 * Lancé lorsque le plugin est désinstallé.
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 */

// Si la désinstallation n'est pas appelée depuis WordPress, alors on stop.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}
