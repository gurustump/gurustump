<?php
/*
 Template Name: Gallery Type Switcher
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
								<?php $galleryType = get_post_meta(get_the_ID(), '_gurustump_page_gallery_type', true); ?>
								<div class="simple-page-heading">
									<h1 class="wrap"><?php the_title(); ?></h1>
								</div>
								<section class="body-content wrap cf" itemprop="articleBody">
									<?php if (get_the_content()) { ?>
									<div class="body-content-inner"><?php the_content(); ?></div>
									<?php } ?>
									<?php /* if ($galleryType == 'movie-gallery') { ?>
										<div class="cat-selector">
											<h2>Gallery Type:</h2>
											<?php $showCats = (get_terms('show_cat')); ?>
											<div class="select-container">
												<select class="TYPE_SELECT">
													<option value="type-basic">Basic</option>
													<option value="type-expanding-thumb">Expanding Thumbnails</option>
												</select>
											</div>
										</div>
									<?php } */ ?>
								<?php 
								if ($galleryType == 'movie-gallery') {
									$items = get_posts(array(
											'posts_per_page'=>-1,
											'post_type'=>'shows'/*,
											'orderby'=>'title',
											'order'=>'ASC',
											'media_item_cat'=> $mediaItemCat*/
									));
									if (count($items) > 0) { 
									?>
									<div class="vid-container">
										<div class="video-player-static-container">
											<div class="vid-player-container VID_PLAYER">
												<div class="vid-player-wrapper ov-inner-wrapper VID_PLAYER_WRAPPER">
													<div class="vid-playing-next">
														<p>Playing next in <span class="next-play-countdown NEXT_PLAY_COUNTDOWN"></span> seconds:</p>
														<h3><a class="VID_NEXT_PAGE VID_NEXT_TITLE" href=""></a></h3>
														<a class="VID_NEXT_PAGE video-thumb" href="">
															<img class="VID_NEXT_THUMB" src="" alt="" />
														</a>
														<div class="actions">
															<a class="cancel CANCEL_AUTOPLAY">Cancel Autoplay</a>
															<a class="VID_NEXT_PAGE play-now" href="">Play Now</a>
														</div>
													</div>
													<div id="video_player"></div>
													<div class="hidden">
														<input class="VID_PLAYER_CURRENT_ID" type="hidden" value="" />
														<input class="VID_NEXT_ID" type="hidden" value="" />
														<input class="VID_CREDITS_TIMECODE" type="hidden" value="" />
													</div>
												</div>
											</div>
										</div>
										<div class="video-thumb-index">
											<div class="thumb-index-inner">
												<ul class="thumb-index-list VID_THUMBS_LIST">
													<?php global $post;
													foreach($items as $key => $item) {
														$post = $item;
														setup_postdata($post);
														$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'movie-thumb'); $itemMeta = get_post_meta(get_the_ID());
														$show_cats = get_the_terms($item->ID, 'show_cat');
														$show_cat_class_string = '';
														if ($show_cats) {
															foreach($show_cats as $show_cat) {
																$show_cat_class_string .= ' cat-'.$show_cat->slug;
															}
														}
														$nextVideoUrl = get_permalink($itemMeta['_gurustump_show_next_video'][0]);
														$nextVideoMeta = get_post_meta($itemMeta['_gurustump_show_next_video'][0]);
														$nextVideoID = $nextVideoMeta['_gurustump_show_video_ID'][0];
														$nextVideoTitle = get_the_title($itemMeta['_gurustump_show_next_video'][0]);
														$nextVideoThumbArray = wp_get_attachment_image_src(get_post_thumbnail_id($itemMeta['_gurustump_show_next_video'][0]), 'movie-thumb', true);
														$nextVideoThumb = $nextVideoThumbArray[0];
														$creditsTimecode = $itemMeta['_gurustump_show_credits_timecode'][0];
														//skip this iteration if the video can't be played locally
														if (!$itemMeta['_gurustump_show_video_ID'][0]) { continue; }
														?>
														<li class="<?php echo trim($show_cat_class_string); ?>">
															<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
															<div class="actions">
																<span class="item-head"><span><?php the_title(); ?></span></span>
																<?php if ($itemMeta['_gurustump_show_offsite_url'][0]) { ?>
																<a class="btn-external" target="_blank" href="<?php echo $itemMeta['_gurustump_show_offsite_url'][0]; ?>">Open External Link</a>
																<?php } else if ($itemMeta['_gurustump_show_video_ID'][0]) { ?>
																<a class="btn-play VIDEO_PLAY" href="<?php the_permalink(); ?>" 
																	data-video-ID="<?php echo $itemMeta['_gurustump_show_video_ID'][0]; ?>"
																	data-next-ID="<?php echo $nextVideoID; ?>"
																	data-next-page="<?php echo $nextVideoUrl; ?>"
																	data-next-title="<?php echo $nextVideoTitle; ?>"
																	data-next-thumb-src="<?php echo $nextVideoThumb; ?>"
																	data-credits-timecode="<?php echo $creditsTimecode; ?>"
																>Play Movie</a>
																<?php } ?>
																<?php /*<a class="btn-info<?php echo ($itemMeta['_gurustump_show_offsite_url'][0] || $itemMeta['_gurustump_show_video_ID'][0]) ? '' : ' full-width'; ?>" href="<?php the_permalink(); ?>">View Details</a> */ ?>
															</div>
														</li>
													<?php } ?>
												</ul>
											</div>
										</div>
									</div>
									<?php } 
								} ?>
								</section>

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

			<?php // include 'library/includes/video-player.php'; ?>

<?php get_footer(); ?>
