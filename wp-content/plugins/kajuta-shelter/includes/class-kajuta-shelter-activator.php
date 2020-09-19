<?php

/**
 * Cette classe définit tout le code nécessaire pour s'exécuter pendant l'activation du plugin.
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/includes
 * @author     Loïc NOGIER <pro.nogierloic@gmail.com>
 */
class Kajuta_Shelter_Activator
{
    /**
     * @since    1.0.0
     */
    public static function activate()
    {
	    /**
	     * Si ACF n'est pas encore installé, on annule l’installation.
	     */
	    if ( !is_plugin_active('advanced-custom-fields/acf.php') ) {
	    	die(__("Advanced custom fields plugin is not installed yet. Please install and setup it first.", 'kajuta_shelter'));
	    }
    }
}
