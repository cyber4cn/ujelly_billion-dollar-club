<?php $this->slot("title", __("Configuration", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<div class="clear">&nbsp;</div>

<table class="form-table">
    <tbody>
    <tr valign="top">
        <td colspan="2" class="wpjb-form-spacer"><h3><?php _e("Main URLs", WPJB_DOMAIN) ?></h3></td>
    </tr>
    <tr>
        <th><?php _e("Job Board URL", WPJB_DOMAIN) ?></th>
        <td>
            <a href="<?php echo wpjb_url() ?>"><?php echo wpjb_url() ?></a> &nbsp; &nbsp;
            <a class="button button-highlighted" href="post.php?post=<?php echo Wpjb_Project::getInstance()->conf("link_jobs") ?>&action=edit"><?php _e("Edit", WPJB_DOMAIN) ?></a>
        </td>
    </tr>
    <tr>
        <th><?php _e("Resumes URL", WPJB_DOMAIN) ?></th>
        <td>
            <a href="<?php echo wpjr_url() ?>"><?php echo wpjr_url() ?></a> &nbsp; &nbsp;
            <a class="button button-highlighted" href="post.php?post=<?php echo Wpjb_Project::getInstance()->conf("link_resumes") ?>&action=edit"><?php _e("Edit", WPJB_DOMAIN) ?></a>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="2" class="wpjb-form-spacer"><h3><?php _e("Config Categories", WPJB_DOMAIN) ?></h3></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    </tbody>
</table>

<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit/section/payment"); ?>"class="button button-highlighted">
            <?php _e("Edit Payment Options", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("PayPal configuration", WPJB_DOMAIN) ?>
</div>

<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit/section/posting"); ?>"class="button button-highlighted">
            <?php _e("Edit Job Posting Options", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("Jobs moderation and Twitter", WPJB_DOMAIN) ?>
</div>

<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit/section/frontend"); ?>"class="button button-highlighted">
            <?php _e("Edit Job Board Options", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("Job Board options", WPJB_DOMAIN) ?>
</div>

<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit/section/integration"); ?>"class="button button-highlighted">
            <?php _e("Edit External Integrations", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("Career Builder API key, Twitter username and pasword", WPJB_DOMAIN) ?>
</div>

<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit/section/seo"); ?>"class="button button-highlighted">
            <?php _e("Edit SEO &amp; Titles Options", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("&lt;title&gt; tag values", WPJB_DOMAIN) ?>
</div>

<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit/section/resume"); ?>"class="button button-highlighted">
            <?php _e("Edit 'Resumes' Options", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("CV module options", WPJB_DOMAIN) ?>
</div>



<div class="wpjb-buttons">
    <div style="width:200px; float:left">
        <a href="<?php echo $this->_url->linkTo("wpjb/config", "edit"); ?>"class="button button-highlighted">
            <?php _e("Edit All At Once", WPJB_DOMAIN) ?>
        </a>
    </div>
    - <?php _e("All configurations on a single page", WPJB_DOMAIN) ?>
</div>

<?php $this->_include("footer.php"); ?>