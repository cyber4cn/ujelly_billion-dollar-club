<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$
/*
Template Name: 公司估值历史数据页面
*/
global $wpdb, $postdata1;
$user_ID = get_current_user_id();
/*echo "<script language='javascript'>";
 echo "alert(\"+$user_ID +\");"; 
  echo "</script>";*/
//检查用户是否登录
if (user_ID != null) {
    $query = array(
        'fields' => array() ,
        'orderby' => 'datetime',
        'order' => 'desc',
        'company_id' => false,
        'since' => false,
        'until' => false,
        'number' => - 1,
        'offset' => 0
    ); //(查询参数，这里是浏览数据功能)
    $result = coolwp_get_valuations($query);
	
	echo '$_POST[action]:' .  $_POST['action'] . '<br/>'; 

    if ($_POST[action]) {
		
		foreach ($_POST as $key => $value) {
			echo $key . ':' . $value . '<br/>';
			$position = strpos($key,'company_id');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['company_id'] = $value;
			$position = strpos($key,'valuation');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['valuation'] = $value;
			$position = strpos($key,'valuation_date');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['valuation_date'] = $value;
			$position = strpos($key,'totale_quity_funding');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['totale_quity_funding'] = $value;
			$position = strpos($key,'rounds_offunding');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['rounds_offunding'] = $value;
			$position = strpos($key,'product_name');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['product_name'] = $value;
			$position = strpos($key,'oonline_date');
			echo $position . '<br/>';
			if ($position === 0)
				$postdata1['oonline_date'] = $value;
			
          /*  if (false === strpos($key, self::DATA_PREFIX)) {
                $this->extra_fields[$key] = $value;
                continue;
            }

            $field = substr($key, $pfx_length);

            if (is_array($value)) {
                $this->data[ $field ] = stripslashes_deep($value);
            } else {
                $this->data[ $field ] = stripslashes(trim($value));
            }*/

        }
		echo 'postdata1:' . $postdata1 . '<br/>';
        echo '$post->posttype:' . $postdata1['posttype'] . '<br/>';
        echo '$post->company_id:' . $postdata1['company_id'] . '<br/>';
        echo '$post->valuation:' . $postdata1['valuation'] . '<br/>';
        echo '$post->valuation_date:' . $postdata1['valuation_date'] . '<br/>';
        echo '$post->totale_quity_funding:' . $postdata1['totale_quity_funding'] . '<br/>';
        echo '$post->rounds_offunding:' . $postdata1['rounds_offunding'] . '<br/>';
        echo '$post->product_name:' . $postdata1['product_name'] . '<br/>';
        echo '$post->oonline_date:' . $postdata1['oonline_date'] . '<br/>';
        if (strcasecmp($_POST['posttype'], 'modify') == 0) {
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
            $result = coolwp_update_valuation($id, $postdata1);
            if ($result) {
                echo "<script language='javascript'>";
                echo " location=http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                echo "</script>";
            } else echo "更新失败！";
            exit();
        }
        if (strcasecmp($_POST['posttype'], 'del') == 0) {
            $id = $_POST['id'];
            $result = coolwp_delete_valuation($id);
            if ($result) {
                echo "<script language='javascript'>";
                echo " location=http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                echo "</script>";
            } else echo "删除失败！";
            exit();
        }
        if ($_POST['add']) {
			echo '$_POST[add]' . '<br/>';
	$result=coolwp_insert_valuation($postdata1);
			echo '$result' . $result . '<br/>';
            if ($result) {
                echo "添加成功" . '<br/>';
				                echo "<script language='javascript'>";
                echo " location=http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                echo "</script>";
            } else echo "添加失败！";
            exit();
        }
        exit();
    } else {
        get_header();
?>
		
		<script type="text/javascript">
		function addfun(){
				alert("asdd");
				var input_data = jQuery('#company_valuationthem').serialize();
			jQuery('#result').html('<img src="<?php
        echo includes_url(); ?>/js/mediaelement/loading.gif" class="loader" />').fadeIn();
			alert("input_data:"+input_data);
			var url="<?php
        echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?posttype=add"; ?>";
			jQuery.ajax({
			type: "POST",
			url:  'company_valuationthem',
			data: input_data,
			success: function(msg){
				jQuery('.loader').remove();
				jQuery('div#result').html(msg).hide().fadeIn('slow');
			}
			});
			return false;
		};
	//全局变量   
        var i=0;   
        //添加行   
        function addMyRow(){   
            var mytable = document.getElementById("mybody");   
           var mytr = mytable.insertRow();   
            mytr.setAttribute("id","tr"+i);   
            var mytd_1=mytr.insertCell(0);   
            var mytd_2=mytr.insertCell(1);   
           var mytd_3=mytr.insertCell(2);
   var mytd_4=mytr.insertCell(3);
   var mytd_5=mytr.insertCell(4);
   var mytd_6=mytr.insertCell(5);
   var mytd_7=mytr.insertCell(6);
   var mytd_8=mytr.insertCell(7);
   if(document.getElementById("company_id")!=null)
   {var company_id= document.getElementById("company_id").innerHTML; 
mytd_1.innerHTML="<input type='text' id='company_id' name='company_id"+i+"' value='"+company_id+"'/>";   
		}else
			mytd_1.innerHTML="<input type='text' id='company_id' name='company_id"+i+"' value=''/>";   
 if(document.getElementById("valuation")!=null)
 {var valuation= document.getElementById("valuation").innerHTML;   
mytd_2.innerHTML="<input type='text' id='valuation' name='valuation"+i+"' value='"+valuation+"'/>";   
 }else
	 mytd_2.innerHTML="<input type='text' id='valuation' name='valuation"+i+"' value=''/>";   
 if(document.getElementById("valuation_date")!=null)
 {var valuation_date= document.getElementById("valuation_date").innerHTML;   
 mytd_3.innerHTML="<input type='text' id='valuation_date' name='valuation_date"+i+"' value='"+valuation_date+"'/>";
 }else
	  mytd_3.innerHTML="<input type='text' id='valuation_date' name='valuation_date"+i+"' value=''/>";
  if(document.getElementById("totale_quity_funding")!=null)
 {
   var totale_quity_funding= document.getElementById("totale_quity_funding").innerHTML;   
   mytd_4.innerHTML="<input type='text' id='totale_quity_funding' name='totale_quity_funding"+i+"' value='"+totale_quity_funding+"'/>";
 }else
	 mytd_4.innerHTML="<input type='text' id='totale_quity_funding' name='totale_quity_funding"+i+"' value=''/>";
     if(document.getElementById("rounds_offunding")!=null)
 {var rounds_offunding= document.getElementById("rounds_offunding").innerHTML;   
mytd_5.innerHTML="<input type='text' id='rounds_offunding' name='rounds_offunding"+i+"' value='"+rounds_offunding+"'/>";
 }else
	 mytd_5.innerHTML="<input type='text' id='rounds_offunding' name='rounds_offunding"+i+"' value=''/>";
     if(document.getElementById("valuation_date")!=null)
 {var product_name= document.getElementById("valuation_date").innerHTML;   
mytd_6.innerHTML="<input type='text' id='product_name' name='product_name"+i+"' value='"+product_name+"'/>";
 }else
	 mytd_6.innerHTML="<input type='text' id='product_name' name='product_name"+i+"' value=''/>";
     if(document.getElementById("oonline_date")!=null)
 {var oonline_date= document.getElementById("oonline_date").innerHTML;   
 mytd_7.innerHTML="<input type='text' id='oonline_date' name='oonline_date"+i+"' value='"+oonline_date+"'/>";
 }else
	 mytd_7.innerHTML="<input type='text' id='oonline_date' name='oonline_date"+i+"' value=''/>";

mytd_8.innerHTML='<input name="add" type="submit" id="add" value="保存"/>'; 
            i++; 
  
        }   
</script>

		<div id="main-content" class="main-content">
		
<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<h1>公司估值历史数据</h1>
		<div id="result"></div><!--  为ajax返回结果做准备 -->

		<form id="company_valuationthem" name="company_valuationthem" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="company_valuationthem">
<table>  
            <thead>  
                <tr>
<td>
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
                    <td bgcolor="#CCCCCC" scope="col" align="center">  
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
<td style="display:none"><input type="text" name="id" id="id" value="<?php
            echo $v->id; ?>"/></td>
<td><input type="text" name="company_id" id="company_id" value="<?php
            echo $v->company_id; ?>"/></td>
		<td><input type="text" name="valuation" id="valuation" value="<?php
            echo $v->valuation; ?>" /></td>
              <td><input type="text" name="valuation_date" id="valuation_date" value="<?php
            echo $v->valuation_date; ?>" /></td>
			  <td><input type="text" name="totale_quity_funding" id="totale_quity_funding" value="<?php
            echo $v->totale_quity_funding; ?>" /></td>
			  <td><input type="text" name="rounds_offunding" id="rounds_offunding" value="<?php
            echo $v->rounds_offunding; ?>" /></td>
			  <td><input type="text" name="product_name" id="product_name" value="<?php
            echo $v->product_name; ?>" /></td>
			  <td><input type="text" name="oonline_date" id="oonline_date" value="<?php
            echo $v->oonline_date; ?>" /></td>
                <td><input name="modify" type="button" id="modify" value="更新" />
<input name="del" type="button" id="del" value="删除" />
 </td>
         </tr>
<?php
        }
?>
            </tbody>  

        </table>  
</form>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			
		/*$("#modify").click(function() {
			$('#result').html('<img src="<?php
        echo includes_url(); ?>/js/mediaelement/loading.gif" class="loader" />').fadeIn();
			var input_data =$('#company_valuation_form').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php
        echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?posttype=modify"; ?>",
			data: input_data,
			success: function(msg){
				$('.loader').remove();
				$('div#result').html(msg).hide().fadeIn('slow');
			}
			});
			return false;
		});
		$("#del").click(function() {
			$('#result').html('<img src="<?php
        echo includes_url(); ?>/js/mediaelement/loading.gif" class="loader" />').fadeIn();
			var input_data = $('#company_valuation_form').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php
        echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?posttype=del"; ?>",
			data: input_data,
			success: function(msg){
				$('.loader').remove();
				$('div#result').html(msg).hide().fadeIn('slow');
			}
			});
			return false;
		});
		 });
		})(jQuery);*/
		
		});
		
        
        </script>  

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
		
		<?php
        get_sidebar();
        get_footer(); //加载底部文件
        
    }
} else {
    wp_redirect(home_url());
    exit();
}
?>
