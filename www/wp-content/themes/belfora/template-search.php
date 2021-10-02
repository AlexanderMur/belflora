<form class="search search-main" action="<?php echo esc_url( home_url( '/' ) ) ?>">
    <button class="circle__button search__btn -js-searchopen" type="submit">
        <svg class="svgsprite _search">
            <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#search') ?>"></use>
        </svg>
    </button>
    <input class="search__input" type="text" placeholder="Поиск..." name="s" value="<?php echo get_search_query() ?>">
    <button class="search__close -js-searchclose">
        <svg class="svgsprite _close">
            <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#close') ?>"></use>
        </svg>
    </button>
</form>
