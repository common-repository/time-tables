<?php
/**
 * The template for displaying all single time table.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <!-- Display featured image in right-aligned floating div -->
                <div class="course-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <strong><?php _e('Teacher:', 'codott');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'codott_teacher_time_table_teacher', true ) ); ?>
                <br />
            </header><!-- .entry-header -->

            <div class="entry-content-wrapper">
                <div class="entry-content">
                    <?php 
                        $teacher_time_table = intval(get_post_meta( get_the_ID(), 'codott_teacher_time_table', true ));
                        $current_teacher = esc_html (get_post_meta( get_the_ID(), 'codott_teacher_time_table_teacher', true ));
                        
                        $time_table_filledslotcolor = esc_html (get_post_meta( $teacher_time_table, 'time_table_filledslotcolor', true ));
                        $time_table_emptyslotcolor = esc_html (get_post_meta( $teacher_time_table, 'time_table_emptyslotcolor', true ));
                        
                        $time_table_nofclassesperweek = intval (get_post_meta( $teacher_time_table, 'time_table_nofclassesperweek', true )); 
                        
                        if($time_table_nofclassesperweek == 0){
                            $time_table_nofclassesperweek = 1;
                        }

                        $time_table_time_slots1 = get_post_meta($teacher_time_table, 'repeatable_fields_codott_timeslot', true);
                        $time_table_day_slots1 = get_post_meta($teacher_time_table, 'repeatable_fields_codott_dayslot', true);
                        $time_table_room_slots1 = get_post_meta($teacher_time_table, 'repeatable_fields_codott_roomslot', true);
                        
                        $time_table_time_slots2 = '';
                        $size = sizeof($time_table_time_slots1);
                        //echo $size;
                        $i = 1;
                        foreach ($time_table_time_slots1 as $key => $value) {
                            if($i < $size){
                                $time_table_time_slots2 .= $value['codott_timeslot_start'].'-'.$value['codott_timeslot_end'].',';
                            }else{
                                $time_table_time_slots2 .= $value['codott_timeslot_start'].'-'.$value['codott_timeslot_end'];
                            }
                            $i++;
                        }

                        $time_table_day_slots2 = '';
                        $size = sizeof($time_table_day_slots1);
                        //echo $size;
                        $i = 1;
                        foreach ($time_table_day_slots1 as $key => $value) {
                            if($i < $size){
                                $time_table_day_slots2 .= $value['codott_dayslot'].',';
                            }else{
                                $time_table_day_slots2 .= $value['codott_dayslot'];
                            }
                            $i++;
                        }

                        $time_table_room_slots2 = '';
                        $size = sizeof($time_table_room_slots1);
                        //echo $size;
                        $i = 1;
                        foreach ($time_table_room_slots1 as $key => $value) {
                            if($i < $size){
                                $time_table_room_slots2 .= $value['codott_roomslot'].',';
                            }else{
                                $time_table_room_slots2 .= $value['codott_roomslot'];
                            }
                            $i++;
                        }

                        if($time_table_time_slots2 == "" || $time_table_day_slots2 == "" || $time_table_room_slots2 == ""){
                            _e('Selected time table is not configured properly', 'codott');
                        }else{
                            $time_table_classes1 = get_post_meta($teacher_time_table, 'repeatable_fields_codott_class', true);
                            $time_table_classes_courses1 = get_post_meta($teacher_time_table, 'repeatable_fields_codott_courseslot', true);
                            
                            $time_table_classes2 = '';
                            $size = sizeof($time_table_classes1);
                            //echo $size;
                            $i = 1;
                            foreach ($time_table_classes1 as $key => $value) {
                                if($i < $size){
                                    $time_table_classes2 .= $value['codott_class'].',';
                                }else{
                                    $time_table_classes2 .= $value['codott_class'];
                                }
                                $i++;
                            }

                            $time_table_classes_courses2 = '';
                            $size = sizeof($time_table_classes_courses1);
                            //echo $size;
                            $i = 1;
                            foreach ($time_table_classes_courses1 as $key => $value) {
                                if($i < $size){
                                    $time_table_classes_courses2 .= $value['codott_courseslot_class'].'-->'.$value['codott_courseslot_course'].'-->'.$value['codott_courseslot_teacher'].',';
                                }else{
                                    $time_table_classes_courses2 .= $value['codott_courseslot_class'].'-->'.$value['codott_courseslot_course'].'-->'.$value['codott_courseslot_teacher'];
                                }
                                $i++;
                            }

                            $time_table_classes_sem = get_post_meta( $teacher_time_table, 'time_table_cust_classes_sem', true );
                            $time_table_classes_courses_assign = get_post_meta( $teacher_time_table, 'time_table_cust_classes_courses_assign', true );
                            $time_table_empty_slots = get_post_meta( $teacher_time_table, 'time_table_cust_empty_slots', true );
                            
                            if($time_table_classes2 == "" && $time_table_classes_courses2 == ""){
                                _e('Selected time table is not configured properly','codott');
                            }else{
                                ?>
                                <?php
                                if($time_table_classes_sem == "" 
                                && $time_table_classes_courses_assign == "" 
                                && $time_table_empty_slots == ""){
                                    _e('Selected time table is not configured properly','codott');
                                }else{
                                    include( CODOTT_BASE_DIR . '/plugin_pages/saved_teacher_time_table.php');
                                }
                            }
                        
                        }
                    ?>

                </div><!-- .entry-content -->
            </div><!-- .entry-content-wrapper -->

        </article><!-- #post-## -->

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>

    <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
