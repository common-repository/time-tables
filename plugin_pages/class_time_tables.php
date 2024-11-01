<?php
/*create custom post type codott_class_tt*/

function create_post_codott_class_time_tables() {
    register_post_type( 'codott_class_tt',
        array(
            'labels' => array(
                'name' => __('Class Time Tables', 'codott'),
                'singular_name' => __('Class Time Table', 'codott'),
                'add_new' => __('Add New', 'codott'),
                'add_new_item' => __('Add New Class Time Table', 'codott'),
                'edit' => __('Edit', 'codott'),
                'edit_item' => __('Edit Class Time Table', 'codott'),
                'new_item' => __('New Class Time Table', 'codott'),
                'view' => __('View', 'codott'),
                'view_item' => __('View Class Time Table', 'codott'),
                'search_items' => __('Search Class Time Tables', 'codott'),
                'not_found' => __('No Class Time Table found', 'codott'),
                'not_found_in_trash' => __('No Class Time Tables found in Trash', 'codott'),
                'parent' => __('Parent Class Time Table', 'codott')
            ),
 
            'public' => true,
            'supports' => array( 'title' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false
        )
    );
}

add_action( 'init', 'create_post_codott_class_time_tables' );

function display_codott_class_time_tables_meta_box( $codott_time_tables ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'codott_class_time_tables_meta_box');
    }

    $class_time_table = intval (get_post_meta( $codott_time_tables->ID, 'codott_class_time_table', true ));
    $class_time_table_class = esc_html (get_post_meta( $codott_time_tables->ID, 'codott_class_time_table_class', true ));
    $repeatable_fields_codott_courseslot = get_post_meta($class_time_table, 'repeatable_fields_codott_courseslot', true);
    
    ?>
    <table>
        <tr>
            <td class="widefat">
                <label><?php _e('Select Time Table', 'codott'); ?></label>
                </br>
                <?php 
                $args = array( 
                    'post_type' => 'codott_time_tables',
                    'posts_per_page' => -1
                );
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="codott_class_time_tables">
                    <option value="0" <?php if($class_time_table == 0){echo 'selected';}?> ><?php _e('Select Time Table','codott');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($class_time_table == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('Please define time tables first!','codott');
                }
                ?>
            </td>
        </tr>
        <?php
            if ( $repeatable_fields_codott_courseslot ) :
                $check_repeating_class = array();
        ?>
        <tr>
            <td>
                <h2><strong><?php _e('Select class', 'codott'); ?></strong></h2>
                <select name="codott_class_time_tables_class" class="widefat" required>
                    <?php 
                    foreach ( $repeatable_fields_codott_courseslot as $course_field ) {
                        $string10 = $course_field['codott_courseslot_class'];
                        if(in_array($string10, $check_repeating_class)){
                            
                        }else{
                            $check_repeating_class[] = $string10;
                            ?>
                            <option value="<?php if(array_key_exists('codott_courseslot_class', $course_field)){echo $course_field['codott_courseslot_class'];} ?>" <?php if(array_key_exists('codott_courseslot_class', $course_field) && $course_field['codott_courseslot_class'] == $class_time_table_class){echo 'selected';}?> ><?php if(array_key_exists('codott_courseslot_class', $course_field)){echo $course_field['codott_courseslot_class'];} ?></option>
                        <?php
                        }
                        
                    }
                    ?>
                </select>
            </td>
        </tr>
        <?php endif;?>
        
    </table>
    <input type="submit" class="codott_timetable_data_submit" value="Save" />
    <hr>
        
    <?php
}

