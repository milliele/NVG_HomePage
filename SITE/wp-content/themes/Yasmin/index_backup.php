<?php get_header(); ?>
<?php if (ft_of_get_option('fabthemes_feat_slide')== "1") { ?>
<div class="container intro" id="feature">
	<div class="six columns">
	<div class="welcome">
		<h2>我们的团队	Our Team</h2>
		<p>网络视频组隶属于北京大学计算机所，目前拥有一位教授，一位副教授，两名博士研究生以及六名硕士研究生。</p>
		<p>The Net Video Group (NVG) locates at Peking University. Currently we have one professor and one associate professor, two PhD students and six Master students.</p>
		<h2>研究方向	Our Interests</h2>
		<ul>
			<li>实时视频流媒体技术<br>Real-time video Streaming.&nbsp&nbsp&nbsp&nbsp<a>Details>></a></li>
			<li>基于HTTP的动态自适应流媒体技术<br>Dynamic Adaptive Streaming over HTTP (DASH).&nbsp&nbsp&nbsp&nbsp<a>Details>></a></li>
			<li>信息中心网络<br>Information-centric Networks (ICN).&nbsp&nbsp&nbsp&nbsp<a>Details>></a></li>
		</ul>
		</div>
	</div>
	<div class="ten columns">
		<div class="flexslider">
		    <ul class="slides">
			
		    <?php 	$count = ft_of_get_option('fabthemes_slide_number');
					$slidecat = ft_of_get_option('fabthemes_slide_categories');
					$query = new WP_Query( array( 'cat' => $slidecat,'posts_per_page' =>$count ) );
		           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
		 	
			<li> 
					<?php $image_attr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'top_feature'); ?>	
					<a href="<?php the_permalink() ?>">	<img src="<?php echo $image_attr[0]; ?>"></a>
					<div class="flex-caption"> 
						<h3> <?php the_title(); ?></h3> 
					</div>
			</li>
			<?php endwhile; endif; ?>
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

<div class="container" id="recent-projects">
	
	<div class="four columns leftbox">
		<h2>latest projects</h2>
		<p>These are few latest projects published on my site</p>
		<span><?php $portlink = ft_of_get_option('fabthemes_port_page'); ?> <a href="<?php echo get_page_link($portlink); ?>">View All</a>  </span>
	</div>
	
	 	<?php 	$query = new WP_Query( array( 'post_type' => 'portfolio','posts_per_page' =>'3' ) );
	           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
	
	<div class="four columns rightbox">
					<?php $foliotype = get_post_meta( get_the_ID(), 'WTF_protype', true ); ?>
			<?php if ($foliotype == 'i') { ?>
				<img class="overlay" src="<?php echo get_template_directory_uri(); ?>/images/cover.png">  </img>
			<?php } else { ?>	
				<img class="overlay" src="<?php echo get_template_directory_uri(); ?>/images/mover.png"></img>
		    <?php } ?>
			<?php $image_attr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'index_box'); ?>
			<a href="<?php the_permalink() ?>">	<img src="<?php echo $image_attr[0]; ?>" class="index-img scale-with-grid"></a>
		<div class="panelbox">		
			<h2> <a href="<?php the_permalink() ?>"> <?php the_title(); ?> </a></h2>
			<p> <?php echo get_post_meta( get_the_ID(), 'WTF_subtitle', true ); ?> </p>
			
		</div>	 
	</div>
	
		<?php endwhile; endif; ?>
</div>
 <!-- end projects -->

<div class="container" id="recent-posts">
	<div class="four columns leftbox">
		<h2>latest articles</h2>
		<p>These are few latest articles published on my site</p>
		<span> <?php $bloglink = ft_of_get_option('fabthemes_blog_page'); ?> <a href="<?php echo get_page_link($bloglink); ?>">View All</a>  </span>
	</div>
	
	 	<?php 	$query = new WP_Query( array( 'posts_per_page' =>'3' ) );
	           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
	
	<div class="four columns rightbox">
			<?php $image_attr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'index_wide'); ?>
			<a href="<?php the_permalink() ?>">	<img src="<?php echo $image_attr[0]; ?>" class="index-wideimg scale-with-grid"></a>
	
			<div class="panelpost">
			<h2><a href="<?php the_permalink() ?>"> <?php the_title(); ?> </a></h2> 	
			<span class="paneldate"><?php the_time('l, n F Y'); ?></span>	
			<?php wpe_excerpt('wpe_excerptlength_index', ''); ?>
			</div>
	</div>
	
		<?php endwhile; endif; ?>
</div>
 <!-- end posts -->
<?php get_footer(); ?>