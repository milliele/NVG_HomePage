<?php get_header(); ?>

<div id="left" class="eleven columns" >

<?php if (have_posts()) : $cnt=0;?>
<?php while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<?php if($cnt>0) : ?>
			<hr class="split">
		<?php endif; $cnt=$cnt+1;?>
		<div class="title">
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<div class="postmeta"> 	<span><?php
					//作者
					$aus = explode(",",get_post_meta(get_the_ID(),'author_info_value',true));
					$query = new WP_Query( array( 'post_type' => 'people', 'post__in' => $aus ) );
					$is_emp = true;
					while($query->have_posts()){
						$query->the_post();
						$en_name = ucwords(get_post_meta(get_the_ID(),'en_name_value', true));
						if($is_emp) $is_emp=false;
						else echo ", ";
						echo "<a href='".get_the_permalink()."'>".$en_name;
						echo "</a>";
					}
					wp_reset_postdata();
					?></span> | <span><?php the_time('l, n F Y'); ?></span> | <span><?php
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
							$query = new WP_Query( $args );
							while($query->have_posts()){
								$query->the_post();
								echo "<a href='".get_the_permalink()."'>";
								break;
							}
							wp_reset_postdata();
							echo ucwords(map_slug($term_list[0]->slug))."</a>";
						}

					?></span> </div>
		</div>
	</div>

<?php endwhile; ?>

<?php getpagenavi(); ?>

<?php else : ?>

	<h1 class="title">Not Found</h1>
	<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>