<?php $subject = __("Edit Resume (ID: {id}", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $subject)); ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/resumes"); ?>"class="button button-highlighted">
        <?php _e("Go back", WPJB_DOMAIN) ?>
    </a>
</div>

<?php if($form->getObject()->hasImage()): ?>
<form action="" method="post" id="wpjb-remove-image-form">
    <input type="hidden" name="remove_image" id="wpjb-remove-image-form-input" value="-1" />
    <input type="hidden" name="id" value="<?php echo $form->getObject()->getId() ?>" />
</form>
<?php endif; ?>
<?php if($form->getObject()->hasFile()): ?>
<form action="" method="post" id="wpjb-remove-file-form">
    <input type="hidden" name="remove_file" id="wpjb-remove-file-form-input" value="-1" />
    <input type="hidden" name="id" value="<?php echo $form->getObject()->getId() ?>" />
</form>
<?php endif; ?>

<form action="" method="post" id="wpjb-resume" class="wpjb-form" enctype="multipart/form-data">
    <table class="form-table">
        <tbody>
        <tr valign="top">
            <td colspan="2" class="wpjb-form-spacer"><h3><?php _e("Resume Information", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <tr valign="bottom">
            <th scope="row"><?php _e("Uploaded Photo", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php $object = $form->getObject(); ?>
                <?php if($object->hasImage()): ?>
                    <a id="wpjb-image-preview" target="blank" href="<?php echo $object->getImageUrl() ?>" class="button button-highlighted"><?php _e("preview", WPJB_DOMAIN) ?></a>
                    <a id="wpjb-image-remove" href="#"class="button button-highlighted"><?php _e("remove", WPJB_DOMAIN) ?></a>
                <?php else: ?>
                    <i><?php _e("no image uploaded", WPJB_DOMAIN) ?></i>
                <?php endif; ?>
            </td>
        </tr>
        <tr valign="bottom">
            <th scope="row"><?php _e("Uploaded File", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php $object = $form->getObject(); ?>
                <?php if($object->hasFile()): ?>
                    <a id="wpjb-file-preview" target="blank" href="<?php echo $object->getFileUrl() ?>" class="button button-highlighted"><?php _e("download", WPJB_DOMAIN) ?></a>
                    <a id="wpjb-file-remove" href="#"class="button button-highlighted"><?php _e("remove", WPJB_DOMAIN) ?></a>
                <?php else: ?>
                    <i><?php _e("no file uploaded", WPJB_DOMAIN) ?></i>
                <?php endif; ?>
            </td>
        </tr>


        <?php
            foreach($form->getFinalScheme() as $key => $formPart):

            if(!count($formPart["element"])) continue;
        ?>

        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php echo esc_html($formPart["title"]) ?></h3></td>
        </tr>
        <?php echo $form->renderGroup($key); ?>


        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>


<?php $this->_include("footer.php"); ?>