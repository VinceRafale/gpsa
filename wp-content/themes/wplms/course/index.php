<?php get_header( 'buddypress' ); 

global $bp;

if(bp_is_course_component()){
	if(bp_is_single_item()){
		bp_core_load_template('course/single/home');
	}
}
?>

<section id="memberstitle">
    <div class="container">
        <div class="row">
             <div class="col-md-9 col-sm-8">
                <div class="pagetitle">
                	<h1>Learning Activities</h1>
			<h5></h5>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
            	<?php 
            		$teacher_form = vibe_get_option('teacher_form');
            		
					echo '<a href="'.(isset($teacher_form)?get_permalink($teacher_form):'#').'" class="button create-group-button full">'. __( 'Become a Teacher', 'vibe' ).'</a>';
				?>
            </div>
        </div>
    </div>
</section>
<section id="content">
	<div id="buddypress">
    <div class="container">

	<?php do_action( 'bp_before_directory_course_page' ); ?>

		<div class="padder">

		<?php do_action( 'bp_before_directory_course' ); ?>
		<div class="row">
			<div class="col-md-9 col-sm-8">
				<form action="" method="post" id="course-directory-form" class="dir-form">

					<?php do_action( 'bp_before_directory_course_content' ); ?>

					<?php do_action( 'template_notices' ); ?>

					<div class="item-list-tabs" role="navigation">
						<ul>
							<li class="selected" id="course-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_course_root_slug() ); ?>"><?php printf( __( 'All Courses <span>%s</span>', 'vibe' ), bp_course_get_total_course_count( ) ); ?></a></li>

							<?php if ( is_user_logged_in() ) : ?>

								<li id="course-personal"><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_course_slug() . 'course' ); ?>"><?php printf( __( 'My Courses <span>%s</span>', 'vibe' ), bp_course_get_total_course_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

								<?php if(is_user_instructor()): ?>
									<li id="course-instructor"><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_course_slug() . 'course' ); ?>"><?php printf( __( 'Instructing Courses <span>%s</span>', 'vibe' ), bp_course_get_instructor_course_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

								<?php endif; ?>		
							<?php endif; ?>

							<?php do_action( 'bp_course_directory_filter' ); ?>

						</ul>
					</div><!-- .item-list-tabs -->
					<div class="item-list-tabs" id="subnav" role="navigation">
						<ul>
							<?php do_action( 'bp_course_directory_course_types' ); ?>
							<li>
								<div id="group-dir-search" class="dir-search" role="search">
									<?php bp_directory_course_search_form(); ?>
								</div><!-- #group-dir-search -->
							</li>
							<li id="groups-order-select" class="last filter">

								<label for="groups-order-by"><?php _e( 'Order By:', 'vibe' ); ?></label>
								<select id="groups-order-by">
									<option value="alphabetical"><?php _e( 'Alphabetical', 'vibe' ); ?></option>
									<option value="popular"><?php _e( 'Most Members', 'vibe' ); ?></option>
									<option value="newest"><?php _e( 'Newly Created', 'vibe' ); ?></option>
									<option value="rated"><?php _e( 'Highest Rated', 'vibe' ); ?></option>

									<?php do_action( 'bp_course_directory_order_options' ); ?>

								</select>
							</li>
						</ul>
					</div>
					<div id="course-dir-list" class="course dir-list">

						<?php  
					
					include('course-loop.php' );  ?>

					</div><!-- #courses-dir-list -->

					<?php do_action( 'bp_directory_course_content' ); ?>

					<?php wp_nonce_field( 'directory_course', '_wpnonce-course-filter' ); ?>

					<?php do_action( 'bp_after_directory_course_content' ); ?>


				</form><!-- #course-directory-form -->
			</div>	
			<div class="col-md-3 col-sm-3">
				<?php get_sidebar( 'buddypress' ); ?>
			</div>
		</div>	
		<?php do_action( 'bp_after_directory_course' ); ?>

		</div><!-- .padder -->
	
	<?php do_action( 'bp_after_directory_course_page' ); ?>
</div><!-- #content -->
</div>
</section>

<?php get_footer( 'buddypress' ); ?>

