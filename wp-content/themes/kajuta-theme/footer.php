    <!--
       Section pied de page
    -->
        <footer class="container-fluid d-flex align-items-center justify-content-around mt-3 mb-3 kajuta-flex">
            <div class="kajuta-maxw-400 text-left p-5 kajuta-color-gray">
                <h3>
                    <?php
                    $footerLeftTitle = get_theme_mod('kajuta-footer-left-headline');
                    if (empty($footerLeftTitle)) {
                        $footerLeftTitle = 'Left footer';
                    }

                    echo $footerLeftTitle;
                    ?>
                </h3>
                <p>
                    <?php
                    $footerLeftText = get_theme_mod('kajuta-footer-left-text');
                    if (empty($footerLeftText)) {
                        $footerLeftText = 'Left text';
                    }

                    echo $footerLeftText;
                    ?>
                </p>
            </div>
            <div class="kajuta-maxw-400 text-left p-5 kajuta-color-gray">
                <h3>
                    <?php
                    $footerMidTitle = get_theme_mod('kajuta-footer-mid-headline');
                    if (empty($footerMidTitle)) {
                        $footerMidTitle = 'Mid footer';
                    }

                    echo $footerMidTitle;
                    ?>
                </h3>
                <p>
                    <?php
                    $footerMidText = get_theme_mod('kajuta-footer-mid-text');
                    if (empty($footerMidText)) {
                        $footerMidText = 'Mid text';
                    }

                    echo $footerMidText;
                    ?>
                </p>
            </div>
            <div class="kajuta-maxw-400 text-left p-5 kajuta-color-gray">
                <h3>
                    <?php
                    $footerRightTitle = get_theme_mod('kajuta-footer-right-headline');
                    if (empty($footerRightTitle)) {
                        $footerRightTitle = 'Mid footer';
                    }

                    echo $footerRightTitle;
                    ?>
                </h3>
                <p>
                    <?php
                    $footerRightText = get_theme_mod('kajuta-footer-right-text');
                    if (empty($footerRightText)) {
                        $footerRightText = 'Mid text';
                    }

                    echo $footerRightText;
                    ?>
                </p>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
