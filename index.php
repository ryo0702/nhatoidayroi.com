<?php get_header(); ?>
<main id="main" class="site-main">
    <?php
    include get_template_directory() . '/parts/hero-slider.php';
    include get_template_directory() . '/parts/serach-form.php';
    include get_template_directory() . '/parts/cta-email.php';
    include get_template_directory() . '/parts/archive-top-project.php';
    include get_template_directory() . '/parts/archive-top-new-mansions.php';
    include get_template_directory() . '/parts/archive-top-used-mansions.php';
    include get_template_directory() . '/parts/archive-top-news.php';
    ?>
</main>
<?php get_footer(); ?>
