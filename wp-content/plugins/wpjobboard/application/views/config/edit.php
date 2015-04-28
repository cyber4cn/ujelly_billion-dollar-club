<?php $this->slot("title", __("Edit Config", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/config"); ?>"class="button button-highlighted">
        <?php _e("Go back", WPJB_DOMAIN) ?>
    </a>
</div>

<form action="" method="post">
    <table class="form-table">
        <tbody>
        <?php foreach($fList as $k => $form): ?>
        <tr valign="top">
            <td colspan="2" class="wpjb-form-spacer"><h3><?php echo $form->name; ?></h3></td>
        </tr>
        <?php echo $form->render(); ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="submit">
        <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
        <?php if($section == "integration"): ?>
        <input type="submit" value="<?php _e("Save and send test tweet", WPJB_DOMAIN) ?>" class="" name="saventest"/>
        <?php endif; ?>
    </p>

</form>

<?php $this->_include("footer.php"); ?>