<?php
/*
	Template Name: People-display
*/
?>
<?php get_header(); ?>

<div id="left" class="eleven columns">
	<?php
		$args = array("taxonomy"=>"people_category");
		$res = get_categories($args);
		usort($res, 'people_category_sort');
		$temp = $wp_query;
		$wp_query= null;
		$cnt=0;
		foreach ($res as $tax)
		{ ++$cnt;?>
	<div class="post dis-people">

			<div class="title">
				<h1><?php echo $tax->name; ?>&nbsp;&nbsp;<?php echo map_slug($tax->slug); ?></h1>
			</div>
			<hr class="split">
	<?php
			$args = array(
				'post_type' => 'people',
				'tax_query' => array(
					array(
						'taxonomy' => 'people_category',
						'field'    => 'slug',
						'terms'    => $tax->slug
					)
				)
			);
			$wp_query = new WP_Query($args);
			while($wp_query->have_posts()): $wp_query->the_post(); $id = get_the_ID();?>
				<div class="each-people">
					<div class="candidate"><?php
						if(get_post_meta($id,'is_graduate_value',true)!='true') echo 'Candidate';
						else echo 'Graduate';
						?></div>
					<div class="basic-intro">
						<ul>
							<li><span class="icon-user"></span><?php the_title();?>&nbsp;&nbsp;<?php echo map_slug(get_post_meta($id,'en_name_value',true)); ?></li>
							<li><span class="icon-mail4"></span><?php $cont = get_post_meta($id,'email_addr_value',true);
								if(!empty($cont)) echo $cont;
								else echo 'None';?></li>
							<li><span class="icon-home"></span><a href="<?php $hm = get_post_meta($id,'homepage_link_value',true); if($hm=="") $hm = get_the_permalink(); echo $hm;?>">个人主页>></a></li>
						</ul>
					</div>
					<div class="entry">
						<?php wpe_excerpt('wpe_excerptlength_archive', ''); ?>
						<div class="clear"></div>
					</div>
				</div>
		<?php endwhile; ?>
		</div>
			<?php }

	?>
	<?php if($cnt==0): ?>

	<h1 class="title">Not Found</h1>
	<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; $wp_query = null; $wp_query = $temp;?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
