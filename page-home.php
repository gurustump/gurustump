<?php
/*
 Template Name: Home Page
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
			<div  class="home-logo HOME_LOGO">
				<video class="bg-video" id="home_sizzle" autoplay loop>
					<source src="<?php echo get_template_directory_uri(); ?>/library/video/home-sizzle.mp4" type="video/mp4"></source>
					<source src="<?php echo get_template_directory_uri(); ?>/library/video/home-sizzle.webm" type="video/webm"></source>
					<source src="<?php echo get_template_directory_uri(); ?>/library/video/home-sizzle.ogv" type="video/ogg"></source>
				</video>
				<div class="title-box">
					<div class="title-box-inner">
						<h1><span><?php bloginfo('name'); ?></span></h1>
						<h2><?php bloginfo('description'); ?></h2>
					</div>
				</div>
			</div>
			<div id="content">
				<div id="inner-content" class=" cf">
						<main id="main" class="content-primary cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<div id="post-<?php the_ID(); ?>">
								<section class="cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();

										/*
										 * Link Pages is used in case you have posts that are set to break into
										 * multiple pages. You can remove this if you don't plan on doing that.
										 *
										 * Also, breaking content up into multiple pages is a horrible experience,
										 * so don't do it. While there are SOME edge cases where this is useful, it's
										 * mostly used for people to get more ad views. It's up to you but if you want
										 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
										 *
										 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
										 *
										*/
									?>
								</section>
							</div>
							<?php endwhile;  endif; ?>
						</main>
				</div>
			</div>
<?php get_footer(); ?>
