<?php
abstract class FormInput
{
	protected var $type = '';
	protected var $name = '';
	protected var $id = '';
	protected var $value = '';
	protected var $options = array();
    protected var $extra_attributes = '';
	protected var $class = '';

	function __construct( $type, $name, $id, $value = '', $class = '', $extra_attributes = '' )
	{
		$this->type = (string)$type;
		$this->name = (string)$name;
		$this->id = (string)$id;
		$this->value = $value;
		$this->class = (string)$class;
		$this->extra_attributes = (string)$extra_attributes;
	}

	function add_option( $value, $label = false )
	{
		$label = ( $label ) ? $label : false;
		$this->options[] = array( $value, $label );
	}

	function add_attribute($name, $value)
	{
		$this->extra_attributes[ $name ] = $value;
	}

	function __toString()
	{
		return $this->draw();
	}

	function get_name()
	{
		return $this->name;
	}

	function draw( $echo = false )
	{
		$html = '';
		$tag_open = '';
		$tag_close = '';
		$attributes = '';
		$value = '';

		switch( $this->type )
		{
			case 'select':
				$tag_open = 'select';
				$value = $this->options_to_str();
			break;
			case 'textarea':
				$tag_open = 'textarea';
				$tag_close = 'textarea';
				$value = $this->value;
			break;

			default:
				$tag_open = 'input';
            	$attributes['type'] = $this->type;
				$attributes['value'] = $this->value;
			break;
		}

		$html = "<{$tag_open} ";
		$html .= $this->attr_to_str( $attributes );
		$html .= ">";

		if( $value )
		{
			$html .= $value;
		}

		if( $tag_close )
		{
			$html .= "</{$tag_close}>";
		}

		if( $echo )
		{
			echo $html;
		}

		return $html;


	}
	protected function options_to_str()
	{
		$html = '';

		foreach( $this->options as $option)
		{
			$value = $option[0];
			$label = $option[1];

			if( !$label )
			{
				$label = $value;
			}

			$html .= "\t<option value=\"{$value}\">{$label}</option>\n";
		}

		return $html;
	}
	protected function attr_to_str($attributes)
	{
		$extra_attributes = parse_str( $this->extra_attributes );
		$attributes = array_merge( $attributes, $extra_attributes );
        $str = '';

		foreach( (array)$attributes as $name => $value )
		{
			$str .= $name . '"' . $value . '" ';
		}

		$str = preg_replace( "/ $/", '', $str );

		return $str;
	}
?>
