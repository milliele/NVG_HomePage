<?php

// 先定义好function们

//用于注册“成员文章类型”
function my_custom_init()
{
    $labels = array(
        'name' => '成员',
        'singular_name' => '成员',
        'add_new' => '添加新成员',
        'add_new_item' => '添加一个新成员',
        'edit_item' => '编辑成员信息',
        'new_item' => '新成员',
        'view_item' => '查看成员',
        'search_items' => '搜索成员',
        'not_found' =>  '未找到有关成员信息',
        'not_found_in_trash' => '回收站内没有相关成员信息',
        'parent_item_colon' => '',
        'menu_name' => '成员管理'

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor','revisions', 'page-attributes','thumbnail','excerpt')
    );
    register_post_type('people',$args);
}

// 添加各种表单信息
function people_metabox() {
    //“简介”表单信息
    if ( function_exists('add_meta_box') ) {
        add_meta_box(
            'people_information',
            '成员介绍信息',
            'people_information_meta_box',
            'people',
            'advanced',
            'core'
        );
        add_meta_box(
            'people_other_information',
            '成员基本信息',
            'people_other_information_meta_box',
            'people',
            'side'
        );
    }
}
//侧边其它信息表单HTML代码
$people_input_settings = array(
    "is_graduate" => array(
        "name" => "is_graduate",
        "placeholder" => "",
        "std" => "已毕业",
        "title" => "是否毕业",
        "type" => "checkbox",
        "value" =>"",
        "length" => -1
    ),
    "institute" => array(
        "name" => "institute",
        "placeholder" => "",
        "std" => "",
        "title" => "所属机构",
        "type" => "text",
        "value" =>"",
        "length" => -1
    ),
    "en_name" => array(
        "name" => "en_name",
        "placeholder" => "",
        "std" => "",
        "title" => "英文姓名",
        "type" => "text",
        "value" =>"",
        "length" => -1
    ),
    "homepage_link" => array(
        "name" => "homepage_link",
        "placeholder" => "",
        "std" => "个人主页的URL，可以是本站主页也可以是自己的主页",
        "title" => "主页链接",
        "type" => "text",
        "value" =>"",
        "length" => -1
    ),
    "contact_addr" => array(
        "name" => "contact_addr",
        "placeholder" => "",
        "std" => "",
        "title" => "通讯地址",
        "type" => "text",
        "value" =>"",
        "length" => -1
    ),
    "phone" => array(
        "name" => "phone",
        "placeholder" => "",
        "std" => "",
        "title" => "电话号码",
        "type" => "text",
        "value" =>"",
        "length" => -1
    ),
    "fax" => array(
        "name" => "fax",
        "placeholder" => "",
        "std" => "",
        "title" => "传真",
        "type" => "text",
        "value" =>"",
        "length" => -1
    ),
    "email_addr" => array(
        "name" => "email_addr",
        "placeholder" => "",
        "std" => "",
        "title" => "邮箱",
        "type" => "text",
        "value" =>"",
        "length" => -1
    )
);

function people_other_information_meta_box($post) {
    global $people_input_settings;
    foreach($people_input_settings as $meta_box) {
        // 获取之前存储的值
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
        if($meta_box_value != "")
            $meta_box['value'] = $meta_box_value;//将默认值替换为以保存的值

        echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

        //通过选择类型输出不同的html代码
        switch ( $meta_box['type'] ){
            case 'title':
                echo'<h4>'.$meta_box['title'].'</h4>';
                break;
            case 'text':
                echo'<h4>'.$meta_box['title'].'</h4>';
                echo '<input type="text" maxlength="'.$meta_box['length'].'" size="32" name="'.$meta_box['name'].'_value" placeholder="'.$meta_box['placeholder'].'" value="'.$meta_box['value'].'" /><br />';
                if($meta_box['std']!='') echo '<p>'.$meta_box['std'].'</p>';
                break;
            case 'checkbox':
                echo'<h4>'.$meta_box['title'].'</h4>';
                if( isset($meta_box['value']) && $meta_box['value'] == 'true')
                    $checked = 'checked = "checked"';
                else
                    $checked  = '';
                echo '<input type="checkbox" name="'.$meta_box['name'].'_value" value="true"  '.$checked.' />';
                echo '<label for="'.$meta_box['name'].'_value">'.$meta_box['std'].'</label>';
                break;
        }
    }
}

