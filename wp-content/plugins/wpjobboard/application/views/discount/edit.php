<?php if($form->getObject()->getId()>0): ?>
<?php $title = __("Edit Discount | ID: {id}", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $title)); ?>
<?php else: ?>
<?php $this->slot("title", __("Add Discount", WPJB_DOMAIN)); ?>
<?php endif; ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/discount"); ?>"class="button button-highlighted">
        <?php _e("Go Back", WPJB_DOMAIN) ?>
    </a>
</div>

<form action="" method="post">
    <table class="form-table">
        <tbody>
        <?php echo $form->render(); ?>
        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>

<?php $this->_include("footer.php"); ?>