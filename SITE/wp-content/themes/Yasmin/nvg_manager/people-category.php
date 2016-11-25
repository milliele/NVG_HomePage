<?php
//先定义所有函数
function people_taxonomies() {
    $labels = array(
        'name' => '成员分类',
        'singular_name' => 'people_category',
        'search_items' =>  '搜索成员分类' ,
        'popular_items' => '常用成员分类' ,
        'all_items' => '所有成员分类' ,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => '编辑成员分类' ,
        'update_item' => '更新成员分类' ,
        'add_new_item' => '添加成员分类' ,
        'new_item_name' => '成员分类',
        'separate_items_with_commas' => '按逗号分开' ,
        'add_or_remove_items' => '添加或删除',
        'choose_from_most_used' => '从经常使用的类型中选择',
        'menu_name' => '成员分类',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'people_category' )
    );
    register_taxonomy( 'people_category', array('people'), $args );
}

// 添加各种表单信息
function people_category_field_small() {
    echo '<div class="form-field">';
    echo '<label for="people_cat_priority" >显示优先级</label>';
    echo '<input type="text" size="" value="" id="people_cat_priority" name="people_cat_priority"/>';
    echo '<p>该分类在“人员队伍”页面上的显示优先级，为整数</p>';
    echo '</div>';
}

function people_category_field_edit($tag){
    echo '<tr><th>显示优先级</th><td><input type="text" size="" value="'.get_term_meta($tag->term_id, 'people_cat_priority',true).'" id="people_cat_priority" name="people_cat_priority"/><p class="description">该分类在“人员队伍”页面上的显示优先级，为整数</p></td></tr>';
}

//保存数据接受的参数为分类ID
function people_category_metadata($term_id){
    if(isset($_POST['people_cat_priority'])){
        //判断权限--可改
        if(!current_user_can('manage_categories')){
            return $term_id ;
        }

        $data = $_POST['people_cat_priority'];
        $old = get_term_meta($term_id , 'people_cat_priority',true);
        if(is_numeric($data))
        {
            if($old == ""){
                //如果数据库中没有就新添加
                add_term_meta($term_id , 'people_cat_priority', $data, true);
            }elseif($data != $old){
                //如果更改了就更新
                update_term_meta($term_id , 'people_cat_priority', $data);
            }
        }
        elseif($old == ""){
            //如果数据库中没有就新添加
            add_term_meta($term_id , 'people_cat_priority',0, true);
        }
    }
    return $term_id ;
}

function add_new_people_category_columns($columns) {
    $columns['people_cat_priority']='显示优先级';
    return $columns;
}

function manage_people_category_columns($notknow, $column_name, $id) {
    return get_term_meta($id, $column_name,true);
}

function add_new_people_category_sortable_columns($columns) {
    $columns['people_cat_priority']='people_cat_priority';
    return $columns;
}

function people_category_asc($a,$b)
{
    $data_a = (int)get_term_meta($a->term_id, 'people_cat_priority', true);
    $data_b = (int)get_term_meta($b->term_id, 'people_cat_priority', true);
    if($data_a== $data_b) return 0;
    return ($data_a<$data_b)?-1:1;
}

function people_category_desc($a,$b)
{
    return (-1)*people_category_asc($a,$b);
}

function sort_people_category_columns( $terms, $taxonomies, $args ) {
    if(strtolower($args['orderby']) =='people_cat_priority') {
        usort($terms, 'people_category_'.strtolower($args['order']));
    }
    return $terms;
}

//再添加动作
add_action('init', 'people_taxonomies');
add_action('people_category_edit_form_fields','people_category_field_edit',10,2);  //在单独编辑页面添加
add_action('people_category_add_form_fields','people_category_field_small');    //在新建页面显示
//虽然要两个钩子，但是我们可以两个钩子使用同一个函数
add_action('created_people_category', 'people_category_metadata', 10, 1);
add_action('edited_people_category','people_category_metadata', 10, 1);
add_filter('manage_people_category_taxonomy_columns', 'add_new_people_category_columns',10,1);  //自定义类型列信息
add_filter('manage_people_category_custom_column', 'manage_people_category_columns',10,3);    //为列信息填充值
add_filter('manage_people_category_taxonomy_sortable_columns', 'add_new_people_category_sortable_columns',10,1); //增加分类各类
add_filter( 'get_terms', 'sort_people_category_columns',10,3);



