<?php $this->slot("title", __("Visual Editor", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<style type="text/css">
#wpjb-sort-space { width: 600px; float:left }
.wpjb-sort-visible { visibility: visible !important}
.wpjb-sort-conf { display:block; float:right; visibility: hidden}
.wpjb-ribbon { border: 1px dashed silver !important; }
#wpjb-sort-groups .wpjb-drop-target { border:2px silver dashed !important; height: 40px }
#wpjb-sort-groups li {border: 1px dashed transparent; }
#wpjb-sort-groups li div.wpjb-group-form { padding: 5px; font-weight: bold; }
#wpjb-sort-groups li h5 { display:block; width:95%; font-size: 1.4em; cursor: move; padding:5px; margin:0 }
#wpjb-sort-groups li h5 a { display:block; float:right; visibility: hidden; font-weight:normal }
#wpjb-sort-groups li ul.wpjb-sort-items { padding: 5px }
#wpjb-sort-groups li ul.wpjb-sort-items strong { display:block; width:100%; border-bottom: 2px; border-color: black }
#wpjb-sort-groups li ul.wpjb-sort-items li { border: 1px solid silver; padding: 5px; background-color:white }
#wpjb-sort-groups li ul.wpjb-sort-items li:hover { border: 1px dashed silver; cursor: move }

</style>

<script type="text/javascript">

var WpjbVisualEditor = {
    
    init: function() {

        jQuery(function() {
            
            jQuery("#wpjb-sort-groups").sortable({
               handle: "h5",
               opacity: 0.5,
               stop: WpjbVisualEditor.reorder
            });

            jQuery("#wpjb-sort-groups .wpjb-sort-items").sortable({
               connectWith: '.wpjb-sort-items',
               opacity: 0.5,
               placeholder: 'wpjb-drop-target',
               stop: WpjbVisualEditor.reorder
            });

            jQuery(".wpjb-sort-item").hover(function(){
                jQuery(this).find("a.wpjb-sort-conf").addClass("wpjb-sort-visible");
            }, function() {
                jQuery(this).find("a.wpjb-sort-conf").removeClass("wpjb-sort-visible");
            });
            
            jQuery("#wpjb-sort-groups h5").hover(function(){
                jQuery(this).find("a").addClass("wpjb-sort-visible");
                jQuery(this).parent().addClass("wpjb-ribbon");
            }, function() {
                jQuery(this).find("a").removeClass("wpjb-sort-visible");
                jQuery(this).parent().removeClass("wpjb-ribbon");
            });

            jQuery("#wpjb-sort-groups table").css("display", "none");
            jQuery("#wpjb-sort-groups .wpjb-group-form").css("display", "none");

            jQuery("#wpjb-sort-groups .wpjb-preview a.wpjb-sort-conf").click(function() {
                var wrap = jQuery(this).parent().parent();

                wrap.find("div.wpjb-preview").css("display", "none");
                wrap.find("table").css("display", "table");

                return false;
            });

            jQuery("#wpjb-sort-groups input.wpjb-sort-ok").click(function() {
                var wrap = jQuery(this).parents("li.wpjb-sort-item");
                var name = jQuery(this).attr("name");

                wrap.find(".wpjb-field-label").text(jQuery("#"+name+"_label").val());
                wrap.find(".wpjb-field-hint").text(jQuery("#"+name+"_hint").val());

                var req = "No";
                if(jQuery("#"+name+"_required:checked").val() == 1) {
                    req = "Yes";
                }

                var vis = "No";
                if(jQuery("#"+name+"_visible:checked").val() == 1) {
                    vis = "Yes";
                }

                wrap.find(".wpjb-field-required").text(req);
                wrap.find(".wpjb-field-visible").text(vis);

                wrap.find("div.wpjb-preview").css("display", "block");
                wrap.find("table").css("display", "none");
                return false;
            });

            jQuery("#wpjb-sort-groups h5 a.wpjb-group-edit").click(function() {
                var wrap = jQuery(this).parents("li");

                wrap.find("h5").css("display", "none");
                wrap.find("ul.wpjb-sort-items").css("display", "none");
                wrap.find("div.wpjb-group-form").css("display", "block");

                return false;
            });

            jQuery("#wpjb-sort-groups input.wpjb-group-ok").click(function() {
                var wrap = jQuery(this).parents("li");

                wrap.find("h5").css("display", "block");
                wrap.find("ul.wpjb-sort-items").css("display", "block");
                wrap.find("div.wpjb-group-form").css("display", "none");

                var value = wrap.find("div.wpjb-group-form input[type=text]").val();
                wrap.find("h5 span").text(value);

                return false;
            });

            jQuery("#wpjb-layout-save").click(function() {
                jQuery("#wpjb-sort-groups .wpjb-sort-items input").each(function(i) {
                    var input = jQuery(this);
                    var gName = input.parents("ul.wpjb-sort-items").find("input.wpjb-group-name").val();
                    var newVal = input.attr("name").replace("#group#", gName);
                    input.attr("name", newVal);
                });
            });

            WpjbVisualEditor.reorder();

        })
    },

    reorder: function() {
        jQuery("#wpjb-sort-groups input.wpjb-group-order").each(function(i, input) {
           jQuery(input).val(i);
        });
        jQuery("#wpjb-sort-groups input.wpjb-item-order").each(function(i, input) {
           jQuery(input).val(i);
        });
    }
};

</script>


<div id="wpjb-sort-space">

    <div class="wpjb-buttons">
        <a href="<?php echo $this->_url->linkTo("wpjb/visualEditor"); ?>"class="button button-highlighted">
            <?php _e("Go back", WPJB_DOMAIN) ?>
        </a>
    </div>

    <form action="" method="post">
    <ul id="wpjb-sort-groups">
        <?php foreach($scheme as $gName => $s): ?>
        <li>

            <h5><span><?php echo esc_html($s["title"]) ?></span> <a class="wpjb-group-edit" href=""><?php _e("configure", WPJB_DOMAIN) ?></a></h5>

            <div class="wpjb-group-form wpjb-ribbon">
                <?php _e("Group name", WPJB_DOMAIN) ?>: 
                <input type="text" name="group[<?php echo $gName ?>][title]" value="<?php echo esc_html($s["title"]) ?>" />
                <input type="hidden" class="wpjb-group-order" name="group[<?php echo $gName ?>][order]" value="" />
                <input class="button-primary wpjb-group-ok" value="<?php _e("Ok", WPJB_DOMAIN) ?>" type="button" />
            </div>

            <ul class="wpjb-sort-items">
                <input class="wpjb-group-name" type="hidden" name="input_<?php echo $gName ?>" value="<?php echo $gName ?>" />
                <?php foreach((array)$s["element"] as $element): ?>
                <?php $name = $element["name"]; ?>
                <?php $gName = "#group#"; ?>

                <li class="wpjb-sort-item">
                    <div class="wpjb-preview">
                        <a href="#" class="wpjb-sort-conf"><?php _e("configure", WPJB_DOMAIN) ?></a>
                        <strong class="wpjb-field-label"><?php echo esc_html($element["label"]) ?></strong>
                        <i class="wpjb-field-hint"><?php echo esc_html($element["hint"]) ?></i><br />
                        <?php _e("Is required", WPJB_DOMAIN) ?>: <span class="wpjb-field-required"><?php echo $element["required"] ? __("Yes", WPJB_DOMAIN) : __("No", WPJB_DOMAIN) ?></span> |
                        <?php _e("Is visible", WPJB_DOMAIN) ?>: <span class="wpjb-field-visible"><?php echo $element["visible"] ? __("Yes", WPJB_DOMAIN) : __("No", WPJB_DOMAIN) ?></span>
                    </div>
                    
                    <input type="hidden" name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][name]" value="<?php echo esc_html($element["name"]) ?>" />
                    <input type="hidden" class="wpjb-item-order" name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][order]" value="" />
                    <?php if(in_array($element["name"], $forced)): ?>
                    <input name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][visible]" id="<?php echo $name ?>_visible" class="code" value="1" type="hidden" />
                    <?php endif; ?>

                    <table>
                        <tbody>
                        <tr class="form-field form-required">
                                <td scope="row"><label for="<?php echo $name ?>_label"><?php _e("Label", WPJB_DOMAIN) ?>  </label></td>
                                <td><input name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][label]" id="<?php echo $name ?>_label" value="<?php echo esc_html($element["label"]) ?>" type="text" /></td>
                        </tr>
                        <tr class="form-field">
                                <td scope="row"><label for="<?php echo $name ?>_hint"><?php _e("Hint", WPJB_DOMAIN) ?>  </label></td>
                                <td><input name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][hint]" id="<?php echo $name ?>_hint" value="<?php echo esc_html($element["hint"]) ?>" type="text" /></td>
                        </tr>
                        <tr class="form-field">
                                <td scope="row"><label for="<?php echo $name ?>_required"><?php _e("Is Required", WPJB_DOMAIN) ?>  </label></td>
                                <td><input name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][required]" id="<?php echo $name ?>_required" value="1" type="checkbox" <?php echo $element["required"] ? 'checked="checked"' : '' ?> /></td>
                        </tr>
                        <?php if(!in_array($element["name"], $forced)): ?>
                        <tr class="form-field">
                                <td scope="row"><label for="<?php echo $name ?>_visible"><?php _e("Is Visible", WPJB_DOMAIN) ?>  </label></td>
                                <td><input name="group[<?php echo $gName ?>][element][<?php echo $element["name"] ?>][visible]" id="<?php echo $name ?>_visible" class="code" value="1" type="checkbox" <?php echo $element["visible"] ? 'checked="checked"' : '' ?> /></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input name="<?php echo $name ?>" class="button-primary wpjb-sort-ok" value="<?php _e("Ok", WPJB_DOMAIN) ?>" type="button" />
                        </td>
                        </tr>
                        </tbody>
                    </table>

                </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endforeach; ?>
    </ul>

    <input name="submit" id="wpjb-layout-save" class="button-primary" value="<?php _e("Save form layout", WPJB_DOMAIN) ?>" type="submit" />
    <input name="reset" id="wpjb-layout-save" class="secondary-primary" value="<?php _e("Reset form layout", WPJB_DOMAIN) ?>" type="submit" />

    </form>
</div>

<script type="text/javascript">

WpjbVisualEditor.init();

</script>

<?php $this->_include("footer.php"); ?>