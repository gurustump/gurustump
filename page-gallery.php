<?php
/*
 Template Name: Gallery Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="cf">

						<main id="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


							<h1 class="page-title wrap"><?php the_title(); ?></h1>
								<?php if (get_the_content()) { ?>
								<section class="entry-content cf" itemprop="articleBody">
									<?php the_content(); ?>
								</section>
								<?php } 
								//$mediaItemCat = get_post_meta(get_the_ID(), '_skinsplex_index_grid_select', true); 
								$galleryType = get_post_meta(get_the_ID(), '_gurustump_page_gallery_type', true);
								if ($galleryType == 'movie-gallery') {
									$items = get_posts(array(
											'posts_per_page'=>-1,
											'post_type'=>'shows',
											'orderby'=>'title',
											'order'=>'ASC'/*,
											'media_item_cat'=> $mediaItemCat*/
									));
									if (count($items) > 0) { 
									?>
									
									<div class="thumb-index video-thumb-index">
										<div class="thumb-index-inner">
											<ul class="thumb-index-list VID_THUMBS_LIST">
												<?php global $post;
												foreach($items as $key => $item) {
													$post = $item;
													setup_postdata($post);
													$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'movie-thumb'); $itemMeta = get_post_meta(get_the_ID());
													$show_cats = get_the_terms($item->ID, 'show_cat');
													$show_cat_class_string = '';
													foreach($show_cats as $show_cat) {
														$show_cat_class_string .= ' cat-'.$show_cat->slug;
													}
													?>
													<li class="<?php echo trim($show_cat_class_string); ?>">
														<!--<pre><?php print_r( $show_cats ); ?></pre>-->
														<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
														<div class="actions">
															<span class="item-head"><span><?php the_title(); ?></span></span>
															<a class="btn-play VIDEO_PLAY" href="<?php the_permalink(); ?>" data-video-ID="<?php echo $itemMeta['_gurustump_show_video_ID'][0]; ?>">Play Movie</a>
															<a class="video-details" href="<?php the_permalink(); ?>">View Details</a>
														</div>
													</li>
												<?php } ?>
											<ul>
										</div>
									</div>
									<?php } 
								} ?>
						

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

			<?php include 'library/includes/video-player.php'; ?>

<?php get_footer(); ?>
