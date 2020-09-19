<?php

/**
 * Fonctionnalités back-office pour le plugin
 *
 * Définit le nom du plugin, la version.
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/admin
 * @author     Loïc NOGIER <pro.nogierloic@gmail.com>
 */
class Kajuta_Shelter_Admin
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

    public function includes_menu_list()
    {
        require_once 'partials/kajuta-shelter-admin-display-list.php';
    }

    public function includes_menu_add()
    {
        require_once 'partials/kajuta-shelter-admin-display-add.php';
    }

    /**
     * Création du Menu dans le back-office
     */
    public function create_menu()
    {
        add_menu_page(
            'Kajuta',
            __('Kajuta Shelter', 'kajuta_shelter'),
            'manage_options',
            'kajuta',
            [$this, 'includes_menu_list'],
            '',
            5
        );
    }

    /**
     * Création du sous menu dans le back-office
     */
    public function create_sub_menu()
    {
        add_submenu_page(
            'kajuta',
            __('List', 'kajuta_shelter'),
            __('List', 'kajuta_shelter'),
            'manage_options',
            'kajuta',
            [$this, 'includes_menu_list']
        );

        add_submenu_page(
            'kajuta',
            __('Add', 'kajuta_shelter'),
            __('Add', 'kajuta_shelter'),
            'manage_options',
            'kajuta_add',
            [$this, 'includes_menu_add']
        );
    }

    public function register_post()
    {
        register_post_type('kajuta_shelter', [
            'label' => __('Shelter', 'kajuta_shelter'),
            'public' => true,
            'menu_position' => 3,
            'menu_icon' => 'dashicons-admin-home',
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true,
	        'publicly_queryable' => false
        ]);
    }

    /**
     * Enregistre les feuilles de style pour le back-office
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            "{$this->kajuta_shelter}_bootstrap_css",
            plugin_dir_url(__FILE__) . 'css/bootstrap.min.css',
            [],
            null,
            'all'
        );

        wp_enqueue_style(
            $this->kajuta_shelter,
            plugin_dir_url(__FILE__) . 'css/kajuta-shelter-admin.css',
            ["{$this->kajuta_shelter}_bootstrap_css"],
            $this->version,
            'all'
        );
    }

    /**
     * Enregistre les fichiers javascript pour le back-office
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            "{$this->kajuta_shelter}_bootstrap_js",
            plugin_dir_url(__FILE__) . 'js/bootstrap.min.js',
            [],
            null,
            true
        );

        wp_enqueue_script(
            $this->kajuta_shelter,
            plugin_dir_url(__FILE__) . 'js/kajuta-shelter-admin.js',
            ["{$this->kajuta_shelter}_bootstrap_js"],
            $this->version,
            true
        );
    }
}
