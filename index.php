<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="cf">

						<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<div class="wrap">
								<?php add_action('gurustump_posts_page_before_loop', function() {
									$posts_page = get_option( 'page_for_posts' );
									if ( is_null( $posts_page ) ) {
										return;
									}
									$title   = get_post( $posts_page )->post_title;
									$content = get_post( $posts_page )->post_content;
									$title_output = $content_output = '';
									if ( $title ) { ?>
										<h1><?php echo $title; ?></h1>
									<?php }
									if ( $content ) {
										$content_output = wpautop( $content ); ?>
										<div class="blog-description"><?php echo $content_output; ?></div>
									<?php }
									
								});
								do_action('gurustump_posts_page_before_loop'); ?>
								<ul class="blog-index-list">
									<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
									<li id="post-<?php the_ID(); ?>">
										<h2 class="h2 entry-title">
											<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
												<?php if (has_post_thumbnail()) { ?>
													<?php the_post_thumbnail('movie-thumb'); ?>
												<?php } ?>
												<?php the_title(); ?>
											</a>
										</h2>
										<div class="excerpt">
											<?php the_excerpt(); ?>
										</div>

									</li>

									<?php endwhile; ?>
								</ul>

								<?php bones_page_navi(); ?>
							</div>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>


						</main>

					<?php // get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
