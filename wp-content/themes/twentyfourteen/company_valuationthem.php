<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// $Id:$
/*
  Template Name: 公司估值历史数据页面
 */
global $wpdb, $postdata1;
$user_ID = get_current_user_id();

//检查用户是否登录
if ($user_ID != null)
{
    //删除操作
    if (strcasecmp($_POST['posttype'], 'del') == 0)
    {
        $id = $_POST['id'];
        $result = coolwp_delete_valuation($id);
        if ($result)
        {
            echo "<script type='text/javascript'>";
            echo " window.location='http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "';";
            echo "</script>";
        } else
            echo "删除失败！";
        exit();
    }
    //更新操作
    if (strcasecmp($_POST['posttype'], 'modify') == 0 || strcasecmp($_POST['posttype'], 'add') == 0)
    {
        $id = $_POST['id'];
        $company_id = $_POST['company_id'];
        $valuation = $_POST['valuation'];
        $valuation_date = $_POST['valuation_date'];
        $totale_quity_funding = $_POST['totale_quity_funding'];
        $rounds_offunding = $_POST['rounds_offunding'];
        $product_name = $_POST['product_name'];
        $oonline_date = $_POST['oonline_date'];
        $data = array(
            'company_id' => $company_id,
            'valuation' => $valuation,
            'valuation_date' => $valuation_date,
            'totale_quity_funding' => $totale_quity_funding,
            'rounds_offunding' => $rounds_offunding,
            'product_name' => $product_name,
            'oonline_date' => $oonline_date,
        );
        $tipstr = "添加";
        if ($_POST['posttype'] == "add")
        {
            $result = coolwp_insert_valuation($data);
        } else
        {
            $tipstr = "更新";
            $result = coolwp_update_valuation($id, $data);
        }
        if ($result)
        {
            echo "<script type='text/javascript'>";
            echo " window.location='http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "';";
            echo "</script>";
        } else
            echo "$tipstr 失败！";
        exit();
    }

    $query = array(
        'fields' => array(),
        'orderby' => 'datetime',
        'order' => 'desc',
        'company_id' => false,
        'since' => false,
        'until' => false,
        'number' => - 1,
        'offset' => 0
    ); //(查询参数，这里是浏览数据功能)
    $result = coolwp_get_valuations($query);
    if ($_POST[action])
    {
        
    } else
    {
        get_header();
        ?>

        <script type="text/javascript">
            var tdmap = {
                0: "company_id",
                1: "valuation",
                2: "valuation_date",
                3: "totale_quity_funding",
                4: "rounds_offunding",
                5: "product_name",
                6: "oonline_date"
            }
            //全局变量   
            var i = 0;
            //添加行   
            function addMyRow() {
                var mytable = document.getElementById("mybody");
                var mytr = mytable.insertRow();
                mytr.setAttribute("id", "tr" + i);
                i++;
                for (var j = 0; j < 7; j++)
                {
                    var elem = mytr.insertCell(j);
                    elem.innerHTML = "<input required   class='tblinput' type='text' id='new_" + tdmap[j] + "_"+i+"' name='new_" + tdmap[j] + "_" + i + "' value=''/>";
                }
                var elem = mytr.insertCell(7);
                elem.innerHTML = '<input  class="tblinput" style="width:84px" name="add" data-id='+i+' type="button" id="add" value="保存"/>';
                
                jQuery("#add").click(function () {
                    var input_data = jQuery('#company_valuationthem').serialize();
                    jQuery('#result').html('<img src="<?php echo includes_url(); ?>/js/mediaelement/loading.gif" class="loader" />').fadeIn();
                    //alert("input_data:" + input_data);
                    var id = jQuery(this).data("id");
                    var input_data = {posttype: "add"};
                    for (x in tdmap)
                    {
                        input_data[tdmap[x]] = jQuery("#new_" + tdmap[x]+"_"+id).val();
                    }
                    var url = "<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ""; ?>";
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: input_data,
                        success: function (msg) {
                            jQuery('.loader').remove();
                            jQuery('div#result').html(msg).hide().fadeIn('slow');
                        }
                    });
                    return false;
                });
            }
        </script>

        <div id="main-content" class="main-content">

            <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">
                    <h1>公司估值历史数据</h1>
                    <div id="result"></div><!--  为ajax返回结果做准备 -->

                    <input type="hidden" name="action" value="company_valuationthem">
                    <table style="width:100%; overflow: scroll;">  
                        <thead>  
                            <tr>
                                <td colspan="9">
                                    <input  onclick="addMyRow();" type="button" name="call" value="添加"/>
                                </td>
                            </tr>
                            <tr>  
                                <td  style="display:none" bgcolor="#CCCCCC" scope="col" align="center">  
                                    编号  
                                </td>  
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    公司编号   
                                </td>  
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    融资   
                                </td>  
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    融资日期   
                                </td>   
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    市值   
                                </td>  
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    融资次数   
                                </td>  
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    产品名称   
                                </td>  
                                <td bgcolor="#CCCCCC" scope="col" align="center">  
                                    上线日期   
                                </td>  
                                <td  style="width:200px;" bgcolor="#CCCCCC" scope="col" align="center">  
                                    操作   
                                </td>  
                            </tr>  
                        </thead>  
                        <tbody id="mybody"> 
                            <?php
                            //这里是PHP代码
                            foreach ($result as $k => $v) //循环开始
                            {
                                ?> 

                                <tr>
                                    <td style="display:none">
                                        <input class="tblinput" type="text" required name="id" id="id" value="<?php echo $v->id; ?>"/></td>
                                    <td><input class="tblinput" type="text" required name="company_id_<?php echo $v->id; ?>" id="company_id_<?php echo $v->id; ?>" value="<?php echo $v->company_id; ?>"/></td>
                                    <td><input class="tblinput" type="text" required name="valuation_<?php echo $v->id; ?>" id="valuation_<?php echo $v->id; ?>" value="<?php echo $v->valuation; ?>" /></td>
                                    <td><input class="tblinput" type="text" required name="valuation_date_<?php echo $v->id; ?>" id="valuation_date_<?php echo $v->id; ?>" value="<?php echo date("Y年m月", strtotime($v->valuation_date)); ?>" /></td>
                                    <td><input class="tblinput" type="text" required name="totale_quity_funding_<?php echo $v->id; ?>" id="totale_quity_funding_<?php echo $v->id; ?>" value="<?php echo $v->totale_quity_funding; ?>" /></td>
                                    <td><input class="tblinput" type="text" required name="rounds_offunding_<?php echo $v->id; ?>" id="rounds_offunding_<?php echo $v->id; ?>" value="<?php echo $v->rounds_offunding; ?>" /></td>
                                    <td><input class="tblinput" type="text" required name="product_name_<?php echo $v->id; ?>" id="product_name_<?php echo $v->id; ?>" value="<?php echo htmlspecialchars($v->product_name); ?>" /></td>
                                    <td><input class="tblinput" type="text" required name="oonline_date_<?php echo $v->id; ?>" id="oonline_date_<?php echo $v->id; ?>" value="<?php echo date("Y年m月", strtotime($v->oonline_date)); ?>" /></td>
                                    <td style="width:200px;">
                                        <input class="modifybutton" name="modify"  data-id="<?php echo $v->id; ?>" type="button" id="modify" value="更新" />
                                        <input class="delbutton" name="del"    data-id="<?php echo $v->id; ?>" type="button" id="del" value="删除" />
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>  

                    </table>  

                    <script type="text/javascript">
                        jQuery(document).ready(function () {

                            jQuery(".modifybutton").click(function () {
                                jQuery('#result').html('<img src="<?php echo includes_url(); ?>/js/mediaelement/loading.gif" class="loader" />').fadeIn();
                                var id = jQuery(this).data("id");
                                var input_data = {posttype: "modify", id:id};
                                for (x in tdmap)
                                {
                                    input_data[tdmap[x]] = jQuery("#" + tdmap[x] + "_" + id).val();
                                }
                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ""; ?>",
                                    data: input_data,
                                    success: function (msg) {
                                        jQuery('.loader').remove();
                                        jQuery('div#result').html(msg).hide().fadeIn('slow');
                                    }
                                });
                                return false;
                            });
                            jQuery(".delbutton").click(function () {
                                jQuery('#result').html('<img src="<?php echo includes_url(); ?>/js/mediaelement/loading.gif" class="loader" />').fadeIn();
                                var id = jQuery(this).data("id");
                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ""; ?>",
                                    data: {posttype: "del", id: id},
                                    success: function (msg) {
                                        jQuery('.loader').remove();
                                        jQuery('div#result').html(msg).hide().fadeIn('slow');
                                    }
                                });
                                return false;
                            });
                        });


                    </script>  

                </div><!-- #content -->
            </div><!-- #primary -->
        </div><!-- #main-content -->

        <?php
        get_sidebar();
        get_footer(); //加载底部文件
    }
} else
{
    wp_redirect(home_url());
    exit();
}
?>
<style>
    .tblinput{
        width:110px;
    }
</style>
