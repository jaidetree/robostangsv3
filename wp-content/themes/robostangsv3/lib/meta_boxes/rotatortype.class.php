<?php
/**
 * MetaBox Rotator Type Class
 *
 * Adds a rotator type dropdown to the rotator Add New page for the
 * custom post type.
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 * @package RoboStangs2011
 */
/**
 * Our sub-class to extend the MetaBox class.
 *
 * Draws the drop down, and manipulates the save data if necessary.
 * @package RoboStangs2011
 * @subpackage MetaBoxClass
 */
class RotatorType extends MetaBoxClass
{
	/**
	 * RotatorType Class Constructor
	 *
	 * Calls our parent class's construct function to get everything going.
	 * This also sets our settings as well.
	 * @access public
	 */
	public function __construct()
	{
		$this->settings = array( 
			'id' => 'rotator-type-box', 
			'title' => 'Rotator Type', 
			'name' => 'rotator_type', 
			'post_type' => 'rotator' 
		);

        $field = new SelectInput(
			'rotator_type', #name
			'rotator-type', #id
			'rotator-type-input' #class
		);

		$field->add_option( 'image', 'Image' );
		$field->add_option( 'post', 'Post' );
		$field->add_option( 'link', 'Link' );
		$field->add_option( 'video', 'Video' );
		$field->add_option( 'youtube', 'Youtube Video' );

		$this->add_field( $field ) ;

		parent::__construct();
	}

	/**
	 * MetaBox Abstract Draw Method
	 *
	 * Defines the MetaBox abstract draw method. It renders the input form.
	 * @access public
	 * @staticvar string $html The form html to return, specifically our Rotator Post type dropdown.
	 * @return string
	 */
	public function draw()
	{
		// Use nonce for verification
		wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

		$field = $this->get_field( 0 );

		$id = get_the_ID();

		$rotator_type = get_post_meta( $id, '_rotator_type', true ); 

		// The actual fields for data entry
		echo '<label for="myplugin_new_field">' . __("Description for this field", 'myplugin_textdomain' ) . '</label> ';
		echo $this->fields[0];

	}
}
$rotatorType = new RotatorType();
?>
