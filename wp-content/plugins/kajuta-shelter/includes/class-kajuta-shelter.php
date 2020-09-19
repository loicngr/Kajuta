<?php

/**
 * Class principal du plugin
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/includes
 * @author     Loïc NOGIER <pro.nogierloic@gmail.com>
 */
class Kajuta_Shelter
{
    /**
     * Maintient et enregistre tous les hooks pour le plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Kajuta_Shelter_Loader      $loader
     */
    protected $loader;

    /**
     * L'identifiant unique du plugin
     *
     * @since    1.0.0
     * @access   protected
     * @var      string     $kajuta_shelter
     */
    protected $kajuta_shelter;

    /**
     * La version actuelle du plugin
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version
     */
    protected $version;

    /**
     * Définition de la fonctionnalité de base du plugin.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('KAJUTA_SHELTER_VERSION')) {
            $this->version = KAJUTA_SHELTER_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->kajuta_shelter = 'kajuta_shelter';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Chargement des dépendances pour le plugin
     *
     * - Kajuta_Shelter_Loader. Organise les hooks du plugin.
     * - Kajuta_Shelter_i18n. Définit la fonctionnalité liée au langages.
     * - Kajuta_Shelter_Admin. Définit tous les hooks pour la zone d'administration.
     * - Kajuta_Shelter_Public. Définit tous les crochets pour la zone publique.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * Classe responsable de l'organisation des actions et filters pour le plugin
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-kajuta-shelter-loader.php';

        /**
         * Classe chargée de définir les langages
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-kajuta-shelter-i18n.php';

        /**
         * La classe chargée de définir toutes les actions qui se produisent dans le back-office.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'admin/class-kajuta-shelter-admin.php';

        /**
         * La classe responsable de la définition de toutes les actions qui se produisent dans le front-office.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'public/class-kajuta-shelter-public.php';

        $this->loader = new Kajuta_Shelter_Loader();
    }

    /**
     * Défini la langue
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Kajuta_Shelter_i18n();

        $this->loader->add_action(
            'plugins_loaded',
            $plugin_i18n,
            'load_plugin_textdomain'
        );
    }

    /**
     * Enregistre tous les hooks pour le back-office.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Kajuta_Shelter_Admin(
            $this->get_kajuta_shelter(),
            $this->get_version()
        );

        /*$this->loader->add_action(
            'admin_enqueue_scripts',
            $plugin_admin,
            'enqueue_styles'
        );
        $this->loader->add_action(
            'admin_enqueue_scripts',
            $plugin_admin,
            'enqueue_scripts'
        );*/

        $this->loader->add_action('init', $plugin_admin, 'register_post');
    }

    /**
     * Enregistre tous les hooks pour le front-office.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Kajuta_Shelter_Public(
            $this->get_kajuta_shelter(),
            $this->get_version()
        );

        $this->loader->add_action(
            'wp_enqueue_scripts',
            $plugin_public,
            'enqueue_styles'
        );
        $this->loader->add_action(
            'wp_enqueue_scripts',
            $plugin_public,
            'enqueue_scripts'
        );
        $this->loader->add_action(
            'init',
            $plugin_public,
            'register_shortcodes'
        );
    }

    /**
     * Lance le loader pour exécuter tous les hooks avec WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Retourne le nom du plugin
     *
     * @since     1.0.0
     * @return    string    Le nom du plugin
     */
    public function get_kajuta_shelter()
    {
        return $this->kajuta_shelter;
    }

    /**
     * Retourne le loader
     *
     * @since     1.0.0
     * @return    Kajuta_Shelter_Loader    Organise tous les hooks du plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retourne la version du plugin
     *
     * @since     1.0.0
     * @return    string    La version du plugin
     */
    public function get_version()
    {
        return $this->version;
    }
}
