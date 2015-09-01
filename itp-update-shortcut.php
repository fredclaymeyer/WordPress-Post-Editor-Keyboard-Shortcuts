<?php
/*
Plugin Name:  ITP Update Shortcut
Description:  Creates update keyboard shortcut
Author:       Press Up
Author URI:   http://pressupinc.com
*/

function itp_return_bindings() {
    $bindings = array(
        'Save Draft' => array( 'name' => 'save', 'binding' => 'ctrl+s' ),
        'Publish or Update' => array( 'name' => 'publish', 'binding' => 'ctrl+g' ),
        'Preview' => array( 'name' => 'preview', 'binding' => 'ctrl+p' ),
        'Toggle Visual Editor' => array( 'name' => 'visual', 'binding' => 'ctrl+h' ),
        'Toggle Text Editor' => array( 'name' => 'text', 'binding' => 'ctrl+j' ),
        'Add New' => array( 'name' => 'new', 'binding' => 'ctrl+m' ),
    );

    return $bindings;
}

function itp_return_prefix() {
    return 'itp';
}


add_action('admin_menu', 'my_plugin_menu');
function my_plugin_menu() {
	add_options_page( 'Post Edit Shortcuts', 'Post Edit Shortcuts', 'manage_options', 'post-update-shortcuts.php', 'itp_post_update_shortcuts_page' );
}

function itp_post_update_shortcuts_page() {
	include 'itp-update-shortcut-options-page.php';
}

add_action( 'admin_init', 'itp_admin_init' );
function itp_admin_init(){
    $prefix = itp_return_prefix();
    $bindings = itp_return_bindings();

    // Create Setting
    $section_group = itp_return_prefix();
    $section_name = 'itp_bindings';

    // Create section of Page
    $settings_section = 'itp_main';
    $page = $section_group;
    add_settings_section( 
        $settings_section,
        'Keyboard Bindings',
        '' ,
        $page
    );

    foreach( $bindings as $name => $data ) :

        $setting_name = $prefix .'_' . $data['name'];
        register_setting( $section_group, $setting_name );

        // Add fields to that section
        add_settings_field(
            $data['name'],
            $name,
            'itp_create_binding_field',
            $page,
            $settings_section,
            array( 'name' => $setting_name, 'binding' => $data['binding'] )
        );
    endforeach;
}

function itp_create_binding_field( $setting_data ) {
    if (! get_option( $setting_data['name'] ) ) :
        update_option( $setting_data['name'], $setting_data['binding'] );
    endif;

    if (! get_option( $setting_data['name'] ) ) :
        echo '<input type="text" id="' . $setting_data['name'] . '" name="' . $setting_data['name'] . '" value="Error: Failed to set default.">';
    else:
        echo '<input type="text" id="' . $setting_data['name'] . '" name="' . $setting_data['name'] . '" value="' . get_option( $setting_data['name'] ) . '">';
    endif;
}

add_action( 'admin_init', 'itp_get_scripts' );
function itp_get_scripts() {
	wp_enqueue_script( 'jquery_hotkeys', plugin_dir_url( __FILE__ ) . 'jquery.hotkeys.js', array( 'jquery' ) );
	wp_enqueue_script( 'itp_update_shortcut', plugin_dir_url( __FILE__ ) . 'itp-update-shortcut.js', array( 'jquery', 'jquery_hotkeys' ) );

    $prefix = itp_return_prefix();
    $bindingsArray = itp_return_bindings();

    $bindingsToPass = array();
    foreach( $bindingsArray as $name => $data ) {
        $bindingName = $prefix . '_' . $data['name']; 
        $binding = get_option( $bindingName );
        $bindingsToPass[] = $binding;
    }

    $dataToPass = array(
        'keys' => $bindingsToPass
    );
    wp_localize_script( 'itp_update_shortcut', 'passedData', $dataToPass );
}


add_action( 'wp_tiny_mce_init', function () {
    ?>

    <script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ) . 'itp-mce-scripts.js' ?>"></script>
    <?php
});

function wpse167402_tiny_mce_before_init( $mceInit ) {
    $mceInit['setup'] = 'wpse167402_tiny_mce_init';
    return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'wpse167402_tiny_mce_before_init', 10, 999 );


add_action('admin_menu', 'awesome_page_create');
function awesome_page_create() {
    add_menu_page( 'My Awesome Admin Page', 'Awesome Admin Page', 'create_post', 'awesome_page', 'my_awesome_page_display', '', 24);
}

// in main file
function my_awesome_page_display() {
    if (isset($_POST['awesome_text'])) {
        update_option('awesome_text', $_POST['awesome_text']);
        $value = $_POST['awesome_text'];
    } 

    $value = get_option('awesome_text', 'hey-ho'); ?>

	<h1>My Awesome Settings Page</h1>

	<form method="POST">
	    <label for="awesome_text">Awesome Text</label>
	    <input type="text" name="awesome_text" id="awesome_text" value="<?php echo $value; ?>">
	    <input type="submit" value="Save" class="button button-primary button-large">
	</form> <?php
}