function register_meta_boxes_for_codott_class_time_tables() {
    add_meta_box( 'codott_class_time_tables_meta_box',
        __('Details', 'codott'),
        'display_codott_class_time_tables_meta_box',
        'codott_class_tt', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_codott_class_time_tables' );

function add_codott_class_time_tables_fields( $codott_time_tables_id, $codott_time_tables ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $codott_time_tables_id );
    $is_revision = wp_is_post_revision( $codott_time_tables_id );
    $is_valid_nonce = ( isset( $_POST[ 'codott_class_time_tables_meta_box' ] ) && wp_verify_nonce( $_POST[ 'codott_class_time_tables_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $codott_time_tables->post_type == 'codott_class_tt' ) {

        $class_time_table = intval (get_post_meta( $codott_time_tables_id, 'codott_class_time_table', true ));
        if(isset($_POST['codott_class_time_tables']) && $_POST['codott_class_time_tables'] != ''){
            update_post_meta( $codott_time_tables_id, 'codott_class_time_table', intval($_POST['codott_class_time_tables']) );
        }
        if(isset($_POST['codott_class_time_tables_class']) && $_POST['codott_class_time_tables_class'] != ''){
            update_post_meta( $codott_time_tables_id, 'codott_class_time_table_class', sanitize_text_field($_POST['codott_class_time_tables_class']) );
        }
    }
}

add_action( 'save_post', 'add_codott_class_time_tables_fields', 10, 2 );


function display_codott_class_time_tables_contents_meta_box( $codott_time_tables ) {
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'codott_class_time_tables_contents_meta_box');
    }
    ?>
    <style>
    .widefat.codott_table td, .widefat.codott_table th{
        border: 1px solid #e1e1e1;
    }
    span.codott-timetable-content-mob {
        display: none;
    }
    </style>
    <?php
    $class_time_table = intval(get_post_meta( $codott_time_tables->ID, 'codott_class_time_table', true ));
    if($class_time_table != 0){
        $current_class = esc_html (get_post_meta( $codott_time_tables->ID, 'codott_class_time_table_class', true ));
        
        $time_table_filledslotcolor = esc_html (get_post_meta( $class_time_table, 'time_table_filledslotcolor', true ));
        $time_table_emptyslotcolor = esc_html (get_post_meta( $class_time_table, 'time_table_emptyslotcolor', true ));
        
        $time_table_nofclassesperweek = intval (get_post_meta( $class_time_table, 'time_table_nofclassesperweek', true )); 
        
        if($time_table_nofclassesperweek == 0){
            $time_table_nofclassesperweek = 1;
        }

        $time_table_time_slots1 = get_post_meta($class_time_table, 'repeatable_fields_codott_timeslot', true);
        $time_table_day_slots1 = get_post_meta($class_time_table, 'repeatable_fields_codott_dayslot', true);
        $time_table_room_slots1 = get_post_meta($class_time_table, 'repeatable_fields_codott_roomslot', true);
        
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
            $time_table_classes1 = get_post_meta($class_time_table, 'repeatable_fields_codott_class', true);
            $time_table_classes_courses1 = get_post_meta($class_time_table, 'repeatable_fields_codott_courseslot', true);
            
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
                    $time_table_classes_courses2 .= $value['codott_courseslot_class'].'-->'.$value['codott_courseslot_course'].'-->'.$value['codott_courseslot_class'].',';
                }else{
                    $time_table_classes_courses2 .= $value['codott_courseslot_class'].'-->'.$value['codott_courseslot_course'].'-->'.$value['codott_courseslot_class'];
                }
                $i++;
            }

            $time_table_classes_sem = get_post_meta( $class_time_table, 'time_table_cust_classes_sem', true );
            $time_table_classes_courses_assign = get_post_meta( $class_time_table, 'time_table_cust_classes_courses_assign', true );
            $time_table_empty_slots = get_post_meta( $class_time_table, 'time_table_cust_empty_slots', true );
            
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
                    include( CODOTT_BASE_DIR . '/plugin_pages/saved_class_time_table.php');
                }
            }
        
        }
    }else{
        _e('Please select time table first to see contents of this section','codott');
    }
    

}

function register_meta_boxes_for_codott_class_time_tables_contents() {
    add_meta_box( 'codott_class_time_tables_contents_meta_box',
        __('class Time Table', 'codott'),
        'display_codott_class_time_tables_contents_meta_box',
        'codott_class_tt', 'normal', 'low'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_codott_class_time_tables_contents' );

function add_codott_class_time_tables_contents_fields( $codott_time_tables_id, $codott_time_tables ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $codott_time_tables_id );
    $is_revision = wp_is_post_revision( $codott_time_tables_id );
    $is_valid_nonce = ( isset( $_POST[ 'codott_class_time_tables_contents_meta_box' ] ) && wp_verify_nonce( $_POST[ 'codott_class_time_tables_contents_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
}

add_action( 'save_post', 'add_codott_class_time_tables_contents_fields', 10, 2 );


function include_template_function_codott_class_time_tables( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'codott_class_tt' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return codott_class_time_tables_get_template_hierarchy( 'single-codott_class_tt' );
    }elseif (is_archive()) {
        return codott_class_time_tables_get_template_hierarchy( 'archive-codott_class_tt' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function codott_class_time_tables_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    //To override default single course template of plugin, create new folder in your theme directory
    // and create new file named as single-codott_courses.php and define your new layout there
    if ( $theme_file = locate_template( array( 'codott_templates/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = CODOTT_BASE_DIR . '/codott_templates/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_codott_class_time_tables', 1 );

?>