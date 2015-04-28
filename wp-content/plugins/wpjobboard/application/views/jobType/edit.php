<?php if($form->getObject()->getId()>0): ?>
<?php $subject = __("Edit Job Type | ID: {id}", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $subject)); ?>
<?php else: ?>
<?php $this->slot("title", __("Add Job Type", WPJB_DOMAIN)); ?>
<?php endif; ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/jobType"); ?>"class="button button-highlighted">
        <?php _e("Go Back", WPJB_DOMAIN) ?>
    </a>
</div>

<form action="" method="post" class="wpjb-form">
    <table class="form-table">
        <tbody>
        <?php echo $form->render(); ?>
        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>

<?php wp_enqueue_script("wpjb-color-picker", null, null, null, true) ?>
<script type="text/javascript">
    jQuery(function() {
        jQuery("#color").val("#"+jQuery("#color").val().replace("#", ""));
        jQuery("#color").colorPicker();
        jQuery(".color_picker").after("<div class=\"color-picker-legend\"><?php _e("Click to select job type \\\"color\\\"", WPJB_DOMAIN) ?></div>");
        
        var a = jQuery("<a href=\"#\"><?php _e("reset color", WPJB_DOMAIN) ?></a>");
        a.click(function(e) {
            e.preventDefault();
            jQuery("#color").val("-1");
            jQuery(".color_picker").css("background-color", "#FFFFFF");
            return false;
        });
        jQuery(".color_picker").after(a);

    });
    
</script>

<?php $this->_include("footer.php"); ?>