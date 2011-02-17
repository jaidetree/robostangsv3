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

	/*
	* Default Settings
	*/
	settings : {
		'slide_duration' : 5000,
		'padding' : 35,
	},

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

		if( options ) {
			$.extend( methods.settings, options );
		}


		return this.each(function() {

			var $this = $(this);
            
			/**
			 * Start Here
			 */

			methods.set_slides( $this );
            methods.set_container_width($this);
			methods.start_rotating();


			/**
			* Handle Events
			*/

			$('#rotator-ui li a').click( methods.select_slide );

		} );

	},

	select_slide : function( event )
	{
		var index = $(this).attr('rel');
		methods.stop_rotating();
		methods.slide_to( index );
		methods.update_ui( index );
		methods.current_slide = index;

		methods.start_rotating();
	},

	slide_to : function( slide_index )
	{
		var current_index = methods.current_slide;
        var width = methods.calculate_slide_position( slide_index );
		var up_to_width = width;

		$(methods.slides).animate( {
				'margin-left' : -(up_to_width)
			});
	},

	set_container_width : function(slides_ul) {

		var total_width = 0;

		$('li', slides_ul).each( function() {
			   total_width += $(this).width();
		} );

		total_width += methods.settings.padding * methods.total_slides;

		$(methods.slides).css( 'width', total_width );
	},

	set_slides : function( slides_ul )
	{
		methods.slides = slides_ul;
		methods.total_slides = $('li', slides_ul).length;
	},
                                            
	start_rotating : function()
	{
		methods.interval = setInterval( methods.rotate_slide, methods.settings.slide_duration );
	},

	stop_rotating : function()
	{
		clearInterval( methods.interval );
	},

	rotate_slide : function()
	{
		methods.next_slide();
	},

	next_slide : function()
	{

		if( methods.current_slide == methods.total_slides - 1 )
		{
			methods.reposition_slides();
            methods.current_slide = 0;
		}else{
			methods.current_slide++;	
			methods.slide_to( methods.current_slide );
		}

		methods.update_ui( methods.current_slide );

	},

	reposition_slide : function( slide_index )
	{
		var slide = $( 'li:eq(' + slide_index + ')', methods.slides );
		console.log( slide );
		$(methods.slides).remove( slide );
		$(methods.slides).append( slide );
	},

	reposition_slides : function ()
	{
		$(methods.slides).animate( {
				'margin-left' : 0
			} );
	},

	animate_slide : function( slide_index )
	{
		var slides = $( methods.slides );
		var width = methods.calculate_slide_position( slide_index );
		
		$(slides).animate( { 
				'margin-left' : -(width) 
			} );
	},

	calculate_slide_position : function( slide_index )
	{
		var width = $('li:eq(' + slide_index + ')', methods.slides).width();
		width = ( width + methods.settings.padding - 4 ) * slide_index;   
		
		return width;
	},

	update_ui : function( slide_index )
	{
		var rotator_ui = $(methods.slides).siblings( '#rotator-ui' ).children( 'ul' );

		$('a', rotator_ui).removeClass( 'selected' );
		$( 'li:eq(' + slide_index + ')', rotator_ui ).children( 'a' ).addClass( 'selected' );
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

