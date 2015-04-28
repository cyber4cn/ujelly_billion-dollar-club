<?php

/**
 * Feeds 
 * 
 * Feeds widget template
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage Widget
 * 
 */

 /* @var $categories array List of Wpjb_Model_Category objects */
 /* @var $param stdClass Widget configurations options */


?>
<?php echo $theme->before_widget ?>
<?php if($title) echo $theme->before_title.$title.$theme->after_title ?>

<ul id="wpjb_feeds">
    <li>
        <a  href="<?php echo wpjb_link_to("feed", null, array("slug"=>"all")) ?>"><?php _e("All Feeds", WPJB_DOMAIN); ?></a>
    </li>
    <?php if(!empty($categories)): foreach($categories as $category): ?>
    <li>
        <a href="<?php echo wpjb_link_to("feed", $category) ?>"><?php esc_html_e($category->title) ?></a>
    </li>
    <?php endforeach; ?>
    <?php else: ?>
    <li><?php _e("No feeds found.", WPJB_DOMAIN) ?></li>
    <?php endif; ?>
</ul>

<?php echo $theme->after_widget ?>