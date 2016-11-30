<?php get_header(); ?>

<div id="left" class="eleven columns" >
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<?php if(get_the_category()[0]->cat_name=="研究方向"): ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<?php
				$research_name="";
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
						$research_name=$cat->slug;
						$title_en=map_slug($cat->slug);		//replace "_" with " "
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
				<?php wp_link_pages(array('before' => '<p><strong>Pages: </strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
			<?php 
				$isShow=false;
				$query = new WP_Query( array( 'category_name' =>'blog,news,events,announcements', 
										'posts_per_page' =>10, 
										'tax_query' => array(
										        array(
					       						    'taxonomy' => 'research',
										            'field'    => 'slug',
										            'terms'    => $research_name,
										        ),
										), ) );
				if($query->have_posts())$isShow=true;
				wp_reset_postdata();
				if($isShow):
			?>
				<div class="post_indexpanel">
					<div class="post_indexpanel-title">
						<h2>相关动态</h2>
						<span class="en_name">updates</span>
						<span class="toall">
							<a href="<?php echo $linka; ?>">View All <span class="icon-forward3"></span></a>  
						</span>
					</div>
		
				 	<?php $query = new WP_Query( array( 'category_name' =>'blog,news,events,announcements', 
											'posts_per_page' =>10, 
											'tax_query' => array(
											        array(
					        						    'taxonomy' => 'research',
											            'field'    => 'slug',
											            'terms'    => $research_name,
											        ),
											), ) );
						if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
			
						<div class="panelpost">	
							<span>【<?php the_category(', '); ?>】</span>
							<a href="<?php the_permalink() ?>"><?php yasmin_title(75); ?><span><?php the_time('m-d'); ?></span></a>	
						</div>
					<?php endwhile; endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
			<?php 
				$isShow=false;
				$query = new WP_Query( array( 'category_name' =>'publication', 
										'posts_per_page' =>10, 
										'tax_query' => array(
										        array(
				        						    'taxonomy' => 'research',
										            'field'    => 'slug',
										            'terms'    => $research_name,
										        ),
										), ) );
				if($query->have_posts())$isShow=true;
				wp_reset_postdata();
				if($isShow):
			?>
				<div class="post_indexpanel">
					<div class="post_indexpanel-title">
						<h2>发表成果</h2>
						<span class="en_name">publication</span>
						<span class="toall">
							<a href="<?php echo $linkp; ?>">View All <span class="icon-forward3"></span></a>  
						</span>
					</div>
		
				 	<?php 	$query = new WP_Query( array( 'category_name' =>'publication', 
											'posts_per_page' =>10, 
											'tax_query' => array(
											        array(
					        						    'taxonomy' => 'research',
											            'field'    => 'slug',
											            'terms'    => $research_name,
											        ),
											), ) );
						if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
				
						<div class="panelpost">	
							<a href="<?php the_permalink() ?>"><?php yasmin_title(75); ?><span><?php the_time('m-d'); ?></span></a>	
						</div>
					<?php endwhile; endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
		</div>
	
	<?php else: ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="title">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
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
						
				<?php the_content('Read the rest of this entry &raquo;'); ?>
				<div class="clear"></div>
				<?php wp_link_pages(array('before' => '<p><strong>Pages: </strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>	
		<?php comments_template(); ?>
	<?php endif; ?>
	<?php endwhile; endif; ?>	
</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
