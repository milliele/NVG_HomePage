<?php
function FT_OP_update()
{
	$settings = get_option('ft_op');
	$settings['id'] = 'ft_' . FT_scope::tool()->optionsName;
	update_option('ft_op', $settings);
}

function FT_OP_options()
{
	
	// Test data
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
	
	
	$options[] = array( "name" => "General ",
						"type" => "heading");	
						
	$options[] = array( "name" => "Twitter id",
						"desc" => "Enter your twitter id.",
						"id" => "fabthemes_twitter",
						"std" => "twitter",
						"type" => "text");		

	$options[] = array( "name" => "Facebook",
						"desc" => "Enter your facebook page url.",
						"id" => "fabthemes_facebook",
						"std" => "",
						"type" => "text");							
							
	$options[] = array( "name" => "Google plus",
						"desc" => "Enter your Google plus profile link. Use http://gplus.to/",
						"id" => "fabthemes_google",
						"std" => "",
						"type" => "text");			
		
	$options[] = array( "name" => "Linkedin",
						"desc" => "Enter your Linkedin profile link.",
						"id" => "fabthemes_linkedin",
						"std" => "",
						"type" => "text");			
		
		
	$options[] = array( "name" => "Homepage ",
						"type" => "heading");			
		
	$options[] = array( "name" => "Featured image slider",
						"desc" => "Check if you want to show the featured slider.",
						"id" => "fabthemes_feat_slide",
						"std" => "1",
						"type" => "checkbox");			
		
		
	$options[] = array( "name" => "Featured Slider Category",
						"desc" => "Select the category for featured slider",
						"id" => "fabthemes_slide_categories",
						"type" => "select",
						"options" => $options_categories);		
		
	$options[] = array( "name" => "Number of slider items",
						"desc" => "Set the number of items on the featured slider.",
						"id" => "fabthemes_slide_number",
						"std" => "4",
						"class" => "mini",
						"type" => "text");	
							
						
	$options[] = array( "name" => "Callout text box",
						"desc" => "Check if you want to show the callout box.",
						"id" => "fabthemes_callout_box",
						"std" => "1",
						"type" => "checkbox");	
	
	$options[] = array( "name" => "Callout box content",
						"desc" => "Enter the content to be shown in the callout box",
						"id" => "fabthemes_callout",
						"type" => "textarea");		
	
	$options[] = array( "name" => "Portfolio page",
						"desc" => "Select the portfolio page",
						"id" => "fabthemes_port_page",
						"type" => "select",
						"options" => $options_pages);		
	
	$options[] = array( "name" => "Blog page",
						"desc" => "Select the blog page",
						"id" => "fabthemes_blog_page",
						"type" => "select",
						"options" => $options_pages);	

						

	if (file_exists(dirname(__FILE__) . '/FT/options/banners.php'))
			include ('FT/options/banners.php');

	if (file_exists(dirname(__FILE__) . '/FT/options/colors.php'))
			include ('FT/options/colors.php');

	if (file_exists(dirname(__FILE__) . '/FT/options/common.php'))
			include ('FT/options/common.php');

	return $options;
}