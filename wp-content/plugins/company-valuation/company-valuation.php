<?php

/*
  Plugin Name: company valuation
  Plugin URI: http://www.xxxx.com/plugins/
  Description: 公司估值历史数据插件
  Version: 1.0.0
  Author: fc
  Author URI: http://user.qzone.qq.com/603369821
  License: GPL
 */
register_activation_hook(__FILE__, 'create_company_valuation_table');

/**
 * Store our table name in $wpdb with correct prefix
 * Prefix will vary between sites so hook onto switch_bvaluation too
 * @since 1.0
 */
function register_company_valuation_table()
{
    global $wpdb;
    $wpdb->company_valuation = $wpdb->prefix . 'company_valuation';
}

add_action('init', 'register_company_valuation_table', 1);
add_action('switch_bvaluation', 'register_company_valuation_table');

/**
 * Creates our table
 * Hooked onto activate_[plugin] (via register_activation_hook)
 * @since 1.0
 */
function create_company_valuation_table()
{
    global $wpdb;
    global $charset_collate;
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    //Call this manually as we may have missed the init hook
    register_company_valuation_table();
    if ($wpdb->get_var("SHOW TABLES LIKE '$wpdb->company_valuation'") != $wpdb->company_valuation):
        $sql_create_table = " CREATE TABLE {$wpdb->company_valuation} (`id` bigint(20) NOT NULL AUTO_INCREMENT, 
        company_id bigint(20) unsigned NOT NULL default '0',  
        valuation double NOT NULL default '0',  
        valuation_date datetime NOT NULL default '0000-00-00 00:00:00',  
        totale_quity_funding double NOT NULL default '0',  
        rounds_offunding bigint(20) unsigned NOT NULL default '0',  
        product_name varchar(100) NOT NULL DEFAULT '',
        oonline_date datetime NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (id),  
        KEY `company_id` (`company_id`) 
		) $charset_collate; ";
        dbDelta($sql_create_table);
    endif;
}

function coolwp_get_valuation_table_columns()
{
    return array(
        'id' => '%d',
        'company_id' => '%d',
        'valuation' => '%f',
        'valuation_date' => '%s',
        'totale_quity_funding' => '%f',
        'rounds_offunding' => '%d',
        'product_name' => '%s',
        'oonline_date' => '%s',
    );
}

/**
 * Inserts a valuation into the database
 *
 * @param $data array An array of key => value pairs to be inserted
 * @return int The valuation ID of the created activity valuation. Or WP_Error or false on failure.
 * 插入记录到数据库
 *
 * @param $data数组是一个要被插入到数据库的 key => value 对.
 * @return 整型的记录ID或者WP_Error或者false.
 */
function coolwp_insert_valuation($data = array())
{
    global $wpdb;
    //Set default values  设置默认值
    /* $data = wp_parse_args($data, array(
      'company_id'=> get_current_company_id(),
      'date'=> current_time('timestamp'),
      )); */
    //Check date validity   日期验证
        
        
    //Convert activity date from local timestamp to GMT mysql format   将本地时间戳转换为 mysql(GMT) 格式
    $data['valuation_date'] = date_i18n('Y-m-d', strtotime($data['valuation_date']), true);
    $data['oonline_date'] = date_i18n('Y-m-d', strtotime($data['oonline_date']), true);
 
    //Initialise column format array   初始化列(字段，下同)格式数组
    $column_formats = coolwp_get_valuation_table_columns();
    //Force fields to lower case   强制小写
    $data = array_change_key_case($data);
    //White list columns   白名单列
    $data = array_intersect_key($data, $column_formats);
    //Reorder $column_formats to match the order of columns given in $data   记录$column_formats与$data格式相符的数据行
    $data_keys = array_keys($data);
    $column_formats = array_merge(array_flip($data_keys), $column_formats);
    $wpdb->insert($wpdb->company_valuation, $data, $column_formats);
    echo '$wpdb->insert_id' . $wpdb->insert_id;
    return $wpdb->insert_id;
}

