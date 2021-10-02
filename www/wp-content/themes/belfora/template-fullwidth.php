<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Full width
 */

get_header();
?>
<div class="content">

    <?php
    if (!is_checkout()) {
        get_template_part('template', 'banner-search');
    }
    ?>
    <section>
        <?php the_content(); ?>
    </section>
</div>
<?php
get_footer();
