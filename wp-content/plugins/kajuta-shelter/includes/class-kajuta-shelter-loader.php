<?php

/**
 * Permet d'enregistrer toutes les actions et les filtres du plugin.
 *
 * Maintenir une liste de tous les hooks qui sont enregistrés dans le plugin,
 * et les enregistrer avec l'API WordPress.
 *
 * @since      1.0.0
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/includes
 * @author     Loïc NOGIER <pro.nogierloic@gmail.com>
 */
class Kajuta_Shelter_Loader
{
    /**
     * L'ensemble des actions enregistrées avec WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $actions
     */
    protected $actions;

    /**
     * L'ensemble des filtres enregistrés avec WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $filters
     */
    protected $filters;

    /**
     * Initialise les tableaux utilisées pour maintenir les actions et les filtres.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->actions = [];
        $this->filters = [];
    }

    /**
     * Ajoute une nouvelle action au tableau pour être enregistré avec WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             Le nom de l'action WordPress qui est enregistrée.
     * @param    object               $component        Une référence à l'instance de l'objet sur lequel l'action est définie.
     * @param    string               $callback         Le nom de la définition de la fonction sur le $component.
     * @param    int                  $priority         Optionnel. La priorité à laquelle la fonction doit être exercée. La valeur par défaut est 10.
     * @param    int                  $accepted_args    Optionnel. Le nombre d'arguments qui doivent être transmis au $callback. La valeur par défaut est 1.
     */
    public function add_action(
        $hook,
        $component,
        $callback,
        $priority = 10,
        $accepted_args = 1
    ) {
        $this->actions = $this->add(
            $this->actions,
            $hook,
            $component,
            $callback,
            $priority,
            $accepted_args
        );
    }
    /**
     * Ajoute un nouveau filtre au tableau pour être enregistré avec WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             Le nom du filtre WordPress qui est enregistrée.
     * @param    object               $component        Une référence à l'instance de l'objet sur lequel le filtre est défini.
     * @param    string               $callback         Le nom de la définition de la fonction sur le $component.
     * @param    int                  $priority         Optionnel. La priorité à laquelle la fonction doit être exercée. La valeur par défaut est 10.
     * @param    int                  $accepted_args    Optionnel. Le nombre d'arguments qui doivent être transmis au $callback. La valeur par défaut est 1.
     */
    public function add_filter(
        $hook,
        $component,
        $callback,
        $priority = 10,
        $accepted_args = 1
    ) {
        $this->filters = $this->add(
            $this->filters,
            $hook,
            $component,
            $callback,
            $priority,
            $accepted_args
        );
    }

    /**
     * Fonction qui est utilisée pour enregistrer les actions et les hooks dans un tableau
     *
     * @since    1.0.0
     * @access   private
     * @param    array                $hooks            Le tableau de hooks qui est en cours d'enregistrement (c'est-à-dire les actions ou les filtres).
     * @param    string               $hook             Le nom du filtre WordPress qui est enregistré.
     * @param    object               $component        Une référence à l'instance de l'objet sur lequel le filtre est défini.
     * @param    string               $callback         Le nom de la définition de la fonction sur le $component.
     * @param    int                  $priority         La priorité à laquelle la fonction doit être exercée.
     * @param    int                  $accepted_args    Le nombre d'arguments qui devraient être transmis au $callback.
     * @return   array                                  Le tableau d'actions et de filtres enregistrés avec WordPress.
     */
    private function add(
        $hooks,
        $hook,
        $component,
        $callback,
        $priority,
        $accepted_args
    ) {
        $hooks[] = [
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args,
        ];

        return $hooks;
    }

    /**
     * Execute tous les filtres et actions avec WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }
}
