<div class="orders">
    <?php

    /** @var WP_Comment[] $comments */
    /** @var array $args */
    $comments = (array) $args['comments'];
    foreach ($comments as $comment) {
        ?>
        <div class="order__item">
            <div class="order__left">
                <div class="order__date"><?php echo date_i18n(  'j M\' Y',  $comment->comment_date) ?></div>
                <div class="order__name"><?php echo esc_attr($comment->comment_author) ?></div>
                <div class="order__country"><?php echo esc_attr(get_comment_meta($comment->comment_ID, '_country', true)) ?></div>
            </div>
            <div class="order__right">
                <div class="order__stars">
                    <div class="stars --small">
                        <?php
                        $stars = get_comment_meta($comment->comment_ID, 'rating', true) ?? 0;
                        foreach ([1, 2, 3, 4, 5] as $i) {
                            ?>
                            <div class="star <?php echo $i <= $stars ? 'active' : '' ?>">
                                <svg class="svgsprite _star">
                                    <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
                                </svg>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="order__text"><?php echo $comment->comment_content ?></div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
