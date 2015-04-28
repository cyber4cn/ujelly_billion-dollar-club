var WpjbVE = {
    
    Init: function() {

    }
};

var WpjbDashboard = {
    
    previousPoint: null,
    
    _tmp: null,
    
    Init: function() {
        jQuery(function() {
            if(jQuery("#wpjb_dashboard_currency option").length < 2) {
                jQuery("#wpjb_dashboard_currency").hide();
            }
            jQuery("#wpjb_dashboard_period").change(function() {
                WpjbDashboard.load();
            });
            jQuery("#wpjb_dashboard_currency").change(function() {
                WpjbDashboard.load();
            });
            
            WpjbDashboard.load();
            
            jQuery("#wpjb_dashboard_placeholder").bind("plothover", function (event, pos, item) {
                if (item) {
                    if (WpjbDashboard.previousPoint != item.dataIndex) {
                        WpjbDashboard.previousPoint = item.dataIndex;

                        jQuery("#tooltip").remove();
                        var x = item.datapoint[0];
                        var xValue = "";
                        var y = item.datapoint[1];

                        var i = 0;
                        for(i in WpjbDashboard._tmp.info.tick) {
                            if(WpjbDashboard._tmp.info.tick[i][0] == x) {
                                xValue = WpjbDashboard._tmp.info.tick[i][1];
                            }
                        }
                        
                        if(item.seriesIndex == 1) {
                            y = WpjbDashboard._tmp.info.symbol+y.toFixed(2);
                        } 
                        

                        WpjbDashboard.tooltip(
                            item.pageX, 
                            item.pageY,
                            xValue+"<br/>"+item.series.label+": "+y
                        );
                    }
                }
                else {
                    jQuery("#tooltip").remove();
                    WpjbDashboard.previousPoint = null;            
                }
            });
        });     
    },
    
    load: function() {
        jQuery.ajax({
            type: "POST",
            url: "admin-ajax.php",
            dataType: "json",
            data: {
                action: "wpjb_dashboard_stats",
                currency: jQuery("#wpjb_dashboard_currency").val(),
                stats: jQuery("#wpjb_dashboard_period").val()
            },
            success: WpjbDashboard.loaded
        });
    },
    
    loaded: function(json) {
        jQuery.plot(jQuery("#wpjb_dashboard_placeholder"), json.data, json.options);
        
        var symbol = json.info.symbol;
        var jobP = (json.info.jobs/json.info.orders*100).toFixed(2);
        var resP = (json.info.resumes/json.info.orders*100).toFixed(2);
        
        jQuery("#wpjb_dashboard_info_revenue").text(symbol+json.info.volume.toFixed(2));
        jQuery("#wpjb_dashboard_info_orders").text(json.info.orders);
        jQuery("#wpjb_dashboard_info_job").text(jobP+"%");
        jQuery("#wpjb_dashboard_info_resumes").text(resP+"%");
        
        WpjbDashboard._tmp = json;
    },
    
    tooltip: function (x, y, contents) {
        jQuery('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #9F9FAF',
            padding: '4px',
            'background-color': '#DFDFDF',
            opacity: "0.8",
            'font-size': "12px",
            'font-family': "Arial",
            'color': "#464646",
            'line-height': '1.2em'
        }).appendTo("body").fadeIn(200);
    }
}

