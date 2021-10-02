<?php

namespace Belfora;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Comments
{
    public function __construct()
    {
        add_action('comment_post', [$this, 'saveComment']);
    }

    function saveComment($comment_id)
    {
        add_comment_meta($comment_id, 'rating', intval($_POST['rating']), true);
        add_comment_meta($comment_id, '_country', ($_POST['country']), true);
    }

    static function metaFields()
    {

        Container::make( 'comment_meta', 'Дополнительные настройки' )
            ->add_fields(array(
                Field::make( 'text', 'country', 'Город' ),
            ));

    }

}
