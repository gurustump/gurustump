<?php
/*
 Template Name: Index Page
*/
?>

<?php get_header(); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="sub-header">
				<header class="page-header">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</header>
				<?php $headerGalleryMeta = get_post_meta(get_the_ID(), '_gurustump_page_index_gallery', true);
				if ($headerGalleryMeta) { ?>
				<ul class="rotating-gallery SUBHEAD_CAROUSEL">
					<?php $headerGalleryCounter = 0;
					foreach ($headerGalleryMeta as $key => $image) {
						$imageSrc = wp_get_attachment_image_src($key, 'extra-large');
						?>
						<li<?php echo $headerGalleryCounter == 0 ? ' class="active"' : ''; ?> style="background-image:url(<?php echo $imageSrc[0]; ?>)">
							<?php /* <img src="<?php echo $imageSrc[0]; ?>" /> */ ?>
						</li>
						<?php $headerGalleryCounter++; ?>
					<?php }; ?>
				</ul>
				<?php } ?>
				<?php $submenuMeta = get_post_meta(get_the_ID(), '_gurustump_page_submenu', true);
				if ($submenuMeta) { ?>
				<nav class="index-nav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php wp_nav_menu(array(
							 'container' => false,                           // remove nav container
							 'container_class' => 'menu',                 // class of container (should you choose to use it)
							 'menu' =>  $submenuMeta,  // nav name
							 'menu_class' => 'index-menu',               // adding custom nav class
							 //'theme_location' => 'video-index',                 // where it's located in the theme
							 'before' => '',                                 // before the menu
							   'after' => '',                                  // after the menu
							   'link_before' => '',                            // before each link
							   'link_after' => '',                             // after each link
							   'depth' => 0,                                   // limit the depth of the nav
							 'fallback_cb' => ''                             // fallback function (if there is one)
					)); ?>
				</nav>
				<?php } ?>
			</div>
			<div id="content">
				<div id="inner-content" class="wrap cf">
						<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/WebPage">
							<div id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> >
								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									?>
								</section>
								<footer class="article-footer">
									<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
								</footer>
							</div>
						</main>
						<?php get_sidebar(); ?>
				</div>
			</div> <?php // end content ?>
			<?php $fileMeta = get_post_meta(get_the_ID(), '_gurustump_page_file', true);
			if ($fileMeta) { ?>
			<div class="ov vid-player-container OV VID_PLAYER_OV">
				<div class="vid-player-wrapper ov-inner-wrapper VID_PLAYER_WRAPPER">
					<video preload="auto" controls>
						<source src="<?php echo $fileMeta; ?>" type="video/mp4">
					</video>
				</div>
				<a class="ov-close OV_CLOSE" href="#">Close</a>
			</div>
			<?php } ?>
			<?php endwhile; endif; ?>

<?php get_footer(); ?>
