<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Movie">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php $showMeta = get_post_meta(get_the_ID()); ?>
						<div class="video-wrapper">
							<div class="video-controls">
								<a class="video-thumb TRIGGER_VIDEO" href="#">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
								</a>
								<a class="btn TRIGGER_VIDEO" href="#">Play</a>
								<div class="vid-playing-next-mobile VID_PLAYING_NEXT_MOBILE">
									<p>Going to next video in <span class="next-play-countdown NEXT_PLAY_COUNTDOWN_MOBILE">10</span> seconds:</p>
									<h3><a href="<?php echo get_permalink($itemMeta['_skinsplex_media_item_next_video'][0]); ?>"><?php echo get_the_title($itemMeta['_skinsplex_media_item_next_video'][0]); ?></a></h3>
									<a class="video-thumb" href="<?php echo get_permalink($itemMeta['_skinsplex_media_item_next_video'][0]); ?>">
										<?php echo get_the_post_thumbnail($itemMeta['_skinsplex_media_item_next_video'][0], 'media-item-thumb'); ?>
									</a>
									<div class="actions">
										<a class="cancel CANCEL_AUTOPLAY_MOBILE">Cancel Next Video</a>
										<a href="<?php echo get_permalink($itemMeta['_skinsplex_media_item_next_video'][0]); ?>">Go Now</a>
									</div>
								</div>
							</div>
							<?php
								/*
								 * Ah, post formats. Nature's greatest mystery (aside from the sloth).
								 *
								 * So this function will bring in the needed template file depending on what the post
								 * format is. The different post formats are located in the post-formats folder.
								 *
								 *
								 * REMEMBER TO ALWAYS HAVE A DEFAULT ONE NAMED "format.php" FOR POSTS THAT AREN'T
								 * A SPECIFIC POST FORMAT.
								 *
								 * If you want to remove post formats, just delete the post-formats folder and
								 * replace the function below with the contents of the "format.php" file.
								*/
								get_template_part( 'post-formats/format', get_post_format() );
							?>
						</div>
						<?php endwhile; endif; ?>

					</main>

					<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