/**
 * Updates an activity valuation with supplied data
 *
 * @param $id int ID of the activity valuation to be updated
 * @param $data array An array of column=>value pairs to be updated
 * @return bool Whether the valuation was successfully updated.
 * 更新事件记录
 *
 * @param $id 要被更新的事件记录的ID.
 * @param $data 要被更新的一个 column=>value 对数组.
 * @return 一个布尔型变量，用以反馈更新是否成功
 */
function coolwp_update_valuation($id, $data = array())
{
    global $wpdb;
    $data['date'] = current_time('timestamp');
    //valuation ID must be positive integer   记录ID必须是正的整型变量
    $id = absint($id);
    if (empty($id))
        return false;
    //Convert activity date from local timestamp to GMT mysql format   时间戳转换
    $data['valuation_date'] = date_i18n('Y-m-d', strtotime($data['valuation_date']), true);
    $data['oonline_date'] = date_i18n('Y-m-d', strtotime($data['oonline_date']), true);
    //Initialise column format array   初始化格式数组
    $column_formats = coolwp_get_valuation_table_columns();
    //Force fields to lower case   强制小写
    $data = array_change_key_case($data);
    //White list columns   白名单列
    $data = array_intersect_key($data, $column_formats);
    //Reorder $column_formats to match the order of columns given in $data   $column_formats与$data 数组格式相符的数据行
    $data_keys = array_keys($data);
    $column_formats = array_merge(array_flip($data_keys), $column_formats);
    if (false === $wpdb->update($wpdb->company_valuation, $data, array(
                'id' => $id
                    ), $column_formats))
    {
        return false;
    }
    return true;
}

/**
 * Retrieves company valuation from the database matching $query.
 * $query is an array which can contain the following keys:
 *
 * 'fields' - an array of columns to include in returned roles. Or 'count' to count rows. Default: empty (all fields).
 * 'orderby' - datetime, company_id or id. Default: datetime.
 * 'order' - asc or desc
 * 'company_id' - company ID to match, or an array of company IDs
 * 'since' - timestamp. Return only activities after this date. Default false, no restriction.
 * 'until' - timestamp. Return only activities up to this date. Default false, no restriction.
 *
 * @param $query Query array
 * @return array Array of matching valuations. False on error.
 * 从数据库中与 $query 相匹配的事件记录.
 * $query 是一个包含了以下键的数组:
 *
 * 'fields' - 列的数组中返回的角色，比如：用以统计有多少条记录的 'count' . 默认: empty (全部).
 * 'orderby' - datetime, company_id 或 id. 默认: datetime.
 * 'order' - asc 或 desc
 * 'company_id' - 匹配的 company ID , 或是一个公司ID数组.
 * 'since' - timestamp.返回某个日期时间之后的事件记录. 默认： false(没有限制).
 * 'until' - timestamp.返回某个日期时间之前的事件记录. 默认： false(没有限制).
 *
 * @param $query 查询数组
 * @return array 符合查询条件的事件或者False.
 */
