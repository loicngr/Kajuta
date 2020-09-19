<?php

/**
 * Définit la fonctionnalité d'internationalisation.
 *
 * Charge et définit les fichiers d'internationalisation pour ce plugin afin qu'il soit prêt à être traduit.
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/includes
 * @author     Loïc NOGIER <pro.nogierloic@gmail.com>
 */
class Kajuta_Shelter_i18n
{
    /**
     * Charge la traduction du plugin.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'kajuta_shelter',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
