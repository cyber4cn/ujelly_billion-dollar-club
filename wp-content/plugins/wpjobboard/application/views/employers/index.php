<?php $this->slot("title", __("Employers List", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>


<form method="post" action="" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<?php if(Wpjb_Project::getInstance()->conf("cv_access")==2): ?>
<ul class="subsubsub">
    <li><a <?php if($show == "all"): ?>class="current"<?php endif; ?> href="<?php echo $this->_url->linkTo("wpjb/employers", "index/show/all/".$qstring) ?>"><?php _e("All", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->total ?>)</span> | </li>
    <li><a <?php if($show == "pending"): ?>class="current"<?php endif; ?>href="<?php echo $this->_url->linkTo("wpjb/employers", "index/show/pending/".$qstring) ?>"><?php _e("Requesting Approval", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->pending ?>)</span> </li>
</ul>
<?php endif; ?>

<div class="tablenav">

<div class="alignleft actions">
    <select id="wpjb-action1">
        <option selected="selected" value="-1"><?php _e("Bulk Actions", WPJB_DOMAIN) ?></option>
        <option value="activate"><?php _e("Activate", WPJB_DOMAIN) ?></option>
        <option value="deactivate"><?php _e("Deactivate", WPJB_DOMAIN) ?></option>
        <?php if(Wpjb_Project::getInstance()->conf("cv_access")==2): ?>
        <option value="approve"><?php _e("Approve", WPJB_DOMAIN) ?></option>
        <option value="decline"><?php _e("Decline", WPJB_DOMAIN) ?></option>
        <?php endif; ?>
    </select>

    <input type="submit" class="button-secondary action" id="wpjb-doaction1" value="<?php _e("Apply", WPJB_DOMAIN) ?>" />

</div>

<div class="clear"/>&nbsp;</div>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
            <th style="" class="column-comments" scope="col"><?php _e("Id", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Company Name", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Company Location", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Representative", WPJB_DOMAIN) ?></th>
            <th style="" class="fixed column-icon" scope="col"><?php _e("Jobs Posted", WPJB_DOMAIN) ?></th>
            <th style="" class="fixed column-icon" scope="col"><?php _e("Active", WPJB_DOMAIN) ?></th>
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php foreach($data as $i => $item): ?>
        <?php $user = $item->getUsers(); ?>
	<tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?>  author-self status-publish iedit">
            <th class="check-column" scope="row">
                <input type="checkbox" value="<?php echo $item->getId() ?>" name="item[]"/>
            </th>
            <td class=""><?php echo $item->getId() ?></td>
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", WPJB_DOMAIN) ?>  "(<?php echo esc_html($item->company_name) ?>)"' href="<?php echo $this->_url->linkTo("wpjb/employers", "edit/id/".$item->getId()); ?>" class="row-title"><?php echo (strlen($item->company_name)<1) ? '<i>'.__("not set", WPJB_DOMAIN).'</i>' : esc_html($item->company_name) ?></a></strong>
                <div class="row-actions">
                    <span class="edit"><a title="<?php _e("Edit", WPJB_DOMAIN) ?>" href="<?php echo $this->_url->linkTo("wpjb/employers", "edit/id/".$item->getId()); ?>"><?php _e("Edit", WPJB_DOMAIN) ?></a> | </span>
                    <span class="view"><a rel="permalink" title="<?php _e("View Profile", WPJB_DOMAIN) ?>" href="<?php echo Wpjb_Project::getInstance()->getUrl()."/".Wpjb_Project::getInstance()->router("frontend")->linkTo("company", $item); ?>"><?php _e("View Profile", WPJB_DOMAIN) ?></a> | </span>
                    <span class="view"><a rel="permalink" title="<?php _e("View Jobs", WPJB_DOMAIN) ?>" href="<?php echo $this->_url->linkTo("wpjb/job", "index/employer/".$item->getId()); ?>"><?php _e("View Jobs", WPJB_DOMAIN) ?></a></span>
                </div>
            </td>
            <td class="author column-author"><?php echo (strlen($item->company_location)<1) ? "-" : esc_html($item->company_location) ?></td>
            <td class="author column-author"><strong><a href="user-edit.php?user_id=<?php echo $user->ID ?>"><?php echo esc_html($user->display_name." (ID: ".$user->ID.")") ?></a></strong></td>
            <td class="categories column-categories"><?php echo $item->jobs_posted ?></td>
            <td class="date column-date"><?php echo $item->is_active ? __("Yes", WPJB_DOMAIN) : __("NO", WPJB_DOMAIN)  ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
            'base' => $this->_url->linkTo("wpjb/employers", "index/page/%_%"),
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
            <option value="activate"><?php _e("Activate", WPJB_DOMAIN) ?></option>
            <option value="deactivate"><?php _e("Deactivate", WPJB_DOMAIN) ?></option>
            <?php if(Wpjb_Project::getInstance()->conf("cv_access")==2): ?>
            <option value="approve"><?php _e("Approve", WPJB_DOMAIN) ?></option>
            <option value="decline"><?php _e("Decline", WPJB_DOMAIN) ?></option>
            <?php endif; ?>
        </select>
        <input type="submit" class="button-secondary action" id="wpjb-doaction2" value="<?php _e("Apply", WPJB_DOMAIN) ?>" />

        <br class="clear"/>
    </div>

    <br class="clear"/>
</div>


</form>

<script type="text/javascript">
    WpjbBubble.update(".wpjb-bubble-companies", <?php echo (int)$stat->pending ?>);
</script>

<?php $this->_include("footer.php"); ?>