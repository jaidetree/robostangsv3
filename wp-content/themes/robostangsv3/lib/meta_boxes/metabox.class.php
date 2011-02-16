<?php
abstract class MetaBox
{
	/* = Abstract Methods = */
	protected abstract function draw();

	/* = Variables = */
    protected $settings = array();
    protected $fields = array();
	protected $callback = null;

	/* = Constructor = */
	protected function __construct()
	{
		$this->_init();
	}

	/* = Parent Initiator = 
	 * Used from the extending class's constructor */
	protected function _init()
	{
		add_action( 'admin_init', array( $this, 'load' ), 1 );
		add_action( 'save_post', array( $this, 'save_post_data' ) );
	}

	/* = Load Mechanism =
	 * The function that gets triggered on the admin init to show the meta box */
	public function load()
	{
		add_meta_box( 
			$this->settings['id'], 
			__( $this->settings['title'], $this->settings['name'] . '_textdomain' ),
			array( $this, draw ),
			'rotator'
		);
	}

	/* = Save Function =
	 * Proccesses data to be saved */ 
	protected function save_post_data($post_id)
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

	protected function get_post_data($post_array)
	{
		$post_data = array();

		foreach( $fields as $field )
		{
			$value = $post_array[ $field->getName() ];

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
