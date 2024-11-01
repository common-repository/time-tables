<?php
/*create custom post type codott_time_tables*/

function create_post_codott_time_tables() {
    register_post_type( 'codott_time_tables',
        array(
            'labels' => array(
                'name' => __('Time Tables', 'codott'),
                'singular_name' => __('Time Table', 'codott'),
                'add_new' => __('Add New', 'codott'),
                'add_new_item' => __('Add New Time Table', 'codott'),
                'edit' => __('Edit', 'codott'),
                'edit_item' => __('Edit Time Table', 'codott'),
                'new_item' => __('New Time Table', 'codott'),
                'view' => __('View', 'codott'),
                'view_item' => __('View Time Table', 'codott'),
                'search_items' => __('Search Time Tables', 'codott'),
                'not_found' => __('No Time Table found', 'codott'),
                'not_found_in_trash' => __('No Time Tables found in Trash', 'codott'),
                'parent' => __('Parent Time Table', 'codott')
            ),
 
            'public' => true,
            'supports' => array( 'title' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false
        )
    );
}

add_action( 'init', 'create_post_codott_time_tables' );

function display_codott_time_tables_meta_box( $codott_time_tables ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'codott_time_tables_meta_box');
    }

    $time_table_type = esc_html (get_post_meta( $codott_time_tables->ID, 'time_table_type', true ));
    
    $time_table_filledslotcolor = esc_html (get_post_meta( $codott_time_tables->ID, 'time_table_filledslotcolor', true ));
    $time_table_emptyslotcolor = esc_html (get_post_meta( $codott_time_tables->ID, 'time_table_emptyslotcolor', true ));
    $time_table_nofclassesperweek = intval (get_post_meta( $codott_time_tables->ID, 'time_table_nofclassesperweek', true )); 

    if($time_table_nofclassesperweek == 0){
        $time_table_nofclassesperweek = 1;
    }
    $repeatable_fields_codott_timeslot = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_timeslot', true);
    $repeatable_fields_codott_dayslot = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_dayslot', true);
    $repeatable_fields_codott_roomslot = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_roomslot', true);
    $repeatable_fields_codott_class = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_class', true);
    $repeatable_fields_codott_courseslot = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_courseslot', true);
    
    ?>
    <?php
        // Enqueue Datepicker + jQuery UI CSS
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_style( 'jquery-ui-timepicker-style', CODOTT_PLUGIN_URL. '/css/jquery-ui-timepicker-addon.css', true);
        wp_enqueue_style( 'jquery-ui-style', CODOTT_PLUGIN_URL. '/css/codott-jquery-ui.css', true);
        wp_enqueue_script('jquery-time-picker' ,  CODOTT_PLUGIN_URL. 'js/jquery-ui-timepicker-addon.min.js',  array('jquery' ));
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script('codott-repeatablefields' ,  CODOTT_PLUGIN_URL. 'js/codott-script.js',  array('wp-color-picker'), false, true);
    ?>
    <table>
        <tr>
            <td>
                <label><?php _e('Number of Classes Per Week For Each Course', 'codott'); ?></label>
                </br>
                <input type="text" name="codott_time_tables_nofclassesperweek" value="<?php echo esc_attr($time_table_nofclassesperweek);?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('Slot Background Color', 'codott'); ?></label>
                </br>
                <input type="text" class="codott_timetables_colorpick" name="codott_time_tables_filledslotcolor" value="<?php echo esc_attr($time_table_filledslotcolor);?>" data-default-color="#effeff"/>
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('Slot Text Color', 'codott'); ?></label>
                </br>
                <input type="text" class="codott_timetables_colorpick" name="codott_time_tables_emptyslotcolor" value="<?php echo esc_attr($time_table_emptyslotcolor);?>" data-default-color="#effeff"/>
            </td>
        </tr>
        
    </table>
    <input type="submit" class="codott_timetable_data_submit" value="Save" />
    <hr>
        <div class="codott_timetable_data">
            <h2><strong><?php _e('Add Time Slots', 'codott'); ?></strong></h2>
            <table id="repeatable-fieldset-codott-timeslot" width="100%">
            <thead>
                <tr>
                    <th width="2%">Remove</th>
                    <th width="45%">Start Time</th>
                    <th width="45%">End Time</th>
                    <th width="2%">Sort</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ( $repeatable_fields_codott_timeslot ) :
                foreach ( $repeatable_fields_codott_timeslot as $field ) {
        ?>
            <tr>
                <td><a class="button remove-row-codott-timeslot" href="#">&times;</a></td>
                <td><input type="text" class="widefat codott_timetables_date" name="codott_timeslot_start[]" value="<?php if(array_key_exists('codott_timeslot_start', $field) && $field['codott_timeslot_start'] != '') echo esc_attr( $field['codott_timeslot_start'] ); ?>" required/></td>

                <td><input type="text" class="widefat codott_timetables_date" name="codott_timeslot_end[]" value="<?php if (array_key_exists('codott_timeslot_end', $field) && $field['codott_timeslot_end'] != '') echo esc_attr( $field['codott_timeslot_end'] ); ?>" required /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php
                }
            else :
                // show a blank one
        ?>
            <tr>
                <td><a class="button remove-row-codott-timeslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat codott_timetables_date" name="codott_timeslot_start[]" /></td>


                <td><input type="text" required class="widefat codott_timetables_date" name="codott_timeslot_end[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php endif; ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-codott-timeslot-row screen-reader-text">
                <td><a class="button remove-row-codott-timeslot" href="#">&times;</a></td>
                <td><input type="text" class="widefat codott_timetables_date" name="codott_timeslot_start[]" /></td>

                <td><input type="text" class="widefat codott_timetables_date" name="codott_timeslot_end[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            </tbody>
            </table>

            <p><a id="add-codott-timeslot-row" class="button" href="#">Add another</a>
            </p><hr>
            <input type="submit" class="codott_timetable_data_submit" value="Save" />

            <h2><strong><?php _e('Add Available Days e.g Friday etc.', 'codott'); ?></strong></h2>
            <table id="repeatable-fieldset-codott-dayslot" width="100%">
            <thead>
                <tr>
                    <th width="2%">Remove</th>
                    <th width="90%">Day</th>
                    <th width="2%">Sort</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ( $repeatable_fields_codott_dayslot ) :
                foreach ( $repeatable_fields_codott_dayslot as $field ) {
        ?>
            <tr>
                <td><a class="button remove-row-codott-dayslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_dayslot[]" value="<?php if(array_key_exists('codott_dayslot', $field) && $field['codott_dayslot'] != '') echo esc_attr( $field['codott_dayslot'] ); ?>" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php
                }
            else :
                // show a blank one
        ?>
            <tr>
                <td><a class="button remove-row-codott-dayslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_dayslot[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php endif; ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-codott-dayslot-row screen-reader-text">
                <td><a class="button remove-row-codott-dayslot" href="#">&times;</a></td>
                <td><input type="text" class="widefat" name="codott_dayslot[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            </tbody>
            </table>

            <p><a id="add-codott-dayslot-row" class="button" href="#">Add another</a>
            </p><hr>
            <input type="submit" class="codott_timetable_data_submit" value="Save" />


            <h2><strong><?php _e('Add Available Rooms e.g Room-20 etc.', 'codott'); ?></strong></h2>
            <table id="repeatable-fieldset-codott-roomslot" width="100%">
            <thead>
                <tr>
                    <th width="2%">Remove</th>
                    <th width="90%">Room</th>
                    <th width="2%">Sort</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ( $repeatable_fields_codott_roomslot ) :
                foreach ( $repeatable_fields_codott_roomslot as $field ) {
        ?>
            <tr>
                <td><a class="button remove-row-codott-roomslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_roomslot[]" value="<?php if(array_key_exists('codott_roomslot', $field) && $field['codott_roomslot'] != '') echo esc_attr( $field['codott_roomslot'] ); ?>" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php
                }
            else :
                // show a blank one
        ?>
            <tr>
                <td><a class="button remove-row-codott-roomslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_roomslot[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php endif; ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-codott-roomslot-row screen-reader-text">
                <td><a class="button remove-row-codott-roomslot" href="#">&times;</a></td>
                <td><input type="text" class="widefat" name="codott_roomslot[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            </tbody>
            </table>

            <p><a id="add-codott-roomslot-row" class="button" href="#">Add another</a>
            </p><hr>
            <input type="submit" class="codott_timetable_data_submit" value="Save" />


            <h2><strong><?php _e('Add Classes e.g BSCS(2nd) etc. Class names should be unique', 'codott'); ?></strong></h2>
            <table id="repeatable-fieldset-codott-class" width="100%">
            <thead>
                <tr>
                    <th width="2%">Remove</th>
                    <th width="90%">Class</th>
                    <th width="2%">Sort</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ( $repeatable_fields_codott_class ) :
                foreach ( $repeatable_fields_codott_class as $field ) {
        ?>
            <tr>
                <td><a class="button remove-row-codott-class" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_class[]" value="<?php if(array_key_exists('codott_class', $field) && $field['codott_class'] != '') echo esc_attr( $field['codott_class'] ); ?>" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php
                }
            else :
                // show a blank one
        ?>
            <tr>
                <td><a class="button remove-row-codott-class" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_class[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php endif; ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-codott-class-row screen-reader-text">
                <td><a class="button remove-row-codott-class" href="#">&times;</a></td>
                <td><input type="text" class="widefat" name="codott_class[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            </tbody>
            </table>

            <p><a id="add-codott-class-row" class="button" href="#">Add another</a>
            </p><hr>
            <input type="submit" class="codott_timetable_data_submit" value="Save" />

            <?php
            if ( $repeatable_fields_codott_class ){
            ?>
            <h2><strong><?php _e('Add Courses', 'codott'); ?></strong></h2>
            <table id="repeatable-fieldset-codott-courseslot" width="100%">
            <thead>
                <tr>
                    <th width="2%">Remove</th>
                    <th width="30%">Course Title</th>
                    <th width="30%">Class</th>
                    <th width="30%">Teacher</th>
                    <th width="2%">Sort</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ( $repeatable_fields_codott_courseslot ) :
                foreach ( $repeatable_fields_codott_courseslot as $field ) {
        ?>
            <tr>
                <td><a class="button remove-row-codott-courseslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_courseslot_course[]" value="<?php if(array_key_exists('codott_courseslot_course', $field) && $field['codott_courseslot_course'] != '') echo esc_attr( $field['codott_courseslot_course'] ); ?>" /></td>

                <td>
                    <select name="codott_courseslot_class[]" class="widefat" required>
                        <option value="" <?php if(array_key_exists('codott_courseslot_class', $field) && $field['codott_courseslot_class'] == ''){echo 'selected';}?> ><?php _e('Select Class', 'codott'); ?></option>
                        <?php 
                        foreach ( $repeatable_fields_codott_class as $class_field ) {
                        ?>
                        <option value="<?php if(array_key_exists('codott_class', $class_field)){echo $class_field['codott_class'];} ?>" <?php if(array_key_exists('codott_courseslot_class', $field) && array_key_exists('codott_class', $class_field) &&  $class_field['codott_class'] == $field['codott_courseslot_class']){echo 'selected';}?> ><?php if(array_key_exists('codott_class', $class_field)){echo $class_field['codott_class'];} ?></option>
                    
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" required class="widefat" name="codott_courseslot_teacher[]" value="<?php if(array_key_exists('codott_courseslot_teacher', $field) && $field['codott_courseslot_teacher'] != '') echo esc_attr( $field['codott_courseslot_teacher'] ); ?>" /></td>
                
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php
                }
            else :
                // show a blank one
        ?>
            <tr>
                <td><a class="button remove-row-codott-courseslot" href="#">&times;</a></td>
                <td><input type="text" required class="widefat" name="codott_courseslot_course[]" /></td>

                <td>
                    <select name="codott_courseslot_class[]" class="widefat" required>
                        <option value="" <?php echo 'selected';?> ><?php _e('Select Class', 'codott'); ?></option>
                        <?php 
                        foreach ( $repeatable_fields_codott_class as $class_field ) {
                        ?>
                        <option value="<?php echo $class_field['codott_class']; ?>"  ><?php echo $class_field['codott_class']; ?></option>
                    
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" class="widefat" required name="codott_courseslot_teacher[]" /></td>
                
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
                
            </tr>
            <?php endif; ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-codott-courseslot-row screen-reader-text">
                <td><a class="button remove-row-codott-courseslot" href="#">&times;</a></td>
                <td><input type="text" class="widefat" name="codott_courseslot_course[]" /></td>

                <td>
                    <select name="codott_courseslot_class[]" class="widefat">
                        <option value="" <?php echo 'selected';?> ><?php _e('Select Class', 'codott'); ?></option>
                        <?php 
                        foreach ( $repeatable_fields_codott_class as $class_field ) {
                        ?>
                        <option value="<?php echo $class_field['codott_class']; ?>"  ><?php echo $class_field['codott_class']; ?></option>
                    
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" class="widefat" name="codott_courseslot_teacher[]" /></td>
                <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
            </tr>
            </tbody>
            </table>

            <p><a id="add-codott-courseslot-row" class="button" href="#">Add another</a>
            </p><hr>
            <input type="submit" class="codott_timetable_data_submit" value="Save" />
            <?php 
            }else{
                echo '<hr>';
                _e('Please define your classes first and then save it so that you can define
                 courses here', 'codott');
            }
            ?>


        </div>
    <?php
}

function register_meta_boxes_for_codott_time_tables() {
    add_meta_box( 'codott_time_tables_meta_box',
        __('Details', 'codott'),
        'display_codott_time_tables_meta_box',
        'codott_time_tables', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_codott_time_tables' );

function add_codott_time_tables_fields( $codott_time_tables_id, $codott_time_tables ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $codott_time_tables_id );
    $is_revision = wp_is_post_revision( $codott_time_tables_id );
    $is_valid_nonce = ( isset( $_POST[ 'codott_time_tables_meta_box' ] ) && wp_verify_nonce( $_POST[ 'codott_time_tables_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $codott_time_tables->post_type == 'codott_time_tables' ) {

        $time_table_nofclassesperweek = intval(get_post_meta( $codott_time_tables_id, 'time_table_nofclassesperweek', true ));
        
        if(isset($_POST['codott_time_tables_nofclassesperweek'])) {
            if($time_table_nofclassesperweek != $_POST['codott_time_tables_nofclassesperweek']){
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', '' );
            }
            
        }

        if(isset($_POST['codott_time_tables_nofclassesperweek']) && $_POST['codott_time_tables_nofclassesperweek'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_nofclassesperweek', $_POST['codott_time_tables_nofclassesperweek'] );
        }

        if(isset($_POST['codott_time_tables_filledslotcolor']) && $_POST['codott_time_tables_filledslotcolor'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_filledslotcolor', $_POST['codott_time_tables_filledslotcolor'] );
        }

        if(isset($_POST['codott_time_tables_emptyslotcolor']) && $_POST['codott_time_tables_emptyslotcolor'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_emptyslotcolor', $_POST['codott_time_tables_emptyslotcolor'] );
        }

        //update time slots in post meta
        if ( isset( $_POST['codott_timeslot_start'] ) && isset( $_POST['codott_timeslot_end'] )){
            $old_timeslots = get_post_meta($codott_time_tables_id, 'repeatable_fields_codott_timeslot', true);
            $new_timeslots = array();
            $codott_timeslot_start = $_POST['codott_timeslot_start'];
            $codott_timeslot_end = $_POST['codott_timeslot_end'];
            $count = count( $codott_timeslot_start );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $codott_timeslot_start[$i] != '' ) :
                    $new_timeslots[$i]['codott_timeslot_start'] = stripslashes( strip_tags( $codott_timeslot_start[$i] ) );
                if ( $codott_timeslot_end[$i] != '' )
                    $new_timeslots[$i]['codott_timeslot_end'] = stripslashes( $codott_timeslot_end[$i] ); // and however you want to sanitize
                endif;
            }
            if ( !empty( $new_timeslots ) && $new_timeslots != $old_timeslots ){
                update_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_timeslot', $new_timeslots );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', '' );
            }elseif ( empty($new_timeslots) && $old_timeslots ){
                delete_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_timeslot', $old_timeslots );
            }
        }

        //update day slots in post meta
        if ( isset( $_POST['codott_dayslot'] )){
            $old_dayslots = get_post_meta($codott_time_tables_id, 'repeatable_fields_codott_dayslot', true);
            $new_dayslots = array();
            $codott_dayslot = $_POST['codott_dayslot'];
            $count = count( $codott_dayslot );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $codott_dayslot[$i] != '' ) :
                    $new_dayslots[$i]['codott_dayslot'] = sanitize_text_field( stripslashes( strip_tags( $codott_dayslot[$i] ) ) );
                endif;
            }
            if ( !empty( $new_dayslots ) && $new_dayslots != $old_dayslots ){
                update_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_dayslot', $new_dayslots );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', '' );
            }elseif ( empty($new_dayslots) && $old_dayslots ){
                delete_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_dayslot', $old_dayslots );
            }
        }


        //update room slots in post meta
        if ( isset( $_POST['codott_roomslot'] )){
            $old_roomslots = get_post_meta($codott_time_tables_id, 'repeatable_fields_codott_roomslot', true);
            $new_roomslots = array();
            $codott_roomslot = $_POST['codott_roomslot'];
            $count = count( $codott_roomslot );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $codott_roomslot[$i] != '' ) :
                    $new_roomslots[$i]['codott_roomslot'] = sanitize_text_field( stripslashes( strip_tags( $codott_roomslot[$i] ) ) );
                endif;
            }
            if ( !empty( $new_roomslots ) && $new_roomslots != $old_roomslots ){
                update_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_roomslot', $new_roomslots );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', '' );
            }elseif ( empty($new_roomslots) && $old_roomslots ){
                delete_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_roomslot', $old_roomslots );
            }
        }


        //update classes in post meta
        if ( isset( $_POST['codott_class'] )){
            $old_classslots = get_post_meta($codott_time_tables_id, 'repeatable_fields_codott_class', true);
            $new_classslots = array();
            $codott_classslot = $_POST['codott_class'];
            $count = count( $codott_classslot );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $codott_classslot[$i] != '' ) :
                    $new_classslots[$i]['codott_class'] = sanitize_text_field( stripslashes( strip_tags( $codott_classslot[$i] ) ) );
                endif;
            }
            if ( !empty( $new_classslots ) && $new_classslots != $old_classslots ){
                update_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_class', $new_classslots );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', '' );
            }elseif ( empty($new_classslots) && $old_classslots ){
                delete_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_class', $old_classslots );
            }
        }

        //update course slots in post meta
        if ( isset( $_POST['codott_courseslot_course'] ) &&
         isset( $_POST['codott_courseslot_class'] ) &&
         isset( $_POST['codott_courseslot_teacher'] )
         ){
            $old_courseslots = get_post_meta($codott_time_tables_id, 'repeatable_fields_codott_courseslot', true);
            $new_courseslots = array();
            $codott_courseslot_course = $_POST['codott_courseslot_course'];
            $codott_courseslot_class = $_POST['codott_courseslot_class'];
            $codott_courseslot_teacher = $_POST['codott_courseslot_teacher'];
            $count = count( $codott_courseslot_course );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $codott_courseslot_course[$i] != '' ) :
                    $new_courseslots[$i]['codott_courseslot_course'] = stripslashes( strip_tags( $codott_courseslot_course[$i] ) );
                if ( $codott_courseslot_class[$i] != '' )
                    $new_courseslots[$i]['codott_courseslot_class'] = stripslashes( $codott_courseslot_class[$i] ); // and however you want to sanitize
                if ( $codott_courseslot_teacher[$i] != '' )
                    $new_courseslots[$i]['codott_courseslot_teacher'] = stripslashes( $codott_courseslot_teacher[$i] ); // and however you want to sanitize
                
                endif;
            }
            if ( !empty( $new_courseslots ) && $new_courseslots != $old_courseslots ){
                update_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_courseslot', $new_courseslots );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', '' );
                update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', '' );
            }elseif ( empty($new_courseslots) && $old_courseslots ){
                delete_post_meta( $codott_time_tables_id, 'repeatable_fields_codott_courseslot', $old_courseslots );
            }
        }
    }
}

