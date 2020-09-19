<?php

/**
 * Fonctionnalités front-office pour le plugin
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/public
 * @author     Loïc NOGIER <pro.nogierloic@gmail.com>
 */
class Kajuta_Shelter_Public
{
    /**
     * L'ID du plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $kajuta_shelter
     */
    private $kajuta_shelter;

    /**
     * La version du plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version
     */
    private $version;

    /**
     * Initialise la classe et défini ses propriétés
     *
     * @since    1.0.0
     * @param      string    $kajuta_shelter       Le nom du plugin
     * @param      string    $version              La version du plugin
     */
    public function __construct($kajuta_shelter, $version)
    {
        $this->kajuta_shelter = $kajuta_shelter;
        $this->version = $version;
    }

    public function short_code_preview()
    {
        $this->includes_slider();
    }

    public function register_shortcodes()
    {
        add_shortcode('kajuta_preview', [$this, 'short_code_preview']);
    }

    public function includes_slider()
    {
        require_once 'partials/kajuta-shelter-public-display.php';
    }

    /**
     * Enregistre les feuilles de style pour le front-office
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->kajuta_shelter,
            plugin_dir_url(__FILE__) . 'css/kajuta-shelter-public.css',
            [],
            $this->version,
            'all'
        );
    }

    /**
     * Enregistre les fichiers javascript pour le front-office
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->kajuta_shelter,
            plugin_dir_url(__FILE__) . 'js/kajuta-shelter-public.js',
            [],
            $this->version,
            false
        );
    }
}
