<?php
/*
	Template Name: Research List
*/
?>
<?php get_header(); ?>

<div id="left" class="eleven columns">
	<?php
	$query = new WP_Query(array('category_name' =>'researches', 
				'orderby' => 'ID',
				'order'   => 'ASC',
				));
	//$wp_query->query('paged='.$paged);
	?>
	<?php while ($query->have_posts()) : $query->the_post(); ?>
			
		<div class="post" id="post-<?php the_ID(); ?>">
			<?php
				$linka="";
				$linkp="";
		
				$args=array("taxonomy"=>"research");
				$res=get_categories($args);
				$title=get_the_title();
				$title_en="";
				foreach($res as $cat)
				{
					if($title==$cat->name)
					{
						$linka=get_site_url(null,"?cat=6&research=".$cat->slug);
						$linkp=get_site_url(null,"?cat=69&research=".$cat->slug);
						$title_en=map_slug($cat->slug);
					}
				}	
				?>
			<div class="title">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(""," ".$title_en); ?>">
					<?php the_title(""," <br />".$title_en); ?>
				</a></h2>
			</div>
			<div class="postlink">	
				<span><a href="<?php echo $linka; ?>">Updates</a></span>
				<span><a href="<?php echo $linkp; ?>">Publication</a></span>
			</div>
		
			<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
					<div class="clear"></div>
			</div>	
		</div>

	<?php endwhile; ?>

	<?php getpagenavi(); ?>
	
	<?php wp_reset_postdata(); ?>	
				
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
