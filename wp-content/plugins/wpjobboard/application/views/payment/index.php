<?php $this->slot("title", __("Payments", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<div class="clear">&nbsp;</div>

<form action="" method="post">
    <p class="search-box" style="float:left; margin-bottom: 10px">
        <label for="post-search-input" class="screen-reader-text"><?php _e("Find ID", WPJB_DOMAIN) ?>:</label>
        <input type="text" value="<?php echo esc_html($id) ?>" name="id" id="post-search-input"/>
        <input type="submit" class="button" value="<?php _e("Find ID", WPJB_DOMAIN) ?>" />
        <?php if($id > 0): ?>
        <a href="" class="button"><?php _e("Clear Search", WPJB_DOMAIN) ?></a>
        <?php endif; ?>
    </p>
</form>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
            <th style="" class="column-comments" scope="col"><?php _e("Id", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Made At", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("User", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("Payment For", WPJB_DOMAIN) ?></th>
            <th style="" class="" scope="col"><?php _e("External Id", WPJB_DOMAIN) ?></th>
            <th style="" class="column-icon" scope="col"><?php _e("To Pay", WPJB_DOMAIN) ?></th>
            <th style="" class="fixed column-icon" scope="col"><?php _e("Paid", WPJB_DOMAIN) ?></th>
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
            <td class=""><?php echo date("Y-m-d", strtotime($item->made_at)) ?></td>
            <td class="">
                <?php if($item->user_id < 1): ?>
                <?php _e("Anonymous", WPJB_DOMAIN) ?>
                <?php else: ?>
                <a href="user-edit.php?user_id=<?php echo $item->user_id ?>"><?php echo esc_html($item->getUser()->display_name." (ID: ".$item->getUser()->getId().")") ?></a>
                <?php endif; ?>
            </td>
            <td class="post-title column-title">
                <?php if($item->object_type == Wpjb_Model_Payment::FOR_JOB): ?>
                <a href="<?php echo $this->_url->linkTo("wpjb/job", "edit/id/".$item->object_id); ?>" >Job Posting #<?php echo esc_html($item->object_id) ?></a>
                <?php elseif($item->object_type == Wpjb_Model_Payment::FOR_RESUMES): ?>
                <?php _e("Resumes Access", WPJB_DOMAIN) ?>
                <?php endif; ?>
            </td>
            <td class="author column-author"><?php echo($item->engine.": ". ($item->external_id ? $item->external_id : "-")) ?></td>
            <td class="categories column-categories"><?php echo ($item->toPay()) ?></td>
            <td class="tags column-tags"><?php echo $item->paid() ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
                'base' => $this->_url->linkTo("wpjb/payment", "index/page/%_%"),
                'format' => '%#%',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => $total,
                'current' => $current
        ));
        ?>
    </div>

    <br class="clear"/>
</div>


</form>


<?php $this->_include("footer.php"); ?>