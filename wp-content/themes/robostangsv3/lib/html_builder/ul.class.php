<?php
class ul extends HTML
{
	protected function set_open_tag()
	{
		$this->open_tag = 'ul';
	}
	protected function set_close_tag()
	{
		$this->close_tag = 'ul';
	}

	public function __construct($content = '', $after_html = '', $before_html = '', $indent_level = '')
	{
		parent::__construct( array(
			'after_html' => $after_html, 
			'before_html' => $before_html,
			'indent_level' => $indent_level,
			'content' => $content,
		) );

		$this->set_attribute( 'title' );
		$this->set_attribute( 'dir' );
		$this->set_attribute( 'xml:lang' );
	}
}
?>
