<?php get_header(); ?>
			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Person">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php $personMeta = get_post_meta(get_the_ID()); ?>
						<div class="headshot">
							<?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
						</div>
						<article id="post-<?php the_ID(); ?>" role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
							<header class="show-header">
								<h1 class="show-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
								<?php if ($personMeta['_gurustump_person_duration'][0] || $personMeta['_gurustump_person_age_restriction'][0] || $personMeta['_gurustump_person_country'][0] || $personMeta['_gurustump_person_imdb_url'][0] || $personMeta['_gurustump_person_homepage_url'][0]) { ?>
								<div class="person-info">
									<table class="data-table">
										<?php if ($personMeta['_gurustump_person_imdb_url'][0]) { ?>
										<tr>
											<td>IMDb Page</td>
											<td><a href="<?php echo $personMeta['_gurustump_person_imdb_url'][0]; ?>" target="_blank"><?php echo $personMeta['_gurustump_person_imdb_url'][0]; ?></a></td>
										</tr>
										<?php } ?>
										<?php if ($personMeta['_gurustump_person_homepage_url'][0]) { ?>
										<tr>
											<td>Home page</td>
											<td><a href="<?php echo $personMeta['_gurustump_person_homepage_url'][0]; ?>" target="_blank"><?php echo $personMeta['_gurustump_person_homepage_url'][0]; ?></a></td>
										</tr>
										<?php } ?>
									</table>
								</div>
								<?php } ?>
							</header> <?php // end article header ?>
							<div class="person-content cf">
								<?php the_content(); ?>
							</div>
						</article> <?php // end article ?>
						<div class="person-vid-gallery">
							<h2>Projects</h2>
							<div class="thumb-index">
								<div class="thumb-index-inner">
									<ul class="thumb-index-list">
										<?php $personShows = get_posts(array(
											'numberposts' => -1,
											'post_type' => 'shows',
											'orderby' => 'date',
											'order' => 'DESC'/*,
											'meta_query' => array (
												'relation' => 'OR',
												array(
													'key' => '_gurustump_show_director', 
													'value' => get_the_ID(),
													'compare' => 'IN'
												),
												array(
													'key' => '_gurustump_show_producer', 
													'value' => get_the_ID(),
													'compare' => 'IN'
												),
												array(
													'key' => '_gurustump_show_writer', 
													'value' => get_the_ID(),
													'compare' => 'IN'
												)
											)*/
										)); 
										foreach($personShows as $key => $show) {
											$showThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($show->ID), 'movie-thumb');
											$showMeta = get_post_meta($show->ID);
											$castMeta = get_post_meta($show->ID, '_gurustump_show_cast', true);
											$inCast = false;
											foreach($castMeta as $item) {
												if ($item[name] == get_the_ID()) {
													$inCast = true;
													break;
												}
											}
											$crewMeta = get_post_meta($show->ID, '_gurustump_show_other_crew', true);
											$inCrew = false;
											foreach($crewMeta as $item) {
												if ($item[name] == get_the_ID()) {
													$inCrew = true;
													break;
												}
											}
											// filter the movies so only the ones where this person was in the cast or crew get written into the page
											if ($showMeta['_gurustump_show_director'][0] == get_the_ID() || 
												$showMeta['_gurustump_show_producer'][0] == get_the_ID() || 
												$showMeta['_gurustump_show_writer'][0] == get_the_ID() ||
												$inCast ||
												$inCrew) { ?>
												<li>
													<img class="item-thumb" src="<?php echo $showThumbArray[0]; ?>" />
													<a href="<?php echo get_the_permalink($show->ID); ?>"><span><?php echo $show->post_title; ?></span></a>
												</li>
												<?php } ?>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div> <?php // person-vid-gallery ?>
						<?php endwhile; endif; ?>

					</main>

					<?php // get_sidebar(); ?>

				</div>

			</div>
			<?php include 'library/includes/video-player.php'; ?>

<?php get_footer(); ?>
