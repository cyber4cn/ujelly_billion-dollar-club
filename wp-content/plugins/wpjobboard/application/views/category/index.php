<?php $this->slot("title", __("Category List", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/category", "edit"); ?>"class="button button-highlighted">
        <?php _e("Add New Category", WPJB_DOMAIN) ?>
    </a>
</div>

<form method="post" action="" id="wpjb-delete-form">
    <input type="hidden" name="delete" value="1" />
    <input type="hidden" name="id" value="" id="wpjb-delete-form-id" />
</form>

<script type="text/javascript">
    Wpjb.DeleteType = "<?php _e("category", WPJB_DOMAIN) ?>";
</script>

<form method="post" action="" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<div class="tablenav">

<div class="alignleft actions">
    <select id="wpjb-action1">
        <option selected="selected" value="-1"><?php _e("Bulk Actions", WPJB_DOMAIN) ?></option>
        <option value="delete"><?php _e("Delete", WPJB_DOMAIN) ?></option>
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
            <th style="" class="" scope="col"><?php _e("Title", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Slug", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Description", WPJB_DOMAIN) ?></th>
            <th style="" class="column-icon" scope="col"><?php _e("Total Jobs", WPJB_DOMAIN) ?></th>
            <th style="" class="fixed column-icon" scope="col"><?php _e("Active Jobs", WPJB_DOMAIN) ?></th>
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php foreach($data as $i => $item): ?>
	<tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?> author-self status-publish iedit">
            <th class="check-column" scope="row">
                <input type="checkbox" value="<?php echo $item->getId() ?>" name="item[]" <?php if($item->helper->c_all>0): ?>class="wpjb_disabled"<?php endif; ?> />
            </th>
            <td class=""><?php echo $item->getId() ?></td>
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", WPJB_DOMAIN) ?>  "(<?php echo esc_html($item->title) ?>)"' href="<?php echo $this->_url->linkTo("wpjb/category", "edit/id/".$item->getId()); ?>" class="row-title"><?php echo esc_html($item->title) ?></a></strong>
                <div class="row-actions">
                    <span class="edit"><a title="<?php _e("Edit", WPJB_DOMAIN) ?>" href="<?php echo $this->_url->linkTo("wpjb/category", "edit/id/".$item->getId()); ?>"><?php _e("Edit", WPJB_DOMAIN) ?></a> | </span>
                    <span class=""><a href="#<?php echo $item->getId() ?>" title="<?php _e("Delete", WPJB_DOMAIN) ?>" class="wpjb-delete"><?php _e("Delete", WPJB_DOMAIN) ?></a> | </span>
                    <span class="view"><a rel="permalink" title="<?php _e("View", WPJB_DOMAIN) ?>" href="<?php echo Wpjb_Project::getInstance()->getUrl()."/".Wpjb_Project::getInstance()->router("frontend")->linkTo("category", $item) ?>"><?php _e("View", WPJB_DOMAIN) ?></a></span>
                </div>
            </td>
            <td class="author column-author"><?php echo esc_html($item->slug) ?></td>
            <td class="categories column-categories"><?php echo(substr(esc_html($item->description), 0, 120)) ?></td>
            <td class="tags column-tags"><?php echo $item->helper->c_all ?></td>
            <td class="date column-date"><?php echo $item->helper->c_active ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
                'base' => $this->_url->linkTo("wpjb/category", "index/page/%_%"),
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
        </select>
        <input type="submit" class="button-secondary action" id="wpjb-doaction2" value="<?php _e("Apply", WPJB_DOMAIN) ?>" />

        <br class="clear"/>
    </div>

    <br class="clear"/>
</div>


</form>

<?php $this->_include("footer.php"); ?>