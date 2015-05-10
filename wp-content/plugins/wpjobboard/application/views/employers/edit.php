<?php $subject = __("Edit Company (ID: {id})", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $subject)); ?>
<?php $this->_include("header.php"); ?>


<?php if($form->getObject()->hasImage()): ?>
<form action="" method="post" id="wpjb-remove-image-form">
    <input type="hidden" name="remove_image" id="wpjb-remove-image-form-input" value="-1" />
    <input type="hidden" name="id" value="<?php echo $form->getObject()->getId() ?>" />
</form>
<?php endif; ?>

<form action="" method="post" class="wpjb-form" enctype="multipart/form-data">
    <table class="form-table">
        <tbody>
        <tr valign="top">
            <td colspan="2" class="wpjb-form-spacer"><h3><?php _e("Company Data", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <tr valign="bottom">
            <th scope="row"><?php _e("Uploaded Image", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php $object = $form->getObject(); ?>
                <?php if($object->hasImage()): ?>
                    <a id="wpjb-image-preview" target="blank" href="<?php echo $object->getImageUrl() ?>"class="button button-highlighted"><?php _e("preview", WPJB_DOMAIN) ?></a>
                    <a id="wpjb-image-remove" href="#"class="button button-highlighted"><?php _e("remove", WPJB_DOMAIN) ?></a>
                <?php else: ?>
                    <i><?php _e("no image uploaded", WPJB_DOMAIN) ?></i>
                <?php endif; ?>
            </td>
        </tr>
        <tr valign="bottom">
            <th scope="row"><?php _e("Company Profile Page", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <a href="<?php echo Wpjb_Project::getInstance()->getUrl()."/".Wpjb_Project::getInstance()->router("frontend")->linkTo("company", $form->getObject()) ?>"class="button button-highlighted">view profile page</a>
            </td>
        </tr>
        <tr valign="bottom">
            <th scope="row"><?php _e("Company Profile Status", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php if($object->is_active == Wpjb_Model_Employer::ACCOUNT_INACTIVE): ?>
                <?php _e("Inactive", WPJB_DOMAIN); ?>
                <?php elseif($object->is_active == Wpjb_Model_Employer::ACCOUNT_REQUEST): ?>
                <?php _e("Requested Full Actiavation", WPJB_DOMAIN); ?>
                <?php elseif($object->is_active == Wpjb_Model_Employer::ACCOUNT_DECLINED): ?>
                <?php _e("Access Declined", WPJB_DOMAIN) ?>
                <?php elseif($object->is_active == Wpjb_Model_Employer::ACCOUNT_FULL_ACCESS): ?>
                <?php _e("Full Access Granted", WPJB_DOMAIN); ?>
                <?php else: ?>
                <?php _e("Active", WPJB_DOMAIN) ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr valign="top">
            <td colspan="2" class="wpjb-form-spacer"><h3><?php _e("Company Information", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <?php echo $form->renderGroup("default"); ?>

        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>



<?php $this->_include("footer.php"); ?>