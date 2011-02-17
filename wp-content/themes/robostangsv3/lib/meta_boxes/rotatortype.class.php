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
        $field = new SelectInput(
			'rotator_type', #name
			'rotator-type', #id
			'rotator-type-input' #class
		);

		$field->add_option( 'image', 'Image' );
		$field->add_option( 'post', 'Post' );
		$field->add_option( 'link', 'Link' );
		//$field->add_option( 'video', 'Video' );
		$field->add_option( 'youtube', 'Youtube Video' );

		$this->add_field( $field ) ;

		parent::__construct();
	}

	/**
	 * Update Global Settings
	 *
	 * This function sets the required settings for this system to function properly.
	 * @access protected
	 * @method
	 */
	protected function update_settings()
	{
		$this->id = 'rotator-type-box'; 
		$this->title = 'Rotator Type'; 
		$this->name = 'rotator_type'; 
		$this->post_type = 'rotator';
	}

	/**
	 * MetaBox Abstract Draw Method
	 *
	 * Defines the MetaBox abstract draw method. It renders the input form.
	 * @access public
	 * @global PostClass $post WordPress Post object
	 * @staticvar string $html The form html to return, specifically our Rotator Post type dropdown.
	 * @return string
	 */
	public function draw()
	{
		global $post;
		// Use nonce for verification
		wp_nonce_field( plugin_basename($this->name), 'rotator_nonce' );

		$field = $this->get_field( 0 );

		$id = $post->ID;

		$rotator_type = get_post_meta( $id, '_rotator_type', true ); 

		$field->set_default_value( $rotator_type );

		// The actual fields for data entry
		echo '<label for="' . $field->get_name() . '">' . __("Select Rotator Post Type/Format: ", $this->name . '_textdomain' ) . '</label> ';
		echo $field;

	}
}
$rotatorType = new RotatorType();
?>
