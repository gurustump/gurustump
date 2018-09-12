<?php get_header(); ?>
			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Movie">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php $showMeta = get_post_meta(get_the_ID()); 
						$nextVideoMeta = get_post_meta($showMeta['_gurustump_show_next_video'][0]); 
						$nextVideoThumbArray = wp_get_attachment_image_src(get_post_thumbnail_id($showMeta['_gurustump_show_next_video'][0]), 'movie-thumb', true); ?>
						<div class="video-wrapper">
							<?php if ($showMeta['_gurustump_show_offsite_url'][0]) { ?>
							<a class="video-controls external-link" href="<?php echo $showMeta['_gurustump_show_offsite_url'][0]; ?>" target="_blank">
								<span class="video-thumb">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
								</span>
								<span class="btn-external" href="#"></span>
							</a>
							<?php } else if ($showMeta['_gurustump_show_video_ID'][0]) { ?>
							<a class="video-controls TRIGGER_VIDEO" href="#"
								data-video-ID="<?php echo $showMeta['_gurustump_show_video_ID'][0]; ?>"
								data-next-ID="<?php echo $nextVideoMeta['_gurustump_show_video_ID'][0]; ?>"
								data-next-page="<?php echo $showMeta['_gurustump_show_next_video'][0] ? get_permalink($showMeta['_gurustump_show_next_video'][0]) : ''; ?>"
								data-next-title="<?php echo get_the_title($showMeta['_gurustump_show_next_video'][0]); ?>"
								data-next-thumb-src="<?php echo $nextVideoThumbArray[0]; ?>"
								data-credits-timecode="<?php echo $showMeta['_gurustump_show_credits_timecode'][0]; ?>">
								<span class="video-thumb">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
								</span>
								<span class="btn-play" href="#"></span>
							</a>
							<?php } else { ?>
							<span class="video-thumb">
								<?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
							</span>
							<?php } ?>
						</div>
						<article id="post-<?php the_ID(); ?>" role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
							<header class="show-header">
								<h1 class="show-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
								<?php // if (/* $showMeta['_gurustump_show_duration'][0] || */ $showMeta['_gurustump_show_age_restriction'][0] || /* $showMeta['_gurustump_show_country'][0] || */ $itemMeta['_gurustump_show_imdb_url'][0] || $itemMeta['_gurustump_show_view_url'][0]) { ?>
								<div class="show-info">
									<table class="data-table">
										<?php /* if ($showMeta['_gurustump_show_duration'][0]) { ?>
										<tr>
											<td>Duration</td>
											<td><?php echo $showMeta['_gurustump_show_duration'][0]; ?> min.</td>
										</tr>
										<?php } */ ?>
										<?php if ($showMeta['_gurustump_show_imdb_url'][0]) { ?>
										<tr>
											<td>IMDb Page</td>
											<td><a href="<?php echo $showMeta['_gurustump_show_imdb_url'][0]; ?>" target="_blank"><?php echo $showMeta['_gurustump_show_imdb_url'][0]; ?></a></td>
										</tr>
										<?php } ?>
										<?php if ($showMeta['_gurustump_show_view_url'][0]) { ?>
										<tr>
											<td>On the web</td>
											<td><a href="<?php echo $showMeta['_gurustump_show_view_url'][0]; ?>" target="_blank"><?php echo $showMeta['_gurustump_show_view_url'][0]; ?></a></td>
										</tr>
										<?php } ?>
										<?php if ($showMeta['_gurustump_show_age_restriction'][0]) { ?>
										<tr>
											<td>Age Restriction</td>
											<td><?php echo $showMeta['_gurustump_show_age_restriction'][0]; ?></td>
										</tr>
										<?php } ?>
										<?php /* if ($showMeta['_gurustump_show_country'][0]) { ?>
										<tr>
											<td>Country</td>
											<td><?php echo $showMeta['_gurustump_show_country'][0]; ?></td>
										</tr>
										<?php } */ ?>
										<tr>
											<td>Release Date</td>
											<td><time class="updated entry-time" datetime="<?php echo get_the_time('Y-m-d'); ?>" itemprop="datePublished"><?php echo get_the_time(get_option('date_format')); ?></time></td>
										</tr>
									</table>
								</div>
								<?php // } ?>
							</header> <?php // end article header ?>
							<div class="show-content cf">
								<?php the_content(); ?>
							</div>
							<div class="show-details">
								<?php if ($showMeta['_gurustump_show_director'][0] || $showMeta['_gurustump_show_producer'][0] || $showMeta['_gurustump_show_writer'][0] || $showMeta['_gurustump_show_dp'][0] || $showMeta['_gurustump_show_editor'][0] || $showMeta['_gurustump_show_cast'][0]) { ?>
								<div class="cast-crew CAST_CREW">
									<table class="data-table">
										<?php if ($showMeta['_gurustump_show_director'][0]) { 
										$directorArray = explode(',',$showMeta['_gurustump_show_director'][0]);
										?>
										<tr>
											<td>Director</td>
											<td><?php
												foreach($directorArray as $key => $item) { ?>
													<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($directorArray) ? '' : ', '; ?>
												<?php }
											?></td>
										</tr>
										<?php } ?>
										<?php if ($showMeta['_gurustump_show_producer'][0]) {
										$producerArray = explode(',',$showMeta['_gurustump_show_producer'][0]);
										?>
										<tr>
											<td>Producer</td>
											<td><?php
												foreach($producerArray as $key => $item) { ?>
													<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($producerArray) ? '' : ', '; ?>
												<?php }
											?></td>
										</tr>
										<?php } ?>
										<?php if ($showMeta['_gurustump_show_writer'][0]) {
										$writerArray = explode(',',$showMeta['_gurustump_show_writer'][0]);
										?>
										<tr>
											<td>Writer</td>
											<td><?php
												foreach($writerArray as $key => $item) { ?>
													<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($writerArray) ? '' : ', '; ?>
												<?php }
											?></td>
										</tr>
										<?php } ?>
										<?php if ($showMeta['_gurustump_show_dp'][0]) {
										$dpArray = explode(',',$showMeta['_gurustump_show_dp'][0]);
										?>
										<tr>
											<td>Director of Photography</td>
											<td><?php
												foreach($dpArray as $key => $item) { ?>
													<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($dpArray) ? '' : ', '; ?>
												<?php }
											?></td>
										</tr>
										<?php } ?>
										<?php if ($showMeta['_gurustump_show_editor'][0]) {
										$editorArray = explode(',',$showMeta['_gurustump_show_editor'][0]);
										?>
										<tr>
											<td>Editor</td>
											<td><?php
												foreach($editorArray as $key => $item) { ?>
													<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($editorArray) ? '' : ', '; ?>
												<?php }
											?></td>
										</tr>
										<?php } ?>
										<?php $castMeta = get_post_meta(get_the_ID(), '_gurustump_show_cast', true);
										if (gettype($castMeta) == 'array' && count($castMeta[0]) > 0 && $castMeta[0] != '' && !ctype_space($castMeta[0])) { ?>
										<tr class="subheading sub-cast TOGGLE_CAST">
											<td colspan="2">Cast</td>
										</tr>
											<?php foreach($castMeta as $key => $castmember) { 
												$castmemberArray = explode(',',$castmember['name']);
												?>
												<tr class="cast">
													<td><?php echo $castmember['character']; ?></td>
													<td><?php
														foreach($castmemberArray as $key => $item) { ?>
															<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($castmemberArray) ? '' : ', '; ?>
														<?php }
													?></td>
												</tr>
											<?php } ?>
										<?php } ?>
										<?php $crewMeta = get_post_meta(get_the_ID(), '_gurustump_show_other_crew', true);
										if (gettype($crewMeta) == 'array' && count($crewMeta[0]) > 0 && $crewMeta[0] != '' && !ctype_space($crewMeta[0])) { ?>
										<tr class="subheading sub-crew TOGGLE_CREW">
											<td colspan="2">Other Crew</td>
										</tr>
											<?php foreach($crewMeta as $key => $crewmember) { 
												$crewmemberArray = explode(',',$crewmember['name']);
												?>
												<tr class="crew">
													<td><?php echo $crewmember['title']; ?></td>
													<td><?php
														foreach($crewmemberArray as $key => $item) { ?>
															<a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a><?php echo $key + 1 == count($crewmemberArray) ? '' : ', '; ?>
														<?php }
													?></td>
												</tr>
											<?php } ?>
										<?php } ?>
									</table>
								</div>
								<?php } ?>
							</div> <?php // end show details ?>
						</article> <?php // end article ?>
						<div class="show-gallery">
							<?php if ($showMeta['_gurustump_show_gallery_heading'][0]) { ?>
							<h2><?php echo $showMeta['_gurustump_show_gallery_heading'][0]; ?></h2>
							<?php } ?>
							<?php if ($showMeta['_gurustump_show_gallery'][0]) {
								echo do_shortcode($showMeta['_gurustump_show_gallery'][0]);
							} ?>
						</div>
						<?php endwhile; endif; ?>

					</main>

					<?php // get_sidebar(); ?>

				</div>

			</div>
			<?php include 'library/includes/video-player.php'; ?>

<?php get_footer(); ?>