var Wpjb = {
	Ajax: "admin-ajax.php",
	
    DeleteType: "item",

    Option: null,

    JobState: null,

    Id: 0,

    InsertField: function(object) {

        var option = jQuery("#wpjbOptionText");
        var list = jQuery("#wpjbOptionList");

        var value = object.value;
        if(value.replace(" ", "").length == 0) {
            alert(WpjbAdminLang.addField_empty);
            return false;
        }

        if(value.length >= 120) {
            alert(WpjbAdminLang.addField_120);
            return false;
        }

        var key = "";
        if(object.id) {
            key = "id_"+object.id;
        }

        var input = jQuery('<input type="text" />')
            .attr("name", "option["+key+"]")
            .attr("value", object.value);

        var a = jQuery('<a></a>')
            .attr("href", "#")
            .append(WpjbAdminLang.addField_remove)
            .bind("click", function() {
                var a = jQuery(this);
                a.parent().remove();
                return false;
            });

        var li = jQuery('<li></li>')
            .hide()
            .append(input)
            .append(" ")
            .append(a);

        list.append(li);
        li.show("slow");
        option.val("");

        return false;
    },

    InitSlugUI: function(id) {
        var modifySlug = jQuery('<a class="button button-highlighted" href="#">'+WpjbAdminLang.slug_save+'</a>')
            .attr("id", "wpjb-save-slug")
            .attr("class", "button button-highlighted")
            .css("display", "none")
            .click(function() {
                var save = jQuery(this);
                var cancel = jQuery("#wpjb-cancel-slug");
                var change = jQuery("#wpjb-change-slug");

                jQuery("#"+id).attr("readonly", "readonly");

                cancel.css("display", "none");
                cancel.removeAttr("hold");
                change.css("display", "inline");
                save.css("display", "none");
                return false;
            });

        var cancelSlug = jQuery('<a href="#">'+WpjbAdminLang.slug_cancel+'</a>')
            .attr("id", "wpjb-cancel-slug")
            .attr("class", "button button-highlighted")
            .css("display", "none")
            .click(function() {
                var save = jQuery("#wpjb-save-slug");
                var cancel = jQuery(this);
                var change = jQuery("#wpjb-change-slug");

                jQuery("#"+id)
                    .attr("readonly", "readonly")
                    .attr("value", cancel.attr("hold"));

                cancel.css("display", "none");
                cancel.removeAttr("hold");
                change.css("display", "inline");
                save.css("display", "none");
                return false;
            });

        var changeSlug = jQuery('<a href="#">'+WpjbAdminLang.slug_change+'</a>')
            .attr("class", "button button-highlighted")
            .attr("id", "wpjb-change-slug")
            .click(function() {
                var save = jQuery("#wpjb-save-slug");
                var cancel = jQuery("#wpjb-cancel-slug");
                var change = jQuery(this);

                change.css("display", "none");
                save.css("display", "inline");
                cancel.css("display", "inline");
                cancel.attr("hold", jQuery("#"+id).val());

                jQuery("#"+id).removeAttr("readonly");
                return false;
            });


        var slug = jQuery("#"+id);
        slug
            .attr("readonly", "readonly")
            .after(changeSlug)
            .after(modifySlug)
            .after(cancelSlug);
    },

    Slugify: function(domId, title, object, id) {

        var data = {
            action: 'wpjb_main_slugify',
            object: object,
            title: title,
            id: id
	};

	jQuery.post("admin-ajax.php", data, function(response) {
            jQuery("#"+domId).val(response);
	});

    },

    ChartLoaded: function() {

        jQuery("#stats_draw")
            .bind("click", function() {
                Wpjb.ChartDraw();
                return false;
            })
            .html("draw chart");

    },

    ChartDraw: function() {

        var request = {
            action: "wpjb_stats_index",
            chart: jQuery("#stats_type").val(),
            start: jQuery("#stats_start").val(),
            end: jQuery("#stats_end").val()
        }


	jQuery.post("admin-ajax.php", request, function(response) {
            var data = new google.visualization.DataTable();
            eval("var json = "+response);

            var chart = json.chart;
            var type = "string";
            for(var i in chart.meta) {
                data.addColumn(type, chart.meta[i]);
                type = "number";
            }

            data.addRows(chart.data.length);
            for(i in chart.data) {
                data.setValue(parseInt(i), 0, chart.data[0].date);
                for(var j in chart.data[i].data) {
                    data.setValue(parseInt(i), j+1, parseInt(chart.data[i].data[j]));
                }
            }

            chart = new google.visualization.ImageLineChart(document.getElementById('wpjb-chart'));
            chart.draw(data, {width: 600, height: 240, min: 0});
	});
    }
}

jQuery(document).ready(function() {
    jQuery("a.wpjb-delete").bind("click", function() {
        var id = jQuery(this).attr("href").replace("#", "");
        var t = Wpjb.DeleteType;
        if(confirm(WpjbAdminLang.remove+" "+t+": "+id+"?")) {
            jQuery("#wpjb-delete-form-id").attr("value", id);
            jQuery("#wpjb-delete-form").submit();
        }
        return false;
    });

    jQuery("#wpjb-doaction1").bind("click", function(){
        var value = jQuery("#wpjb-action1").val();
        if(value == "-1") {
            alert(WpjbAdminLang.selectAction);
            return false;
        }
        jQuery("#wpjb-action-holder").attr("value", value);
    });
    jQuery("#wpjb-doaction2").bind("click", function(){
        var value = jQuery("#wpjb-action2").val();
        if(value == "-1") {
            alert(WpjbAdminLang.selectAction);
            return false;
        }
        jQuery("#wpjb-action-holder").attr("value", value);
    });
});

