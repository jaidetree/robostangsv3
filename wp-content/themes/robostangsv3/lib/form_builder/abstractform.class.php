<?php
abstract class FormInputClass
{
	abstract protected function parse_attributes();
	abstract protected function parse_value();

	protected var $type = '';
	protected var $name = '';
	protected var $id = '';
	protected var $value = '';
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

	function add_attribute($name, $value)
	{
		$this->extra_attributes[ $name ] = $value;
	}

	function __toString()
	{
		return $this->draw();
	}

	function getName()
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
				$value = true;
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
			$html .= $this->parse_value($value);
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
	protected function parse_value( $value )
	{
		return $value
	}
	protected function parse_attributes( $attributes )
	{
		return $attributes
	}
	protected function attr_to_str($attributes)
	{
		$extra_attributes = parse_str( $this->extra_attributes );
		$attributes = array_merge( $attributes, $extra_attributes );
		$this->parse_attributes( $attributes );
        $str = '';

		foreach( (array)$attributes as $name => $value )
		{
			$str .= $name . '"' . $value . '" ';
		}

		$str = preg_replace( "/ $/", '', $str );

		return $str;
	}
?>
