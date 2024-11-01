<?php 
$args1 = array( 
	'post_type' => 'codott_time_tables',
	'posts_per_page' => -1
);
$loop1 = new WP_Query( $args1 );
$total_time_tables = $loop1->found_posts;

$args2 = array( 
	'post_type' => 'codott_teacher_tt',
	'posts_per_page' => -1
);
$loop2 = new WP_Query( $args2 );
$total_teacher_time_tables = $loop2->found_posts;

$args3 = array( 
	'post_type' => 'codott_class_tt',
	'posts_per_page' => -1
);
$loop3 = new WP_Query( $args3 );
$total_class_time_tables = $loop3->found_posts;
?>

<h2><?php _e('Codott Dashboard', 'codott');?></h2>
<div class="wrap">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2 class="hndle"><span><?php esc_attr_e( 'Codott Home', 'codott' ); ?></span></h2>

						<div class="inside">
							<p>
								<?php 
									esc_attr_e(
										'Welcome to Codott Time Tables!',
										'codott'
									); 
								?>
							</p>
							<p>
								<?php 
									esc_attr_e(
										'A Time Table WordPress plugin developed
										for universities, schools, colleges, academies or any other
											type of institutes.',
										'codott'
									); 
								?>
							</p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h2 class="hndle"><span><?php esc_attr_e( 'Codott Features', 'codott' ); ?></span></h2>

						<div class="inside">
							<ol>
								<li><?php esc_attr_e( 'Custom time table generation from time slots, room slots, day slots, classes and courses', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Easy drag and drop interface (to reorder slots) to define time slots, day slots, room slots, classes and courses', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Ability to define number of classes per week for each course', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Once custom time table is generated, then individual teacher time table can be extracted from that time table', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Once custom time table is generated, then individual class time table can be extracted from that time table', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Time table archive and single page templates are available', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Once time table is generated it can be viewed publicly', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Filled slot background color and text color can also be changed while editing the custom time table', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Codott time tables are responsive enough to fit into the screen size of the device', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Codott time tables are generated randomnly, any number of randomn generations of the time table are possible', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Save only that randomn time table which you like', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Codott time tables are smart enough to give you warnings if courses are greater than the number of available slots', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Codott time table also specify how many courses are overlapping and how to remove that overlapping', 'codott' ); ?></li>
								<li><?php esc_attr_e( 'Codott time table also specify which slots are empty. These empty slots can be used for extra classes/tutorials', 'codott' ); ?></li>
							</ol>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2 class="hndle">
							<span>
								<?php esc_attr_e('Stats', 'codott'); ?>
							</span>
						</h2>

						<div class="inside">
							<strong><?php _e('Total Time Tables:', 'codott'); ?></strong>
							<p><?php echo esc_html($total_time_tables);?></p>
							<strong><?php _e('Total Teacher Time Tables:', 'codott'); ?></strong>
							<p><?php echo esc_html($total_teacher_time_tables);?></p>
							<strong><?php _e('Total Class Time Tables:', 'codott'); ?></strong>
							<p><?php echo esc_html($total_class_time_tables);?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->