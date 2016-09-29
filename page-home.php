<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<!-- Show a fancy art preview for the post -->
			<div class="artSquareContainers">
				ADSFBGSERSFDAEFDTESGFGRTAE
				<?php
				//Create an array of animation classes
				$fadeArray = array("fadeInUp", "fadeInLeft", "fadeInDown", "fadeInRight");
				// Start the loop.
				while ( have_posts() ) : the_post();
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					//get_template_part( 'content', get_post_format() );
				?>
					<!-- Singular Art Square -->
					<div class="artSquare animated <?php echo $fadeArray[array_rand($fadeArray)]; ?>">
						<?php
                            $artImage = types_render_field("art-images", array("raw" => "true"));
							$artVideo = types_render_field("art-video", array("raw" => "true"));
                            if( !empty($artImage) ) {
								//Get the url of the first Image in the array
								$imageUrls = types_render_field("art-images", array(
									'size' => 'medium',
									'class' => 'artSquareImage',
									'separator' => '|'));
								$imageUrls = explode( '|', $imageUrls );
								console_log($imageUrls);
								echo $imageUrls[0];
                        ?>
							<!-- <img class="artSquareImage" alt="Work Image" src="<?php echo $imageUrls[0] ?>"> -->
                        <?php
							} else if( !empty($artVideo) ) {
							//Get the first video in the array
							$videos = types_render_field("art-video", array(
								"output" => "raw",
								'separator' => '|'));
							$videos = explode( '|', $videos );
                        ?>

						<!-- Unclickable iframe youtube embed -->
						<img class="artSquareImage" alt="Youtube Image" src="https://img.youtube.com/vi/<?php echo get_youtube_video_id($videos[0]) ?>/0.jpg">
						<img class="playButtonOverlay" alt="Play Overlay" src="<?php echo get_template_directory_uri() . '/' . 'assets/playButton.png'; ?>">

						<?php
							} else {
                        ?>
							<!-- Post the default material icon -->
							<img class="artSquareImage" alt="Post Icon material" src="<?php echo get_template_directory_uri() . '/' . 'assets/speakerNotes.png'; ?>">
						<?php
							}
                        ?>

						<!-- Finally the overlay -->
						<div class="infoOverlay">
							<!--Link the div -->
							<a class = "overlayLink" href="<?php the_permalink() ?>">
							</a>

							<div class="overlayInfo">
								<!-- Post title -->
								<h3 class="centerText"><?php the_title() ?></h3>

								<!-- Horizontal divider -->
								<div class="artSquareDividerContainer center">
									<div class="artSquareDivider"></div>
								</div>

								<!-- Post Date -->
								<h5 class="centerText"><?php the_time( get_option( 'date_format' ) ); ?></h5>
							</div>
						</div>
					</div>

				<?php
				// End the loop.
				endwhile;
				?>
			</div>

			<?php
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
