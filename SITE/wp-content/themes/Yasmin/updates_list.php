<?php
/*
	Template Name: Update List
*/
?>
<?php get_header(); ?>

<div id="left" class="eleven columns">
	<?php
	$query = new WP_Query(array('category_name' =>'updates', 
					'posts_per_page' =>10
				));
	//$wp_query->query('paged='.$paged);
	?>
	<?php while ($query->have_posts()) : $query->the_post(); ?>
		
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="title">
				<h2>
					【<?php the_category(', '); ?>】
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="postmeta"> 	<span>Posted by <?php the_author_posts_link(); ?></span> | <span><?php the_time('l, n F Y'); ?></span> 
					<?php
						//研究方向
						$term_list = wp_get_post_terms(get_the_ID(), 'research');
						foreach ($term_list as $te)
						{
							$args = array(
								'post_type' => 'post',
								'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'category',
										'field'    => 'slug',
										'terms'    => 'researches',
									),
									array(
										'taxonomy' => 'research',
										'field'    => 'slug',
										'terms'    => $te->slug
									)
								)
							);
							$query_research = new WP_Query( $args );
							if($query_research->have_posts()){
								echo "| <span>";
								$query_research->the_post();
								echo "<a href='".get_the_permalink()."'>";
								echo ucwords(map_slug($term_list[0]->slug))."</a>";
								echo "</span>";
							}
							wp_reset_postdata();
						}

						?> </div>
			</div>

			<div class="entry">
			<?php $image_attr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'top_feature'); ?>	
				<img src="<?php echo $image_attr[0]; ?>" class="postim scale-with-grid"  >
				<?php wpe_excerpt('wpe_excerptlength_archive', ''); ?>
				<div class="clear"></div>
			</div>
		</div>

	<?php endwhile; ?>

	<?php getpagenavi(); ?>
	
	<?php wp_reset_postdata(); ?>	
				
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
