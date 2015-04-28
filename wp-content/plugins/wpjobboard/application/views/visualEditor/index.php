<?php $this->slot("title", __("Visual Editor", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<img src="<?php echo site_url()."/wp-content/plugins/wpjobboard".Wpjb_List_Path::getRawPath("admin_public") ?>/char.png" alt="" style="float:left; margin-top:40px" />

<div class="wpjb_intro">

<h3><?php _e("About Visual Editor", WPJB_DOMAIN) ?></h3>

<span>
    <p>
    <?php _e("Visual Editor is a tool that will help you reorganize some forms in admin and frontend using intuitive drag&amp;drop interface.", WPJB_DOMAIN) ?>
    </p>

    <p style="margin-bottom:40px">
        <a class="button rbutton" href="<?php echo $this->_url->linkTo("wpjb/visualEditor", "edit/form/add") ?>"><?php _e("Edit \"Add Job\" Form", WPJB_DOMAIN) ?></a>

        <a class="button rbutton" href="<?php echo $this->_url->linkTo("wpjb/visualEditor", "edit/form/apply") ?>"><?php _e("Edit \"Apply for a job\" Form", WPJB_DOMAIN) ?></a>

        <a class="button rbutton" href="<?php echo $this->_url->linkTo("wpjb/visualEditor", "edit/form/resume") ?>"><?php _e("Edit \"My Resume\" Form", WPJB_DOMAIN) ?></a>
    </p>
</span>

<h3><?php _e("What you can do with Visual Editor?", WPJB_DOMAIN) ?></h3>
<p>
    <ul>
        <li><?php _e("Drag&amp;Drop single fields as well as whole fieldsets", WPJB_DOMAIN) ?></li>
        <li><?php _e("Rename fields labels and \"hints\"", WPJB_DOMAIN) ?></li>
        <li><?php _e("Hide fields you don't want to use", WPJB_DOMAIN) ?></li>
        <li><?php _e("If you won't like the changes you can click \"Reset form layout\" button", WPJB_DOMAIN) ?></li>
    </ul>
</p>



</div>