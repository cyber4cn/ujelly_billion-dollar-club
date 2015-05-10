<?php echo $theme->before_widget ?>
<?php if($title) echo $theme->before_title.$title.$theme->after_title ?>

<form action="" method="post">
<input type="hidden" name="add_alert" value="1" />
<ul id="wpjb_widget_alerts" class="wpjb_widget">
    <?php if($form_sent): ?>
    <li>
        <?php if($is_valid): ?>
        <?php _e("Alert was added to the database.", WPJB_DOMAIN); ?>
        <?php else: ?>
        <?php _e("Alert could not be added. There was an error in the form.", WPJB_DOMAIN); ?>
        <?php endif; ?>
    </li>
    <?php else: ?>
    <li>
        <?php _e("Keyword", WPJB_DOMAIN) ?>: <br />
        <input type="text" name="keyword" value="" />
    </li>
    <li>
        <?php _e("E-mail", WPJB_DOMAIN) ?>: <br />
        <input type="text" name="email" value="" />
    </li>
    <li>
        <input type="submit" value="<?php _e("Add Alert", WPJB_DOMAIN) ?>" />
    </li>
    <?php endif; ?>
</ul>
</form>

<?php echo $theme->after_widget ?>