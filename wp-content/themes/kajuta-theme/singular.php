<?php get_header(); ?>
    <main class="container-fluid h-auto p-0 mt-5 kajuta-color-gray d-flex flex-column justify-content-center align-items-center">
	    <div class="container-sm kajuta-bg-silver">
		    <?php if ( have_posts() ) : ?>
			    <?php the_post(); ?>

                <h1 class="p-3"><?= the_title(); ?></h1>
                <div class="mt-5 p-5 text-left">
				    <?= the_content(); ?>
                </div>
		    <?php else: ?>

			    <?= __("Post not found.", 'kajuta'); ?>

		    <?php endif; ?>
        </div>
    </main>
    <div class="separator mt-5"></div>
<?php get_footer();