// 个人简介分为几个域，分别保存这些域的域名
$intro_field = array(
    array(
        'title'=>'positions',
        'slug'=>'position'
    ),
    array(
        'title'=>'honors &amp; awards',
        'slug'=>'haa'
    ),
    array(
        'title'=>'recent interests',
        'slug'=>'rec-interest'
    ),
    array(
        'title'=>'recent projects',
        'slug'=>'rec-project'
    )
);

function people_information_meta_box($post) {
    global $intro_field;
    $settings = array(
        'textarea_rows' => 5
    );
    foreach($intro_field as $onetiny)
    {
        echo '<input type="hidden" name="'.$onetiny['slug'].'_noncename" id="'.$onetiny['slug'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
        echo'<h3 sytle="text-transform:capitalize">'.$onetiny['title'].'</h3>';
        $data = get_post_meta($post->ID, $onetiny['slug']."_meta_eidtor_value", true);
        wp_editor( $data, $onetiny['slug']."_meta_eidtor_value", $settings);
    }
}

function people_save_meta_box($post_id){
    global $people_input_settings,$intro_field;

    foreach($people_input_settings as $meta_box) {
        if(!isset($_POST[$meta_box['name'].'_noncename'])){
            return $post_id;
        }
        if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))  {
            return $post_id;
        }

        //检查权限
        if ( !current_user_can( 'edit_post', $post_id )){
            return $post_id;
        }

        $data = $_POST[$meta_box['name'].'_value'];
        $prev = get_post_meta($post_id, $meta_box['name'].'_value',true);
        if($prev == "")
        {
            if(!add_post_meta($post_id, $meta_box['name'].'_value', $data, true)){
                update_post_meta($post_id, $meta_box['name'].'_value', $data);
            }
        }
        elseif($data != $prev)
            update_post_meta($post_id, $meta_box['name'].'_value', $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'].'_value', $prev);
    }
    foreach($intro_field as $onetiny)
    {
        if(!isset($_POST[$onetiny['slug'].'_noncename'])){
            return $post_id;
        }
        if ( !wp_verify_nonce( $_POST[$onetiny['slug'].'_noncename'], plugin_basename(__FILE__) ))  {
            return $post_id;
        }

        //检查权限
        if ( !current_user_can( 'edit_post', $post_id )){
            return $post_id;
        }

        $prev = get_post_meta($post_id, $onetiny['slug']."_meta_eidtor_value", true);
        $data = $_POST[$onetiny['slug']."_meta_eidtor_value"];
        if($prev == ""){
            if(!add_post_meta($post_id, $onetiny['slug']."_meta_eidtor_value", $data, true)){
                update_post_meta($post_id, $onetiny['slug']."_meta_eidtor_value", $data);
            }
        }
        elseif($data != $prev)
            update_post_meta($post_id, $onetiny['slug']."_meta_eidtor_value", $data);
        elseif($data == "")
            delete_post_meta($post_id, $onetiny['slug']."_meta_eidtor_value", $prev);
    }
    return $post_id;
}

function add_new_people_columns($book_columns) {

    $new_columns['cb'] = '<input type="checkbox" />';//这个是前面那个选框，不要丢了
    $new_columns['id'] = __('ID');
    $new_columns['title'] = '姓名';
    $new_columns['homepage_link'] = '个人主页';
    $new_columns['taxonomy-people_category'] = '所属分类';
    $new_columns['date'] = _x('Date', 'column name');

    //直接返回一个新的数组
    return $new_columns;
}

function manage_people_columns($column_name, $id) {
    switch ($column_name) {
        case 'id':
            echo $id;
            break;
        default:
            echo get_post_meta($id, $column_name.'_value', true);
            break;
    }
}

//再添加动作
add_action('init', 'my_custom_init');	//添加“成员”文章类型
add_action( 'add_meta_boxes', 'people_metabox' );	//为“成员”文章类型添加表单信息
add_action( 'save_post', 'people_save_meta_box' );	//保存“成员”文章类型的表单信息
add_filter('manage_people_posts_columns', 'add_new_people_columns');  //自定义“成员”文章类型列信息
add_action('manage_people_posts_custom_column', 'manage_people_columns', 10, 2);    //为列信息填充值








