<?php $this->slot("title", __("Import source", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<div class="clear">&nbsp;</div>

<style type="text/css">
    hr.divide {
        clear:both;
        overflow:hidden;
        color:whitesmoke;
    }
    
    div.import-wrap {
        width:250px;
        height:100px;
        float:left; 
        text-align:left;
        margin-left:30px
    }
    
    div.import-desc {
        width:500px;
        margin-bottom: 10px; 
        margin-top: 0px; 
        float:left;
    }
    
    div.import-desc p {
        margin-top: 0;
    }
</style>

<div class="wpjb-buttons">
    <div class="import-wrap">
        <a href="<?php echo $this->_url->linkTo("wpjb/import", "careerbuilder"); ?>"><img src="<?php echo site_url() ?>/wp-content/plugins/wpjobboard/application/public/careerbuilder.gif" alt="" /></a>
        <br/><br/>
        <a href="<?php echo $this->_url->linkTo("wpjb/import", "careerbuilder"); ?>"class="button button-highlighted">
            <?php _e("Import Jobs ...", WPJB_DOMAIN) ?>
        </a>
    </div>
    
    <div class="import-desc">
        <p><b><?php _e("Import jobs from <a href=\"http://careerbuilder.com\">CareerBuilder.com</a> one of the biggest international job boards.", WPJB_DOMAIN) ?></b></p>
        <p><?php _e("CareerBuilder is recommended source for jobs import since it allows to download jobs along with their full descriptions.", WPJB_DOMAIN) ?></p>
        <p><?php _e("Before using CareerBuilder import please read", WPJB_DOMAIN) ?>  <a href="http://kb.wpjobboard.net/jobs-import-from-careerbuilder/"><?php _e("Guide to CareerBulder import", WPJB_DOMAIN) ?></a></p>
    </div>

</div>

<hr class="divide"/>

<div class="wpjb-buttons" style="float:left">
    <div class="import-wrap">
        <a href="<?php echo $this->_url->linkTo("wpjb/import", "indeed"); ?>"><img src="<?php echo site_url() ?>/wp-content/plugins/wpjobboard/application/public/indeed-logo.png" height="52" alt="" /></a>
        <br/><br/>
        <a href="<?php echo $this->_url->linkTo("wpjb/import", "indeed"); ?>"class="button button-highlighted">
            <?php _e("Import Jobs ...", WPJB_DOMAIN) ?>
        </a>
    </div>
    <div class="import-desc">
        <p><b><?php _e("Import jobs from <a href=\"http://indeed.com\">Indeed</a> most popular job search and aggregation site.", WPJB_DOMAIN) ?></b></p>
        <p><?php _e("Indeed is often selected as an import source because of wide selection of aggregated jobs and accurate job search. On the other hand Indeed API returns only 256 characters from the job description.", WPJB_DOMAIN) ?></p>
    </div>

</div>

<hr class="divide" />

<div class="wpjb-buttons" style="float:left">
    <div class="import-wrap">
        <a href="<?php echo $this->_url->linkTo("wpjb/import", "xml"); ?>" style="font-size:40px;text-decoration:none;font-weight: bold">&lt;XML /&gt;</a>
        <br/><br/>
        <a href="<?php echo $this->_url->linkTo("wpjb/import", "xml"); ?>"class="button button-highlighted">
            <?php _e("Import Jobs ...", WPJB_DOMAIN) ?>
        </a>
    </div>
    <div class="import-desc">
        <p><b><?php _e("Import from your own XML file", WPJB_DOMAIN) ?></b></p>
        <p><?php _e("This is the best option for users who wish to Import jobs from their database. ", WPJB_DOMAIN) ?></p>
    </div>

</div>




<?php $this->_include("footer.php"); ?>