// wpjb/job/add
jQuery(function() {
    if(location.href.indexOf("page=wpjb/job&action=edit") == -1) {
        return;
    }

    var state = jQuery('#job_state');

    var input = jQuery('<input type="text" />')
        .css("display", "none")
        .attr("value", Wpjb.JobState)
        .insertAfter("#job_state");




    jQuery("#job_country").bind("change", function() {
        var obj = jQuery(this);
        var state = jQuery('#job_state');

        if(obj.val() == 840) {
            // show select
            state.css("display", "inline");
            state.attr("name", "job_state");
            
            input.css("display", "none");
            input.removeAttr("name");
        } else {
            // show input
            state.css("display", "none");
            state.removeAttr("name");

            input.css("display", "inline");
            input.attr("name", "job_state");
        }
    });
    jQuery("#job_country").trigger("change");

    jQuery("#wpjb-image-remove").bind("click", function() {
        jQuery("#wpjb-remove-image-form-input").val(1);
        jQuery("#wpjb-remove-image-form").submit();
        
        return false;
    });

    Wpjb.InitSlugUI("job_slug");

    jQuery("#job_title").bind("blur", function() {
        if(jQuery("#job_slug").val().length == 0) {
            Wpjb.Slugify("job_slug", jQuery(this).val(), "job", Wpjb.Id);
        }
    });


});

// wpjb/job
jQuery(function() {
    if(location.href.indexOf("page=wpjb/employer&action=edit") == -1) {
        return;
    }

    jQuery("#wpjb-image-remove").bind("click", function() {
        jQuery("#wpjb-remove-image-form-input").val(1);
        jQuery("#wpjb-remove-image-form").submit();

        return false;
    });
});

// wpjb/addField
jQuery(function() {
    if(location.href.indexOf("page=wpjb/addField") == -1) {
        return;
    }

    if(Wpjb.TypeValue == 5) {
        jQuery("#type").append('<option value="5">'+WpjbAdminLang.addField_file+'</option>').val(5);
    }

    jQuery("#field_for").bind("change", function() {
        var obj = jQuery(this);

        if(obj.val() == 2) {
            jQuery("#type").append('<option value="5">'+WpjbAdminLang.addField_file+'</option>');
        } else {
            jQuery("#type option[value=5]").remove();
        }
    });
    
    jQuery("#type").bind("change", function(){

        var obj = jQuery(this);

        var option = jQuery("#wpjb-add-field-option");
        var validator = jQuery("#validator").parent().parent();

        if(obj.val() == 1) {
            // show validator; hide options
            validator.show();
            option.hide();
        } else if(obj.val() == 3 || obj.val() == 6 || obj.val() == 5) {
            // hide validator; hide options
            validator.hide();
            option.hide();
        } else if(obj.val() == 4) {
            // hide validator; show options
            validator.hide();
            option.show();
        } 
    });
    jQuery("#type").trigger("change");

    jQuery("#wpjbOptionAdd").bind("click", function() {
        var option = jQuery("#wpjbOptionText");
        var object = {
            id: null,
            value: option.val()
        }
        Wpjb.InsertField(object);
    });

    if(Wpjb.Option != null) {
        for(var i in Wpjb.Option) {
            Wpjb.InsertField(Wpjb.Option[i]);
        }
    }
});

// list category
jQuery(function() {

    if(location.href.indexOf("page=wpjb/category") == -1) {
        return;
    }

    if(!jQuery(".wpjb_disabled")) {
        return;
    }

    jQuery(".wpjb_disabled").click(function() {
        alert(WpjbAdminLang.category_notEmpty);
        return false;
    });
});

// edit category
jQuery(function() {
    if(location.href.indexOf("page=wpjb/category&action=edit") == -1) {
        return;
    }
    
    Wpjb.InitSlugUI("slug");

    jQuery("#title").bind("blur", function() {
        if(jQuery("#slug").val().length == 0) {
            Wpjb.Slugify("slug", jQuery(this).val(), "category", Wpjb.Id);
        }
    });
});

