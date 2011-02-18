<?php
/**
 * A SelectInput abstration object for a Select Object
 *
 * Creates an object that represents an HTML select object.
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 * @package RoboStangs2011
 */
if( ! class_exists( 'FormInputClass' ) )
{
	include THEME_LIB_DIR . 'form_builder/abstractform.class.php';
}
/**
 * Our SelectInput class
 *
 * This extends FormInput class, and allows deeper select-input 
 * based actions such as setting a default value.
 * @package RoboStangs2011
 * @subpackage FormInputClass
 */
class SelectInput extends FormInputClass
{
	/**
	 * Stores the default selected option
	 * @var string default_option
	 * @access protected
	 */
	protected $default_value = '';

	/**
	 * @var array 
	 * @access protected
	 */
	protected $options = array();

	/**
	 * SelectInput Constructor
	 *
	 * Sets the basic html input element's attributes
	 * @method
	 * @access public
	 * @param string $name The HTML name attribute
	 * @param string $id Optional: The HTML id attribute
	 * @param string $class Optional: The HTML class attribute
	 * @param string $extra_attributes Optional: A key=value&key2=value2 string of extra HTML attributes
	 */
	public function __construct( $name, $id = false, $class = false )
	{
		$attrs = array();
		$attrs['name'] = $name;
		$attrs['type'] = 'select';
		$attrs['value'] = true;
		$attrs['id'] = $id;
		$attrs['class'] = $class;
		$attr['extra_attributes'] = $extra_attributes;

		parent::__construct( $attrs );
	}

	/**
	 * Parse the select tag's HTML attributes.
	 *
	 * Defines our abstract parse_attribtues function and allows us to
	 * manipulate the attributes as we see fit.
	 * @method
	 * @access protected
	 * @param array $attributes the array of key=>value attributes to be converted to HTML
	 * @return array
	 */
	protected function parse_attributes($attributes)
	{
		return $attributes;
	}

	/**
	 * Parse the tag's value
	 *
	 * In this case, render our options as HTML and return that as the value. This
	 * is also a required function from our parent class that we're defining here.
	 * @method
	 * @access protected
	 * @param string $value The value to be manipulated, returned, then inserted into the HTML
	 * @return string
	 */
	protected function parse_value( $value )
	{
		return $this->options_to_str();
	}

	/**
	 * Add an option to our select's options list
	 *
	 * Adds an object abstraction of the HTML <option> element to our $options array.
	 * @method
	 * @access public
	 * @param string $value The value to go in the option's value attribute: 
	 * <option value="value"></option>.
	 * @param string $label The label for the option <option value="value">label</option>
	 * @return string
	 */
	public function add_option( $value, $label = false )
	{
		$label = ( $label ) ? $label : false;
		$this->options[] = array( $value, $label );
	}

	/**
	 * Set a default value option
	 * 
	 * Called anytime before the draw statement to set the default option.
	 * It searches for option with a value equivelent of the value param.
	 * @method
	 * @access public
	 * @param string value The search string for the <option value=""
	 * @return boolean true
	 * @todo add default by label or index options
	 */
	public function set_default_value( $value )
	{
       	$this->default_value = $value;
		return true;
	}
	/**
	 * Converts our options array to an HTML string
	 * 
	 * Goes through our options array and converts it to an HTML string then returns it.
	 * It also sets the default value. Called from the parse_value method.
	 * @method
	 * @access protected
	 * @return string
	 */
	protected function options_to_str()
	{
		$html = "\n";

		foreach( $this->options as $option)
		{
			$value = $option[0];
			$label = $option[1];
			$selected = '';

			if( !$label )
			{
				$label = $value;
			}

			if( ! empty( $this->default_value ) && $value == $this->default_value )
			{
				$selected = ' selected';
			}

			$html .= "\t<option value=\"{$value}\"{$selected}>{$label}</option>\n";
		}

		return $html;
	}
     
}
?>
