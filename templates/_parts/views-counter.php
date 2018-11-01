<?php
if (is_singular() && booklovers_get_theme_option('use_ajax_views_counter')=='no') {
    booklovers_set_post_views(get_the_ID());
}
?>