add_action( 'save_post', 'add_codott_time_tables_fields', 10, 2 );


function display_codott_time_tables_contents_meta_box( $codott_time_tables ) {
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'codott_time_tables_contents_meta_box');
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
    $time_table_filledslotcolor = esc_html(get_post_meta( $codott_time_tables->ID, 'time_table_filledslotcolor', true ));
    $time_table_emptyslotcolor = esc_html(get_post_meta( $codott_time_tables->ID, 'time_table_emptyslotcolor', true ));
    $time_table_nofclassesperweek = intval (get_post_meta( $codott_time_tables->ID, 'time_table_nofclassesperweek', true )); 
    
    if($time_table_nofclassesperweek == 0){
        $time_table_nofclassesperweek = 1;
    }

    $time_table_time_slots1 = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_timeslot', true);
    $time_table_day_slots1 = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_dayslot', true);
    $time_table_room_slots1 = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_roomslot', true);
    
    $time_table_time_slots2 = '';
    $size = sizeof($time_table_time_slots1);
    //echo $size;
    $i = 1;
    if ( $time_table_time_slots1 ){
        foreach ($time_table_time_slots1 as $key => $value) {
            if($i < $size){
                $time_table_time_slots2 .= $value['codott_timeslot_start'].'-'.$value['codott_timeslot_end'].',';
            }else{
                $time_table_time_slots2 .= $value['codott_timeslot_start'].'-'.$value['codott_timeslot_end'];
            }
            $i++;
        }
    }

    $time_table_day_slots2 = '';
    $size = sizeof($time_table_day_slots1);
    //echo $size;
    $i = 1;
    if($time_table_day_slots1){
        foreach ($time_table_day_slots1 as $key => $value) {
            if($i < $size){
                $time_table_day_slots2 .= $value['codott_dayslot'].',';
            }else{
                $time_table_day_slots2 .= $value['codott_dayslot'];
            }
            $i++;
        }
    }

    $time_table_room_slots2 = '';
    $size = sizeof($time_table_room_slots1);
    //echo $size;
    $i = 1;
    if($time_table_room_slots1){
        foreach ($time_table_room_slots1 as $key => $value) {
            if($i < $size){
                $time_table_room_slots2 .= $value['codott_roomslot'].',';
            }else{
                $time_table_room_slots2 .= $value['codott_roomslot'];
            }
            $i++;
        }
    }

    if($time_table_time_slots2 == "" || $time_table_day_slots2 == "" || $time_table_room_slots2 == ""){
        _e('Time slots, day slots or room slots are empty. Fill these fields, 
        select time table type and publish/update time table to see more options 
        or to see generated time table', 'codott');
    }else{
        $time_table_classes1 = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_class', true);
        $time_table_classes_courses1 = get_post_meta($codott_time_tables->ID, 'repeatable_fields_codott_courseslot', true);
        
        $time_table_classes2 = '';
        $size = sizeof($time_table_classes1);
        //echo $size;
        $i = 1;
        if($time_table_classes1){
            foreach ($time_table_classes1 as $key => $value) {
                if($i < $size){
                    $time_table_classes2 .= $value['codott_class'].',';
                }else{
                    $time_table_classes2 .= $value['codott_class'];
                }
                $i++;
            }
        }

        $time_table_classes_courses2 = '';
        $size = sizeof($time_table_classes_courses1);
        //echo $size;
        $i = 1;
        if($time_table_classes_courses1){
            foreach ($time_table_classes_courses1 as $key => $value) {
                if($i < $size){
                    $time_table_classes_courses2 .= $value['codott_courseslot_class'].'-->'.$value['codott_courseslot_course'].'-->'.$value['codott_courseslot_teacher'].',';
                }else{
                    $time_table_classes_courses2 .= $value['codott_courseslot_class'].'-->'.$value['codott_courseslot_course'].'-->'.$value['codott_courseslot_teacher'];
                }
                $i++;
            }
        }

        $time_table_classes_sem = get_post_meta( $codott_time_tables->ID, 'time_table_cust_classes_sem', true );
        $time_table_classes_courses_assign = get_post_meta( $codott_time_tables->ID, 'time_table_cust_classes_courses_assign', true );
        $time_table_empty_slots = get_post_meta( $codott_time_tables->ID, 'time_table_cust_empty_slots', true );
        
        if($time_table_classes2 == "" && $time_table_classes_courses2 == ""){
            _e('Fill classes and classes courses fields and hit update button to see 
                generated time table.','codott');
        }else{
            ?>
            <?php
            if($time_table_classes_sem == "" 
            && $time_table_classes_courses_assign == "" 
            && $time_table_empty_slots == ""){
                //include( CODOTT_BASE_DIR . '/plugin_pages/cust_time_table_for_post_type.php');
                include( CODOTT_BASE_DIR . '/plugin_pages/new_time_table.php');
            }else{
                include( CODOTT_BASE_DIR . '/plugin_pages/time_table_for_post_type.php');
            }
        }
    }
    

}

function register_meta_boxes_for_codott_time_tables_contents() {
    add_meta_box( 'codott_time_tables_contents_meta_box',
        __('Time Table', 'codott'),
        'display_codott_time_tables_contents_meta_box',
        'codott_time_tables', 'normal', 'low'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_codott_time_tables_contents' );

function add_codott_time_tables_contents_fields( $codott_time_tables_id, $codott_time_tables ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $codott_time_tables_id );
    $is_revision = wp_is_post_revision( $codott_time_tables_id );
    $is_valid_nonce = ( isset( $_POST[ 'codott_time_tables_contents_meta_box' ] ) && wp_verify_nonce( $_POST[ 'codott_time_tables_contents_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $codott_time_tables->post_type == 'codott_time_tables' ) {
        // Store data in post meta table if present in post data
        if(isset( $_POST[ 'codott_time_tables_classes_sem' ]) && $_POST['codott_time_tables_classes_sem'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_classes_sem', $_POST['codott_time_tables_classes_sem'] );
        }
        if(isset( $_POST[ 'codott_time_tables_classes_courses_assign' ]) && $_POST['codott_time_tables_classes_courses_assign'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_classes_courses_assign', $_POST['codott_time_tables_classes_courses_assign'] );
        }
        if(isset( $_POST[ 'codott_time_tables_empty_slots' ]) && $_POST['codott_time_tables_empty_slots'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_empty_slots', $_POST['codott_time_tables_empty_slots'] );
        }
        if(isset( $_POST[ 'codott_time_tables_cust_classes_sem' ]) && $_POST['codott_time_tables_cust_classes_sem'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_sem', $_POST['codott_time_tables_cust_classes_sem'] );
        }
        if(isset( $_POST[ 'codott_time_tables_cust_classes_courses_assign' ]) && $_POST['codott_time_tables_cust_classes_courses_assign'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_cust_classes_courses_assign', $_POST['codott_time_tables_cust_classes_courses_assign'] );
        }
        if(isset( $_POST[ 'codott_time_tables_cust_empty_slots' ]) && $_POST['codott_time_tables_cust_empty_slots'] != ''){
            update_post_meta( $codott_time_tables_id, 'time_table_cust_empty_slots', $_POST['codott_time_tables_cust_empty_slots'] );
        }

    }
}

add_action( 'save_post', 'add_codott_time_tables_contents_fields', 10, 2 );


function include_template_function_codott_time_tables( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'codott_time_tables' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return codott_time_tables_get_template_hierarchy( 'single-codott_time_tables' );
    }elseif (is_archive()) {
        return codott_time_tables_get_template_hierarchy( 'archive-codott_time_tables' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function codott_time_tables_get_template_hierarchy( $template ) {
 
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

add_filter( 'template_include', 'include_template_function_codott_time_tables', 1 );


?>