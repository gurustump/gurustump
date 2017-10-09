<?php
/*
 Template Name: Randomizer
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
<?php
$randomizerMeta = get_post_meta(get_the_ID(), '_gurustump_page_randomizer', true);

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty($_POST['post_id']) && isset($_POST['update_post_nonce']) ) {
	$post_id   = $_POST['post_id'];
	if ( current_user_can('edit_page', $post_id) && wp_verify_nonce( $_POST['update_post_nonce'], 'update_post_'. $post_id ) ) {
		/*$post = array(
			'ID'             => esc_sql($post_id),
			'post_content'   => esc_sql($_POST['postcontent']),
			'post_title'     => esc_sql($_POST['post_title'])
		);
		wp_update_post($post);*/
		
		$post_array = array();
		foreach($randomizerMeta as $key => $item) {
			array_push($post_array, array('title' => $item[title],'likelihood_modifier' => $_POST['item_'.$key.'_likelihood_modifier']));
		}
		
		update_post_meta($post_id, '_gurustump_page_randomizer', $post_array );
		
		
	   // Redirect to this page. This prevents the form being resubmitted on refresh
	   // https://stackoverflow.com/questions/4142809/simple-post-redirect-get-code-example
	   header("Location: " . $_SERVER['REQUEST_URI']);
	   exit();
	} else {
		wp_die("You can't do that");
	}
}
?>
<?php get_header(); ?>
			<div id="content">
				<div id="inner-content" class="wrap cf">
						<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<header class="article-header">
									<h1 class="page-title"><?php the_title(); ?></h1>
								</header>
								<section class="entry-content cf" itemprop="articleBody">
									<?php
										the_content();
									?>
									<div class="actions">
										<a href="#" class="btn SPIN">Spin</a>
									</div>
									<form id="randomizer_form" method="POST">
										<?php /*
										<pre>
											<?php print_r($randomizerMeta); ?>
										</pre>
										<pre>
											<?php print_r($post_array); ?>
										</pre>
										*/ ?>
										<div class="hidden">
											<input type="hidden" name="post_id" value="<?php the_ID(); ?>" />
											<?php wp_nonce_field( 'update_post_'. get_the_ID(), 'update_post_nonce' ); ?>
										</div>
										<ul class="randomization-items RANDOMIZE_LIST">
											<?php foreach($randomizerMeta as $key => $item) { ?>
											<li class="present" data-option-index="<?php echo $key; ?>">
												<h2 ><?php echo $item[title]; ?></h2>
												<label for="item_<?php echo $key; ?>_present">
													<span>
														<span>Present</span>
														<input class="RADIO_PRESENT" name="item_<?php echo $key; ?>_attendance" id="item_<?php echo $key; ?>_present" type="radio" value="present" checked />
													</span>
												</label>
												<label for="item_<?php echo $key; ?>_absent">
													<span>
														<span>Absent</span>
														<input class="RADIO_ABSENT" name="item_<?php echo $key; ?>_attendance" id="item_<?php echo $key; ?>_absent" type="radio" value="absent" />
													</span>
												</label>
												<input class="LIKELIHOOD_MODIFIER" type="hidden" id="item_<?php echo $key; ?>_likelihood_modifier" name="item_<?php echo $key; ?>_likelihood_modifier" value="<?php echo $item[likelihood_modifier]; ?>" autocomplete="off" />
											</li>
											<?php } ?>
										</ul>
										<?php /*
										<div class="actions">
											<input class="btn" type="submit" value="save winner" />
										</div>
										*/ ?>
									</form>
								</section>
							</article>
							<?php endwhile; else : ?>
									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>
							<?php endif; ?>
						</main>
				</div>
			</div>
			<div class="spinner-container SPINNER_CONTAINER">
				<a href="#" class="ov-close SPINNER_CLOSE">Close</a>
				<div class="spinner SPINNER">
					<?php foreach($randomizerMeta as $key => $item) { ?>
					<div class="spinner-item" id="spinner_item_<?php echo $key; ?>" data-option-index="<?php echo $key; ?>">
						<h2><?php echo $item[title]; ?><span class="hide-until-selected"> Wins!</span></h2>
					</div>
					<?php } ?>
				</div>
			</div>
			<a class="play-beep PLAY_BEEP">Play Beep</a>
<?php get_footer(); ?>
