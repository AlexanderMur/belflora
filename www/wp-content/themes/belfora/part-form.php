
<?php
/** @var $args */
?>
<form class="form" action="<?php echo site_url( '/wp-comments-post.php' ) ?>" method="post">
    <h4 class="form__title">Оставьте отзыв</h4>
    <div class="form__block">
        <input class="form__input" type="text" placeholder="Ваше имя" name="author" required="required">
        <div class="form__error">Неправильный формат имени</div>
    </div>
    <div class="form__block">
        <input class="form__input" type="text" placeholder="Ваш город" name="country" required="required">
        <div class="form__error">Неправильный формат города</div>
    </div>
    <div class="form__block">
        <textarea class="form__textarea" placeholder="Текст отзыва" name="comment" required="required"></textarea>
        <div class="form__error">Неправильный формат</div>
    </div>
    <div class="form__block stars -js-starclick">
        <div class="star">
            <svg class="svgsprite _star">
                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
            </svg>
        </div>
        <div class="star">
            <svg class="svgsprite _star">
                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
            </svg>
        </div>
        <div class="star">
            <svg class="svgsprite _star">
                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
            </svg>
        </div>
        <div class="star">
            <svg class="svgsprite _star">
                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
            </svg>
        </div>
        <div class="star">
            <svg class="svgsprite _star">
                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
            </svg>
        </div>
        <input class="input-hidden" name="rating" required>
        <div class="form__error">Пожалуйста, поставьте оценку.</div>
    </div>
    <label class="checkbox form__checkbox">
        <input class="input-hidden" type="checkbox" name="terms" required><span class="checkbox__ico"></span>
        <p class="checkbox__text"> <span>Даю согласие на обработку</span>&nbsp;<a href="#">персональных данных</a></p>
    </label>
    <input type="hidden" name="comment_post_ID" value="<?php echo $args['post_id'] ?>" id="comment_post_ID">
    <button class="button --dark --big form__buttom">Отправить отзыв</button>
</form>
