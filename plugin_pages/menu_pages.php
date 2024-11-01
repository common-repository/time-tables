<?php
function display_codott_setup_page() {
    require_once(CODOTT_BASE_DIR . '/plugin_pages/home.php');
}

function codott_admin_actions() {
	global $codott_plugin_name;
	add_menu_page( __('Time Tables Settings Page', 'codott'), 'Time Tables', 'edit_posts', $codott_plugin_name, 'display_codott_setup_page', '', 30
    );
    add_submenu_page( $codott_plugin_name, __('Time Tables Dashboard', 'codott'), 'Dashboard', 'edit_posts', $codott_plugin_name, 'display_codott_setup_page'
    );
    add_submenu_page( $codott_plugin_name, __('Codott', 'codott'), 'Time Tables', 'edit_posts','edit.php?post_type=codott_time_tables');
    add_submenu_page( $codott_plugin_name, __('Teacher Time Tables', 'codott'), 'Teacher Time Tables', 'edit_posts','edit.php?post_type=codott_teacher_tt');
    add_submenu_page( $codott_plugin_name, __('Class Time Tables', 'codott'), 'Class Time Tables', 'edit_posts','edit.php?post_type=codott_class_tt');
}

/* Parent Menu Fix */
add_filter( 'parent_file', 'codott_parent_file' );
 
/**
 * Fix Parent Admin Menu Item
 */
function codott_parent_file( $parent_file ){
 
    /* Get current screen */
    global $current_screen, $self, $codott_plugin_name;
 
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 
        (
            'codott_time_tables' == $current_screen->post_type ||
            'codott_teacher_tt' == $current_screen->post_type ||
            'codott_class_tt' == $current_screen->post_type
        ) 
    ) {
        $parent_file = $codott_plugin_name;
    }
 
    return $parent_file;
}

add_filter( 'submenu_file', 'codott_submenu_file' );
 
/**
 * Fix Sub Menu Item Highlights
 */
function codott_submenu_file( $submenu_file ){
 
    /* Get current screen */
    global $current_screen, $self;

    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'codott_time_tables' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=codott_time_tables';
    }

    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'codott_teacher_tt' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=codott_teacher_tt';
    }

    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'codott_class_tt' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=codott_class_tt';
    }
 
    return $submenu_file;
}

?>