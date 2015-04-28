<?php $this->slot("title", __("Edit Jobs", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/job", "edit"); ?>"class="button button-highlighted">
        <?php _e("Add New Job", WPJB_DOMAIN) ?>
    </a>
</div>

<form method="post" action="" id="wpjb-delete-form">
    <input type="hidden" name="delete" value="1" />
    <input type="hidden" name="id" value="" id="wpjb-delete-form-id" />
</form>

<script type="text/javascript">
    Wpjb.DeleteType = "<?php _e("job", WPJB_DOMAIN) ?>";
</script>

<form method="post" action="" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<?php if($employer > 0): ?>
<div class="updated fade below-h2" style="background-color: rgb(255, 251, 204);">
    <p>
        <?php _e("You are browsing jobs posted by company", WPJB_DOMAIN) ?>&nbsp;
        <strong><? echo (strlen($company->company_name)>1) ? esc_html($company->company_name) : '-' ?> (ID: <?php echo $company->getId() ?>)</strong>
        <?php _e("represented by", WPJB_DOMAIN) ?>&nbsp;<strong><?php echo esc_html($repr->display_name) ?></strong>.
        <?php _e("Click here to", WPJB_DOMAIN) ?>&nbsp;<a href="<?php echo $this->_url->linkTo("wpjb/job", "index/show/all/days/".esc_html($days)); ?>"><?php _e("browse all jobs", WPJB_DOMAIN) ?></a>.</p>
</div>
<?php endif; ?>

<ul class="subsubsub">
    <li><a <?php if($show == "all"): ?>class="current"<?php endif; ?> href="<?php echo $this->_url->linkTo("wpjb/job", "index/show/all/".$qstring) ?>"><?php _e("All", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->total ?>)</span> | </li>
    <li><a <?php if($show == "active"): ?>class="current"<?php endif; ?>href="<?php echo $this->_url->linkTo("wpjb/job", "index/show/active/".$qstring) ?>"><?php _e("Active", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->active ?>)</span> | </li>
    <li><a <?php if($show == "inactive"): ?>class="current"<?php endif; ?>href="<?php echo $this->_url->linkTo("wpjb/job", "index/show/inactive/".$qstring) ?>"><?php _e("Inactive", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->inactive ?>)</span> | </li>
    <li><a <?php if($show == "awaiting"): ?>class="current"<?php endif; ?>href="<?php echo $this->_url->linkTo("wpjb/job", "index/show/awaiting/".$qstring) ?>"><?php _e("Awaiting Approval", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->awaiting ?>)</span></li>
</ul>

<!--p class="search-box">
    <label for="post-search-input" class="hidden">Search Jobs:</label>
    <input type="text" value="" name="s" id="post-search-input" class="search-input"/>
    <input type="submit" class="button" value="Search Jobs"/>
</p-->

<div class="tablenav">

<div class="alignleft actions">
    <select id="wpjb-action1">
        <option selected="selected" value="-1"><?php _e("Bulk Actions", WPJB_DOMAIN) ?></option>
        <option value="delete"><?php _e("Delete", WPJB_DOMAIN) ?></option>
        <option value="activate"><?php _e("Activate", WPJB_DOMAIN) ?></option>
        <option value="deactivate"><?php _e("Deactivate", WPJB_DOMAIN) ?></option>
    </select>

    <input type="submit" class="button-secondary action" id="wpjb-doaction1" value="<?php _e("Apply", WPJB_DOMAIN) ?>" />

    <select name="days">
        <option value=""><?php _e("Show all dates", WPJB_DOMAIN) ?></option>
        <option <?php if($days==30): ?>selected="selected"<?php endif; ?> value="30"><?php _e("Last 30 days", WPJB_DOMAIN) ?></option>
        <option <?php if($days==7): ?>selected="selected"<?php endif; ?> value="7"><?php _e("Last 7 days", WPJB_DOMAIN) ?></option>
        <option <?php if($days==3): ?>selected="selected"<?php endif; ?> value="3"><?php _e("Last 3 days", WPJB_DOMAIN) ?></option>
        <option <?php if($days==2): ?>selected="selected"<?php endif; ?> value="2"><?php _e("Since yesterday", WPJB_DOMAIN) ?></option>
        <option <?php if($days==1): ?>selected="selected"<?php endif; ?> value="1"><?php _e("Today", WPJB_DOMAIN) ?></option>
    </select>
<!--
    <select class="postform" id="cat" name="cat">
        <option value="0">View all categories</option>
    </select>
-->
    <input type="submit" class="button-secondary" value="<?php _e("Filter", WPJB_DOMAIN) ?>" id="post-query-submit"/>

</div>

<div class="clear"/>&nbsp;</div>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
            <th style="width:250px" class="" scope="col"><?php _e("Position Title", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Category", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Job Type", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Price", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Paid", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Created", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Expires", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Applicants", WPJB_DOMAIN) ?></th>
            <th style="" class="fixed column-icon" scope="col"><?php _e("Active", WPJB_DOMAIN) ?></th>
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php foreach($data as $i => $item): ?>
	<tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?> author-self status-publish iedit">
            <th class="check-column" scope="row">
                <input type="checkbox" value="<?php echo $item->getId() ?>" name="item[]"/>
            </th>
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", WPJB_DOMAIN) ?>  "(<?php echo esc_html($item->job_title) ?>)"' href="<?php echo $this->_url->linkTo("wpjb/job", "edit/id/".$item->getId()); ?>" class="row-title"><?php echo esc_html($item->job_title) ?></a></strong>
                <div class="row-actions">
                    <span><a href="<?php echo Wpjb_Project::getInstance()->getUrl()."/".Wpjb_Project::getInstance()->router("frontend")->linkTo("job", $item) ?>"><?php _e("View", WPJB_DOMAIN) ?></a> | </span>
                    <span class="edit"><a title="<?php _e("Edit", WPJB_DOMAIN) ?>" href="<?php echo $this->_url->linkTo("wpjb/job", "edit/id/".$item->getId()); ?>"><?php _e("Edit", WPJB_DOMAIN) ?></a> | </span>
                    <span class=""><a href="<?php echo wpjb_link_to("step_add") ?>republish/<?php echo $item->getId() ?>" title="<?php _e("Clone", WPJB_DOMAIN) ?>" class=""><?php _e("Clone", WPJB_DOMAIN) ?></a> | </span>
                    <span class=""><a href="#<?php echo $item->getId() ?>" title="<?php _e("Delete", WPJB_DOMAIN) ?>" class="wpjb-delete"><?php _e("Delete", WPJB_DOMAIN) ?></a> | </span>
                </div>
            </td>
            <td class="author column-author"><?php echo esc_html($item->getCategory()->title) ?></td>
            <td class="author column-author"><?php echo esc_html($item->getType()->title) ?></td>
            <td class="categories column-categories">
                <?php echo ($item->payment_sum>0) ? $item->paymentAmount() : __('<i>free</i>', WPJB_DOMAIN) ?>
            </td>
            <td class="date column-date">
                <?php echo ($item->payment_sum>0) ? $item->paymentpaid() : __('<i>n/a</i>', WPJB_DOMAIN) ?>
            </td>
            <td class="date column-date">
                <?php echo daq_time_ago_in_words(strtotime($item->job_created_at)) ?>&nbsp;<?php _e("ago", WPJB_DOMAIN) ?>
            </td>
            <td class="date column-date">
                <?php echo ($item->expiresAt() === null) ? __("<i>never</i>", WPJB_DOMAIN) : $item->expiresAt(true) ?>
            </td>
            <td class="date column-date">
                <a href="<?php esc_attr_e($this->_url->linkTo("wpjb/application", "index/job/".$item->id)) ?>"><?php esc_html_e($item->stat_apply) ?></a>
            </td>
            <td class="date column-date">
                <?php echo ($item->is_active) ? _e("Yes", WPJB_DOMAIN) : _e("No", WPJB_DOMAIN) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
                'base' => $this->_url->linkTo("wpjb/job", "index/page/%_%/show/".esc_html($show)."/".$qstring),
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
            <!--option value="approve"><?php _e("Approve", WPJB_DOMAIN) ?></option-->
        </select>
        <input type="submit" class="button-secondary action" id="wpjb-doaction2" value="<?php _e("Apply", WPJB_DOMAIN) ?>"/>

        <br class="clear"/>
    </div>

    <br class="clear"/>
</div>


</form>

<script type="text/javascript">
    WpjbBubble.update(".wpjb-bubble-jobs", <?php echo (int)$stat->awaiting ?>);
</script>

<?php $this->_include("footer.php"); ?>