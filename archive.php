<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="cf">

					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
						<div class="wrap">
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
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

									<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the archive.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>
							</div>
						</main>

					<?php // get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
