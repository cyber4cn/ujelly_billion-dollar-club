<?php if($form->getObject()->getId()>0): ?>
<?php $title = __("Edit Additional Field | ID:{id}", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $title)); ?>
<?php else: ?>
<?php $this->slot("title", __("Add Additional Field", WPJB_DOMAIN)); ?>
<?php endif; ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/addField"); ?>"class="button button-highlighted">
        <?php _e("Go Back", WPJB_DOMAIN) ?>
    </a>
</div>

<script type="text/javascript">
    Wpjb.Option = <?php echo $option; ?>;
    Wpjb.TypeValue = <?php echo (int)$typeValue; ?>;
</script>

<form action="" method="post">
    <table class="form-table">
        <tbody>
        <?php echo $form->renderHidden(); ?>
        <?php echo $form->render(array("field_for", "type")); ?>
        <tr valign="top" id="wpjb-add-field-option">
            <th scope="row">
                <label for="label"><?php _e("Option", WPJB_DOMAIN) ?></label>
            </th>
            <td>
                <ul id="wpjbOptionList">
                    
                </ul>

                <input type="text" id="wpjbOptionText" />
                <input type="button" value="<?php _e("Add", WPJB_DOMAIN) ?>" name="label" id="wpjbOptionAdd"/>
            </td>
        </tr>
        <?php echo $form->render(array("validator", "label", "hint", "default_value", "is_required", "is_active")) ?>
        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>


<?php $this->_include("footer.php"); ?>