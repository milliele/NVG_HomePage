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
			<div class="postmeta"> 	<span>Posted by <?php the_author_posts_link(); ?></span> | <span><?php the_time('l, n F Y'); ?></span> | <span><?php the_category(', '); ?></span> </div>
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
