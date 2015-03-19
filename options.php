<php

function testimonials_display_submenu_options(){
	echo 'Wheeeee!';
	}
	
function testimonials_add_submenu() {	
add_submenu_page( 'options-general.php','Submenu', 'Submenu', 'manage_options', 'awesomesub-menu','testimonials_display_submenu_options');
}
add_action( 'admin_menu', 'testimonials_add_submenu' );

function testimonials_awesome_add_admin_menu(){
add_menu_page( 'Testimonials',
'Testimonials', 'manage_options',
'Testimonials',
'testimonials_plugin_options_page',
'dashicons-hammer', 66 );
}

add_action( 'admin_menu','testimonials_add_admin_menu' );

function testimonials_settings_init() {

register_setting( 'plugin_page','testimonials_settings' );

add_settings_section('testimonials_plugin_page_section', __( 'Your section description', 'testimonials' ), 'testimonials_settings_section_callback','plugin_page');

add_settings_field(
'testimonials_text_field_0', __('Settings field description', 'testimonials'), 'testimonials_text_field_0_render', 'plugin_page', 'testimonials_plugin_page_section'
);

add_settings_field(
'testimonials_checkbox_field_1', __( 'Settings field description', 'testimonials' ), 'testimonials_checkbox_field_1_render', 'plugin_page', 'testimonials_plugin_page_section'
);

add_settings_field(
'testimonials_radio_field_2', __( 'Settings field description', 'testimonials' ), 'testimonials_radio_field_2_render', 'plugin_page', 'testimonials_plugin_page_section'
);

add_settings_field(
'testimonials_textarea_field_3', __( 'Settings field description', 'testimonials' ), 'testimonials_textarea_field_3_render', 'plugin_page', 'testimonials_plugin_page_section'
);

add_settings_field(
'testimonials_select_field_4', __( 'Settings field description', 'testimonials' ), 'testimonials_select_field_4_render', 'plugin_page', 'testimonials_plugin_page_section'
);

}

function testimonials_text_field_0_render() {
$options = get_option( 'testimonials_settings' );
?>
<input type="text" name="testimonials_settings
[testimonials_text_field_0]" value="<?php if (isset
($options['testimonials_text_field_0'])) echo $options
['testimonials_text_field_0']; ?>">
<?php
}

function testimonials_checkbox_field_1_render() {
$options = get_option( 'testimonials_settings' );
?>
<input type="checkbox" name="testimonials_settings
[cd_awesome_checkbox_field_1]" <?php if (isset($options
['testimonials_checkbox_field_1'])) checked( $options
['testimonials_checkbox_field_1'], 1 ); ?> value="1">
<?php
}

function testimonials_radio_field_2_render() {
$options = get_option( 'testimonials_settings' );
?>
<input type="radio" name="testimonials_settings
[testimonials_radio_field_2]" <?php if (isset($options
['testimonials_radio_field_2'])) checked( $options
['testimonials_radio_field_2'], 1 ); ?> value="1">
<?php
}

function testimonials_textarea_field_3_render() {
$options = get_option( 'testimonials_settings' );
?>
<textarea cols="40" rows="5" name="testimonials_settings
[testimonials_textarea_field_3]">
<?php if (isset($options['testimonials_textarea_field_3']))
echo $options['testimonials_textarea_field_3']; ?>
</textarea>
<?php
}

function testimonials_select_field_4_render() {
$options = get_option( 'testimonials_settings' );
?>
<select name="testimonials_settings[cd_awesome_select_field_4]">
<option value="1" <?php if (isset($options
['testimonials_select_field_4'])) selected( $options
['testimonials_select_field_4'], 1 ); ?>>Option 1</option>
<option value="2" <?php if (isset($options
['testimonials_select_field_4'])) selected( $options
['testimonials_select_field_4'], 2 ); ?>>Option 2</option>
</select>
<?php
}

function
testimonials_settings_section_callback() {
echo __( 'More of a description and
detail about the section.', 'codediva' );
}

function testimonials_plugin_options_page(){
?>
<form action="options.php" method="post">
<h2>Options</h2>
<?php
settings_fields( 'plugin_page' );
do_settings_sections( 'plugin_page' );
submit_button();
?>
</form>
<?php
}

add_action( 'admin_init',
'testimonials_settings_init' );

function testimonials_plugin_callit(){
$options = get_option( 'testimonials_settings' );
echo '<img src="' . $options['testimonials_text_field_0'] . '" />';
echo '<p>Checkbox: ' . $options['testimonials_checkbox_field_1'] .
'</p>';
echo '<p>Radio: ' . $options['testimonials_radio_field_2'] . '</p>';
echo '<p>Textarea: ' . $options['testimonials_textarea_field_3'] .
'</p>';
echo '<p>Select: ' . $options['testimonials_select_field_4'] . '</p>';
}

add_filter('the_content', 'testimonials_plugin_callit');

?>