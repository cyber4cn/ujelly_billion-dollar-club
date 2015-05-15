<?php $this->slot("title", __("User Resumes", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<form method="post" action="" id="wpjb-delete-form">
    <input type="hidden" name="delete" value="1" />
    <input type="hidden" name="id" value="" id="wpjb-delete-form-id" />
</form>

<ul class="subsubsub">
    <li><a <?php if($show == "all"): ?>class="current"<?php endif; ?> href="<?php echo $this->_url->linkTo("wpjb/resumes", "index/show/all/".$qstring) ?>"><?php _e("All", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->total ?>)</span> | </li>
    <li><a <?php if($show == "pending"): ?>class="current"<?php endif; ?>href="<?php echo $this->_url->linkTo("wpjb/resumes", "index/show/pending/".$qstring) ?>"><?php _e("Pending Approval", WPJB_DOMAIN) ?></a><span class="count">(<?php echo (int)$stat->pending ?>)</span> </li>
</ul>

<form method="post" action="" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<div class="tablenav">

<div class="alignleft actions">
    <select id="wpjb-action1">
        <option selected="selected" value="-1"><?php _e("Bulk Actions", WPJB_DOMAIN) ?></option>
        <option value="approve"><?php _e("Approve", WPJB_DOMAIN) ?></option>
        <option value="decline"><?php _e("Decline", WPJB_DOMAIN) ?></option>
    </select>

    <input type="submit" class="button-secondary action" id="wpjb-doaction1" value="<?php _e("Apply", WPJB_DOMAIN) ?>"/>

</div>

<div class="clear"/>&nbsp;</div>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
            <th style="" class="column-comments" scope="col"><?php _e("Id", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Name", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Title", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("E-mail", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Phone", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Last Update", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Status", WPJB_DOMAIN) ?></th>
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php foreach($data as $i => $item): ?>
	<tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?>  author-self status-publish iedit">
            <th class="check-column" scope="row">
                <input type="checkbox" value="<?php echo $item->getId() ?>" name="item[]"/>
            </th>
            <td class=""><?php echo $item->getId() ?></td>
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", WPJB_DOMAIN) ?>  "(<?php echo esc_html(trim($item->firstname." ".$item->lastname)) ?>)"' href="<?php echo $this->_url->linkTo("wpjb/resumes", "edit/id/".$item->getId()); ?>" class="row-title"><?php echo esc_html(trim($item->firstname." ".$item->lastname)) ?></a></strong>
                <div class="row-actions">
                    <span class="edit"><a title="<?php _e("Edit", WPJB_DOMAIN) ?>" href="<?php echo $this->_url->linkTo("wpjb/resumes", "edit/id/".$item->getId()); ?>"><?php _e("Edit", WPJB_DOMAIN) ?></a> | </span>
                    <span class="view"><a rel="permalink" title="<?php _e("View", WPJB_DOMAIN) ?>" href="<?php echo Wpjb_Project::getInstance()->getApplication("resumes")->getUrl()."/".Wpjb_Project::getInstance()->router("resumes")->linkTo("resume", $item) ?>"><?php _e("View", WPJB_DOMAIN) ?></a></span>
                </div>
            </td>
            <td class="author column-author"><?php echo esc_html($item->title) ?></td>
            <td class="categories column-categories"><?php echo $item->email ?></td>
            <td class="tags column-tags"><?php echo $item->phone ?></td>
            <td class="date column-date"><?php echo daq_time_ago_in_words(strtotime($item->updated_at))." ago" ?></td>
            <td class="date column-date">
                <?php if($item->is_approved == Wpjb_Model_Resume::RESUME_PENDING): ?>
                <?php _e("Pending Approval", WPJB_DOMAIN) ?>
                <?php elseif($item->is_approved == Wpjb_Model_Resume::RESUME_DECLINED): ?>
                <?php _e("Declined", WPJB_DOMAIN) ?>
                <?php elseif($item->is_approved == Wpjb_Model_Resume::RESUME_APPROVED): ?>
                <?php _e("Approved", WPJB_DOMAIN) ?>
                <?php else: ?>
                <?php _e("New", WPJB_DOMAIN) ?>
                <?php endif; ?>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
            'base' => $this->_url->linkTo("wpjb/resumes", "index/page/%_%"),
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
            <option value="approve"><?php _e("Approve", WPJB_DOMAIN) ?></option>
            <option value="decline"><?php _e("Decline", WPJB_DOMAIN) ?></option>
        </select>
        <input type="submit" class="button-secondary action" id="wpjb-doaction2" value="<?php _e("Apply", WPJB_DOMAIN) ?>"/>

        <br class="clear"/>
    </div>

    <br class="clear"/>
</div>


</form>

<script type="text/javascript">
    WpjbBubble.update(".wpjb-bubble-resumes", <?php echo (int)$stat->pending ?>);
</script>

<?php $this->_include("footer.php"); ?>