// list job types
jQuery(function() {

    if(location.href.indexOf("page=wpjb/jobType") == -1) {
        return;
    }

    if(!jQuery(".wpjb_disabled")) {
        return;
    }

    jQuery(".wpjb_disabled").click(function() {
        alert(WpjbAdminLang.jobtype_notEmpty);
        return false;
    });
});
// edit jobType
jQuery(function() {
    if(location.href.indexOf("page=wpjb/jobType&action=edit") == -1) {
        return;
    }

    Wpjb.InitSlugUI("slug");

    jQuery("#title").bind("blur", function() {
        if(jQuery("#slug").val().length == 0) {
            Wpjb.Slugify("slug", jQuery(this).val(), "type", Wpjb.Id);
        }
    });
});

// edit company profile
jQuery(function() {
    if(location.href.indexOf("page=wpjb/employer/company") == -1) {
        return;
    }

    Wpjb.InitSlugUI("slug");

    jQuery("#title").bind("blur", function() {
        if(jQuery("#slug").val().length == 0) {
            Wpjb.Slugify("slug", jQuery(this).val(), "type", Wpjb.Id);
        }
    });

    jQuery("#wpjb-image-remove").bind("click", function() {
        jQuery("#wpjb-remove-image-form-input").val(1);
        jQuery("#wpjb-remove-image-form").submit();

        return false;
    });
});

// import
jQuery(function() {
    if(location.href.indexOf("page=wpjb/import") == -1) {
        return;
    }

    jQuery("#wpjb-continue").click( function() {

        jQuery("#wpjb-import-step-1").css("display", "none");
        jQuery("#wpjb-import-step-2").css("display", "block");
        return false;
    });

    jQuery("#wpjb-back-import").click(function() {

        jQuery("#wpjb-import-step-1").css("display", "block");
        jQuery("#wpjb-import-step-2").css("display", "none");
        return false;
    });

    jQuery("#wpjb-import-info").css("display", "none");

    jQuery("#wpjb-start-import")
    .unbind("click")
    .click(function() {

        jQuery("#wpjb-import-actions").css("display", "none");
        jQuery("#wpjb-import-info").css("display", "block");

        var added = 0;
        var max = jQuery("#import_max").val();

        jQuery("#wpjb-import-max").html(max);

        for( var i = 0; added<max; i++) {
            var response = jQuery.ajax({
                type: "POST",
                url: "admin-ajax.php",
                data: {
                    action: "wpjb_careerbuilder_import",
                    keyword: jQuery("#import_keyword").val(),
                    engine: jQuery("#import_engine").val(),
                    posted_within: jQuery("#import_posted_within").val(),
                    country: jQuery("#import_country").val(),
                    page: (i+1),
                    added: added,
                    max: max,
                    category_id: jQuery("#import_category").val(),
                    location: jQuery("#import_location").val()
                },
                async: false,
                success: function(msg){
                 //alert( "Data Saved: " + msg );
                }
            });

            eval("var response = "+response.responseText);
            
            if(response.isError) {
                alert(response.error);
                break;
            }

            added = response.added;

            jQuery("#wpjb-progress").css("width", ((added)/max*100)+"%");
            jQuery("#wpjb-import-found").html(response.found);
            jQuery("#wpjb-import-added").html(added);
            jQuery("#wpjb-import-max").html(response.max);
            jQuery("#wpjb-import-request").html(i+1);

            if(response.complete) {
                alert("Import complete. Added "+added+" of "+max+" jobs.");
                break;
            }
        }

        return false;
  });
});

// edit resume
jQuery(function() {
    if(location.href.indexOf("admin.php?page=wpjb/resumes") == -1) {
        return;
    }

    jQuery("#wpjb-image-remove").bind("click", function() {
        jQuery("#wpjb-remove-image-form-input").val(1);
        jQuery("#wpjb-remove-image-form").submit();

        return false;
    });

    jQuery("#wpjb-file-remove").bind("click", function() {
        jQuery("#wpjb-remove-file-form-input").val(1);
        jQuery("#wpjb-remove-file-form").submit();

        return false;
    });
});

var WpjbBubble = {
    update: function(cl, newVal) {
        var $this = jQuery(cl);
        var span = $this.find("span.update-count");
        var pid = span.text();
        
        $this.removeClass("count-"+pid);
        if(newVal>0) {
            $this.addClass("count-"+newVal);
        } else {
            $this.addClass("count-0");
        }
        
        span.text(newVal);
        
    }
}
