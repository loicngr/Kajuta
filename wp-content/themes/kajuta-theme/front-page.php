<?php get_header(); ?>

<?php
/**
 * - Récupération du chemin vers le dossier "assets" dans le thème
 * - Récupération du titre du site
 * - Récupération de la description du site
 * */
$ASSETS_DIR = get_template_directory_uri() . '/assets/';
$PAGE_TITLE = esc_html(get_bloginfo('title'));
$PAGE_DESCRIPTION = esc_html(get_bloginfo('description'));
?>

    <!--
        Section haut de page
    -->
    <header class="container-fluid hv-100 d-flex flex-column justify-content-center align-items-center kajuta-bg">
        <h1 class="text-uppercase mt-auto display-1 kajuta-font-bold"><?= $PAGE_TITLE ?></h1>
        <h2 class="kajuta-display-10"><?= $PAGE_DESCRIPTION ?></h2>
        <button type="button" class="btn kajuta-border-white text-uppercase kajuta-color-white kajuta-font-bold mt-auto kajuta-mb-7" id="scrollToMain">Découvrir</button>
    </header>

    <!--
        Section principal
    -->
    <main class="container-fluid h-auto p-0 m-0">
        <!-- Section présentation -->
        <section class="container-fluid d-flex align-items-center justify-content-around mt-3 mb-3 kajuta-flex" id="section-presentation">
            <div class="w-auto text-left p-5 kajuta-color-gray d-flex flex-column align-items-start">
                <h3>
                    <?php
                    /**
                     * Récupération du titre pour la section "Présentation"
                     */
                    $presentationTitle = get_theme_mod(
                        'kajuta-presentation-headline'
                    );
                    if (empty($presentationTitle)) {
                        // Si le titre est vide, on assigne un titre par défaut
                        $presentationTitle = __('Presentation', 'kajuta');
                    }

                    echo $presentationTitle;
                    ?>
                </h3>
                <p>
	                <?php
                 $presentationText = get_theme_mod('kajuta-presentation-text');
                 if (empty($presentationText)) {
                     $presentationText = '...';
                 }

                 echo $presentationText;
                 ?>
                </p>
            </div>
            <div class="w-auto">
	            <?php
             $presentationImage = get_theme_mod('kajuta-presentation-image');
             /**
              * Si l'image est défini par le client
              */
             if (!empty($presentationImage)) {
                 echo "<img src='$presentationImage' alt='abri image' class='rounded img-fluid'>";
             }
             ?>
            </div>
        </section>

        <!-- Section parallax -->
        <section class="kajuta-parallax" id="section-parallax"></section>

        <!-- Section objectifs -->
        <section class="container-fluid d-flex align-items-center justify-content-around mt-3 mb-3 kajuta-flex" id="section-objectifs">
            <div class="w-auto kajuta-bg-green">
	            <?php
             $objectifImage = get_theme_mod('kajuta-objectif-image');
             /**
              * Si l'image est défini par le client
              */
             if (!empty($objectifImage)) {
                 echo "<img src='$objectifImage' alt='abri image' class='rounded img-fluid'>";
             }
             ?>
            </div>
            <div class="w-auto text-right p-5 kajuta-color-gray d-flex flex-column align-items-end">
                <h3>
                    <?php
                    $objectifTitle = get_theme_mod('kajuta-objectif-headline');
                    if (empty($objectifTitle)) {
                        $objectifTitle = __('Our Objectives', 'kajuta');
                    }

                    echo $objectifTitle;
                    ?>
                </h3>
                <p>
                    <?php
                    $objectifText = get_theme_mod('kajuta-objectif-text');
                    if (empty($objectifText)) {
                        $objectifText = '...';
                    }

                    echo $objectifText;
                    ?>
                </p>
            </div>
        </section>

        <!-- Section parallax -->
        <section class="kajuta-parallax" id="section-parallax"></section>

        <!-- Section réalisations -->
        <section class="container-fluid d-flex align-items-center justify-content-center mt-3 mb-3 flex-column" id="section-products">
            <div class="text-left kajuta-color-gray">
                <h3>Nos réalisations</h3>
                <div class="kajuta-slider-container">
	                <?php echo do_shortcode('[kajuta_preview]'); ?>
                </div>
            </div>
        </section>

        <!-- Section parallax -->
        <section class="kajuta-parallax" id="section-parallax"></section>
    </main>
<?php get_footer();
