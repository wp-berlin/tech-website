<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 11:06
 */
$meta = array_map(function (array $values) {
    return maybe_unserialize($values[0]);
}, get_post_meta(get_the_ID()));
?>
<aside class="markdown-sidebar single-sidebar">
    <?php include locate_template(['partials/meeting-minutes/location.php']); ?>
    <?php include locate_template(['partials/meeting-minutes/date-time.php']); ?>
    <?php include locate_template(['partials/meeting-minutes/edit-date.php']); ?>
    <?php include locate_template(['partials/meeting-minutes/authors.php']); ?>
</aside>
