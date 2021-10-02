<div class="carts__wrap carts-list carts-list-4">
    <?php
    $query = new WP_Query('post_type=product&orderby=rand&posts_per_page=4');
    while ($query->have_posts()) {
        $query->the_post();
        wc_get_template_part('content', 'product');
    }
    ?>
</div>
