<?php $this->slot("title", __("Applications", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<form method="post" action="" id="wpjb-delete-form">
    <input type="hidden" name="delete" value="1" />
    <input type="hidden" name="id" value="" id="wpjb-delete-form-id" />
</form>

<script type="text/javascript">
    Wpjb.DeleteType = "application";
</script>

<form method="post" action="" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<?php if($job): ?>
<div class="updated fade below-h2" style="background-color: rgb(255, 251, 204);">
    <p>
        <?php _e("You are browsing applications for job", WPJB_DOMAIN) ?>&nbsp;
        <strong><?php esc_html_e($job->job_title) ?> (ID: <?php echo esc_html($job->getId()) ?>)</strong>.
        <?php _e("Click here to", WPJB_DOMAIN) ?>&nbsp;<a href="<?php echo $this->_url->linkTo("wpjb/application", "index"); ?>"><?php _e("browse all applications", WPJB_DOMAIN) ?></a>.</p>
</div>
<?php endif; ?>

<div class="tablenav">

<div class="alignleft actions">
    <select id="wpjb-action1">
        <option selected="selected" value="-1">Bulk Actions</option>
        <option value="delete">Delete</option>
        <option value="activate">Activate</option>
        <option value="deactivate">Deactivate</option>
    </select>

    <input type="submit" class="button-secondary action" id="wpjb-doaction1" value="Apply"/>

</div>

<div class="clear"/>&nbsp;</div>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
            <th style="width:250px" class="" scope="col"><?php _e("Applicant Name", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Applicant Email", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Job", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Files", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Freshness", WPJB_DOMAIN) ?></th>
            <!--th style="" class="fixed column-icon" scope="col">Active</th-->
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php foreach($data as $i => $item): ?>
	<tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?>  author-self status-publish iedit">
            <th class="check-column" scope="row">
                <input type="checkbox" value="<?php esc_attr_e($item->getId()) ?>" name="item[]"/>
            </th>
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", WPJB_DOMAIN) ?>  "(<?php esc_attr_e($item->applicant_name) ?>)"' href="<?php echo $this->_url->linkTo("wpjb/application", "edit/id/".$item->getId()); ?>" class="row-title"><?php esc_html_e($item->applicant_name) ?></a></strong>
                <div class="row-actions">
                    <span><a href="<?php echo Wpjb_Project::getInstance()->getUrl()."/".Wpjb_Project::getInstance()->router("frontend")->linkTo("job_application", $item) ?>"><?php _e("Preview", WPJB_DOMAIN) ?></a> | </span>
                    <span class="edit"><a title="<?php _e("Edit", WPJB_DOMAIN) ?>" href="<?php echo $this->_url->linkTo("wpjb/application", "edit/id/".$item->getId()); ?>"><?php _e("Edit", WPJB_DOMAIN) ?></a> | </span>
                    <span class=""><a href="#<?php echo $item->getId() ?>" title="<?php _e("Delete", WPJB_DOMAIN) ?>" class="wpjb-delete"><?php _e("Delete", WPJB_DOMAIN) ?></a> | </span>
                </div>
            </td>

            <td class="date column-date">
                <a href="mailto:<?php esc_attr_e($item->email) ?>"><?php esc_attr_e($item->email) ?></a>
            </td>
            <td class="date column-date">
                <a href="<?php esc_attr_e($this->_url->linkTo("wpjb/job", "edit/id/".$item->getJob()->getId())) ?>"><?php esc_attr_e($item->getJob()->job_title) ?> (ID: <?php esc_html_e($item->getJob()->getId()) ?>)</a>
            </td>
            <td class="date column-date">
                <?php esc_html_e(count($item->getFiles())) ?>
            </td>
            <td class="date column-date">
                <?php esc_html_e(daq_time_ago_in_words(strtotime($item->applied_at))) ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
                'base' => $this->_url->linkTo("wpjb/application", "index/page/%_%/show/".esc_html($show)."/".$qstring),
                'format' => '%#%',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => $total,
                'current' => $current
        ));
        ?>
    </div>


    <div class="alignleft actions">
        <select id="wpjb-action2">
            <option selected="selected" value="-1"><?php _e("Bulk Actions", WPJB_DOMAIN) ?></option>
            <option value="delete"><?php _e("Delete", WPJB_DOMAIN) ?></option>
            <option value="activate"><?php _e("Activate", WPJB_DOMAIN) ?></option>
            <option value="deactivate"><?php _e("Deactivate", WPJB_DOMAIN) ?></option>
        </select>
        <input type="submit" class="button-secondary action" id="wpjb-doaction2" value="<?php _e("Apply", WPJB_DOMAIN) ?>" />

        <br class="clear"/>
    </div>

    <br class="clear"/>
</div>


</form>


<?php $this->_include("footer.php"); ?>