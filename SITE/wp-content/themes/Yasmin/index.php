<?php get_header(); ?>
<?php if (ft_of_get_option('fabthemes_feat_slide')== "1") { ?>
<div class="container intro" id="feature">
	<div class="six columns">
	<div class="welcome">
		<h2>我们的团队 Our Team</h2>
		<p>网络视频组隶属于北京大学计算机所，目前拥有一位教授，一位副教授，两名博士研究生以及六名硕士研究生。</p>
		<p>The Net Video Group (NVG) locates at Peking University. Currently we have one professor and one associate professor, two PhD students and six Master students.</p>
		<h2>研究方向 Our Interests</h2>
		<ul>
			<?php
				$args = array("taxonomy"=>"research");
				$res = get_categories($args);
				foreach($res as $t)
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
								'terms'    => $t->slug
							)
						)
					);
					$query = new WP_Query( $args );
					while($query->have_posts()){
						$query->the_post();
						$url = get_the_permalink();
						break;
					}
					wp_reset_postdata();
					echo "<li>".$t->name."<br>".ucwords(map_slug($t->slug))."&nbsp&nbsp&nbsp&nbsp<a href='".$url."'>Details>></a></li>";
				}
			?>
		</ul>
		</div>
	</div>
	<div class="ten columns">
		<div class="flexslider">
		    <ul class="slides">
			
		    <?php 	//$count = ft_of_get_option('fabthemes_slide_number');
					//$slidecat = ft_of_get_option('fabthemes_slide_categories');	
				$query = new WP_Query( array( 'tag' =>'showcase-wall', 'posts_per_page' =>10 ) );
		           	if ($query->have_posts()) : while ($query->have_posts()) :
						$query->the_post();
						if(get_post_thumbnail_id(get_the_ID())!=""):?>
		 	
			<li> 
					<?php $image_attr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'top_feature'); ?>	
					<a href="<?php the_permalink() ?>">	<img src="<?php echo $image_attr[0]; ?>"></a>
					<div class="flex-caption"> 
						<h3> <?php the_title(); ?></h3> 
					</div>
			</li>
			<?php endif;endwhile; endif; ?>
			<?php  ?>
		    </ul>
		</div>
		</div>
</div>

<?php } ?>

 <!-- end feature -->
<?php if (ft_of_get_option('fabthemes_callout_box')== "1") { ?>
<div class="container" id="callout">
	<p> <?php echo ft_of_get_option('fabthemes_callout'); ?> </p>
</div>
<?php } ?>

 <!-- end callout -->

<div class="container" id="recent-posts">
	<div class="eleven columns indexpanel">
		<div class="indexpanel-title">
			<h2>新闻动态</h2>
			<span class="en_name">news</span>
			<span class="toall">
				<?php $bloglink=get_site_url(null,"?cat=7,8,10"); ?>
				<a href="<?php echo $bloglink; ?>">View All <span class="icon-forward3"></span></a>  
			</span>
		</div>
	
	 	<?php 	$query = new WP_Query( array( 'category_name' =>'blog,news,events', 'posts_per_page' =>10 ) );
	           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
	
			<div class="panelpost">	
				<span>【<?php the_category(', ');?>】</span>
				<a href="<?php the_permalink() ?>"><?php yasmin_title(36); ?><span><?php the_time('m-d'); ?></span></a>	
			</div>
	
		<?php endwhile; endif; ?>
	</div>
	<div class="five columns indexpanel">
		<div class="indexpanel-title">
			<h2>通知公告</h2>
			<span class="en_name">announcement</span>
			<span class="toall">
				<?php $bloglink=get_site_url(null,"?cat=9"); ?>
				<a href="<?php echo $bloglink; ?>">View All <span class="icon-forward3"></span></a>  
			</span>
		</div>
	
	 	<?php 	$query = new WP_Query( array( 'category_name' =>'announcements', 'posts_per_page' =>10 ) );
	           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
		
			<div class="panelpost">
				<a href="<?php the_permalink() ?>"><?php yasmin_title(12); ?><span><?php the_time('m-d'); ?></span></a>
			<?php //wpe_excerpt('wpe_excerptlength_index', ''); ?>
			</div>
	
		<?php endwhile; endif; ?>
	</div>
</div>
 <!-- end posts -->
<?php get_footer(); ?>