function coolwp_get_valuations($query = array())
{
    global $wpdb;
    /* Parse defaults 解析默认值 */
    $defaults = array(
        'fields' => array(),
        'orderby' => 'datetime',
        'order' => 'desc',
        'company_id' => false,
        'since' => false,
        'until' => false,
        'number' => 10,
        'offset' => 0
    );
    $query = wp_parse_args($query, $defaults);
    /* Form a cache key from the query 基于查询形成一个缓存键 */
    $cache_key = 'coolwp_valuations:' . md5(serialize($query));
    $cache = wp_cache_get($cache_key);
    if (false !== $cache)
    {
        $cache = apply_filters('coolwp_get_valuations', $cache, $query);
        return $cache;
    }
    extract($query);
    /* SQL Select SQL选择 */
    //Whitelist of allowed fields   白名单
    $allowed_fields = coolwp_get_valuation_table_columns();
    if (is_array($fields))
    {
        //Convert fields to lowercase (as our column names are all lower case - see part 1)  强制小写
        $fields = array_map('strtolower', $fields);
        //Sanitize by white listing   过滤
        $fields = array_intersect($fields, $allowed_fields);
    } else
    {
        $fields = strtolower($fields);
    }
    //Return only selected fields. Empty is interpreted as all   返回查询的值，如果查询的值为空或者就是默认的，就返回默认值.
    if (empty($fields))
    {
        $select_sql = "SELECT* FROM {$wpdb->company_valuation}";
    } elseif ('count' == $fields)
    {
        $select_sql = "SELECT COUNT(*) FROM {$wpdb->company_valuation}";
    } else
    {
        $select_sql = "SELECT " . implode(',', $fields) . " FROM {$wpdb->company_valuation}";
    }
    /* SQL Join */
    //We don't need this, but we'll allow it be filtered (see 'coolwp_valuations_clauses' )   我们不需要这个, 但我们允许它存在 (查看 'coolwp_logs_clauses' )
    $join_sql = '';
    /* SQL Where */
    //Initialise WHERE 初始化 WHERE
    $where_sql = 'WHERE 1=1';
    if (!empty($id))
        $where_sql.= $wpdb->prepare(' AND id=%d', $id);
    if (!empty($company_id))
    {
        //Force $company_id to be an array   强制$company_id 为一个数组
        if (!is_array($company_id))
            $company_id = array(
                $company_id
            );
        $company_id = array_map('absint', $company_id); //Cast as positive integers   转换为正整数
        $company_id__in = implode(',', $company_id);
        $where_sql.= " AND company_id IN($company_id__in)";
    }
    $since = absint($since);
    $until = absint($until);
    if (!empty($since))
        $where_sql.= $wpdb->prepare(' AND valuation_date >= %s', date_i18n('Y-m-d', $since, true));
    if (!empty($until))
        $where_sql.= $wpdb->prepare(' AND valuation_date <= %s', date_i18n('Y-m-d', $until, true));
    /* SQL Order */
    //Whitelist order  白名单
    $order = strtoupper($order);
    $order = ('ASC' == $order ? 'ASC' : 'DESC');
    switch ($orderby)
    {
        case 'id':
            $order_sql = "ORDER BY id $order";
            break;

        case 'company_id':
            $order_sql = "ORDER BY company_id $order";
            break;

        case 'datetime':
            $order_sql = "ORDER BY valuation_date $order";
        default:
            break;
    }
    /* SQL Limit */
    $offset = absint($offset); //Positive integer   正整数
    if ($number == - 1)
    {
        $limit_sql = "";
    } else
    {
        $number = absint($number); //Positive integer   正整数
        $limit_sql = "LIMIT $offset, $number";
    }
    /* Filter SQL SQL过滤器 */
    $pieces = array(
        'select_sql',
        'join_sql',
        'where_sql',
        'order_sql',
        'limit_sql'
    );
    $clauses = apply_filters('coolwp_valuations_clauses', compact($pieces), $query);
    foreach ($pieces as $piece)
        $$piece = isset($clauses[$piece]) ? $clauses[$piece] : '';
    /* Form SQL statement SQL语句格式 */
    $sql = "$select_sql $where_sql $order_sql $limit_sql";
    if ('count' == $fields)
    {
        return $wpdb->get_var($sql);
    }
    /* Perform query 查询 */
    $valuations = $wpdb->get_results($sql);
    /* Add to cache and filter 添加到缓存和过滤器 */
    wp_cache_add($cache_key, $valuations, 24 * 60 * 60);
    $valuations = apply_filters('coolwp_get_valuations', $valuations, $query);
    return $valuations;
}

/**
 * Deletes an activity valuation from the database
 *
 * @param $id int ID of the activity valuation to be deleted
 * @return bool Whether the valuation was successfully deleted.
 * 从数据库中删除事件记录
 *
 * @param $id 要被删除的记录的ID
 * @return bool 是否删除成功.
 */
function coolwp_delete_valuation($id)
{
    global $wpdb;
    //valuation ID must be positive integer   保证要被删除的事件记录的ID为正整数
    $id = absint($id);
    if (empty($id))
        return false;
    do_action('coolwp_delete_valuation', $id);
    $sql = $wpdb->prepare("DELETE from {$wpdb->company_valuation} WHERE id = %d", $id);
    if (!$wpdb->query($sql))
        return false;
    do_action('coolwp_deleted_valuation', $id);
    return true;
}
