<?php
/**
 * Our Meta Box Abstract Class, add meta boxes to post types.
 *
 * The MetaBox System allows a person to create a simple subclass which just handles 
 * it's basic drawing, and necessary save operations.
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 * @package RoboStangs2011
 */
/**
 * The abstract class for our MetaBox system.
 *
 * MetaBox class includes methods for setting up the hooks, saving data, initialing it's self.
 * @package RoboStangs2011
 * @subpackage MetaBoxClass
 * @abstract
 */
abstract class MetaBoxClass
{
	/**
	 * Abstract methods
	 * 
	 * Our methods that our sub clsses HAVE to define or else throw an error.
	 * @abstract
	 * @method boolean draw() draw the form.
	 * @return true
	 * @access public
	 */
	public abstract function draw();

	/**
	 * Our settings array that must be set from the child class.
	 * @abstract
	 * @var array
	 * @access protected
	 */
    protected $settings = array( 'id' => '', 'title' => '', 'name' => '', 'post_type' => '' );

	/**
	 * The data fields we'll be using, they are using my InputField class.
	 * @var array
	 * @access protected
	 */
	protected $fields = array();

	/**
	 * Class Constructor
	 *
	 * Just calls the _init function. This isn't even necessary but it felt right.
	 * @access public
	 */
	function __construct()
	{
		$this->_init();
	}

	/**
	 * Internal initator function
	 *
	 * Sets up our two hooks: One for when the admin panel initates on WordPress admin pages.
	 * The other for when a post is saved and calls the sub class's save function to maniuplate the data if necessary.
	 * @access protected
	 */
	protected function _init()
	{
		add_action( 'admin_init', array( $this, 'load' ), 1 );
		add_action( 'save_post', array( $this, 'save_post_data' ) );
	}

	/**
	 * Load the Meta Box
	 *
	 * Is called from WordPress's admin_init function. This is responsible for telling WordPress to draw our box
	 * when it's drawing the admin post page for the set post type.
	 * @access protected
	 */
	public function load()
	{
		add_meta_box( 
			$this->settings['id'], 
			__( $this->settings['title'], $this->settings['name'] . '_textdomain' ),
			array( $this, draw ),
			$this->settings['post_type']
		);
	}

	/**
	 * Add Field
	 *
	 * Adds a field object to the fields property.
	 * @access public
	 * @param FormInput $field
	 */
	public function add_field( $field )
	{
		$this->fields[] = $field;
	}

	/**
	 * Get Field
	 *
	 * Get's a field item by index number.
	 * @access protected
	 * @param int $field_index
	 * @return FormInput 
	 */
	protected function get_field( $field_index )
	{
		return $this->fields[ $field_index ];
	}

	/**
	 * Save Post Data
	 *
	 * Saves the post data and updates the post_meta database with the processed information
	 * provided that it matches what the other systems have.
	 * @access protected
	 * @param int $post_id
	 */
	function save_post_data($post_id)
	{
		if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}

		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		{
			return $post_id;
		}		

		// Check permissions
		if ( $this->settings['post_type'] != $_POST['post_type'] ) 
		{
        	return $post_id;
		}

		if ( !current_user_can( 'edit_page', $post_id ) )
		{
			return $post_id;
		}

		if ( !current_user_can( 'edit_post', $post_id ) )
		{
			return $post_id;
		}
		
		$post_data = $this->get_post_data( $_POST );

		if( method_exists( $this, 'save' ) )
		{
			$post_data = call_user_func( array( $this, 'save' ), $post_data );
		}

		foreach( $post_data as $key => $value )
		{
			update_post_meta( $post_id, '_' . $key, $value );
		}

		return true;
				
	}
	/**
	 * Get Post Data
	 *
	 * Takes our fields property and checks the names against what we have in our raw $_POST data.
	 * This extracts only the data that we've assigned the meta box to use.
	 * @access protected
	 * @param array $post_array
	 */
	protected function get_post_data($post_array)
	{
		$post_data = array();

		foreach( $fields as $field )
		{
			$value = $post_array[ $field->get_name() ];

        	if( ! $value  )
			{
				continue;	
			}

            $post_data[] = $value;
		}

		return $post_data;
	}
}
?>
