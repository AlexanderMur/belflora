<?php
namespace Belfora;



use WP_Comment;

function get_rating_html($count = 1) {
    ?>
    <div class="stars">
        <?php
        foreach ([1, 2, 3, 4, 5] as $i) {
            ?>
            <div class="star <?php echo $i <= $count ? 'active' : '' ?>">
                <svg class="svgsprite _star">
                    <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#star') ?>"></use>
                </svg>
            </div>
            <?php
        }

        ?>
    </div>
    <?php
}

function num_decline( $number, $titles, $show_number = 1 ){

    if( is_string( $titles ) )
        $titles = preg_split( '/, */', $titles );

    // когда указано 2 элемента
    if( empty( $titles[2] ) )
        $titles[2] = $titles[1];

    $cases = [ 2, 0, 1, 1, 1, 2 ];

    $intnum = abs( (int) strip_tags( $number ) );

    $title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
        ? 2
        : $cases[ min( $intnum % 10, 5 ) ];

    return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
}



function apply_depth($items,$depth = -1){
    foreach ($items as $item) {
        $item->depth = $depth + 1;
    }
    foreach ($items as $item) {
        if(count($item->children) != 0){
            apply_depth($item->children,$item->depth);
        }
    }
    return $items;
}
function sort_menu( $items, $parent = 0){
    $bundle = [];
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent == $parent ) {
            $child = sort_menu( $items, $item->ID );
            $item->children = $child;
            $bundle[ $item->ID ] = $item;
        }
    }
    apply_depth($bundle);
    return $bundle;
}
function get_sorted_menu($name) {
    $id = get_nav_menu_locations()[$name] ?? null;
    if ($id) {
        $items = wp_get_nav_menu_items($id);
        return sort_menu($items);
    }
    return null;
}
/**
 * @param WP_Comment[] $comments
 */
function groupComments(array $comments)
{
    $parentComments = [];
    foreach ($comments as $comment) {
        if ((integer) $comment->comment_parent === 0) {
            $parentComments[] = [
                'comment' => $comment,
                'children' => []
            ];
        }
    }
    foreach ($parentComments as &$parentComment) {
        foreach ($comments as $comment) {
            if ($comment->comment_parent === $parentComment['comment']->comment_ID) {
                $parentComment['children'][] = $comment;
            }
        }
    }
    return $parentComments;
}
