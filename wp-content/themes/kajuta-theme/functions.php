<?php

namespace App;

/**
 * Importation des classes Wordpress
 */
use WP_Customize_Control;
use WP_Customize_Image_Control;
use WP_Customize_Manager;

/**
 * Ajout du support pour le titre de l'onglet
 */
function kajuta_supports(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

/**
 * Ajouter un attribut de type "module"
 *
 * @param $tag
 * @param $handle
 * @param $src
 *
 * @return string
 */
function add_type_attribute($tag, $handle, $src): string
{
    if ('kajuta-main-js' === $handle) {
        // on ajoute l'attribut type="module"
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}

/**
 * Ajoute le type mime (glb) pour les fichiers 3d
 *
 * @param $existing_mimes
 *
 * @return array
 */
function kajuta_custom_upload_mimes( $existing_mimes ): array
{
	$existing_mimes['glb'] = 'application/octet-stream';
	return $existing_mimes;
}
add_filter( 'mime_types', 'App\kajuta_custom_upload_mimes',  1, 1 );


/**
 * Chargement des assets (Js / Css)
 */
function kajuta_enqueue_assets(): void
{
    // Suppression de Jquery importé par Wordpress
    wp_deregister_script('jquery');

    // Chargement du css de Bootstrap
    wp_enqueue_style(
        "kajuta-bootstrap-css",
        get_template_directory_uri() . '/assets/css/bootstrap.css',
        [],
        null,
        'all'
    );

    // Chargement du css personnalisé
    wp_enqueue_style(
        "kajuta-main-css",
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        null,
        'all'
    );

    // Chargement du javascript de Bootstrap
    wp_enqueue_script(
        'kajuta-bootstrap-js',
        get_template_directory_uri() . '/assets/js/bootstrap.js',
        [],
        null,
        true
    );

    // Chargement du Polyfill pour le scroll (Polyfill pour Edge principalement)
    wp_enqueue_script(
        'kajuta-scrollPolyfill-js',
        'https://cdn.jsdelivr.net/npm/scroll-behavior-polyfill@2.0.13/dist/index.min.js',
        [],
        null,
        true
    );

    // Chargement du javascript personnalisé
    wp_enqueue_script(
        'kajuta-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        ['kajuta-scrollPolyfill-js'],
        null,
        true
    );
    // add_filter('script_loader_tag', 'App\add_type_attribute', 10, 3);
}

/**
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kajuta_register_area_template($wp_customize): void
{
    /**
     * Section Présentation
     */
    $wp_customize->add_section('kajuta-presentation-section', [
        'title' => __('Presentation', 'kajuta_shelter'),
    ]);

    /**
     * Titre
     */
    $wp_customize->add_setting('kajuta-presentation-headline', [
        'default' => __('Presentation', 'kajuta_shelter'),
    ]);
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'kajuta-presentation-headline-control',
            [
                'label' => __('Headline', 'kajuta_shelter'),
                'section' => 'kajuta-presentation-section',
                'settings' => 'kajuta-presentation-headline',
            ]
        )
    );
    /**
     * Texte
     */
    $wp_customize->add_setting('kajuta-presentation-text', [
        'default' => __('Default Text', 'kajuta_shelter'),
    ]);
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'kajuta-presentation-text-control',
            [
                'label' => __('Text', 'kajuta_shelter'),
                'section' => 'kajuta-presentation-section',
                'settings' => 'kajuta-presentation-text',
                'type' => 'textarea',
            ]
        )
    );
    /**
     * Image
     */
    $wp_customize->add_setting('kajuta-presentation-image');
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'kajuta-presentation-image-control',
            [
                'label' => __('Upload a image', 'kajuta_shelter'),
                'section' => 'kajuta-presentation-section',
                'settings' => 'kajuta-presentation-image',
                'type' => 'image',
            ]
        )
    );

    /**
     * Section Objectifs
     */
    $wp_customize->add_section('kajuta-objectif-section', [
        'title' => __('Objectives', 'kajuta_shelter'),
    ]);

    /**
     * Titre
     */
    $wp_customize->add_setting('kajuta-objectif-headline', [
        'default' => __('Our objectives', 'kajuta_shelter'),
    ]);
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'kajuta-objectif-headline-control',
            [
                'label' => __('Headline', 'kajuta_shelter'),
                'section' => 'kajuta-objectif-section',
                'settings' => 'kajuta-objectif-headline',
            ]
        )
    );
    /**
     * Texte
     */
    $wp_customize->add_setting('kajuta-objectif-text', [
        'default' => __('Default Text', 'kajuta_shelter'),
    ]);
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'kajuta-objectif-text-control',
            [
                'label' => __('Text', 'kajuta_shelter'),
                'section' => 'kajuta-objectif-section',
                'settings' => 'kajuta-objectif-text',
                'type' => 'textarea',
            ]
        )
    );
    /**
     * Image
     */
    $wp_customize->add_setting('kajuta-objectif-image');
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'kajuta-objectif-image-control',
            [
                'label' => __('Upload a image', 'kajuta_shelter'),
                'section' => 'kajuta-objectif-section',
                'settings' => 'kajuta-objectif-image',
                'type' => 'image',
            ]
        )
    );

	/**
	 * Section Footer
	 */
	$wp_customize->add_section('kajuta-footer-section', [
		'title' => __('Footer', 'kajuta_shelter'),
	]);

	/**
	 * Titre (gauche)
	 */
	$wp_customize->add_setting('kajuta-footer-left-headline', [
		'default' => __('Left title', 'kajuta_shelter'),
	]);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'kajuta-footer-left-headline-control',
			[
				'label' => __('Left Headline', 'kajuta_shelter'),
				'section' => 'kajuta-footer-section',
				'settings' => 'kajuta-footer-left-headline',
			]
		)
	);

	/**
	 * Texte (gauche)
	 */
	$wp_customize->add_setting('kajuta-footer-left-text', [
		'default' => __('Left text', 'kajuta_shelter'),
	]);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'kajuta-footer-left-text-control',
			[
				'label' => __('Left Text', 'kajuta_shelter'),
				'section' => 'kajuta-footer-section',
				'settings' => 'kajuta-footer-left-text',
				'type' => 'textarea',
			]
		)
	);

	/**
	 * Titre (milieu)
	 */
	$wp_customize->add_setting('kajuta-footer-mid-headline', [
		'default' => __('Mid title', 'kajuta_shelter'),
	]);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'kajuta-footer-mid-headline-control',
			[
				'label' => __('Mid Headline', 'kajuta_shelter'),
				'section' => 'kajuta-footer-section',
				'settings' => 'kajuta-footer-mid-headline',
			]
		)
	);

	/**
	 * Texte (milieu)
	 */
	$wp_customize->add_setting('kajuta-footer-mid-text', [
		'default' => __('Mid Headline', 'kajuta_shelter'),
	]);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'kajuta-footer-mid-text-control',
			[
				'label' => __('Mid Text', 'kajuta_shelter'),
				'section' => 'kajuta-footer-section',
				'settings' => 'kajuta-footer-mid-text',
				'type' => 'textarea',
			]
		)
	);

	/**
	 * Titre (droite)
	 */
	$wp_customize->add_setting('kajuta-footer-right-headline', [
		'default' => __('Right Headline', 'kajuta_shelter'),
	]);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'kajuta-footer-right-headline-control',
			[
				'label' => __('Right Headline', 'kajuta_shelter'),
				'section' => 'kajuta-footer-section',
				'settings' => 'kajuta-footer-right-headline',
			]
		)
	);

	/**
	 * Texte (gauche)
	 */
	$wp_customize->add_setting('kajuta-footer-right-text', [
		'default' => __('Right text', 'kajuta_shelter'),
	]);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'kajuta-footer-right-text-control',
			[
				'label' => __('Right Text', 'kajuta_shelter'),
				'section' => 'kajuta-footer-section',
				'settings' => 'kajuta-footer-right-text',
				'type' => 'textarea',
			]
		)
	);
}

add_action('after_setup_theme', 'App\kajuta_supports');
add_action('wp_enqueue_scripts', 'App\kajuta_enqueue_assets');
add_action('customize_register', 'App\kajuta_register_area_template');

// Suppression de la Tagline dans le titre
add_filter('document_title_parts', function ($title): array {
    unset($title['tagline']);
    return $title;
});
