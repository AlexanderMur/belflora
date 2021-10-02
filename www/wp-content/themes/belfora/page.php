<?php


get_header(); ?>

    <div class="content">

        <?php get_template_part('template', 'banner-search') ?>
        <section>
            <div class="container the_content">
                <?php the_content() ?>
            </div>
        </section>
    </div>

<?php
get_footer();
