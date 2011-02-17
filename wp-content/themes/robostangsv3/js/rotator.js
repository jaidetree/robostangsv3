/**
 * A jQuery Rotator Plugin
 *
 * Made to play nicely with my WordPress theme framework.
 * Hopefully.
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 */
(function( $ ){

  var methods = {
	/**
	 * Current Slide Index
	 */
	current_slide : 0,

	/**
	 * The collection of slides
	 */
	 slides : new Object(),

	/**
	* Total slides
	*/
    total_slides : 0,

	 /*
	 * The Interval Timer for when to change slides
	 */
	 interval: 0,

	/**
	 * Initiator Function
	 *
	 * Controls our main logic, gathers the slides, finds the next one.
	 * Sets the event handlers. Whatever needs to be done.
	 * @param {object} options The options to over-ride the default.
	 * @return {object} The jQuery object for chainability
	 * @member jTater
	*/
	init : function( options ) { 
		var settings = {
			'direction' : 'up'
		};

		if( options ) {
			$.extend( settings, options );
		}


		return this.each(function() {

			var $this = $(this);
            
			/**
			 * Start Here
			 */

			methods.set_slides( $this );
            methods.set_container_width($this);
			methods.start_rotating();

		} );

	},

	set_container_width : function(slides_ul) {

		var total_width = 0;
		var padding = 35;

		$('li', slides_ul).each( function() {
			   total_width += $(this).width();
		} );

		total_width += padding * methods.total_slides;

		$(methods.slides).css( 'width', total_width );
	},

	set_slides : function( slides_ul )
	{
		methods.slides = slides_ul;
		methods.total_slides = $('li', slides_ul).length;
	},

	start_rotating : function()
	{
		methods.interval = setInterval( methods.rotate_slide, 5000 );
	},

	stop_rotating : function()
	{
		clearInterval( methods.interval );
	},

	rotate_slide : function()
	{
		console.log( 'rotated' );
		methods.next_slide();
	},

	next_slide : function()
	{
		console.log( 'Reposition: slide: ' + methods.current_slide );
		methods.current_slide++;	

		
		if( methods.current_slide >= methods.total_slides )
		{
			methods.current_slide = 0;
		}

		methods.reposition_slide( 0 );
		console.log( 'Switch to slide: ' + methods.current_slide );
	},

	reposition_slide : function( slide_index )
	{
		var slide = $( 'li:eq(' + slide_index + ')', methods.slides );
		console.log( slide );
		$(methods.slides).remove( slide );
		$(methods.slides).append( slide );
	}
	
  };

  $.fn.jTater = function( method ) {
    
    // Method calling logic
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
    }    
  
  };

})( jQuery );

