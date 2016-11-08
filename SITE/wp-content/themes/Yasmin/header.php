<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
    
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
        
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if gte IE 9 ]><html class="no-js ie9" lang="en"> <![endif]-->
    
   <title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); ?></title>
        
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href= "<?php echo get_template_directory_uri(); ?>/style.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/responsive-style.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/flexslider.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/layout.css">


	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php 
	wp_enqueue_script('jquery');
	wp_enqueue_script('custom', get_stylesheet_directory_uri() .'/js/custom.js');
	wp_enqueue_script('superfish', get_stylesheet_directory_uri() .'/js/superfish.js'); 
	wp_enqueue_script('flexslider', get_stylesheet_directory_uri() .'/js/jquery.flexslider-min.js'); 
	wp_enqueue_script('mobilemenu', get_stylesheet_directory_uri() .'/js/jquery.mobilemenu.js'); 
	wp_enqueue_script('fitvid', get_stylesheet_directory_uri() .'/js/fitvid.js'); 
?>



<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
       
</head>

<body <?php body_class(); ?>><!-- the Body  -->

<header id="header">
	<div class="container toptop-bar">
		<div class="pkulogo">
			<img src="<?php echo get_template_directory_uri(); ?>/images/pkulogo.png" alt="Peking University"/>
		</div>
		<div class="func">
			<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			</ul>
		</div>
		<div class="search-bar">
			<?php get_search_form( ); ?> 
		</div>
	</div>
	<div class="container">
	<div id="head">
		<div id="blogname">	
			<?php if (get_theme_mod(FT_scope::tool()->optionsName . '_logo', '') != '') { ?>
				<h1 class="site-title logo">
				<a class="mylogo" rel="home" href="<?php bloginfo('siteurl');?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					<img relWidth="<?php echo intval(get_theme_mod(FT_scope::tool()->optionsName . '_maxWidth', 0)); ?>" relHeight="<?php echo intval(get_theme_mod(FT_scope::tool()->optionsName . '_maxHeight', 0)); ?>" id="ft_logo" src="<?php echo get_theme_mod(FT_scope::tool()->optionsName . '_logo', ''); ?>" alt="" />
				</a>
				</h1>
			<?php } else { ?>
				<h1 class="site-title logo"><a id="blogname" rel="home" href="<?php bloginfo('siteurl');?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<h2><?php bloginfo( 'description' ); ?> </h2>
			<?php } ?>
		</div>
	</div>
	</div>
	<div class="container main-menu">
		<div id="botmenu">
			<?php 
				wp_nav_menu( array( 'container_id' => 'subnav', 'link_after' => '<br>', 'theme_location' => 'primary','menu_id'=>'web2feel' ,'menu_class'=>'sfmenu','fallback_cb'=> 'fallbackmenu' , 'walker' => new My_Walker_Nav_Menu()) ); ?>
		</div>
	</div>
</header>
 <div class="container" id="casing">